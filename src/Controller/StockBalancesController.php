<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Stock Balances */
/* File: src/Controller/StockBalancesController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class StockBalancesController extends AppController
{
    public $params = [];
    
    public function prepareParams($request = [])
    {
       if ($request->is('post')) {
            $params = $request->data;
       } else {
            $params = $request->query;
       }
       $this->params = $params;
    }
    
    public function initialize()
    {
        parent::initialize();

        $this->Products      = TableRegistry::get('Products');
        $this->ProductTypes  = TableRegistry::get('ProductTypes');
        $this->ProductGroups = TableRegistry::get('ProductGroups');
    }
    
    public function index()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/

        $balances = $this->StockBalances->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                        ->select(['id', 'parameters_id', 'created', 'modified', 'products_id', 'date', 'quantity', 'unity', 'vlcost', 
                                                  'Products.id', 'Products.parameters_id', 'Products.title', 'Products.product_groups_id', 'Products.product_types_id',
                                                  'Products.code', 'Products.minimum', 'Products.maximum', 
                                                  'ProductTypes.id', 'ProductTypes.parameters_id', 'ProductTypes.code', 'ProductTypes.title', 
                                                  'ProductGroups.id', 'ProductGroups.parameters_id', 'ProductGroups.code', 'ProductGroups.title',  
                                                  'Parameters.razao'
                                                 ])
                                        ->where($where)
                                        ->join(['Products' => ['table'      => 'Products',
                                                               'type'       => 'LEFT',
                                                               'conditions' => 'Products.id = StockBalances.products_id'
                                                              ],
                                                'ProductTypes' => ['table'      => 'Product_Types',
                                                                   'type'       => 'LEFT',
                                                                   'conditions' => 'ProductTypes.id = Products.product_types_id'
                                                                  ],
                                                'ProductGroups' => ['table'      => 'Product_Groups',
                                                                    'type'       => 'LEFT',
                                                                    'conditions' => 'ProductGroups.id = Products.product_groups_id'
                                                                   ],
                                               ])
                                        ->contain(['Parameters'])
                                        ->order(['StockBalances.parameters_id', 'StockBalances.date DESC', 'Products.title', 
                                                 'ProductTypes.title', 'ProductGroups.title'
                                                ])
                                        ->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $balances = $this->paginate($balances);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $balances = $this->paginate($balances);
            
        }
        
        $this->set(compact('balances'));

        /**********************************************************************/

        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];

        $this->set('productTypes', $this->ProductTypes->find('list')->where($conditions)->order(['ProductTypes.title']));
        $this->set('productGroups', $this->ProductGroups->find('list')->where($conditions)->order(['ProductGroups.title']));
        
    }
    
    public function filter($request)
    {
        $table = 'StockBalances';
        $where = [];
        $this->prepareParams($request);
        
        if (@$this->params['dtinicial']) { // datepicker
            $datepicker = explode("/", $this->params['dtinicial']);
            $dtinicial = implode('-', array_reverse($datepicker));
        }

        if (@$this->params['dtfinal']) { // datepicker
            $datepicker = explode("/", $this->params['dtfinal']);
            $dtfinal = implode('-', array_reverse($datepicker));
        }
        
        if (!empty($dtinicial) && !empty($dtfinal)) { 
            $where[] = $table.'.date BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"'; 
        } else {
            $where[] = $table.'.quantity > 0'; //Se nenhum período foi selecionado, exiba os produtos com estoque.
        }
        
        if (!empty($this->params['products_id'])) {
            if (is_array($this->params['products_id'])) { $products = implode(', ', $this->params['products_id']); } else { $products = $this->params['products_id']; }
            $where[] = $table.'.products_id IN ('. $products .')';
        }
        
        if (!empty($this->params['product_types_id'])) {
            if (is_array($this->params['product_types_id'])) { $types = implode(', ', $this->params['product_types_id']); } else { $types = $this->params['product_types_id']; }
            $where[] = 'Products.product_types_id IN ('. $types .')';
        }
        
        if (!empty($this->params['product_groups_id'])) {
            if (is_array($this->params['product_groups_id'])) { $groups = implode(', ', $this->params['product_groups_id']); } else { $groups = $this->params['product_groups_id']; }
            $where[] = 'Products.product_groups_id IN ('. $groups .')';
        }

        if (!empty($this->params['minimum'])) {
            $where[] = $table.'.quantity < Products.minimum';
        }

        if (!empty($this->params['maximum'])) {
            $where[] = $table.'.quantity > Products.maximum';
        }
        
        return $where;
    }
    
    public function reportForm()
    {
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('productTypes', $this->ProductTypes->find('list')->where($conditions)->order(['ProductTypes.title']));
        $this->set('productGroups', $this->ProductGroups->find('list')->where($conditions)->order(['ProductGroups.title']));
    }

}