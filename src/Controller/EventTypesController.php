<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* EventTypes */
/* File: src/Controller/EventTypesController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class EventTypesController extends AppController
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
    }
    
    public function index()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $eventTypes = $this->EventTypes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->where($where)
                                       ->order(['EventTypes.title']);
                                       //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $eventTypes = $this->paginate($eventTypes);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $eventTypes = $this->paginate($eventTypes);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('eventTypes'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $eventType = $this->EventTypes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                      ->first();
        
        /**********************************************************************/
        
        $this->set(compact('eventType'));
    }

    public function add()
    {
        $eventType = $this->EventTypes->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Consulta TITLE para evitar duplicidade
            $duplicidade = $this->EventTypes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['title'])
                                       ->where(['EventTypes.title' => $this->request->data['title']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }//if (!empty($duplicidade->toArray()))
            
            /******************************************************************/
            
            $eventType = $this->EventTypes->patchEntity($eventType, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $eventType->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $eventType->username      = $this->Auth->user('name');
            $eventType->status        = 'A';
            
            /******************************************************************/
            
            if ($this->EventTypes->save($eventType)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->EventTypes->save($eventType))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'EventTypesController->add';
            $this->Error->registerError($eventType, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
    }
    
    public function addjson()
    {
        $mensagem = __("Nenhuma requisição foi identificada");
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
            $this->request->data['status']        = 'A';
            
            /******************************************************************/
            
            $eventType = $this->EventTypes->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/
            
            if ($this->EventTypes->save($eventType)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($eventType, 'add', 'EventTypes');
                
                $mensagem = 'Registro gravado com sucesso';
                $status   = 'ok';
                $id       = $eventType->id;
                $title    = $eventType->title;
                
            } else { 
                
                $mensagem = __('Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente');

                //Alerta de erro
                $message = 'EventTypesController->addjson';
                $this->Error->registerError($eventType, $message, true);

            }//else if ($this->EventTypes->save($eventType))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'title')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $eventType = $this->EventTypes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                      ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //REATIVA REGISTRO INATIVO
            if ($eventType['status'] == 'I') { $this->request->data['status'] = 'A'; }
            
            /******************************************************************/
            
            $eventType = $this->EventTypes->patchEntity($eventType, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $eventType->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->EventTypes->save($eventType)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->EventTypes->save($eventType))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'EventTypesController->edit';
            $this->Error->registerError($eventType, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $this->set(compact('eventType'));
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
        
        //CONSULTA REGISTRO
        $eventType = $this->EventTypes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                      ->first();
        
        /**********************************************************************/
        
        if (!empty($eventType)) {

            //VERIFICA SE O CADASTRO ESTÁ EM USO NOS MOVIMENTOS
            if ($vinc_moviments = $this->consultaMovimentos($id, 'event_types_id')) {
                
                if ($eventType->status != 'I') {
                    
                    $eventType->title    = $eventType->title.' (INATIVO)';
                    $eventType->username = $this->Auth->user('name');
                    $eventType->status   = 'I';
                    
                    if ($this->EventTypes->save($eventType)) {
                        
                        $this->Log->gravaLog($eventType, 'inativate', 'EventTypes'); //GRAVA LOG
                        
                        $this->Flash->warning(__('Registro inativado. Não pode ser excluído devido a movimentos vinculados'));
                        return $this->redirect($this->referer());
                        
                    } else {

                        //Alerta de erro
                        $message = 'EventTypesController->delete, inativate';
                        $this->Error->registerError($eventType, $message, true);
                        
                        $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                        return $this->redirect($this->referer());
                        
                    }//else if ($this->EventTypes->save($eventType))
                    
                } else {

                    //Alerta de erro
                    $message = 'EventTypesController->delete, inativated';
                    $this->Error->registerError($eventType, $message, true);
                    
                    $this->Flash->warning(__('Registro inativo. Há movimentos vinculados em ').$vinc_moviments);
                    return $this->redirect($this->referer());
                    
                }//else if ($eventType->status != 'I')
                
            }//if ($vinc_moviments = $this->consultaMovimentos($id, 'event_types_id'))
            
            /******************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($eventType, 'delete', 'EventTypes');
            
            /******************************************************************/
            
            if ($this->EventTypes->delete($eventType)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->EventTypes->delete($eventType))

        }//if (!empty($eventType))

        /**********************************************************************/

        //Alerta de erro
        $message = 'EventTypesController->delete';
        $this->Error->registerError($eventType, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'EventTypes';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['title_search'])) { 
            $where[] = '('.$table.'.title LIKE "%'.$this->params['title_search'].'%")';
        }
        
        if (!empty($this->params['status_search'])) { 
            $where[] = '('.$table.'.status = "'.$this->params['status_search'].'")';
        } else {
            $where[] = '('.$table.'.status = "A")';
        }
        
        return $where;
    }
    
    public function json()
    {
        if ($this->request->is('get')) {
            
            if (isset($this->request->query['query'])) {
                
                $query[] = '(EventTypes.title LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $eventTypes = $this->EventTypes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->select(['EventTypes.id', 'EventTypes.title'])
                                           ->where(['EventTypes.status IN' => ['A', 'T']])
                                           ->where($query)
                                           ->order(['EventTypes.title']);
            
            $json = [];
            
            foreach ($eventTypes as $data) {
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