<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Users */
/* File: src/Controller/UsersController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Log\Log;

class UsersController extends AppController
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

        $this->loadComponent('EmailFunctions');
        $this->UsersParameters = TableRegistry::get('UsersParameters');
    }
    
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['logout', 'rememberPassword', 'changePassword']);
    }

    public function index()
    {
        $this->Regs = TableRegistry::get('Regs');
        
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        //LIMITA A LISTA DE PERFIS
        $limit = 'UsersParameters.parameters_id = ' . $this->request->Session()->read('sessionParameterControl');
        if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) == 'super') { $limit = null; }
        
        /**********************************************************************/
        
        // LISTA APENAS O PERFIL ATUAL
        if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super') { 

            $where[] = 'Users.id IN ('.implode(", ", $this->SystemFunctions->listaUsuarios($this->request->Session()->read('sessionParameterControl'))).')'; 

        }//if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super')
        
        /**********************************************************************/
        
        $users = $this->Users->find('all')
                             ->select(['Users.id', 'Users.created', 'Users.name', 'Users.username', 
                                       'UsersParameters.sendmail', 
                                       'UsersParameters.users_id', 'UsersParameters.rules_id',
                                       'UsersParameters.parameters_id', 
                                       'Parameters.id', 'Parameters.razao', 'Parameters.dtvalidade',
                                       'last_login' => '(SELECT MAX(Regs.created) FROM regs Regs WHERE Regs.users_id = Users.id AND Regs.parameters_id = Parameters.id)'
                                      ])
                             ->where($where)
                             ->join(['UsersParameters' => ['table'      => 'users_parameters',
                                                           'type'       => 'LEFT',
                                                           'conditions' => ['Users.id = UsersParameters.users_id', 
                                                                            $limit
                                                                           ]
                                                          ],
                                     'Parameters'      => ['table'      => 'parameters',
                                                           'type'       => 'LEFT',
                                                           'conditions' => ['UsersParameters.parameters_id = Parameters.id']
                                                          ]
                                    ])
                             ->order(['Parameters.dtvalidade DESC', 'Users.name', 'Users.created', 'Parameters.razao']);

        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $users = $this->paginate($users);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $users = $this->paginate($users);
            
        }
        
        /**********************************************************************/

        $this->set(compact('users'));
    }

    public function view($id)
    {
        //Acessa a tabelas
        $this->UsersParameters = TableRegistry::get('UsersParameters');
        
        /**********************************************************************/
        
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $user = $this->Users->find('all')
                            ->select(['Users.id', 'Users.created', 'Users.name', 'Users.username', 
                                      'UsersParameters.sendmail', 
                                      'UsersParameters.users_id', 'UsersParameters.rules_id',
                                      'UsersParameters.parameters_id', 'Parameters.id', 'Parameters.razao'
                                     ])
                            ->where(['Users.id' => $id])
                            ->join(['UsersParameters' => ['table'      => 'users_parameters',
                                                          'type'       => 'LEFT',
                                                          'conditions' => ['Users.id = UsersParameters.users_id', 
                                                                           'UsersParameters.parameters_id = ' . $this->request->Session()->read('sessionParameterControl')
                                                                          ]
                                                         ],
                                    'Parameters'      => ['table'      => 'parameters',
                                                          'type'       => 'LEFT',
                                                          'conditions' => ['UsersParameters.parameters_id = Parameters.id']
                                                         ]
                                   ])
                            ->order(['Parameters.razao, Users.name, Users.created'])
                            ->first();
        
        /**********************************************************************/

        $parameters = $this->Parameters->find('all')
                                       ->select(['Parameters.id', 'Parameters.razao', 'Parameters.cpfcnpj', 'Parameters.dtvalidade',
                                                 'Users.id', 'Users.name',
                                                 'UsersParameters.users_id', 'UsersParameters.parameters_id'
                                                ])
                                       ->where(['Parameters.id = UsersParameters.parameters_id'])
                                       ->join(['UsersParameters' => ['table'      => 'users_parameters',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => ['UsersParameters.users_id' => $user->id]
                                                                    ],
                                               'Users' => ['table'      => 'users',
                                                           'type'       => 'LEFT',
                                                           'conditions' => ['Users.id' => $user->id]
                                                          ]
                                              ]);
        
        /**********************************************************************/
        
        $this->Regs = TableRegistry::get('Regs');
        
        $last_login = $this->Regs->find('all')
                                 ->select(['last_login'        => 'MAX(Regs.created)'])
                                 ->where(['Regs.users_id'      => $user->id, 
                                          'Regs.parameters_id' => $user->Parameters['id']
                                         ])
                                 ->first();
        
        if (!empty($last_login)) {
            $user->last_login = $last_login->last_login;
        }
        
        /**********************************************************************/
        
        $this->set(compact('user', 'parameters'));
    }
    
    public function changeUsersParameter($users_id, $sendmail, $rules_id)
    {
        //Consulta parameters_id referente ao usuário e perfil atual
        $usersParameter = $this->UsersParameters->find('all')
                                                ->where(['UsersParameters.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                         'UsersParameters.users_id' => $users_id
                                                        ])
                                                ->first();
        
        /**********************************************************************/

        //Verifica se há cadastro existente
        if (empty($usersParameter)) {

            //Cria novo cadastro
            $usersParameter = $this->UsersParameters->newEntity();

            /******************************************************************/

            //Define campos
            $usersParameter->users_id      = $users_id;
            $usersParameter->parameters_id = $this->request->Session()->read('sessionParameterControl');
            $usersParameter->rules_id      = $rules_id;
            $usersParameter->sendmail      = $sendmail;
            $usersParameter->username      = $this->Auth->user('name');

        } else {

            //Define campos
            $usersParameter->rules_id      = $rules_id;
            $usersParameter->sendmail      = $sendmail;
            $usersParameter->username      = $this->Auth->user('name');
            
        }//else if (empty($usersParameter))
        
        /**********************************************************************/
        
        if ($this->UsersParameters->save($usersParameter)) {
            
            return true;

        }//if ($this->UsersParameters->save($usersParameter))

        /**********************************************************************/

        //Alerta de erro
        $message = 'UsersController->changeUsersParameter';
        $this->Error->registerError($usersParameter, $message, true);

        /**********************************************************************/
        
        return false;
        
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        
        if ($this->request->is('post')) {
            
            //Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/

            //DEFINE O ID DA PERMISSÃO
            $rules_id = $this->SystemFunctions->GETuserRulesId($this->request->data['rule']);
            unset($this->request->data['rule']); //Remove do request pois não existe no banco de dados
        
            //Guarda variável de envio de e-mails
            $sendmail = $this->request->data['sendmail'];
            
            /******************************************************************/

            //Vincula usuário existente?
            if ($this->request->data['buscausuario'] == 'S') {
                
                //Consulta o usuário pelo username
                $user = $this->Users->find('all')
                                    ->select(['Users.id'])
                                    ->where(['Users.username' => $this->request->data['username']])
                                    ->first();
                
                if (!empty($user)) {
                
                    //Vincula o usuário a empresa logada com a permissão selecionada
                    $this->changeUsersParameter($user->id, $sendmail, $rules_id);

                    /**************************************************************/

                    $this->Flash->success(__('Usuário vinculado com sucesso'));
                    return $this->redirect($this->referer());

                } else {

                    $this->Flash->error(__('Nome de usuário NÃO localizado, tente novamente'));
                    return $this->redirect($this->referer());

                }//else if (!empty($user))
                
            }//if ($this->request->data['buscausuario'] == 'S')
            
            /******************************************************************/

            $user = $this->Users->patchEntity($user, $this->request->getData());
        
            /**********************************************************************/

            //Consulta duplicidade
            $duplicidade = $this->Users->find('all')
                                       ->where(['Users.username' => $user->username])
                                       ->first();

            if (!empty($duplicidade)) {

                $this->Flash->error(__('Registro NÃO gravado, usuário já cadastrado no sistema'));
                return $this->redirect($this->referer());

            }//if (!empty($duplicidade))
            
            /******************************************************************/
            
            if ($this->Users->save($user)) {

                //Vincula o usuário a empresa logada com a permissão selecionada
                $this->changeUsersParameter($user->id, $sendmail, $rules_id);
                
                /**************************************************************/

                //Envia e-mail de boas vindas
                $sendMail = ['subject'  => 'SISTEMA R2: Você está cadastrado no sistema',
                             'template' => 'boas_vindas',
                             'vars'     => ['user' => $user],
                             'toEmail'  => $user->username
                            ];

                $this->EmailFunctions->sendMail($sendMail);

                /**************************************************************/
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Users->save($user))

            /******************************************************************/

            //Alerta de erro
            $message = 'UsersController->add';
            $this->Error->registerError($user, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $this->set(compact('user'));
    }

    public function edit($id)
    {
        $user = $this->Users->get($id);
        
        if ($this->request->is(['post', 'put'])) {
            
            //NÃO PERMITE MUDAR DADOS DO DESENVOLVEDOR
            if ($this->SystemFunctions->GETuserRules($id, $this->request->Session()->read('sessionParameterControl')) == 'super') { 

                //Alerta de erro
                $message = 'UsersController->edit' . implode(", ", $this->request->Session()->read());
                $this->Error->registerError($user, $message, true);

                $this->Flash->warning(__('Sem permissão para realizar esta operação'));   
                return $this->redirect($this->referer());

            }//if ($this->SystemFunctions->GETuserRules($id, $this->request->Session()->read('sessionParameterControl')) == 'super')
        
            /******************************************************************/
            
            $this->Users->patchEntity($user, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE O ID DA PERMISSÃO
            $rules_id = $this->SystemFunctions->GETuserRulesId($this->request->data['rule']);
            unset($this->request->data['rule']); //Remove do request pois não existe no banco de dados
        
            //Guarda variável de envio de e-mails
            $sendmail = $this->request->data['sendmail'];
        
            /******************************************************************/

            //Não permite a alteração de administradores e do super
            //if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'admin' && 
                // $this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super') {
                
            //Verifica se não está alterando o próprio cadastro
            if ($this->Auth->user('username') != $this->request->data['username']) {
                
                //Verifica se o usuário logado possui permissão de administrador para esse perfil
                if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                    
                    $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                    return $this->redirect($this->referer());

                }//if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
                
            } else {

                //PERMISSÃO DE 'USUÁRIO' ALTERA A PRÓPRIA SENHA MAS NÃO MODIFICAR A PERMISSÃO
                $users = $this->Users->find('all')
                                     ->select(['Users.id', 'Users.created', 'Users.name', 
                                               'Users.username', 'UsersParameters.sendmail',
                                               'UsersParameters.users_id', 
                                               'UsersParameters.rules_id', 'Rules.rule'
                                              ])
                                     ->where(['Users.id' => $id])
                                     ->join(['UsersParameters' => ['table'      => 'users_parameters',
                                                                   'type'       => 'LEFT',
                                                                   'conditions' => ['Users.id = UsersParameters.users_id',
                                                                                    'UsersParameters.parameters_id = '.$this->request->Session()->read('sessionParameterControl')
                                                                                   ]
                                                                  ],
                                             'Rules' => ['table'      => 'rules',
                                                         'type'       => 'LEFT',
                                                         'conditions' => ['UsersParameters.rules_id = Rules.id',
                                                                          'UsersParameters.parameters_id = '.$this->request->Session()->read('sessionParameterControl')
                                                                         ]
                                                        ]
                                            ])
                                     ->order(['Users.username'])
                                     ->first();
                
                $this->request->data['rule'] = $users->Rules['rule'];
                
            }//else if ($this->Auth->user('username') != $this->request->data['username'])

            // }//if $this->SystemFunctions->GETuserRules != 'admin' && $this->SystemFunctions->GETuserRules != 'super'
        
            /******************************************************************/
            
            if ($this->Users->save($user)) {

                //Vincula o usuário a empresa logada com a permissão selecionada
                $this->changeUsersParameter($user->id, $sendmail, $rules_id);
        
                /**************************************************************/

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Users->save($user))

            /******************************************************************/

            //Alerta de erro
            $message = 'UsersController->edit';
            $this->Error->registerError($user, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['post', 'put']))
        
        /**********************************************************************/
        
        //Relaciona a tabela UsersParameter para localizar informações sobre a permissão do usuário (rules)
        $user = $this->Users->find('all')
                            ->select(['Users.id', 'Users.created', 'Users.name', 'Users.username', 
                                      'UsersParameters.sendmail', 
                                      'UsersParameters.users_id', 'UsersParameters.rules_id', 
                                      'Rules.rule'
                                     ])
                            ->where(['Users.id' => $id])
                            ->join(['UsersParameters' => ['table'      => 'users_parameters',
                                                          'type'       => 'LEFT',
                                                          'conditions' => ['Users.id = UsersParameters.users_id',
                                                                           //'UsersParameters.parameters_id = '.$this->request->Session()->read('sessionParameterControl')
                                                                          ]
                                                         ],
                                    'Rules' => ['table'      => 'rules',
                                                'type'       => 'LEFT',
                                                'conditions' => ['UsersParameters.rules_id = Rules.id', 
                                                                 //'UsersParameters.parameters_id = '.$this->request->Session()->read('sessionParameterControl')
                                                                ]
                                               ]
                                  ])
                            ->order(['Users.username'])
                            ->first();
        
        /**********************************************************************/

        //EXIBE PERMISSÃO DO USUÁRIO NO FORM.
        $this->request->data['rule'] = $user->Rules['rule'];
        
        /**********************************************************************/

        $this->set(compact('user'));
    }
    
    public function changePass($id) 
    {
        $user = $this->Users->get($id);
        
        /**********************************************************************/
        
        if ($this->request->is(['patch', 'post', 'put'])) {

            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
            /******************************************************************/
            
            //NÃO PERMITE MUDAR DADOS DO DESENVOLVEDOR
            if ($this->SystemFunctions->GETuserRules($id, $this->request->Session()->read('sessionParameterControl')) == 'super') { 

                //Alerta de erro
                $message = 'UsersController->changePass' . implode(", ", $this->request->Session()->read());
                $this->Error->registerError($user, $message, true);

                $this->Flash->error(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());

            }//if ($this->SystemFunctions->GETuserRules($id, $this->request->Session()->read('sessionParameterControl')) == 'super')
        
            /******************************************************************/
            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
            }//if ($this->Users->save($user))
        
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        /**********************************************************************/
        
        $User = $this->Users->find('all')
                            ->where(['Users.id' => $id]);
        
        $users_row = $User->first();
        $this->request->data = $users_row;
        unset($this->request->data['password']);
    }
    
    public function deleteUsersParameter($users_id, $rule = null)
    {
        //Acessa a tabelas
        $this->UsersParameters = TableRegistry::get('UsersParameters');
        
        /**********************************************************************/
        
        //Atribui o id do Rule
        if (empty($rule)) {
            
            $rule = $this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'));

        } else {
            
            $rule = $this->SystemFunctions->GETuserRulesId($rule);

        }//if (empty($rule))
        
        /**********************************************************************/
        
        if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) == 'super') { 
            $conditions = ['UsersParameters.users_id'      => $users_id];
        } else {
            $conditions = ['UsersParameters.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                           'UsersParameters.users_id'      => $users_id
                          ];
        }
        
        /**********************************************************************/
        
        return $this->UsersParameters->deleteAll($conditions);
    }

    public function delete($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $this->request->allowMethod(['post', 'delete']);
        
        /**********************************************************************/
        
        //NÃO PERMITE MUDAR DADOS DO DESENVOLVEDOR
        if ($this->SystemFunctions->GETuserRules($id, $this->request->Session()->read('sessionParameterControl')) == 'super') { 

            //Alerta de erro
            $message = 'UsersController->delete' . implode(", ", $this->request->Session()->read());
            $this->Error->registerError($this->Users->get($user), $message, true);

            $this->Flash->error(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());

        }//if ($this->SystemFunctions->GETuserRules($id, $this->request->Session()->read('sessionParameterControl')) == 'super')
        
        /**********************************************************************/
        
        //NÃO É POSSÍVEL DESVINCULAR OU EXCLUIR O PRÓPRIO USUÁRIO
        if ($this->Auth->user('id') != $id) {
            
            //DESVINCULA O USUÁRIO SELECIONADO DA EMPRESA ATUAL
            $this->deleteUsersParameter($id);

        } else {
            
            $this->Flash->error(__('Não é possível excluir o próprio usuário'));   
            return $this->redirect($this->referer());

        }//else if ($this->Auth->user('id') != $id)
        
        /**********************************************************************/
        
        //SE O USUÁRIO ESTIVER VINCULADO A OUTRA EMPRESA O CADASTRO NÃO SERÁ EXCLUÍDO
        if (count($this->SystemFunctions->listaPerfis($id)) > 0) {

            $this->Flash->warning(__('Usuário desvinculado com sucesso'));
            return $this->redirect($this->referer());

        }//if (count($this->SystemFunctions->listaPerfis($id)) > 0)
        
        /**********************************************************************/
        
        //CONSULTA REGISTRO COMPLETO PARA REGISTRO DE LOG
        $user = $this->Users->findById($id)
                            ->first();
        
        /**********************************************************************/

        if (!empty($user)) {

            //GRAVA LOG
            $this->Log->gravaLog($user, 'delete', 'Users');
            
            /**********************************************************************/
            
            if ($this->Users->delete($user)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Users->delete($user))

        }//if (!empty($user))
        
        /**********************************************************************/
        
        //Alerta de erro
        $message = 'UsersController->delete';
        $this->Error->registerError($user, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'Users';
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
        
        if (!empty($this->params['name_search'])) { 
            $where[] = $table.'.name LIKE "%'.$this->params['name_search'].'%"';
        }
        
        if (!empty($this->params['username_search'])) { 
            $where[] = $table.'.username LIKE "%'.$this->params['username_search'].'%"';
        }
        
        return $where;
    }
}