<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class InvoicesFunctionsComponent extends Component
{
    public function __construct()
    {
        $this->Error = new ErrorComponent();

        $this->Invoices               = TableRegistry::get('Invoices');
        $this->InvoiceItems           = TableRegistry::get('InvoiceItems');
        $this->InvoicesPurchasesSells = TableRegistry::get('InvoicesPurchasesSells');
        $this->Purchases              = TableRegistry::get('Purchases');
        $this->Sells                  = TableRegistry::get('Sells');
        $this->StockBalancesFunctions = new StockBalancesFunctionsComponent();
        $this->ProductFunctions       = new ProductFunctionsComponent();
    }

    public function stock($invoice, $cancel = false)
    {
        //Define variáveis
        $productList = [];
        $index       = 0;
        $date        = $invoice->endingdate; //Data que o estoque será atualizado

        /******************************************************************/

        //Consulta os itens do faturamento
        $invoiceItems = $this->InvoiceItems->findByInvoicesIdAndParametersId($invoice->id, $invoice->parameters_id);

        /******************************************************************/

        //Lista os produtos
        foreach ($invoiceItems as $invoiceItem):

            //Identifica o tipo da transação
            // S - Sell, P - Purchase, DS - detached selling, DP - detached purchasing
            if ($invoice->type = 'C' || $invoice->type = 'DP') { //Compra ou entrada avulsa
                $quantity = $invoiceItem->quantity;
            } elseif ($invoice->type = 'V' | $invoice->type = 'DS') { //Venda ou saída avulsa
                $quantity = $invoiceItem->quantity *-1;
            }

            /**************************************************************/

            //Define os campos de itens
            $productList[$index]['products_id'] = $invoiceItem->products_id;
            $productList[$index]['quantity']    = $quantity;
            $productList[$index]['unity']       = $invoiceItem->unity;

            /**************************************************************/
            
            //Incrementa indice
            $index++;
            
        endforeach;

        /******************************************************************/

        //Atualiza o saldo de estoque
        $this->StockBalancesFunctions->balance($date, $productList, $invoice->parameters_id, $cancel);
    }

    public function purchasesSells($invoice, $cancel = false)
    {
        /**
         * STATUS DO PEDIDO:
         *  P - Pendente (Sem faturamentos vinculados)
         *  D - Em entrega (Com faturamentos em processo 'P')
         *  E - Entregue parcialmente (Com faturamentos em processo 'P' e finalizados 'F')
         *  F - Finalizado (Todos os faturamentos finalizados 'F')
         *  C - Cancelado (Sem faturamentos vinculados)
         * 
         * FATURAMENTOS CANCELADOS SERÃO IGNORADOS
         */

        //Variável de consulta
        $where = ['InvoicesPurchasesSells.invoices_id <>' => $invoice->id];

        /**********************************************************************/

        //Identifica o tipo
        if ($invoice->type == 'P') { // S - Sell, P - Purchase, DS - detached selling, DP - detached purchasing

            $where[] = 'InvoicesPurchasesSells.purchases_id = ' . $invoice->purchases_id;

            //Consulta Pedido
            $pedido = $this->Purchases->findByIdAndParametersId($invoice->purchases_id, $invoice->parameters_id)
                                      ->first();

        } elseif ($invoice->type == 'S') { // S - Sell, P - Purchase, DS - detached selling, DP - detached purchasing

            $where[] = 'InvoicesPurchasesSells.sells_id = ' . $invoice->sells_id;

            //Consulta Pedido
            $pedido = $this->Sells->findByIdAndParametersId($invoice->sells_id, $invoice->parameters_id)
                                  ->first();

        } else {

            //Caso o tipo seja SD ou DP
            return false;

            //Alerta de erro
            $message = 'InvoicesFunctionsComponent->purchasesSells: Tipo incorreto '.json_encode($invoice);
            $this->Error->registerError(null, $message, true);

        }

        /**********************************************************************/

        if (empty($pedido)) {

            //Caso o pedido não seja localizado
            return false;

            //Alerta de erro
            $message = 'InvoicesFunctionsComponent->purchasesSells: Pedido não identificado '.json_encode($pedido);
            $this->Error->registerError(null, $message, true);

        }//if (empty($pedido))

        /**********************************************************************/

        //Define o status inicial do pedido
        if ($invoice->status == 'P') {

            if ($cancel) {
                //Pedido pendente
                $pedido->status = 'P';
            } else {
                //Pedido em entrega
                $pedido->status = 'D';
            }

        } elseif ($invoice->status == 'F') {

            if ($cancel) {
                //Pedido pendente
                $pedido->status = 'P';
            } else {
                //Pedido finalizado
                $pedido->status = 'F';
            }

        }//elseif ($invoice->status == 'F')

        /**********************************************************************/

        //Consulta demais vinculos
        $invoicesPurchasesSells = $this->InvoicesPurchasesSells->findByParametersId($invoice->parameters_id)
                                                               ->where($where);
        
        /**********************************************************************/

        //Se houver outros faturamentos para o mesmo pedido
        if (!empty($invoicesPurchasesSells->toArray())) {

            foreach ($invoicesPurchasesSells as $invoicesPurchasesSell):

                //Consulta demais faturamentos
                $other_invoice = $this->Invoices->findByIdAndParametersId($invoicesPurchasesSell->invoices_id, $invoice->parameters_id)
                                                ->first();

                if (!empty($other_invoice)) {

                    if ($invoice->status == 'P') { //Faturamento atual

                        if ($other_invoice->status == 'F') { //Demais faturamentos

                            if ($cancel) {
                                //Pedido finalizado
                                $pedido->status = 'F';
                            } else {
                                //Pedido entregue parcialmente
                                $pedido->status = 'E';
                            }

                        }//if ($other_invoice->status == 'F')

                    } elseif ($invoice->status == 'F') { //Faturamento atual

                        if ($other_invoice->status == 'P') { //Demais faturamentos

                            if ($cancel) {
                                //Pedido em entrega
                                $pedido->status = 'D';
                            } else {
                                //Pedido entregue parcialmente
                                $pedido->status = 'E';
                            }

                        }//if ($other_invoice->status == 'P')

                    }//elseif ($invoice->status == 'F')

                } else {

                    //Alerta de erro
                    $message = 'InvoicesFunctionsComponent->purchasesSells: Vínculo incorreto '.json_encode($other_invoice);
                    $this->Error->registerError(null, $message, true);

                }//else if (!empty($other_invoice))
        
            endforeach;

        }//if (!empty($invoicesPurchasesSells->toArray()))
        
        /**********************************************************************/

        //Grava o status do pedido

        //Identifica o tipo
        if ($invoice->type == 'P') { // S - Sell, P - Purchase, DS - detached selling, DP - detached purchasing

            if (!$this->Purchases->save($pedido)) {

                return false;

                //Alerta de erro
                $message = 'InvoicesFunctionsComponent->purchasesSells: Compra';
                $this->Error->registerError($pedido, $message, true);

            }//if (!$this->Purchases->save($pedido))

        } elseif ($invoice->type == 'S') { // S - Sell, P - Purchase, DS - detached selling, DP - detached purchasing

            if (!$this->Sells->save($pedido)) {

                return false;

                //Alerta de erro
                $message = 'InvoicesFunctionsComponent->purchasesSells: Venda';
                $this->Error->registerError($pedido, $message, true);

            }//if (!$this->Sells->save($pedido))

        }//elseif ($invoice->type == 'S')
        
        /**********************************************************************/

        return true;

    }

    public function addInvoicesPurchasesSells($invoice)
    {
        //Novo item
        $ips = $this->InvoicesPurchasesSells->newEntity();

        //Define os campos a serem salvos
        $ips->parameters_id = $invoice->parameters_id;
        $ips->invoices_id   = $invoice->id;

        //Identifica se há cliente ou forncedor
        if ($invoice->sells_id)     $ips->sells_id     = $invoice->sells_id;
        if ($invoice->purchases_id) $ips->purchases_id = $invoice->purchases_id;

        //Salva vínculo
        if (!$this->InvoicesPurchasesSells->save($ips)) {

            return false;

            //Alerta de erro
            $message = 'InvoicesFunctionsComponent->addInvoicesPurchasesSells';
            $this->Error->registerError($ips, $message, true);

        }//if (!$this->InvoicesPurchasesSells->save($ips))

        return true;
    }

    public function findInvoicesPurchases($invoice)
    {
        //Localiza a compra pelo vínculo
        $ips = $this->InvoicesPurchasesSells->findByInvoicesIdAndParametersId($invoice->id, $invoice->parameters_id)
                                            ->first();
        //Retorna o pedido de compra
        return $ips->purchases_id;
    }

    public function findInvoicesSells($invoice)
    {
        //Localiza a venda pelo vínculo
        $ips = $this->InvoicesPurchasesSells->findByInvoicesIdAndParametersId($invoice->id, $invoice->parameters_id)
                                            ->first();
        //Retorna o pedido de venda
        return $ips->sells_id;
    }

    public function addItems($invoiceId, $productList, $parameters_id)
    {
        //Agrupa itens por id e unidade
        $productList = $this->ProductFunctions->groupByProductsId($productList);

        //Identifica os valores e adiciona aos campos
        foreach($productList as $item):
            
            //Novo item
            $invoiceItem = $this->InvoiceItems->newEntity();

            $invoiceItem->invoices_id   = $invoiceId;
            $invoiceItem->products_id   = $item['products_id'];
            $invoiceItem->unity         = $item['unity'];
            $invoiceItem->quantity      = $item['quantity'];
            $invoiceItem->vlunity       = $item['vlunity'];
            $invoiceItem->vldiscount    = $item['vldiscount'];
            $invoiceItem->ipi           = $item['ipi'];
            $invoiceItem->peripi        = $item['peripi'];
            $invoiceItem->icms          = $item['icms'];
            $invoiceItem->pericms       = $item['pericms'];
            $invoiceItem->icmssubst     = $item['icmssubst'];
            $invoiceItem->pericmssubst  = $item['pericmssubst'];
            $invoiceItem->vltotal       = $item['vltotal'];
            $invoiceItem->parameters_id = $parameters_id;

            if (!$this->InvoiceItems->save($invoiceItem)) {

                return false;

                //Alerta de erro
                $message = 'InvoicesFunctionsComponent->addItems';
                $this->Error->registerError($invoiceItem, $message, true);

            }//if (!$this->InvoiceItems->save($invoiceItem))

        endforeach;
        
        return true;
    }

    public function updateItems($invoiceId, $productList, $parameters_id)
    {
        
        //Delete all items
        $this->deleteItems($invoiceId, $parameters_id);

        //Add new items
        $this->addItems($invoiceId, $productList, $parameters_id);

    }

    public function deleteItems($invoiceId, $parameters_id)
    {
        $conditions = ['InvoiceItems.invoices_id'   => $invoiceId,
                       'InvoiceItems.parameters_id' => $parameters_id
                      ];
        
        $this->InvoiceItems->deleteAll($conditions, false);
    }
}