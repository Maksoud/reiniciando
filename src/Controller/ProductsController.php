<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Products */
/* File: src/Controller/ProductsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class ProductsController extends AppController
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

        $this->loadComponent('ProductFunctions');
        $this->ProductTypes  = TableRegistry::get('ProductTypes');
        $this->ProductGroups = TableRegistry::get('ProductGroups');
        $this->ProductTitles = TableRegistry::get('ProductTitles');
    }
    
    public function index()
    {
        //Busca
        $where = $this->filter($this->request);

        $products_union = "((SELECT 
                                Products.id AS `id`, 
                                Products.parameters_id AS `parameters_id`, 
                                Products.created AS `created`, 
                                Products.modified AS `modified`, 
                                Products.username AS `username`, 
                                Products.product_groups_id, 
                                Products.product_types_id, 
                                Products.code AS `code`, 
                                Products.title AS `title`, 
                                Products.ean AS `ean`, 
                                Products.ncm AS `ncm`, 
                                Products.obs AS `obs`, 
                                Products.minimum AS `minimum`, 
                                Products.maximum AS `maximum`,
                                ProductTypes.id AS `ProductTypes__id`,
                                ProductTypes.parameters_id AS `ProductTypes__parameters_id`,
                                ProductTypes.code AS `ProductTypes__code`,
                                ProductTypes.title AS `ProductTypes__title`,
                                ProductTypes.calc_cost AS `ProductTypes__calc_cost`,
                                ProductGroups.id AS `ProductGroups__id`,
                                ProductGroups.parameters_id AS `ProductGroups__parameters_id`,
                                ProductGroups.code AS `ProductGroups__code`,
                                ProductGroups.title AS `ProductGroups__title`
                            FROM `products` Products
                            LEFT JOIN `product_groups` ProductGroups 
                                ON Products.product_groups_id = ProductGroups.id AND ProductGroups.parameters_id = Products.parameters_id
                            LEFT JOIN `product_types` ProductTypes 
                                ON Products.product_types_id = ProductTypes.id AND ProductTypes.parameters_id = Products.parameters_id
                            WHERE Products.parameters_id = ".$this->request->Session()->read('sessionParameterControl').")

                            UNION ALL

                            (SELECT 
                                Products.id AS `id`, 
                                ProductTitles.parameters_id AS `parameters_id`, 
                                ProductTitles.created AS `created`, 
                                ProductTitles.modified AS `modified`, 
                                Products.username AS `username`, 
                                Products.product_groups_id, 
                                Products.product_types_id, 
                                ProductTitles.code AS `code`, 
                                ProductTitles.title AS `title`, 
                                Products.ean AS `ean`, 
                                Products.ncm AS `ncm`, 
                                ProductTitles.obs AS `obs`, 
                                Products.minimum AS `minimum`, 
                                Products.maximum AS `maximum`,
                                ProductTypes.id AS `ProductTypes__id`,
                                ProductTypes.parameters_id AS `ProductTypes__parameters_id`,
                                ProductTypes.code AS `ProductTypes__code`,
                                ProductTypes.title AS `ProductTypes__title`,
                                ProductTypes.calc_cost AS `ProductTypes__calc_cost`,
                                ProductGroups.id AS `ProductGroups__id`,
                                ProductGroups.parameters_id AS `ProductGroups__parameters_id`,
                                ProductGroups.code AS `ProductGroups__code`,
                                ProductGroups.title AS `ProductGroups__title`
                                -- ProductTitles.products_id
                            FROM `product_titles` ProductTitles
                            LEFT JOIN `products` Products 
                                ON Products.id = ProductTitles.products_id AND Products.parameters_id = ProductTitles.parameters_id
                            LEFT JOIN `product_groups` ProductGroups 
                                ON Products.product_groups_id = ProductGroups.id AND ProductGroups.parameters_id = ProductTitles.parameters_id
                            LEFT JOIN `product_types` ProductTypes 
                                ON Products.product_types_id = ProductTypes.id AND ProductTypes.parameters_id = ProductTitles.parameters_id
                            WHERE ProductTitles.parameters_id = ".$this->request->Session()->read('sessionParameterControl').")
                            )";

        $products = $this->Products->find('all')
                                   ->from([$this->Products->alias() => $products_union])
                                   ->contain(['ProductTypes', 'ProductGroups'])
                                   ->where($where)
                                   ->order(['Products.title']);

        /**********************************************************************/
        
        $types = $this->ProductTypes->find('list')
                                    ->where(['ProductTypes.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                    ->order(['ProductTypes.title']);
        $types = $types->select(['id', 'title' => $types->func()->concat(['ProductTypes.code' => 'identifier',
                                                                          ' - ',
                                                                          'ProductTypes.title' => 'identifier'
                                                                         ])
                                ]);
        
        /**********************************************************************/
        
        $groups = $this->ProductGroups->find('list')
                                      ->where(['ProductGroups.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                      ->order(['ProductGroups.title']);
        $groups = $groups->select(['id', 'title' => $groups->func()->concat(['ProductGroups.code' => 'identifier',
                                                                             ' - ',
                                                                             'ProductGroups.title' => 'identifier'
                                                                            ])
                                  ]);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $products = $this->paginate($products);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $products = $this->paginate($products);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('products', 'types', 'groups'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $product = $this->Products->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                  ->contain(['ProductTypes', 'ProductGroups'])
                                  ->first();


        $productTitles = $this->ProductTitles->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                             ->where(['ProductTitles.products_id' => $product->id])
                                             ->join(['Products' => ['table'      => 'products',
                                                                    'type'       => 'INNER',
                                                                    'conditions' => 'Products.id = ProductTitles.products_id'
                                                                  ]
                                                    ])
                                             ->order(['ProductTitles.title']);
        
        /**********************************************************************/
        
        $this->set(compact('product', 'productTitles'));
    }

    public function add()
    {
        $product = $this->Products->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/

            //LIMPA FORMULÁRIO DE INSERÇÃO DE PRODUTOS
            unset($this->request->data['sub_code']);
            unset($this->request->data['sub_title']);
            unset($this->request->data['sub_obs']);
            
            /******************************************************************/
            
            //Consulta TITLE para evitar duplicidade
            $duplicidade = $this->Products->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                          ->select(['title'])
                                          ->where(['Products.title' => $this->request->data['title']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }//if (!empty($duplicidade->toArray()))
            
            /******************************************************************/
            
            $product = $this->Products->patchEntity($product, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $product->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $product->username      = $this->Auth->user('name');

            /******************************************************************/

            //Identifica se a lista de descrições secundárias foi preenchida
            if (!empty($this->request->data['ProductList'])) {
                $productList = $this->request->data['ProductList'];
                unset($this->request->data['ProductList']);
            }//if (!empty($this->request->data['ProductList']))
            
            /******************************************************************/
            
            if ($this->Products->save($product)) {

                //Grava descrições secundárias
                if (!empty($productList)) {
                    $this->ProductFunctions->addItems($product, $productList);
                }//if (!empty($productList))
            
                /**************************************************************/
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Products->save($product))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'ProductsController->add';
            $this->Error->registerError($product, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];

        $types = $this->Products->ProductTypes->find('list')
                                              ->where($conditions)
                                              ->order(['ProductTypes.title']);
        $types = $types->select(['id', 'title' => $types->func()->concat(['ProductTypes.code' => 'identifier',
                                                                          ' - ',
                                                                          'ProductTypes.title' => 'identifier'
                                                                         ])
                                ]);
        $this->set('types', $types);
            
        /**********************************************************************/

        $groups = $this->Products->ProductGroups->find('list')
                                                ->where($conditions)
                                                ->order(['ProductGroups.title']);
        $groups = $groups->select(['id', 'title' => $groups->func()->concat(['ProductGroups.code' => 'identifier',
                                                                             ' - ',
                                                                             'ProductGroups.title' => 'identifier'
                                                                            ])
                                  ]);
        $this->set('groups', $groups);
    }
    
    public function addjson()
    {
        $mensagem = "Nenhuma requisição foi identificada";
        $status   = "error";
        $errors   = [];
        $id       = null;
        $title    = null;
        
        if ($this->request->is('post')) {

            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {

                $mensagem = 'Sem permissão para realizar a operação solicitada';

                $this->response->type('json');  
                $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
                return $this->response;

            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $this->request->data['username']      = $this->Auth->user('name');
            
            /******************************************************************/

            //LIMPA FORMULÁRIO DE INSERÇÃO DE PRODUTOS
            unset($this->request->data['sub_code']);
            unset($this->request->data['sub_title']);
            unset($this->request->data['sub_obs']);
            
            /******************************************************************/
            
            $product = $this->Products->newEntity($this->request->data, ['validate' => 'novo']);

            /******************************************************************/

            //Identifica se a lista de descrições secundárias foi preenchida
            if (!empty($this->request->data['ProductList'])) {
                $productList = $this->request->data['ProductList'];
                unset($this->request->data['ProductList']);
            }//if (!empty($this->request->data['ProductList']))
            
            /******************************************************************/
            
            if ($this->Products->save($product)) {

                //Grava descrições secundárias
                if (!empty($productList)) {
                    $this->ProductFunctions->addItems($product, $productList);
                }//if (!empty($productList))
                
                /**************************************************************/
                
                $mensagem = 'Registro gravado com sucesso';
                $status   = 'ok';
                $id       = $product->id;
                $title    = $product->title;
                
            } else { 

                $mensagem = 'Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente';

                //Alerta de erro
                $message = 'ProductsController->addjson';
                $this->Error->registerError($product, $message, true);

            }//else if ($this->Products->save($product))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'title')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $product = $this->Products->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                  ->contain(['ProductTypes', 'ProductGroups'])
                                  ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/

            //LIMPA FORMULÁRIO DE INSERÇÃO DE PRODUTOS
            unset($this->request->data['sub_code']);
            unset($this->request->data['sub_title']);
            unset($this->request->data['sub_obs']);
            
            /******************************************************************/
            
            $product = $this->Products->patchEntity($product, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $product->username = $this->Auth->user('name');

            /******************************************************************/

            //Identifica se a lista de descrições secundárias foi preenchida
            if (!empty($this->request->data['ProductList'])) {
                $productList = $this->request->data['ProductList'];
                unset($this->request->data['ProductList']);
            }//if (!empty($this->request->data['ProductList']))
            
            /******************************************************************/
            
            if ($this->Products->save($product)) {

                //Grava descrições secundárias
                if (!empty($productList)) {
                    $this->ProductFunctions->updateItems($product, $productList);
                }//if (!empty($productList))
            
                /**************************************************************/
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Products->save($product))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'ProductsController->edit';
            $this->Error->registerError($product, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];

        $types = $this->Products->ProductTypes->find('list')
                                              ->where($conditions)
                                              ->order(['ProductTypes.title']);
        $types = $types->select(['id', 'title' => $types->func()->concat(['ProductTypes.code' => 'identifier',
                                                                          ' - ',
                                                                          'ProductTypes.title' => 'identifier'
                                                                         ])
                                ]);
        $this->set('types', $types);
            
        /**********************************************************************/

        $groups = $this->Products->ProductGroups->find('list')
                                                ->where($conditions)
                                                ->order(['ProductGroups.title']);
        $groups = $groups->select(['id', 'title' => $groups->func()->concat(['ProductGroups.code' => 'identifier',
                                                                             ' - ',
                                                                             'ProductGroups.title' => 'identifier'
                                                                            ])
                                  ]);
        $this->set('groups', $groups);
        
        /**********************************************************************/

        $productTitles = $this->ProductTitles->findByProductsIdAndParametersId($product->id, $this->request->Session()->read('sessionParameterControl'));
        $this->set('productTitles', $productTitles);
            
        /**********************************************************************/
        
        $this->set(compact('product'));
    }

    public function delete($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('delete', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('delete', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $this->request->allowMethod(['post', 'delete']);
        
        /**********************************************************************/
        
        //CONSULTA REGISTRO PARA GRAVAÇÃO DE LOG E CONSULTA DE MOVIMENTOS
        $product = $this->Products->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                  ->first();
        
        /**********************************************************************/

        if (!empty($product)) {

            //INATIVA O PRODUTO, EVITA PERDA DE HISTÓRICO DE COMPRAS/VENDAS/REQUISIÇÕES/SALDOS DE ESTOQUE
            $product->title    = $product->title.' (INATIVO)';
            $product->username = $this->Auth->user('name');
            
            /**********************************************************************/

            if ($this->Products->save($product)) {
                
                $this->Log->gravaLog($product, 'inativate', 'Products'); //GRAVA LOG

                //EXCLUI REGISTROS VINCULADOS
                $this->ProductFunctions->deleteItems($product);
                
                $this->Flash->warning(__('Registro inativado. Não pode ser excluído para evitar falha nos relatórios'));
                return $this->redirect($this->referer());
                
            }//if ($this->Products->save($product))

        }//if (!empty($product))
        
        /**********************************************************************/
        
        //Alerta de erro
        $message = 'ProductsController->delete';
        $this->Error->registerError($product, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function report()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            //CHAMA FUNÇÃO PARA CONSULTAS
            $ordenacao = $this->request->data['Ordem'];
            $periodo   = [];

            /******************************************************************/
                
            // MONTAGEM DO SQL
            $conditions = ['Products.parameters_id = '.$this->request->Session()->read('sessionParameterControl')];
            
            /**************************************************************/
            
            if ($this->request->data['product_types_id']) {

                //Separa a lista de tipos de produtos
                foreach($this->request->data['product_types_id'] as $value):
                    $list_types[] = $value;
                endforeach;
                
                //Conditions dos tipos de produtos
                $conditions[] = 'Products.product_types_id IN (' . implode(', ', $list_types) . ')';
                
                //Consulta os títulos dos tipos de produtos
                $productTypes = $this->ProductTypes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                   ->select(['ProductTypes.id', 'ProductTypes.title'])
                                                   ->where(['ProductTypes.id IN (' . implode(', ', $list_types) . ')']);

                $this->set('types', $productTypes);
                
            }//if ($this->request->data['product_types_id'])
            
            /**************************************************************/
            
            if ($this->request->data['product_groups_id']) {

                //Separa a lista de grupos de produtos
                foreach($this->request->data['product_groups_id'] as $value):
                    $list_groups[] = $value;
                endforeach;
                
                //Conditions dos grupos de produtos
                $conditions[] = 'Products.product_groups_id IN (' . implode(', ', $list_groups) . ')';
                
                //Consulta os títulos dos grupos de produtos
                $productGroups = $this->ProductGroups->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                     ->select(['ProductGroups.id', 'ProductGroups.title'])
                                                     ->where(['ProductGroups.id IN (' . implode(', ', $list_groups) . ')']);

                $this->set('groups', $productGroups);
                
            }//if ($this->request->data['product_groups_id'])
                
            /******************************************************************/

            if ($this->request->data['withbalance'] == 'S') {

                $conditions[] = 'StockBalances.quantity > 0';

            }//if ($this->request->data['withbalance'])

            /******************************************************************/

            $fields = ['Products.id', 'Products.parameters_id', 'Products.title', 'Products.code',
                       'Products.ean', 'Products.ncm', 'Products.product_types_id', 'Products.product_groups_id', 
                       'Products.obs', 'Products.minimum', 'Products.maximum', 
                       'ProductTypes.id', 'ProductTypes.parameters_id', 'ProductTypes.title', 
                       'ProductGroups.id', 'ProductGroups.parameters_id', 'ProductGroups.title', 
                       'StockBalances.id', 'StockBalances.parameters_id', 'StockBalances.products_id', 
                       'StockBalances.quantity', 'StockBalances.unity', 'StockBalances.date'
                      ];

            $products = $this->Products->find('all')
                                       ->select($fields)
                                       ->contain(['ProductTypes', 'ProductGroups'])
                                       ->join(['StockBalances' => ['table'      => 'stock_balances',
                                                                   'type'       => 'LEFT',
                                                                   'conditions' => 'StockBalances.products_id = Products.id'
                                                                  ]
                                              ])
                                       ->where($conditions)
                                       ->order(['Products.'.$ordenacao]);

            $this->set('products', $products);

            /******************************************************************/

            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());

            /******************************************************************/

            //Evitar página de erro
            $this->render('reports/sem_relatorio');

            /******************************************************************/
            
            $this->render('/Products/reports/produtos_analitico');
            
        }//if ($this->request->is(['patch', 'post', 'put']))
            
        /******************************************************************/
        
        //TIPOS DE PRODUTOS
        $productTypes = $this->ProductTypes->find('list')
                                           ->select(['ProductTypes.id', 'ProductTypes.title'])
                                           ->where(['ProductTypes.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                           ->order(['ProductTypes.title']);
        
        $this->set('types', $productTypes);
        
        /******************************************************************/
        
        //GRUPOS DE PRODUTOS
        $productGroups = $this->ProductGroups->find('list')
                                             ->select(['ProductGroups.id', 'ProductGroups.title'])
                                             ->where(['ProductGroups.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                             ->order(['ProductGroups.title']);
        
        $this->set('groups', $productGroups);

    }
    
    public function filter($request)
    {
        $table = 'Products';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['code_search'])) { 
            $where[] = '('.$table.'.code LIKE "%'.$this->params['code_search'].
                       //'%" OR ProductTitles.code LIKE "%'.$this->params['code_search'].
                       '%" OR '.$table.'.ncm LIKE "%'.$this->params['code_search'].
                       '%" OR '.$table.'.ean LIKE "%'.$this->params['code_search'].'%")';
        }
        
        if (!empty($this->params['title_search'])) { 
            $where[] = '('.$table.'.title LIKE "%'.$this->params['title_search'].
                       //'%" OR ProductTitles.title LIKE "%'.$this->params['title_search'].
                       '%")';
        }
        
        if (!empty($this->params['product_types_id_search'])) { 
            $where[] = '('.$table.'.product_types_id LIKE "%'.$this->params['product_types_id_search'].'%")';
        }
        
        if (!empty($this->params['product_groups_id_search'])) { 
            $where[] = '('.$table.'.product_groups_id LIKE "%'.$this->params['product_groups_id_search'].'%")';
        }
        
        return $where;
    }
    
    public function json()
    {
        if ($this->request->is('get')) {
            
            if (isset($this->request->query['query'])) {
                
                $query[] = '(Products.code LIKE "%'.$this->request->query['query'].'%"'.
                           'OR Products.title LIKE "%'.$this->request->query['query'].'%"'.
                           'OR ProductTitles.code LIKE "%'.$this->request->query['query'].'%"'.
                           'OR ProductTitles.title LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))

            $productTitles = $this->ProductTitles->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['Products.id', 'ProductTitles.parameters_id', 
                                                           'ProductTitles.code', 'ProductTitles.title'
                                                          ])
                                                 ->join(['Products' => ['table'      => 'products',
                                                                        'type'       => 'LEFT',
                                                                        'conditions' => 'ProductTitles.products_id = Products.id'
                                                                       ]
                                                        ])
                                                 ->where($query)
                                                 ->order(['ProductTitles.title']);

            $products = $this->Products->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['Products.id', 'Products.parameters_id', 
                                                 'Products.code', 'Products.title'
                                                ])
                                       ->join(['ProductTitles' => ['table'      => 'product_titles',
                                                                   'type'       => 'LEFT',
                                                                   'conditions' => 'Products.id = ProductTitles.products_id'
                                                                  ]
                                              ])
                                       ->where($query)
                                       ->order(['Products.title']);
            
            //Union
            $products->union($productTitles);

            $json = [];
            
            foreach ($products as $data) {
                array_push($json, [
                    'id'    => $data->id,
                    'value' => $data->title
                ]);
            }
            
            echo json_encode($json);
            
        }
        
        $this->autoRender = false;
        die();
    }
}