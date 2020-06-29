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

class PurchaseRequestsFunctionsComponent extends Component
{
    public function __construct()
    {
        $this->Error = new ErrorComponent();

        $this->Purchases                 = TableRegistry::get('Purchases');
        $this->PurchaseRequests          = TableRegistry::get('PurchaseRequests');
        $this->PurchaseRequestItems      = TableRegistry::get('PurchaseRequestItems');
        $this->PurchasesPurchaseRequests = TableRegistry::get('PurchasesPurchaseRequests');
        $this->ProductFunctions          = new ProductFunctionsComponent();
    }

    public function findPurchasesPurchaseRequests($purchase_requests_id, $parameters_id)
    {
        //Lista de vínculos
        $purchases_list = [];

        //Consulta solicitações de compras vinculadas
        $purchasesPurchaseRequests = $this->PurchasesPurchaseRequests->findByParametersId($parameters_id)
                                                                     ->where(['PurchasesPurchaseRequests.purchase_requests_id' => $purchase_requests_id]);

        foreach ($purchasesPurchaseRequests as $purchasesPurchaseRequest):

            //Armazena a lista de requisições
            $purchases_list[] = $purchasesPurchaseRequest->purchases_id;

        endforeach;

        //Retorna array de solicitações de compras
        return $purchases_list;
    }

    public function addItems($purchaseRequestId, $productList, $parameters_id)
    {
        //Agrupa itens por id e unidade
        $productList = $this->ProductFunctions->groupByProductsId($productList);
        
        //Identifica os valores e adiciona aos campos
        foreach($productList as $item):
            
            //Novo item
            $purchaseRequestItem = $this->PurchaseRequestItems->newEntity();

            //Define objeto
            $purchaseRequestItem->purchase_requests_id = $purchaseRequestId;
            $purchaseRequestItem->products_id          = $item['products_id'];
            $purchaseRequestItem->unity                = $item['unity'];
            $purchaseRequestItem->quantity             = $item['quantity'];
            $purchaseRequestItem->parameters_id        = $parameters_id;
            strtotime($item['deadline']) ? $purchaseRequestItem->deadline = $item['deadline'] : ''; //Verifica se é uma data válida

            if (!$this->PurchaseRequestItems->save($purchaseRequestItem)) {

                return false;

                //Alerta de erro
                $message = 'PurchaseRequestsFunctionsComponent->addItems';
                $this->Error->registerError($purchaseRequestItem, $message, true);

            }//if (!$this->PurchaseRequestItems->save($purchaseRequestItem))

        endforeach;
        
        return true;
    }

    public function updateItems($purchaseRequestId, $productList, $parameters_id)
    {
        
        //Delete all items
        $this->deleteItems($purchaseRequestId, $parameters_id);

        //Add new items
        $this->addItems($purchaseRequestId, $productList, $parameters_id);

    }

    public function deleteItems($purchaseRequestId, $parameters_id)
    {
        $conditions = ['PurchaseRequestItems.purchase_requests_id'  => $purchaseRequestId,
                       'PurchaseRequestItems.parameters_id' => $parameters_id
                      ];
        
        $this->PurchaseRequestItems->deleteAll($conditions, false);
    }
}