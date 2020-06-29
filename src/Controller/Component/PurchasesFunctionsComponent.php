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

class PurchasesFunctionsComponent extends Component
{
    public function __construct()
    {
        $this->Error = new ErrorComponent();

        $this->PurchaseItems             = TableRegistry::get('PurchaseItems');
        $this->PurchaseRequests          = TableRegistry::get('PurchaseRequests');
        $this->PurchasesPurchaseRequests = TableRegistry::get('PurchasesPurchaseRequests');
        $this->ProductFunctions          = new ProductFunctionsComponent();
    }

    public function purchaseRequests($purchase, $cancel = false)
    {

        //Consulta as solicitações de compras vinculadas
        $purchasesPurchaseRequests = $this->PurchasesPurchaseRequests->findByParametersId($purchase->parameters_id)
                                                                     ->where(['PurchasesPurchaseRequests.purchases_id' => $purchase->id]);

        /**********************************************************************/
        
        if (!empty($purchasesPurchaseRequests->toArray())) {

            foreach ($purchasesPurchaseRequests as $purchasesPurchaseRequest):

                //Busca o lançamento de solicitação de compra
                $purchaseRequest = $this->PurchaseRequests->findByParametersId($purchase->parameters_id)
                                                          ->where(['PurchaseRequests.id' => $purchasesPurchaseRequest->purchase_requests_id])
                                                          ->first();

                if (!empty($purchaseRequest)) {

                    //Atualiza o status
                    /**
                     * Identificar quando o status for diferente de P, quando não for um cancelamento e diferente de A, quando for um cancelamento.
                     */
                    if ($cancel) {
                        $purchaseRequest->status = 'P'; // P - pending, A - in progress, C - cancelled, F - finalized
                    } else {
                        $purchaseRequest->status = 'A'; // P - pending, A - in progress, C - cancelled, F - finalized
                    }

                    /******************************************************************/

                    //Salva as alterações
                    if (!$this->PurchaseRequests->save($purchaseRequest)) {

                        return false;

                        //Alerta de erro
                        $message = 'PurchasesFunctionsComponent->purchaseRequests';
                        $this->Error->registerError($purchaseRequest, $message, true);

                    }//if (!$this->PurchaseRequests->save($purchaseRequest))

                }//if (!empty($purchaseRequest))

            endforeach;
            
        }//if (!empty($purchasesPurchaseRequests->toArray()))
        
        /**********************************************************************/

        return true;
    }

    public function addPurchasesPurchaseRequests($purchase, $purchase_requests)
    {
        //Lista as solicitações de compras selecionadas
        foreach ($purchase_requests as $purchase_request):

            //Novo item
            $ppr = $this->PurchasesPurchaseRequests->newEntity();

            //Define os campos a serem salvos
            $ppr->parameters_id        = $purchase->parameters_id;
            $ppr->purchases_id         = $purchase->id;
            $ppr->purchase_requests_id = $purchase_request;

            //Salva vínculo
            if (!$this->PurchasesPurchaseRequests->save($ppr)) {

                return false;

                //Alerta de erro
                $message = 'PurchasesFunctionsComponent->addPurchasesPurchaseRequests';
                $this->Error->registerError($ppr, $message, true);

            }//if (!$this->PurchasesPurchaseRequests->save($ppr))

        endforeach;

        return true;
    }

    public function findPurchasesPurchaseRequests($purchases_id, $parameters_id)
    {
        //Lista de vínculos
        $purchaseRequests_list = [];

        //Consulta solicitações de compras vinculadas
        $purchasesPurchaseRequests = $this->PurchasesPurchaseRequests->findByParametersId($parameters_id)
                                                                     ->where(['PurchasesPurchaseRequests.purchases_id' => $purchases_id]);

        foreach ($purchasesPurchaseRequests as $purchasesPurchaseRequest):

            //Armazena a lista de requisições
            $purchaseRequests_list[] = $purchasesPurchaseRequest->purchase_requests_id;

        endforeach;

        //Retorna array de solicitações de compras
        return $purchaseRequests_list;
    }

    public function addItems($purchaseId, $productList, $parameters_id)
    {
        //Agrupa itens por id e unidade
        $productList = $this->ProductFunctions->groupByProductsId($productList);

        //Identifica os valores e adiciona aos campos
        foreach($productList as $item):
            
            //Novo item
            $purchaseItem = $this->PurchaseItems->newEntity();

            //Define valores
            if (isset($item['vlunity']))      { $vlunity = $item['vlunity']; } else { $vlunity = "0,00"; }
            if (isset($item['vldiscount']))   { $vldiscount = $item['vldiscount']; } else { $vldiscount = "0,00"; }
            if (isset($item['ipi']))          { $ipi = $item['ipi']; } else { $ipi = "0,00"; }
            if (isset($item['peripi']))       { $peripi = $item['peripi']; } else { $peripi = "0,00"; }
            if (isset($item['icms']))         { $icms = $item['icms']; } else { $icms = "0,00"; }
            if (isset($item['pericms']))      { $pericms = $item['pericms']; } else { $pericms = "0,00"; }
            if (isset($item['icmssubst']))    { $icmssubst = $item['icmssubst']; } else { $icmssubst = "0,00"; }
            if (isset($item['pericmssubst'])) { $pericmssubst = $item['pericmssubst']; } else { $pericmssubst = "0,00"; }
            if (isset($item['vltotal']))      { $vltotal = $item['vltotal']; } else { $vltotal = "0,00"; }

            $purchaseItem->purchases_id  = $purchaseId;
            $purchaseItem->products_id   = $item['products_id'];
            $purchaseItem->unity         = $item['unity'];
            $purchaseItem->quantity      = $item['quantity'];
            $purchaseItem->vlunity       = $vlunity;
            $purchaseItem->vldiscount    = $vldiscount;
            $purchaseItem->ipi           = $ipi;
            $purchaseItem->peripi        = $peripi;
            $purchaseItem->icms          = $icms;
            $purchaseItem->pericms       = $pericms;
            $purchaseItem->icmssubst     = $icmssubst;
            $purchaseItem->pericmssubst  = $pericmssubst;
            $purchaseItem->vltotal       = $vltotal;
            $purchaseItem->parameters_id = $parameters_id;

            if (!$this->PurchaseItems->save($purchaseItem)) {

                return false;

                //Alerta de erro
                $message = 'PurchasesFunctionsComponent->addItems';
                $this->Error->registerError($purchaseItem, $message, true);

            }//if (!$this->PurchaseItems->save($purchaseItem))

        endforeach;
        
        return true;
    }

    public function updateItems($purchaseId, $productList, $parameters_id)
    {
        
        //Delete all items
        $this->deleteItems($purchaseId, $parameters_id);

        //Add new items
        $this->addItems($purchaseId, $productList, $parameters_id);

    }

    public function deleteItems($purchaseId, $parameters_id)
    {
        $conditions = ['PurchaseItems.purchases_id'  => $purchaseId,
                       'PurchaseItems.parameters_id' => $parameters_id
                      ];
        
        $this->PurchaseItems->deleteAll($conditions, false);
    }
}