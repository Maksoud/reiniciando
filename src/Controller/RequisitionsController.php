<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Requisitions */
/* File: src/Controller/RequisitionsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class RequisitionsController extends AppController
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

        $this->loadComponent('RequisitionsFunctions');
        $this->RequisitionItems = TableRegistry::get('RequisitionItems');
    }
    
    public function index()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $requisitions = $this->Requisitions->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->where($where)
                                           ->contain(['Industrializations', 'Industrializations.Sells.Customers'])
                                           ->order(['Requisitions.code']);
                                           //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $requisitions = $this->paginate($requisitions);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $requisitions = $this->paginate($requisitions);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('requisitions'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $requisition = $this->Requisitions->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                          ->contain(['Industrializations', 'Industrializations.Sells.Customers'])
                                          ->first();

        /**********************************************************************/
        
        $requisitionItems = $this->RequisitionItems->findByRequisitionsIdAndParametersId($requisition->id, $this->request->Session()->read('sessionParameterControl'))
                                                   ->contain(['Products']);
        
        /**********************************************************************/
        
        $this->set(compact('requisition', 'requisitionItems'));
    }

    public function add()
    {
        $requisition = $this->Requisitions->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/

            //LIMPA FORMULÁRIO DE INSERÇÃO DE PRODUTOS
            unset($this->request->data['products_id']);
            unset($this->request->data['unity']);
            unset($this->request->data['quantity']);

            /******************************************************************/

            //Identifica se a lista foi preenchida
            if (empty($this->request->data['ProductList'])) {

                $this->Flash->error(__('Não é possível gravar o registro sem itens'));
                return $this->redirect($this->referer());

            }//if (empty($this->request->data['ProductList']))

            //Itens do lançamento
            $productList = $this->request->data['ProductList'];
            unset($this->request->data['ProductList']);
            
            /******************************************************************/

            //DEFINE O CÓDIGO SEQUENCIAL
            $max_code = $this->Requisitions->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->select(['MAX' => 'MAX(Requisitions.code)'])
                                           ->first();
            $this->request->data['code'] = $max_code->MAX + 1;

            /******************************************************************/
            
            $requisition = $this->Requisitions->patchEntity($requisition, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $requisition->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $requisition->username      = $this->Auth->user('name');
            $requisition->status        = 'F'; // F - finalized, C - cancelled
            
            /******************************************************************/
            
            if ($this->Requisitions->save($requisition)) {

                //ITENS DA REQUISIÇÃO
                $this->RequisitionsFunctions->addItems($requisition->id, $productList, $requisition->parameters_id);
            
                /**************************************************************/

                //Registra o estoque
                $this->RequisitionsFunctions->stock($requisition);
            
                /**************************************************************/
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Requisitions->save($requisition))
        
            /******************************************************************/

            //Alerta de erro
            $message = 'RequisitionsController->add';
            $this->Error->registerError($requisition, $message, true);

            /**********************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        
        /**********************************************************************/

        $industrializations = $this->Requisitions->Industrializations->find('list', ['keyField'   => 'id',
                                                                                     'valueField' => function ($e) { return str_pad($e->code, 6, '0', STR_PAD_LEFT) . ' - ' . $e->Sells->Customers->title; }
                                                                                    ])
                                                                     ->where(['Industrializations.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                                              'Industrializations.status' => 'P' // P - pending, C - cancelled, F - finalized
                                                                             ])
                                                                     ->contain(['Sells.Customers'])
                                                                     ->order(['Industrializations.code']);
        $this->set('industrializations', $industrializations);
        
        /**********************************************************************/
        
        $max_code = $this->Requisitions->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                        ->select(['MAX' => 'MAX(Requisitions.code)'])
                                        ->first();
        $code = $max_code->MAX + 1;
        $this->set('code', $code);
    }
    
    public function addjson()
    {
        $mensagem = "Nenhuma requisição foi identificada";
        $status   = "error";
        $errors   = [];
        $id       = null;
        $code     = null;
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {

                $mensagem = 'Sem permissão para realizar a operação solicitada';

                $this->response->type('json');  
                $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
                return $this->response;

            }//if (!$this->SystemFunctions->validaAcesso()
            
            /******************************************************************/

            //LIMPA FORMULÁRIO DE INSERÇÃO DE PRODUTOS
            unset($this->request->data['products_id']);
            unset($this->request->data['unity']);
            unset($this->request->data['quantity']);

            /******************************************************************/

            //Identifica se a lista foi preenchida
            if (empty($this->request->data['ProductList'])) {

                $mensagem = 'Não é possível gravar o registro sem produtos';

                $this->response->type('json');  
                $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
                return $this->response;

            }//if (empty($this->request->data['ProductList']))

            //Itens do lançamento
            $productList = $this->request->data['ProductList'];
            unset($this->request->data['ProductList']);

            /******************************************************************/

            //DEFINE O CÓDIGO SEQUENCIAL
            $max_code = $this->Requisitions->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->select(['MAX' => 'MAX(Requisitions.code)'])
                                           ->first();
            $this->request->data['code'] = $max_code->MAX + 1;

            /******************************************************************/

            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $this->request->data['username']      = $this->Auth->user('name');
            $this->request->data['status']        = 'F'; // F - finalized, C - cancelled

            /******************************************************************/
            
            $requisition = $this->Requisitions->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/
            
            if ($this->Requisitions->save($requisition)) {
                
                //ITENS DA REQUISIÇÃO
                $this->RequisitionsFunctions->addItems($requisition->id, $productList, $requisition->parameters_id);
            
                /**************************************************************/
                
                //Registra o estoque
                $this->RequisitionsFunctions->stock($requisition);
            
                /**************************************************************/
                
                $mensagem = 'Registro gravado com sucesso';
                $status   = 'ok';
                $id       = $requisition->id;
                $code     = $requisition->code;
                
            } else { 
                
                $mensagem = 'Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente';

                //Alerta de erro
                $message = 'RequisitionsController->addjson';
                $this->Error->registerError($requisition, $message, true);

            }//else if ($this->Requisitions->save($requisition))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
        return $this->response;
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
        $requisition = $this->Requisitions->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                          ->first();
        
        /**********************************************************************/

        if (!empty($requisition)) {

            //VERIFICA SE O CADASTRO ESTÁ EM USO
            if ($requisition->status == 'F') { // F - finalized, C - cancelled
                
                $this->Flash->warning(__('Registro precisa ser cancelado antes da exclusão'));
                return $this->redirect($this->referer());
                
            }//if ($requisition->status == 'F')
                
            /**********************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($requisition, 'delete', 'Requisitions');
            
            /**********************************************************************/
            
            if ($this->Requisitions->delete($requisition)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Requisitions->delete($requisition))

        }//if (!empty($requisition))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'RequisitionsController->delete';
        $this->Error->registerError($requisition, $message, true);

        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }

    public function cancel($id)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            //Consulta o registro
            $requisition = $this->Requisitions->get($id);
                
            /******************************************************************/

            //Define o status para cancelado
            if ($requisition->status == 'F') {

                $requisition->status = 'C'; // F - finalized, C - cancelled
                
            }//elseif ($requisition->status == 'F')
                
            /******************************************************************/
            
            if ($this->Requisitions->save($requisition)) {

                //Registra o estoque
                $this->RequisitionsFunctions->stock($requisition, true);
                
                $this->Flash->warning(__('Registro cancelado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Requisitions->save($requisition))
        
            /******************************************************************/

            //Alerta de erro
            $message = 'RequisitionsController->cancel';
            $this->Error->registerError($requisition, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO cancelado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['ajax']))
    }
    
    public function report()
    {
        $this->Sells            = TableRegistry::get('Sells');
        $this->Customers        = TableRegistry::get('Customers');

        if ($this->request->is(['patch', 'post', 'put'])) {

            //CHAMA FUNÇÃO PARA CONSULTAS
            $ordenacao = $this->request->data['Ordem'];
            $periodo   = [];

            /******************************************************************/
                
            // MONTAGEM DO SQL
            $conditions = ['Requisitions.parameters_id = '.$this->request->Session()->read('sessionParameterControl')];

            /******************************************************************/

            //PERÍODO DE CONSULTA
            if ($this->request->data['dtinicial']) { // datepicker
                $datepicker = explode("/", $this->request->data['dtinicial']);
                $dtinicial = implode('-', array_reverse($datepicker));
            }
            if ($this->request->data['dtfinal']) { // datepicker
                $datepicker = explode("/", $this->request->data['dtfinal']);
                $dtfinal = implode('-', array_reverse($datepicker));
            }

            $conditions[] = '(Requisitions.date BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'")';

            /******************************************************************/

            //FILTRA POR STATUS
            if (!empty($this->request->data['status'])) {
                $conditions[] = '(Requisitions.status = "' . $this->request->data['status'] . '")';
            }//if (!empty($this->request->data['status']))

            /******************************************************************/

            $fields = ['Requisitions.id', 'Requisitions.parameters_id', 'Requisitions.code', 'Requisitions.date', 
                       'Requisitions.industrializations_id', 'Requisitions.applicant', 'Requisitions.status', 
                       'Requisitions.type', 'Requisitions.obs', 
                       'Industrializations.id', 'Industrializations.parameters_id', 'Industrializations.code', 
                       'Industrializations.date', 'Industrializations.sells_id',  'Industrializations.status',
                       'Sells.id', 'Sells.parameters_id', 'Sells.date', 'Sells.code', 'Sells.customercode', 
                       'Sells.customers_id', 'Sells.status', 'Sells.deadline', 'Sells.shipment', 
                       'Customers.id', 'Customers.parameters_id', 'Customers.title', 'Customers.fantasia', 
                       'Customers.cpfcnpj', 
                      ];

            $requisitions = $this->Requisitions->find('all')
                                               ->select($fields)
                                               ->join(['Industrializations' => ['table'      => 'industrializations',
                                                                                'type'       => 'LEFT',
                                                                                'conditions' => 'Industrializations.id = Requisitions.industrializations_id'
                                                                               ],
                                                       'Sells' => ['table'      => 'sells',
                                                                   'type'       => 'LEFT',
                                                                   'conditions' => 'Sells.id = Industrializations.sells_id'
                                                                  ],
                                                       'Customers' => ['table'      => 'customers',
                                                                       'type'       => 'LEFT',
                                                                       'conditions' => 'Customers.id = Sells.customers_id'
                                                                      ]
                                                      ])
                                                ->where($conditions)
                                                ->order(['Requisitions.'.$ordenacao]);

            $this->set('requisitions', $requisitions);

            /******************************************************************/

            //LISTA O ID
            $requisitions_id = [];
            foreach ($requisitions as $requisition):
                $requisitions_id[] = $requisition->id;
            endforeach;

            /******************************************************************/

            //ITENS DAS REQUISIÇÕES
            $requisitionItems = $this->RequisitionItems->find('all')
                                                       ->select(['RequisitionItems.id', 'RequisitionItems.parameters_id', 'RequisitionItems.requisitions_id', 
                                                                 'RequisitionItems.products_id', 'RequisitionItems.quantity', 'RequisitionItems.unity', 
                                                                 'Products.id', 'Products.parameters_id', 'Products.code', 'Products.title'
                                                                ])
                                                       ->join(['Products' => ['table'      => 'products',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'Products.id = RequisitionItems.products_id'
                                                                              ]
                                                              ])
                                                       ->where(['RequisitionItems.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                                'RequisitionItems.requisitions_id IN' => $requisitions_id
                                                               ]);

            $this->set('requisitionItems', $requisitionItems);

            /******************************************************************/

            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());

            /******************************************************************/

            //Evitar página de erro
            $this->render('/Requisitions/reports/sem_relatorio');

            /******************************************************************/
            
            $this->render('/Requisitions/reports/requisicoes_analitico');
            
        }//if ($this->request->is(['patch', 'post', 'put']))
            
        /******************************************************************/
        
        //VENDAS EM ABERTO OU EM PROCESSO
        $sells = $this->Sells->find('list', ['keyField'   => 'id',
                                             'valueField' => function ($e) { return str_pad($e->code, 6, '0', STR_PAD_LEFT) . ' - ' . $e->Customers->title; }
                                            ])
                             ->contain(['Customers'])
                             ->where(['Sells.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                      'Sells.status IN' => ['P', 'D', 'E', 'F'] // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
                                     ])
                             ->order(['Sells.code']);
        
        $this->set('sells', $sells);
        
        /******************************************************************/
        
        //CLIENTES
        $customers = $this->Customers->find('list')
                                     ->select(['Customers.id', 'Customers.title'])
                                     ->where(['Customers.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                     ->order(['Customers.title']);
        
        $this->set('customers', $customers);
            
        /******************************************************************/
        
        //ORDENS DE FABRICAÇÃO EM ABERTO
        $industrializations = $this->Requisitions->Industrializations->find('list', ['keyField'   => 'id',
                                                                                     'valueField' => function ($e) { return str_pad($e->code, 6, '0', STR_PAD_LEFT) . ' - ' . $e->Sells->Customers->title; }
                                                                                    ])
                                                                     ->contain(['Sells.Customers'])
                                                                     ->where(['Industrializations.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                                              'Industrializations.status IN' => ['P', 'F'] // P - pending, C - cancelled, F - finalized
                                                                             ])
                                                                     ->order(['Industrializations.code']);
        
        $this->set('industrializations', $industrializations);

    }
    
    public function filter($request)
    {
        $table = 'Requisitions';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['code_search'])) { 
            $where[] = '('.$table.'.code LIKE "%'.$this->params['code_search'].'%")';
        }
        
        if (!empty($this->params['status_search'])) { 
            $where[] = '('.$table.'.status = "'.$this->params['status_search'].'")';
        } else {
            $where[] = '('.$table.'.status = "F")'; // F - finalized, C - cancelled
        }
        
        if (!empty($this->params['type_search'])) { 
            $where[] = '('.$table.'.type = "'.$this->params['type_search'].'")';
        }
        
        return $where;
    }
    
    public function json()
    {
        if ($this->request->is('get')) {
            
            if (isset($this->request->query['query'])) {
                
                $query[] = '(Requisitions.code LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $requisitions = $this->Requisitions->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                               ->select(['Requisitions.id', 'Requisitions.code'])
                                               ->where(['Requisitions.status' => 'F']) // F - finalized, C - cancelled
                                               ->where($query)
                                               ->order(['Requisitions.code']);
            
            $json = [];
            
            foreach ($requisitions as $data) {
                array_push($json, [
                    'id'    => $data->id,
                    'value' => $data->code
                ]);
            }
            
            echo json_encode($json);
            
        }//if ($this->request->is('get'))
        
        $this->autoRender = false;
        die();
    }
}