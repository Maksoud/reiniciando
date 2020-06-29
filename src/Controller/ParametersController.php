<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Parameters */
/* File: src/Controller/ParametersController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class ParametersController extends AppController
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
        
        $this->loadComponent('Upload');
    }
    
    public function index()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        // LISTA APENAS O PERFIL ATUAL
        if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super') {
            
            $where[] = 'Parameters.id = ' . $this->request->Session()->read('sessionParameterControl');
            
        }//if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super')
        
        /**********************************************************************/
        
        $parameters = $this->Parameters->find('all')
                                       ->where($where)
                                       ->order(['Parameters.dtvalidade DESC', 'Parameters.razao', 'Parameters.created']);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $parameters = $this->paginate($parameters);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $parameters = $this->paginate($parameters);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('parameters'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/

        //Consulta de títulos pelo id do vínculo
        $this->UsersParameters = TableRegistry::get('UsersParameters');
        
        /**********************************************************************/
       
        if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) == 'super') {
            
            $limit = null;
            
        } else {
            
            $limit = 'UsersParameters.parameters_id = ' . $this->request->Session()->read('sessionParameterControl');
            
        }
        
        /**********************************************************************/
        
        $parameter = $this->Parameters->get($id);
        $this->set(compact('parameter'));
        
        /**********************************************************************/
        
        $this->Regs = TableRegistry::get('Regs');
        
        /**********************************************************************/
        
        $usersParameters = $this->UsersParameters->find('all')
                                                 ->select(['Users.id', 'Users.created', 'Users.name', 'Users.username', 
                                                           'UsersParameters.users_id', 'UsersParameters.rules_id',
                                                           'UsersParameters.parameters_id', 'Parameters.razao',
                                                           'last_login' => '(SELECT MAX(Regs.created) FROM regs Regs WHERE Regs.users_id = Users.id AND Regs.parameters_id = Parameters.id)'
                                                          ])
                                                 ->where(['Users.id IN' => $this->SystemFunctions->listaUsuarios($this->request->Session()->read('sessionParameterControl')),
                                                          'UsersParameters.parameters_id' => $this->request->Session()->read('sessionParameterControl')
                                                         ])
                                                 ->join(['Users' => ['table'      => 'users',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => ['UsersParameters.users_id = Users.id', 
                                                                                      $limit
                                                                                     ]
                                                                    ],
                                                         'Parameters' => ['table'      => 'parameters',
                                                                          'type'       => 'LEFT',
                                                                          'conditions' => ['UsersParameters.parameters_id = Parameters.id']
                                                                         ]
                                                        ])
                                                 ->order(['Parameters.razao', 'Users.name', 'Users.created']);
        
        /**********************************************************************/
        
        $this->set(compact('usersParameters'));
    }

    public function add()
    {
        $parameter = $this->Parameters->newEntity();
        
        if ($this->request->is('post')) {
            
            $this->request->data['username'] = $this->Auth->user('name');
        
            /******************************************************************/
            
            //UPLOAD DA LOGOMARCA
            if ($this->request->data['logomarca']['size'] > 0) {
                $this->request->data['logomarca'] = $this->Upload->send($this->request->data['logomarca']);
            }//if ($this->request->data['logomarca']['size'] > 0)
        
            /******************************************************************/
            
            $parameter = $this->Parameters->patchEntity($parameter, $this->request->getData());
        
            /******************************************************************/
            
            if ($this->Parameters->save($parameter)) {
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
            }//if ($this->Parameters->save($parameter))
        
            /******************************************************************/

            //Alerta de erro
            $message = 'ParametersController->add';
            $this->Error->registerError($parameter, $message, true);
        
            /******************************************************************/

            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is('post'))
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $parameter = $this->Parameters->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
            /******************************************************************/
            
            //UPLOAD DA LOGOMARCA
            if ($this->request->data['logomarca']['size'] > 0) {
                $this->request->data['logomarca'] = $this->Upload->send($this->request->data['logomarca']);
            }//if ($this->request->data['logomarca']['size'] > 0)
        
            /******************************************************************/
            
            $parameter = $this->Parameters->patchEntity($parameter, $this->request->getData());
        
            /******************************************************************/
            
            if ($this->Parameters->save($parameter)) {

                if (!empty($parameter['logomarca'])) {
                    $this->brand(); //ATUALIZA LOGOMARCA NA SESSÃO
                }//if (!empty($parameter['logomarca']))

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Parameters->save($parameter))
        
            /******************************************************************/

            //Alerta de erro
            $message = 'ParametersController->edit';
            $this->Error->registerError($parameter, $message, true);
        
            /******************************************************************/

            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        /**********************************************************************/
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($parameter->fundacao)) {
            $parameter->fundacao = date("d/m/Y", strtotime($parameter->fundacao));
        }//if (!empty($parameter->fundacao))
        
        /**********************************************************************/
        
        $this->set('parameter', $parameter);
    }
    
    public function editNovo($id)
    {
        //CONSULTA REGISTRO
        $parameter = $this->Parameters->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
            /******************************************************************/
            
            $this->request->data['username'] = $this->Auth->user('name');
        
            /******************************************************************/
            
            //UPLOAD DA LOGOMARCA
            if ($this->request->data['logomarca']['size'] > 0) {
                $this->request->data['logomarca'] = $this->Upload->send($this->request->data['logomarca']);
            }//if ($this->request->data['logomarca']['size'] > 0)
        
            /******************************************************************/
            
            $parameter = $this->Parameters->patchEntity($parameter, $this->request->getData());
        
            /******************************************************************/
            
            if ($this->Parameters->save($parameter)) {

                if (!empty($parameter['logomarca'])) {
                    $this->brand(); //ATUALIZA LOGOMARCA NA SESSÃO
                }//if (!empty($parameter['logomarca']))

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Parameters->save($parameter))
        
            /******************************************************************/

            //Alerta de erro
            $message = 'ParametersController->editNovo';
            $this->Error->registerError($parameter, $message, true);
        
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        /**********************************************************************/
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($parameter->fundacao)) {
            $parameter->fundacao = date("d/m/Y", strtotime($parameter->fundacao));
        }
        
        /**********************************************************************/
        
        $this->set('parameter', $parameter);
    }
    
    public function admin($id)
    {
        //CONSULTA REGISTRO
        $parameter = $this->Parameters->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))

            /******************************************************************/
            
            $this->request->data['username'] = $this->Auth->user('name');

            /******************************************************************/
            
            $parameter = $this->Parameters->patchEntity($parameter, $this->request->getData());

            /******************************************************************/
            
            if ($this->Parameters->save($parameter)) {

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Parameters->save($parameter))

            /******************************************************************/

            //Alerta de erro
            $message = 'ParametersController->admin';
            $this->Error->registerError($parameter, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $plans = $this->Parameters->Plans->find('list', ['keyField' => 'id', 'valueField' => 'dropdown_accounts'])->order(['Plans.id']);
        $plans = $plans->select(['id', 'dropdown_accounts' => $plans->func()->concat(['Plans.id' => 'identifier', 
                                                                                      ' - ',
                                                                                      'Plans.title' => 'identifier',
                                                                                     ])
                                ]);
        $this->set('plans', $plans->toArray());
        
        /**********************************************************************/
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($parameter->fundacao)) {
            $parameter->fundacao = date("d/m/Y", strtotime($parameter->fundacao));
        }
        if (!empty($parameter->dtvalidade)) {
            $parameter->dtvalidade = date("d/m/Y", strtotime($parameter->dtvalidade));
        }
        
        /**********************************************************************/
        
        $this->set('parameter', $parameter);
    }

    public function delete($id)
    {
        /* Função desenvolvida em 19/07/2018 */

        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $this->request->allowMethod(['post', 'delete']);
        
        /**********************************************************************/

        $tables = [0  => 'AccountPlans',
                   1  => 'Balances',
                   2  => 'Banks',
                   3  => 'Boxes',
                   4  => 'Cards',
                   5  => 'Coins',
                   6  => 'Costs',
                   7  => 'Customers',
                   8  => 'DocumentTypes',
                   9  => 'EventTypes',
                   10 => 'Industrializations',
                   11 => 'IndustrializationItems',
                   12 => 'Inventories',
                   13 => 'InventoryItems',
                   14 => 'Invoices',
                   15 => 'InvoiceItems',
                   16 => 'InvoicesPurchasesSells',
                   17 => 'Moviments',
                   18 => 'MovimentBanks',
                   19 => 'MovimentBoxes',
                   20 => 'MovimentCards',
                   21 => 'MovimentChecks',
                   22 => 'MovimentsMovimentCards',
                   23 => 'MovimentMergeds',
                   24 => 'MovimentRecurrents',
                   25 => 'Plannings',
                   26 => 'Products',
                   27 => 'ProductGroups',
                   28 => 'ProductTypes',
                   29 => 'Providers',
                   30 => 'Purchases',
                   31 => 'PurchaseItems',
                   32 => 'PurchaseRequests',
                   33 => 'PurchaseRequestItems',
                   34 => 'Requisitions',
                   35 => 'RequisitionItems',
                   36 => 'Regs',
                   37 => 'Sells',
                   38 => 'SellItems',
                   39 => 'StockBalances',
                   40 => 'SupportContacts',
                   41 => 'Transfers',
                   42 => 'Transporters',
                   //43 => 'Users',
                   //44 => 'UsersParameters',
                   //45 => 'Parameters'
                  ];
        
        foreach ($tables as $table):

            //Acessa o Model
            $this->Model = TableRegistry::get($table);

            //Consulta a tabela
            $registros = $this->Model->find('all')
                                     ->where([$table.'.parameters_id' => $id]);

            //Verifica a existência de conteúdo
            if (!empty($registros->toArray())) {

                foreach ($registros as $registro):
                    //Apaga o registro
                    if (!$this->Model->delete($registro)) {

                        //Alerta de erro
                        $message = 'ParametersController->delete, '.$table;
                        $this->Error->registerError($registro, $message, true);

                    }//if (!$this->Model->delete($registro))
                endforeach;
                
            }//if (!empty($registros))

        endforeach;

        /**********************************************************************/
        
        //Acessa o Model
        $this->UsersParameters = TableRegistry::get('UsersParameters');
        $this->Users           = TableRegistry::get('Users');

        //Consulta o vínculo de usuários e perfis
        $usersParameters = $this->UsersParameters->find('all')
                                                 ->where(['UsersParameters.parameters_id' => $id]);

        foreach ($usersParameters as $usersParameter):

            //Consulta vínculo se o usuário possui vínculo à outros perfis 
            $upUsers = $this->UsersParameters->find('all')
                                             ->where(['UsersParameters.users_id' => $usersParameter->users_id,
                                                      'UsersParameters.parameters_id <>' => $id
                                                     ])
                                             ->first();

            //Exclui apenas os usuários que não estão vinculados a outros perfis
            if (empty($upUsers)) {

                //Consulta os usuários vinculados ao perfil
                $users = $this->Users->find('all')
                                     ->where(['Users.id' => $usersParameter->users_id]);

                foreach ($users as $user):
                    //Exclui os usuários
                    if (!$this->Users->delete($user)) {

                        //Alerta de erro
                        $message = 'ParametersController->delete, Users';
                        $this->Error->registerError($user, $message, true);

                    }//if (!$this->Users->delete($user))
                endforeach;

            }//if (empty($upUsers))

            /******************************************************************/

            //Exclui o vínculo do usuário com o perfil
            if (!$this->UsersParameters->delete($usersParameter)) {

                //Alerta de erro
                $message = 'ParametersController->delete, UsersParameters';
                $this->Error->registerError($usersParameter, $message, true);

            }//if (!$this->UsersParameters->delete($usersParameter))

        endforeach;

        /**********************************************************************/
        
        //Consulta tabela de perfis
        $parameters = $this->Parameters->get($id);

        /**********************************************************************/

        if (!empty($parameters)) {

            //Exclui o registro
            if ($this->Parameters->delete($parameters)) {

                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Parameters->delete($parameters))

        }//if (!empty($parameters))

        /**********************************************************************/

        //Alerta de erro
        $message = 'ParametersController->delete';
        $this->Error->registerError($parameters, $message, true);

        /**********************************************************************/

        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'Parameters';
        $where = [];
        $this->prepareParams($request);
        
        if (@$this->params['dtinicial_search']) { // datepicker
            $datepicker = explode("/", $this->params['dtinicial_search']);
            $dtinicial = implode('-', array_reverse($datepicker));
        }

        if (@$this->params['dtfinal_search']) { // datepicker
            $datepicker = explode("/", $this->params['dtfinal_search']);
            $dtfinal = implode('-', array_reverse($datepicker));
        }
        
        if (!empty($dtinicial) && !empty($dtfinal)) { 
            $where[] = $table.'.created BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"'; 
        }
        
        if (!empty($this->params['razao_search'])) { 
            $where[] = $table.'.razao LIKE "%'.$this->params['razao_search'].'%"';
        }
        
        if (!empty($this->params['cpfcnpj_search'])) { 
            $where[] = $table.'.cpfcnpj LIKE "%'.$this->params['cpfcnpj_search'].'%"';
        }
        
        if (!empty($this->params['email_search'])) { 
            $where[] = $table.'.email LIKE "%'.$this->params['email_search'].'%"';
        }
        
        return $where;
    }
}