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

class RequisitionsFunctionsComponent extends Component
{
    public function __construct()
    {
        $this->Error = new ErrorComponent();

        $this->RequisitionItems       = TableRegistry::get('RequisitionItems');
        $this->StockBalancesFunctions = new StockBalancesFunctionsComponent();
        $this->ProductFunctions       = new ProductFunctionsComponent();
    }

    public function stock($requisition, $cancel = false)
    {
        //Lista de Produtos
        $productList = [];
        $index       = 0;

        /******************************************************************/

        //Consulta os itens da requisição
        $requisitionItems = $this->RequisitionItems->findByRequisitionsIdAndParametersId($requisition->id, $requisition->parameters_id);

        /******************************************************************/

        //Lista os produtos
        foreach ($requisitionItems as $requisitionItem):

            //Entrada ou Saída
            if ($requisition->type == 'I') {
                $quantity = $requisitionItem->quantity; //Incrementa do estoque
            } elseif ($requisition->type == 'O') {
                $quantity = $requisitionItem->quantity*-1; //Deduz do estoque
            }//elseif ($requisition->type == 'O')

            //Define os campos de itens
            $productList[$index]['products_id'] = $requisitionItem->products_id;
            $productList[$index]['quantity']    = $quantity;
            $productList[$index]['unity']       = $requisitionItem->unity;
            
            //Incrementa indice
            $index++;

        endforeach;

        /******************************************************************/

        //Atualiza o saldo de estoque
        $this->StockBalancesFunctions->balance($requisition->date, $productList, $requisition->parameters_id, $cancel);
    }

    public function addItems($requisitionId, $productList, $parameters_id)
    {
        //Agrupa itens por id e unidade
        $productList = $this->ProductFunctions->groupByProductsId($productList);

        //Identifica os valores e adiciona aos campos
        foreach($productList as $item):
            
            //Novo item
            $requisitionItem = $this->RequisitionItems->newEntity();

            $requisitionItem->requisitions_id = $requisitionId;
            $requisitionItem->products_id     = $item['products_id'];
            $requisitionItem->unity           = $item['unity'];
            $requisitionItem->quantity        = $item['quantity'];
            $requisitionItem->parameters_id   = $parameters_id;

            if (!$this->RequisitionItems->save($requisitionItem)) {

                return false;

                //Alerta de erro
                $message = 'RequisitionsFunctionsComponent->addItems';
                $this->Error->registerError($requisitionItem, $message, true);

            }//if (!$this->RequisitionItems->save($requisitionItem))

        endforeach;
        
        return true;
    }

    public function updateItems($requisitionId, $productList, $parameters_id)
    {
        
        //Delete all items
        $this->deleteItems($requisitionId, $parameters_id);

        //Add new items
        $this->addItems($requisitionId, $productList, $parameters_id);

    }

    public function deleteItems($requisitionId, $parameters_id)
    {
        $conditions = ['RequisitionItems.requisitions_id'  => $requisitionId,
                       'RequisitionItems.parameters_id' => $parameters_id
                      ];
        
        $this->RequisitionItems->deleteAll($conditions, false);
    }
}