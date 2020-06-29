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

class IndustrializationsFunctionsComponent extends Component
{
    public function __construct()
    {
        $this->Error = new ErrorComponent();
        $this->IndustrializationItems = TableRegistry::get('IndustrializationItems');
    }

    public function addItems($industrializations_id, $productList, $parameters_id)
    {
        //Identifica os valores e adiciona aos campos
        foreach($productList as $item):
            
            //Novo item
            $industrializationItem = $this->IndustrializationItems->newEntity();

            $industrializationItem->industrializations_id = $industrializations_id;
            $industrializationItem->products_id           = $item['products_id'];
            $industrializationItem->unity                 = $item['unity'];
            $industrializationItem->quantity              = $item['quantity'];
            $industrializationItem->parameters_id         = $parameters_id;
            !empty($item['obs']) ? $industrializationItem->obs = $item['obs'] : '';

            if (!$this->IndustrializationItems->save($industrializationItem)) {

                return false;

                //Alerta de erro
                $message = 'IndustrializationsFunctionsComponent->addItems';
                $this->Error->registerError($industrializationItem, $message, true);

            }//if (!$this->IndustrializationItems->save($industrializationItem))

        endforeach;
        
        return true;
    }

    public function updateItems($industrializations_id, $productList, $parameters_id)
    {
        
        //Delete all items
        $this->deleteItems($industrializations_id, $parameters_id);

        //Add new items
        $this->addItems($industrializations_id, $productList, $parameters_id);

    }

    public function deleteItems($industrializations_id, $parameters_id)
    {
        $conditions = ['IndustrializationItems.industrializations_id' => $industrializations_id,
                       'IndustrializationItems.parameters_id'         => $parameters_id
                      ];
        
        $this->IndustrializationItems->deleteAll($conditions, false);
    }
    
}