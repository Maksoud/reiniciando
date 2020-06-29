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

class ProductFunctionsComponent extends Component
{
    public function __construct()
    {
        $this->Error = new ErrorComponent();
        $this->ProductTitles = TableRegistry::get('ProductTitles');
    }

    public function groupByProductsId($productList)
    {
        $products = [];

        //Lista itens para somar quantidades de produtos com mesmo id
        foreach ($productList as $key => $val):

            //Adiciona item ao array de produtos
            array_push($products, $val);

            //O produto está na lista?
            foreach ($products as $key2 => $val2) {

                //debug($key2);
                //debug($val2);

                //Identifica se o id do produto já está no array de produtos
                if (array_search($val['products_id'], $val2) == 'products_id') {

                    //Identifica se o código é igual e a descrição diferente
                    if ($val['products_id'] == $val2['products_id'] && $val['products_title'] != $val2['products_title']) {

                        //Identifica se a unidade é igual
                        if ($val['unity'] == $val2['unity']) {

                            $val_quantity  = round(floatval($val['quantity']), 4);
                            $val2_quantity = round(floatval($val2['quantity']), 4);

                            //Acumula a quantidade
                            $products[$key]['quantity'] = number_format($val_quantity + $val2_quantity, 4, '.', '');

                            //Identifica se o valor está no array
                            if (in_array($products[$key2], $products)) {

                                //Remove o item do array
                                unset($products[array_search($products[$key2], $products)]);
                                unset($val2);

                            }//if (in_array($productList[$key], $array))

                            //debug($productList);
                            //debug($products);

                        }//if ($item['unity'] == $product['unity'])
    
                    }//if ($item['products_id'] == $product['products_id'])

                }//if (array_search($item['products_id'], $val) == 'products_id')

            }//foreach ($products as $key => $val)

        endforeach;

        return $products;
    }

    public function addItems($product, $productList)
    {
        //Identifica os valores e adiciona aos campos
        foreach($productList as $item):
            
            //Novo item
            $productTitle = $this->ProductTitles->newEntity();

            $productTitle->products_id    = $product->id;
            $productTitle->code           = $item['products_code'];
            $productTitle->title          = $item['products_title'];
            $productTitle->obs            = $item['products_obs'];
            $productTitle->username       = $product->username;
            $productTitle->parameters_id  = $product->parameters_id;

            if (!$this->ProductTitles->save($productTitle)) {

                return false;

                //Alerta de erro
                $message = 'ProductsFunctionsComponent->addItems';
                $this->Error->registerError($productTitle, $message, true);

            }//if (!$this->ProductTitles->save($productTitle))

        endforeach;
        
        return true;
    }

    public function updateItems($product, $productList)
    {
        
        //Delete all items
        $this->deleteItems($product);

        //Add new items
        $this->addItems($product, $productList);

    }

    public function deleteItems($product)
    {
        $conditions = ['ProductTitles.products_id'   => $product->id,
                       'ProductTitles.parameters_id' => $product->parameters_id
                      ];
        
        $this->ProductTitles->deleteAll($conditions, false);
    }
}