<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* UsersParameters */
/* File: src/Controller/UsersParametersController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class UsersParametersController extends AppController
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
        $this->Parameters = TableRegistry::get('Parameters');
        $this->Users      = TableRegistry::get('Users');
        $this->Rules      = TableRegistry::get('Rules');
    }
    
    public function index()
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);
        
        $usersParameters = $this->UsersParameters->find('all')
                                                 ->where($where)
                                                 ->contain(['Parameters', 'Users', 'Parameters.Plans'])
                                                 ->order(['Parameters.dtvalidade DESC', 'Users.username ASC']);
                                                 //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $usersParameters = $this->paginate($usersParameters);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $usersParameters = $this->paginate($usersParameters);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('usersParameters'));
    }

    public function view($id = null)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
    
        /**********************************************************************/

        $usersParameter = $this->UsersParameters->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                                ->contain(['Parameters', 'Users', 'Rules'])
                                                ->first();
        
        /**********************************************************************/

        $this->set(compact('usersParameter'));
    }

    public function add()
    {
        $usersParameter = $this->UsersParameters->newEntity();

        /**************************************************************************/
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
            /**********************************************************************/
            
            $this->request->data['username'] = $this->Auth->user('name');
        
            /**********************************************************************/
            
            $usersParameter = $this->UsersParameters->patchEntity($usersParameter, $this->request->getData());
        
            /**********************************************************************/

            //Consulta duplicidade
            $duplicidade = $this->UsersParameters->find('all')
                                                 ->where(['UsersParameters.parameters_id' => $usersParameter->parameters_id,
                                                          'UsersParameters.users_id' => $usersParameter->users_id,
                                                         ])
                                                 ->first();

            if (!empty($duplicidade)) {

                $this->Flash->error(__('Registro NÃO gravado, já existe permissão para o usuário e perfil selecionados'));
                return $this->redirect($this->referer());

            }//if (!empty($duplicidade))
        
            /**********************************************************************/
            
            //DEFINE O ID DA PERMISSÃO
            $usersParameter->rules_id = $this->SystemFunctions->GETuserRulesId($this->request->data['rule']);
            unset($this->request->data['rule']); //Remove do request pois não existe no banco de dados
        
            /**********************************************************************/
            
            if ($this->UsersParameters->save($usersParameter)) {

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->UsersParameters->save($usersParameter))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'UsersParametersController->add';
            $this->Error->registerError($usersParameter, $message, true);

            /**********************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))

        /**************************************************************************/
        
        $parameters = $this->UsersParameters->Parameters->find('list', ['limit' => 200])->where(['Parameters.dtvalidade >=' => date('Y-m-d')]);
        $users = $this->UsersParameters->Users->find('list', ['limit' => 200])->where(['Users.id IN' => $this->SystemFunctions->listaUsuarios(/*Lista usuários de perfis ativos*/)]);

        $this->set(compact('usersParameter', 'parameters', 'users'));
        $this->set('_serialize', ['usersParameter']);
    }

    public function edit($id)
    {
        $usersParameter = $this->UsersParameters->findById($id)
                                                ->join(['Parameters' => ['table'      => 'parameters',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => ['Parameters.id = UsersParameters.parameters_id',
                                                                                          'UsersParameters.parameters_id = '.$this->request->Session()->read('sessionParameterControl')
                                                                                         ]
                                                                        ],
                                                        'Users' => ['table'      => 'users',
                                                                    'type'       => 'LEFT',
                                                                    'conditions' => ['Users.id = UsersParameters.users_id',
                                                                                     'UsersParameters.parameters_id = '.$this->request->Session()->read('sessionParameterControl')
                                                                                    ]
                                                                   ],
                                                        'Rules' => ['table'      => 'rules',
                                                                    'type'       => 'LEFT',
                                                                    'conditions' => ['Rules.id = UsersParameters.rules_id',
                                                                                     'UsersParameters.parameters_id = '.$this->request->Session()->read('sessionParameterControl')
                                                                                    ]
                                                                   ]
                                                       ])
                                                ->first();

        /**************************************************************************/
        
        if ($this->request->is(['post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
            /**********************************************************************/
            
            //NÃO PERMITE MUDAR DADOS DO DESENVOLVEDOR
            if ($this->SystemFunctions->GETuserRules($id, $this->request->Session()->read('sessionParameterControl')) == 'super') { 
                //Alerta de erro
                $message = 'UsersParametersController->edit' . implode(", ", $this->request->Session()->read());
                $this->Error->registerError($usersParameter, $message, true);

                $this->Flash->warning(__('Sem permissão para realizar esta operação'));   
                return $this->redirect($this->referer());
            }//if ($this->SystemFunctions->GETuserRules($id, $this->request->Session()->read('sessionParameterControl')) == 'super')
        
            /**********************************************************************/
            
            $this->request->data['username'] = $this->Auth->user('name');
        
            /**********************************************************************/
            
            $this->UsersParameters->patchEntity($usersParameter, $this->request->getData());
        
            /**********************************************************************/
            
            //DEFINE O ID DA PERMISSÃO
            $usersParameter->rules_id = $this->SystemFunctions->GETuserRulesId($this->request->data['rule']);
            unset($this->request->data['rule']); //Remove do request pois não existe no banco de dados
        
            /**********************************************************************/
            
            if ($this->UsersParameters->save($usersParameter)) {

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->UsersParameters->save($usersParameter))

            /******************************************************************/

            //Alerta de erro
            $message = 'UsersParametersController->edit';
            $this->Error->registerError($usersParameter, $message, true);

            /**********************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['post', 'put']))
        
        /**********************************************************************/
                            
        //ENCAMINHA DADOS DA CONSULTA PARA VIEW
        $parameters = $this->Parameters->find('list')->where(['Parameters.id' => $usersParameter->parameters_id]);
        $users = $this->Users->find('list')->where(['Users.id' => $usersParameter->users_id]);
        $this->request->data['rule'] = $this->SystemFunctions->GETuserRules($usersParameter->users_id, $usersParameter->parameters_id);

        $this->set(compact('usersParameter', 'parameters', 'users'));
        //$this->set('_serialize', ['usersParameter', 'parameters', 'users', 'rules']);
    }

    public function delete($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $this->request->allowMethod(['post', 'delete']);
        
        /**********************************************************************/
        
        $usersParameters = $this->UsersParameters->findById($id)
                                                 ->first();
        
        /**********************************************************************/

        if (!empty($usersParameters)) {

            //GRAVA LOG
            $this->Log->gravaLog($usersParameters, 'delete', 'UsersParameters');
            
            /******************************************************************/
            
            if ($this->UsersParameters->delete($usersParameters)) {

                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->UsersParameters->delete($usersParameters))

        }//if (!empty($usersParameters))

        /**********************************************************************/

        //Alerta de erro
        $message = 'UsersParametersController->delete';
        $this->Error->registerError($usersParameter, $message, true);

        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function changeParameter()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //VERIFICA AS PERMISSÕES DO USUÁRIO
            if ($this->SystemFunctions->validaUsuariosPerfis($this->Auth->user('id'), $this->request->data['parameters_id'])) {

                //VARIÁVEL NECESSÁRIA PARA ENVIO DE E-MAIL FORA DE VALIDADE
                $request_data = ['username' => $this->Auth->user('username'),
                                 'password' => 'MUDANÇA DE PERFIL!'
                                ];
                
                //INICIALIZA PROCEDIMENTOS DE SESSÃO
                $this->session($this->request->data['parameters_id'], $request_data);
                
                //ATUALIZA O USUÁRIO PARA O ÚLTIMO PERFIL UTILIZADO
                $this->SystemFunctions->SETlastParameter($this->Auth->user('id'), $this->request->data['parameters_id']);
                
                return $this->redirect(['controller' => 'pages', 'action' => 'home']);

            }//if ($this->SystemFunctions->validaUsuariosPerfis($this->Auth->user('id'), $this->request->data['parameters_id']))
            
            $this->Flash->error(__('Houve uma falha, tente novamente'));
            return $this->redirect(['controller' => 'pages', 'action' => 'home']);

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        /**********************************************************************/
        
        //LISTA TODAS AS EMPRESAS VINCULADAS
        $parameters = $this->SystemFunctions->listaPerfis($this->request->Session()->read('userid'));
        $perfis = [];
        
        foreach($parameters as $parameter):
            array_push($perfis, $parameter);
        endforeach;
        
        /**********************************************************************/
        
        //SELECIONA AS EMPRESAS VINCULADAS PARA EXIBIÇÃO
        $this->Parameters = TableRegistry::get('Parameters');
        
        $perfis = $this->Parameters->find('list')
                                   ->select(['Parameters.id', 'Parameters.razao'])
                                   ->where(['Parameters.id IN' => $perfis])
                                   ->order(['Parameters.id']);
        
        $this->set('parameters', $perfis);
    }
    
    public function filter($request = null)
    {
        //$table = 'UsersParameters';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['parameters_id'])) { 
            $where[] = '(Parameters.title LIKE "%'.$this->params['parameters_id'].'%")';
        }
        
        if (!empty($this->params['users_id'])) { 
            $where[] = '(Users.title LIKE "%'.$this->params['users_id'].'%")';
        }
        
        return $where;
    }
}