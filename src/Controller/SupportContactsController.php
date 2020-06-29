<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* SupportContacts */
/* File: src/Controller/SupportContactsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class SupportContactsController extends AppController
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
    }
    
    public function index()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super') {
            
            $where[] = 'SupportContacts.parameters_id = ' . $this->request->Session()->read('sessionParameterControl');
            
        }
        
        /**********************************************************************/
        
        $supportContacts = $this->SupportContacts->find('all')
                                                 ->where($where)
                                                 ->contain(['Parameters'])
                                                 ->order(['SupportContacts.status']);
                                                 //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $supportContacts = $this->paginate($supportContacts);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $supportContacts = $this->paginate($supportContacts);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('supportContacts'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $where = [];
        
        /**********************************************************************/
            
        if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super') {

            $where[] = 'SupportContacts.parameters_id = ' . $this->request->Session()->read('sessionParameterControl');

        }//if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super')
        
        /**********************************************************************/
        
        $supportContact = $this->SupportContacts->findById($id)
                                                ->where($where)
                                                ->first();
        
        /**********************************************************************/
        
        $this->set(compact('supportContact'));
    }
    
    public function addResponse($id)
    {
        //CONSULTA REGISTRO
        if ($this->request->Session()->read('sessionRule') == 'super') {
            $supportContact = $this->SupportContacts->findById($id)
                                                    ->first();
        } else {
            $supportContact = $this->SupportContacts->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                                    ->first();
        }//else if ($this->request->Session()->read('sessionRule') == 'super')
        
        /**********************************************************************/

        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //DEFINE STATUS COMO ABERTO
            $supportContact->status = 'B'; //A - Aberto, B - Respondido, F - Finalizado
            
            /******************************************************************/

            $supportContact = $this->SupportContacts->patchEntity($supportContact, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->SupportContacts->save($supportContact)) {
                
                //Alerta o usuário da resposta de chamado
                $sendMail = ['subject'  => 'SISTEMA R2: Resposta do Chamado de Suporte - #' . str_pad($supportContact->ordem, 6, '0', STR_PAD_LEFT),
                             'template' => 'support_contact',
                             'vars'     => ['supportContact' => json_decode(json_encode($supportContact), true)],
                             'toEmail'  => $supportContact->mail
                            ];
        
                $this->EmailFunctions->sendMail($sendMail);
            
                /**************************************************************/
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->SupportContacts->save($supportContact))
        
            /******************************************************************/

            //Alerta de erro
            $message = 'SupportContactsController->add_response';
            $this->Error->registerError($supportContact, $message, true);

            /******************************************************************/
            
            $this->Flash->success(__('O registro NÃO foi gravado. Por favor, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        /**********************************************************************/
        
        $this->set(compact('supportContact'));
    }

    public function add()
    {
        $supportContact = $this->SupportContacts->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $supportContact->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE USUÁRIO LOGADO COMO CRIADOR
            $supportContact->username = $this->Auth->user('name');
            
            //DEFINE STATUS COMO ABERTO
            $supportContact->status = 'A'; //A - Aberto, B - Respondido, F - Finalizado
            
            //DEFINE O E-MAIL DE RESPOSTA
            $supportContact->mail = $this->Auth->user('username');
            
            /******************************************************************/
            
            //DEFINE O VALOR DO ORDEM
            $ordem = $this->SupportContacts->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->select(['MAX' => 'MAX(SupportContacts.ordem)'])
                                           ->first();
            $ordem = $ordem->MAX + 1;
            $supportContact->ordem = $ordem;
            
            /******************************************************************/
            
            $supportContact = $this->SupportContacts->patchEntity($supportContact, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->SupportContacts->save($supportContact)) {

                //Alerta o usuário de novo chamado
                $sendMail = ['subject'  => 'SISTEMA R2: Novo Chamado de Suporte - #' . str_pad($supportContact->ordem, 6, '0', STR_PAD_LEFT),
                             'template' => 'support_contact',
                             'vars'     => ['supportContact' => json_decode(json_encode($supportContact), true)],
                             'toEmail'  => $supportContact->mail
                            ];

                $this->EmailFunctions->sendMail($sendMail);
            
                /**************************************************************/
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->SupportContacts->save($supportContact))
            
            /******************************************************************/
            
            $this->Flash->error(__('O registro NÃO foi gravado. Por favor, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is('post'))
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        if ($this->request->Session()->read('sessionRule') == 'super') {
            $supportContact = $this->SupportContacts->findById($id)
                                                    ->first();
        } else {
            $supportContact = $this->SupportContacts->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                                    ->first();
        }//else if ($this->request->Session()->read('sessionRule') == 'super')
        
        /**********************************************************************/

        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super') {
                $supportContact->username = $this->Auth->user('name');
                $supportContact->status   = 'A';
                $supportContact->resposta = null;
            }//if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super')
        
            /******************************************************************/
            
            $supportContact = $this->SupportContacts->patchEntity($supportContact, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->SupportContacts->save($supportContact)) {

                //Alerta o usuário da edição de chamado
                $sendMail = ['subject'  => 'SISTEMA R2: Edição do Chamado de Suporte - #' . str_pad($supportContact->ordem, 6, '0', STR_PAD_LEFT),
                             'template' => 'support_contact',
                             'vars'     => ['supportContact' => json_decode(json_encode($supportContact), true)],
                             'toEmail'  => $supportContact->mail
                            ];

                $this->EmailFunctions->sendMail($sendMail);
            
                /**************************************************************/
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->SupportContacts->save($supportContact))
            
            /******************************************************************/
            
            $this->Flash->error(__('O registro NÃO foi gravado. Por favor, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is(['patch', 'post', 'put']))
        
        /**********************************************************************/
        
        $this->set(compact('supportContact'));
    }
    
    public function finaliza($id)
    {
        //CONSULTA REGISTRO
        if ($this->request->Session()->read('sessionRule') == 'super') {
            $supportContact = $this->SupportContacts->findById($id)
                                                    ->first();
        } else {
            $supportContact = $this->SupportContacts->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                                    ->first();
        }//else if ($this->request->Session()->read('sessionRule') == 'super')
        
        /**********************************************************************/

        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        //FINALIZA SOLICITAÇÃO
        $supportContact->status = 'F'; //A - Aberto, B - Respondido, F - Finalizado
        
        /**********************************************************************/

        $supportContact = $this->SupportContacts->patchEntity($supportContact, $this->request->getData());
        
        /**********************************************************************/

        if ($this->SupportContacts->save($supportContact)) {
            
            //Alerta o usuário da finalização de chamado
            $sendMail = ['subject'  => 'SISTEMA R2: Finalização do Chamado de Suporte - #' . str_pad($supportContact->ordem, 6, '0', STR_PAD_LEFT),
                         'template' => 'support_contact',
                         'vars'     => ['supportContact' => json_decode(json_encode($supportContact), true)],
                         'toEmail'  => $supportContact->mail
                        ];
    
            $this->EmailFunctions->sendMail($sendMail);
        
            /**************************************************************/
            
            $this->Flash->success(__('Registro gravado com sucesso'));
            return $this->redirect($this->referer());
            
        }//if ($this->SupportContacts->save($supportContact))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'SupportContactsController->finaliza';
        $this->Error->registerError($supportContact, $message, true);

        /**********************************************************************/
        
        $this->Flash->error(__('O registro NÃO foi gravado. Por favor, tente novamente'));
        return $this->redirect($this->referer());
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
        $supportContact = $this->SupportContacts->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                                ->first();
        
        /**********************************************************************/

        if (!empty($supportContact)) {

            //GRAVA LOG
            $this->Log->gravaLog($supportContact, 'delete', 'SupportContacts');
            
            /******************************************************************/
            
            if ($this->SupportContacts->delete($supportContact)) {

                //Alerta o usuário da exclusão de chamado
                $sendMail = ['subject'  => 'SISTEMA R2: Exclusão do Chamado de Suporte - #' . str_pad($supportContact->ordem, 6, '0', STR_PAD_LEFT),
                            'template' => 'support_contact',
                            'vars'     => ['supportContact' => json_decode(json_encode($supportContact), true)],
                            'toEmail'  => $supportContact->mail
                            ];

                $this->EmailFunctions->sendMail($sendMail);
            
                /**************************************************************/
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->SupportContacts->delete($supportContact))

        }//if (!empty($supportContact))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'SupportContactsController->delete';
        $this->Error->registerError($supportContact, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request = null)
    {
        $table = 'SupportContacts';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['title'])) { 
            $where[] = '('.$table . '.title LIKE = "%' . $this->params['title'] . '%")';
        }
        
        return $where;
    }
}