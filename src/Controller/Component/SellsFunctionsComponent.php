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

class SellsFunctionsComponent extends Component
{
    public function __construct()
    {
        $this->Error = new ErrorComponent();

        $this->SellItems        = TableRegistry::get('SellItems');
        $this->ProductFunctions = new ProductFunctionsComponent();
    }

    public function addItems($sellId, $productList, $parameters_id)
    {
        //Agrupa itens por id e unidade
        $productList = $this->ProductFunctions->groupByProductsId($productList);

        //Identifica os valores e adiciona aos campos
        foreach($productList as $item):
            
            //Novo item
            $sellItem = $this->SellItems->newEntity();

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

            //Define objeto
            $sellItem->sells_id      = $sellId;
            $sellItem->products_id   = $item['products_id'];
            $sellItem->unity         = $item['unity'];
            $sellItem->quantity      = $item['quantity'];
            $sellItem->vlunity       = $vlunity;
            $sellItem->vldiscount    = $vldiscount;
            $sellItem->ipi           = $ipi;
            $sellItem->peripi        = $peripi;
            $sellItem->icms          = $icms;
            $sellItem->pericms       = $pericms;
            $sellItem->icmssubst     = $icmssubst;
            $sellItem->pericmssubst  = $pericmssubst;
            $sellItem->vltotal       = $vltotal;
            $sellItem->parameters_id = $parameters_id;

            if (!$this->SellItems->save($sellItem)) {

                return false;

                //Alerta de erro
                $message = 'SellsFunctionsComponent->addItems';
                $this->Error->registerError($sellItem, $message, true);

            }//if (!$this->SellItems->save($sellItem))

        endforeach;

        return true;
    }

    public function updateItems($sellId, $productList, $parameters_id)
    {
        //Delete all items
        $this->deleteItems($sellId, $parameters_id);

        //Add new items
        $this->addItems($sellId, $productList, $parameters_id);
    }

    public function deleteItems($sellId, $parameters_id)
    {
        $conditions = ['SellItems.sells_id'      => $sellId,
                       'SellItems.parameters_id' => $parameters_id
                      ];
        
        $this->SellItems->deleteAll($conditions, false);
    }
}