<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* PurchaseRequests */
/* File: src/Controller/PurchaseRequestsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class PurchaseRequestsController extends AppController
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

        $this->loadComponent('PurchaseRequestsFunctions');
        $this->PurchasesPurchaseRequisitions = TableRegistry::get('PurchasesPurchaseRequisitions');
        $this->PurchaseRequestItems          = TableRegistry::get('PurchaseRequestItems');
        $this->Purchases                     = TableRegistry::get('Purchases');
    }
    
    public function index()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $purchaseRequests = $this->PurchaseRequests->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                   ->where($where)
                                                   ->contain(['Industrializations'])
                                                   ->order(['PurchaseRequests.code']);
                                                   //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $purchaseRequests = $this->paginate($purchaseRequests);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $purchaseRequests = $this->paginate($purchaseRequests);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('purchaseRequests'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $purchaseRequest = $this->PurchaseRequests->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                                  ->select(['PurchaseRequests.id', 'PurchaseRequests.parameters_id', 'PurchaseRequests.created', 
                                                            'PurchaseRequests.modified', 'PurchaseRequests.username', 'PurchaseRequests.industrializations_id', 
                                                            'PurchaseRequests.code', 'PurchaseRequests.date', 'PurchaseRequests.applicant', 
                                                            'PurchaseRequests.authorizer', 'PurchaseRequests.dtauth', 'PurchaseRequests.status', 
                                                            'PurchaseRequests.obs', 
                                                            'Industrializations.id', 'Industrializations.parameters_id', 'Industrializations.sells_id',
                                                            'Industrializations.code',
                                                            'Sells.id', 'Sells.parameters_id', 'Sells.customers_id', 'Sells.code', 'Sells.deadline',  
                                                            'Customers.id', 'Customers.parameters_id', 'Customers.cpfcnpj', 'Customers.title'
                                                           ])
                                                  ->join(['PurchasesPurchaseRequisitions' => ['table'      => 'purchases_purchase_requests',
                                                                                              'type'       => 'LEFT',
                                                                                              'conditions' => 'purchaseRequests.id = PurchasesPurchaseRequisitions.purchase_requests_id'
                                                                                             ],
                                                          'Industrializations' => ['table'      => 'Industrializations',
                                                                                   'type'       => 'LEFT',
                                                                                   'conditions' => 'Industrializations.id = purchaseRequests.industrializations_id'
                                                                                  ],
                                                          'Sells' => ['table'      => 'Sells',
                                                                      'type'       => 'LEFT',
                                                                      'conditions' => 'Sells.id = Industrializations.sells_id'
                                                                     ],
                                                          'Customers' => ['table'      => 'Customers',
                                                                          'type'       => 'LEFT',
                                                                          'conditions' => 'Customers.id = Sells.customers_id'
                                                                         ]
                                                         ])
                                                  ->first();

        /**********************************************************************/
        
        $purchaseRequestItems = $this->PurchaseRequestItems->findByPurchaseRequestsIdAndParametersId($purchaseRequest->id, $this->request->Session()->read('sessionParameterControl'))
                                                           ->contain(['Products']);
        
        /**********************************************************************/

        //lista de vínculos de pedidos de compras
        $purchases_list = $this->PurchaseRequestsFunctions->findPurchasesPurchaseRequests($purchaseRequest->id, $this->request->Session()->read('sessionParameterControl'));

        /**********************************************************************/

        if (!empty($purchases_list)) {

            $purchases = $this->Purchases->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->select(['Purchases.id', 'Purchases.parameters_id', 'Purchases.created', 
                                               'Purchases.modified', 'Purchases.username', 'Purchases.username', 
                                               'Purchases.providers_id', 'Purchases.date', 'Purchases.code', 'Purchases.freighttype', 
                                               'Purchases.paymenttype', 'Purchases.deadline', 'Purchases.totalipi', 'Purchases.totalicms', 
                                               'Purchases.totalicmssubst', 'Purchases.totalfreight', 'Purchases.totaldiscount', 
                                               'Purchases.grandtotal', 'Purchases.endingdate', 'Purchases.status', 'Purchases.obs', 
                                               'Providers.id', 'Providers.parameters_id', 'Providers.title', 'Providers.fantasia',
                                               'Providers.cpfcnpj'
                                              ])
                                     ->where(['Purchases.id IN' => $purchases_list,
                                              'Purchases.status IN' => ['P', 'D', 'E', 'F'] // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
                                             ])
                                     ->join(['Providers' => ['table'      => 'Providers',
                                                             'type'       => 'LEFT',
                                                             'conditions' => 'Providers.id = Purchases.providers_id'
                                                            ]
                                            ])
                                     ->order(['Purchases.code']);

        }//if (!empty($purchases_list))
        
        /**********************************************************************/
        
        $this->set(compact('purchaseRequest', 'purchaseRequestItems', 'purchases'));
    }

    public function add()
    {
        $purchaseRequest = $this->PurchaseRequests->newEntity();
        
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
            unset($this->request->data['deadline']);

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
            $max_code = $this->PurchaseRequests->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                               ->select(['MAX' => 'MAX(PurchaseRequests.code)'])
                                               ->first();
            $this->request->data['code'] = $max_code->MAX + 1;
            
            /******************************************************************/
            
            $purchaseRequest = $this->PurchaseRequests->patchEntity($purchaseRequest, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $purchaseRequest->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $purchaseRequest->username      = $this->Auth->user('name');
            $purchaseRequest->status        = 'P'; // P - Pendente, A - Aguardando material, C - Cancelado, F - Finalizado
            
            /******************************************************************/
            
            if ($this->PurchaseRequests->save($purchaseRequest)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($purchaseRequest, 'add', 'PurchaseRequests');

                //ITENS DA REQUISIÇÃO DE COMPRA
                $this->PurchaseRequestsFunctions->addItems($purchaseRequest->id, $productList, $purchaseRequest->parameters_id);
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->PurchaseRequests->save($purchaseRequest))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PurchaseRequestsController->add';
            $this->Error->registerError($purchaseRequest, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];

        /**********************************************************************/

        $industrializations = $this->PurchaseRequests->Industrializations->find('list', ['keyField'   => 'id',
                                                                                         'valueField' => function ($e) { return str_pad($e->code, 6, '0', STR_PAD_LEFT) . ' - ' . $e->Sells->Customers->title; }
                                                                                        ])
                                       ->where(['Industrializations.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                'Industrializations.status' => 'P' // P - pending, C - cancelled, F - finalized
                                               ])
                                       ->contain(['Sells.Customers'])
                                       ->order(['Industrializations.code']);
        $this->set('industrializations', $industrializations);
        
        /**********************************************************************/
        
        $max_code = $this->PurchaseRequests->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->select(['MAX' => 'MAX(PurchaseRequests.code)'])
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
        $title    = null;
        
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
            unset($this->request->data['deadline']);

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
            $max_code = $this->PurchaseRequests->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                               ->select(['MAX' => 'MAX(PurchaseRequests.code)'])
                                               ->first();
            $this->request->data['code'] = $max_code->MAX + 1;

            /******************************************************************/

            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $this->request->data['username']      = $this->Auth->user('name');
            $this->request->data['status']        = 'P'; // P - Pendente, A - Aguardando material, C - Cancelado, F - Finalizado

            /******************************************************************/
            
            $purchaseRequest = $this->PurchaseRequests->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/
            
            if ($this->PurchaseRequests->save($purchaseRequest)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($purchaseRequest, 'add', 'PurchaseRequests');

                //ITENS DA REQUISIÇÃO DE COMPRA
                $this->PurchaseRequestsFunctions->addItems($purchaseRequest->id, $productList, $purchaseRequest->parameters_id);

                $mensagem = 'Registro gravado com sucesso';
                $status   = 'ok';
                $id       = $purchaseRequest->id;
                $title    = $purchaseRequest->title;
                
            } else { 
                
                $mensagem = 'Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente';

                //Alerta de erro
                $message = 'PurchaseRequestsController->addjson';
                $this->Error->registerError($purchaseRequest, $message, true);

            }//else if ($this->PurchaseRequests->save($purchaseRequest))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'title')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $purchaseRequest = $this->PurchaseRequests->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                                  ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))

            /******************************************************************/

            //Identifica o status atual do registro
            if ($purchaseRequest->status != 'P') {
                $this->Flash->error(__('Registro NÃO pode ser editado pois não está pendente'));
                return $this->redirect($this->referer());
            }//if ($purchaseRequest->status != 'P')

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

            //Não permite a mudança do código sequencial
            unset($this->request->data['code']);
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE ALTEROU O REGISTRO
            $this->request->data['username']      = $this->Auth->user('name');
            
            /******************************************************************/
            
            $purchaseRequest = $this->PurchaseRequests->patchEntity($purchaseRequest, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->PurchaseRequests->save($purchaseRequest)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($purchaseRequest, 'edit', 'PurchaseRequests');

                //ITENS DA REQUISIÇÃO DE COMPRA
                $this->PurchaseRequestsFunctions->updateItems($purchaseRequest->id, $productList, $purchaseRequest->parameters_id);

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->PurchaseRequests->save($purchaseRequest))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PurchaseRequestsController->edit';
            $this->Error->registerError($purchaseRequest, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))

        /**********************************************************************/

        $industrializations = $this->PurchaseRequests->Industrializations->find('list', ['keyField'   => 'id',
                                                                                         'valueField' => function ($e) { return str_pad($e->code, 6, '0', STR_PAD_LEFT) . ' - ' . $e->Sells->Customers->title; }
                                                                                        ])
                                                                         ->where(['Industrializations.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                                                  'Industrializations.status' => 'P' // P - pending, C - cancelled, F - finalized
                                                                                 ])
                                                                         ->contain(['Sells.Customers'])
                                                                         ->order(['Industrializations.code']);
        $this->set('industrializations', $industrializations);

        /**********************************************************************/

        $purchaseRequestItems = $this->PurchaseRequestItems->findByPurchaseRequestsIdAndParametersId($purchaseRequest->id, $this->request->Session()->read('sessionParameterControl'))
                                                           ->contain(['Products']);
        $this->set('purchaseRequestItems', $purchaseRequestItems);
        
        /**********************************************************************/
        
        $this->set(compact('purchaseRequest'));
    }

    public function finish($id)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            //Consulta o registro
            $purchaseRequest = $this->PurchaseRequests->get($id);
                
            /******************************************************************/

            //Identifica o status atual do registro
            if ($purchaseRequest->status != 'A') {
                $this->Flash->error(__('Registro NÃO foi finalizado pois não está aguardando material'));
                return $this->redirect($this->referer());
            }//if ($purchaseRequest->status != 'A')
                
            /******************************************************************/

            //Define o status para finalizado
            $purchaseRequest->status = 'F'; // P - Pendente, A - Aguardando, C - Cancelado, F - Finalizado

            //Dados da autorização
            $purchaseRequest->dtauth    = date('Y-m-d');
            $purchaseRequest->authorizer = $this->Auth->user('name');
                
            /******************************************************************/
            
            if ($this->PurchaseRequests->save($purchaseRequest)) {
                
                $this->Flash->success(__('Registro finalizado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->PurchaseRequests->save($purchaseRequest))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PurchaseRequestsController->finish';
            $this->Error->registerError($purchaseRequest, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO finalizado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))

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
        $purchaseRequest = $this->PurchaseRequests->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                                  ->first();
        
        /**********************************************************************/

        if (!empty($purchaseRequest)) {

            //VERIFICA SE O CADASTRO ESTÁ EM USO NOS MOVIMENTOS
            if ($vinc_moviments = $this->consultaMovimentos($id, 'purchase_requests_id')) {
                
                if ($purchaseRequest->status != 'I') {
                    
                    $purchaseRequest->title    = $purchaseRequest->title.' (INATIVO)';
                    $purchaseRequest->username = $this->Auth->user('name');
                    $purchaseRequest->status   = 'I';
                    
                    if ($this->PurchaseRequests->save($purchaseRequest)) {
                        
                        $this->Log->gravaLog($purchaseRequest, 'inativate', 'PurchaseRequests'); //GRAVA LOG
                        
                        $this->Flash->warning(__('Registro inativado. Não pode ser excluído devido a movimentos vinculados'));
                        return $this->redirect($this->referer());
                        
                    } else {

                        //Alerta de erro
                        $message = 'PurchaseRequestsController->delete, inativate';
                        $this->Error->registerError($purchaseRequest, $message, true);
                        
                        $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                        return $this->redirect($this->referer());
                        
                    }//else if ($this->PurchaseRequests->save($purchaseRequest))
                    
                } else {

                    //Alerta de erro
                    $message = 'PurchaseRequestsController->delete, inativated';
                    $this->Error->registerError($purchaseRequest, $message, true);
                    
                    $this->Flash->warning(__('Registro inativo. Há movimentos vinculados em '.$vinc_moviments));
                    return $this->redirect($this->referer());
                    
                }//else if ($purchaseRequest->status != 'I')
                
            }//if ($vinc_moviments = $this->consultaMovimentos($id, 'purchase_requests_id'))
            
            /******************************************************************/
            
            //Exclui Saldos
            $this->GeneralBalance->deleteBalance('purchase_requests_id', $id, $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($purchaseRequest, 'delete', 'PurchaseRequests');
            
            /******************************************************************/
            
            if ($this->PurchaseRequests->delete($purchaseRequest)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->PurchaseRequests->delete($purchaseRequest))

        }//if (!empty($purchaseRequest))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'PurchaseRequestsController->delete';
        $this->Error->registerError($purchaseRequest, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }

    public function cancel($id)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            //Consulta o registro
            $purchaseRequest = $this->PurchaseRequests->get($id);
                
            /******************************************************************/

            //Identifica o status atual do registro
            if ($purchaseRequest->status != 'P') {
                $this->Flash->error(__('Registro NÃO foi cancelado pois não está pendente'));
                return $this->redirect($this->referer());
            }//if ($purchaseRequest->status != 'P')
                
            /******************************************************************/

            //Define o status para cancelado
            $purchaseRequest->status = 'C'; // P - Pendente, A - Aguardando, C - Cancelado, F - Finalizado
                
            /******************************************************************/
            
            if ($this->PurchaseRequests->save($purchaseRequest)) {
                
                $this->Flash->warning(__('Registro cancelado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->PurchaseRequests->save($purchaseRequest))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PurchaseRequestsController->cancel';
            $this->Error->registerError($purchaseRequest, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO cancelado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
    }
    
    public function report()
    {
        $this->Providers = TableRegistry::get('Providers');

        if ($this->request->is(['patch', 'post', 'put'])) {

            //CHAMA FUNÇÃO PARA CONSULTAS
            $ordenacao = $this->request->data['Ordem'];
            $periodo   = [];

            /******************************************************************/
                
            // MONTAGEM DO SQL
            $conditions = ['PurchaseRequests.parameters_id = '.$this->request->Session()->read('sessionParameterControl')];

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

            $conditions[] = '(PurchaseRequests.date BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'")';

            /******************************************************************/

            //FILTRA POR STATUS
            if (!empty($this->request->data['status'])) {
                $conditions[] = '(PurchaseRequests.status = "' . $this->request->data['status'] . '")';
            }//if (!empty($this->request->data['status']))

            /******************************************************************/

            $fields = ['PurchaseRequests.id', 'PurchaseRequests.parameters_id', 'PurchaseRequests.industrializations_id', 
                       'PurchaseRequests.code', 'PurchaseRequests.date', 'PurchaseRequests.applicant', 
                       'PurchaseRequests.dtauth', 'PurchaseRequests.authorizer', 'PurchaseRequests.status', 
                       'PurchaseRequests.obs',
                       'Industrializations.id', 'Industrializations.parameters_id', 'Industrializations.sells_id', 
                       'Industrializations.code', 'Industrializations.date', 'Industrializations.status', 
                       'Sells.id', 'Sells.parameters_id', 'Sells.customers_id', 'Sells.date', 'Sells.code', 
                       'Sells.customercode', 'Sells.shipment', 'Sells.deadline', 'Sells.endingdate', 'Sells.status', 
                       'Customers.id', 'Customers.parameters_id', 'Customers.title', 'Customers.cpfcnpj' 
                      ];

            $purchaseRequests = $this->PurchaseRequests->find('all')
                                            ->select($fields)
                                            ->join(['Industrializations' => ['table'      => 'industrializations',
                                                                             'type'       => 'LEFT',
                                                                             'conditions' => 'Industrializations.id = PurchaseRequests.industrializations_id'
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
                                            ->order(['PurchaseRequests.'.$ordenacao]);

            $this->set('purchaseRequests', $purchaseRequests);

            /******************************************************************/

            //LISTA O ID
            $purchaseRequests_id = [];
            foreach ($purchaseRequests as $purchaseRequest):
                $purchaseRequests_id[] = $purchaseRequest->id;
            endforeach;

            /******************************************************************/

            //ITENS DAS SOLICITAÇÕES DE COMPRAS
            $purchaseRequestItems = $this->PurchaseRequestItems->find('all')
                                                               ->select(['PurchaseRequestItems.id', 'PurchaseRequestItems.parameters_id', 'PurchaseRequestItems.purchase_requests_id', 
                                                                         'PurchaseRequestItems.products_id', 'PurchaseRequestItems.quantity', 'PurchaseRequestItems.unity', 
                                                                         'Products.id', 'Products.parameters_id', 'Products.code', 'Products.title'
                                                                        ])
                                                               ->join(['Products' => ['table'      => 'products',
                                                                                      'type'       => 'LEFT',
                                                                                      'conditions' => 'Products.id = PurchaseRequestItems.products_id'
                                                                                     ]
                                                                      ])
                                                               ->where(['PurchaseRequestItems.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                                        'PurchaseRequestItems.purchase_requests_id IN' => $purchaseRequests_id
                                                                       ]);

            $this->set('purchaseRequestItems', $purchaseRequestItems);

            /******************************************************************/

            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());

            /******************************************************************/

            //Evitar página de erro
            $this->render('/PurchaseRequests/reports/sem_relatorio');

            /******************************************************************/
            
            $this->render('/PurchaseRequests/reports/purchase_requests_analitico');
            
        }//if ($this->request->is(['patch', 'post', 'put']))
            
        /******************************************************************/
        
        //FORNECEDORES
        $providers = $this->Providers->find('list')
                                     ->select(['Providers.id', 'Providers.title'])
                                     ->where(['Providers.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                     ->order(['Providers.title']);
        
        $this->set('providers', $providers);

    }
    
    public function filter($request)
    {
        $table = 'PurchaseRequests';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['code_search'])) { 
            $where[] = '('.$table.'.code LIKE "%'.$this->params['code_search'].'%")';
        }
        
        if (!empty($this->params['status_search'])) { 
            $where[] = '('.$table.'.status = "'.$this->params['status_search'].'")';
        } else {
            $where[] = '('.$table.'.status IN ("P", "A"))';
        }
        
        return $where;
    }
    
    public function json()
    {
        if ($this->request->is('get')) {
            
            if (isset($this->request->query['query'])) {
                
                $query[] = '(PurchaseRequests.title LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $purchaseRequests = $this->PurchaseRequests->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                       ->select(['PurchaseRequests.id', 'PurchaseRequests.title'])
                                                       ->where(['PurchaseRequests.status IN' => ['P', 'A']]) // P - pending, A - in progress, C - cancelled, F - finalized
                                                       ->where($query)
                                                       ->order(['PurchaseRequests.title']);
            
            $json = [];
            
            foreach ($purchaseRequests as $data) {
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

    public function jsonItems()
    {
        if ($this->request->is('get')) {

            if (isset($this->request->query['query'])) {

                $query[] = '(PurchaseRequestItems.purchase_requests_id LIKE "'.$this->request->query['query'].'")';
                
            } else {
                
                $where = null;
                
            }//else if (isset($this->request->query['query']))

            $purchaseRequestItems = $this->PurchaseRequestItems->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                               ->select(['PurchaseRequestItems.id', 'PurchaseRequestItems.parameters_id', 'PurchaseRequestItems.products_id', 
                                                                         'PurchaseRequestItems.quantity', 'PurchaseRequestItems.unity',
                                                                         'Products.id', 'Products.parameters_id', 'Products.title',
                                                                         'Products.code'
                                                                        ])
                                                               ->contain(['Products'])
                                                               ->where($where)
                                                               ->order(['PurchaseRequestItems.id']);

            $json = [];
            
            foreach ($purchaseRequestItems as $data) {
                array_push($json, [
                    'products_id' => $data->Products['id'],
                    'code'     => $data->Products['code'],
                    'title'       => $data->Products['title'],
                    'quantity'    => $data->quantity,
                    'unity'       => $data->unity
                ]);
            }
            
            echo json_encode($json);

        }//if ($this->request->is('get'))
        
        $this->autoRender = false;
        die();
    }
}