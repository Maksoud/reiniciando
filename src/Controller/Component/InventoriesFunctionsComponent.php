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

class InventoriesFunctionsComponent extends Component
{
    public function __construct()
    {
        $this->Error = new ErrorComponent();
        $this->InventoryItems         = TableRegistry::get('InventoryItems');
        $this->StockBalancesFunctions = new StockBalancesFunctionsComponent();
    }

    public function stock($inventory, $cancel = false)
    {
        //Lista de Produtos
        $productList = [];
        $index       = 0;

        /******************************************************************/

        //Consulta os itens do faturamento
        $inventoryItems = $this->InventoryItems->findByInvoicesIdAndParametersId($inventory->id, $inventory->parameters_id);

        /******************************************************************/

        //Lista os produtos
        foreach ($inventoryItems as $inventoryItem):

            //Define os campos de itens
            $productList[$index]['products_id'] = $inventoryItem->products_id;
            $productList[$index]['quantity']    = $inventoryItem->quantity;
            $productList[$index]['unity']       = $inventoryItem->unity;
            
            //Incrementa indice
            $index++;
            
        endforeach;

        /******************************************************************/

        //Atualiza o saldo de estoque
        $this->StockBalancesFunctions->balance($inventory->date, $productList, $inventory->parameters_id, $cancel);
    }

    public function addItems($inventories_id, $productList, $parameters_id)
    {
        //Identifica os valores e adiciona aos campos
        foreach($productList as $item):
            
            //Novo item
            $inventoryItem = $this->InventoryItems->newEntity();

            $inventoryItem->inventories_id = $inventories_id;
            $inventoryItem->products_id    = $item['products_id'];
            $inventoryItem->unity          = $item['unity'];
            $inventoryItem->quantity       = $item['quantity'];
            $inventoryItem->parameters_id  = $parameters_id;

            if (!$this->InventoryItems->save($inventoryItem)) {
                
                return false;

                //Alerta de erro
                $message = 'InventoriesFunctionsComponent->addItems';
                $this->Error->registerError($inventoryItem, $message, true);

            }//if (!$this->InventoryItems->save($inventoryItem))

        endforeach;
        
        return true;
    }

    public function updateItems($inventories_id, $productList, $parameters_id)
    {
        
        //Delete all items
        $this->deleteItems($inventories_id, $parameters_id);

        //Add new items
        $this->addItems($inventories_id, $productList, $parameters_id);

    }

    public function deleteItems($inventories_id, $parameters_id)
    {
        $conditions = ['InventoryItems.inventories_id' => $inventories_id,
                       'InventoryItems.parameters_id'  => $parameters_id
                      ];
        
        $this->InventoryItems->deleteAll($conditions, false);
    }
}