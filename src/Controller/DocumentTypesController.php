<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* DocumentTypes */
/* File: src/Controller/DocumentTypesController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class DocumentTypesController extends AppController
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
        
        $documentTypes = $this->DocumentTypes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                             ->where($where)
                                             ->order(['DocumentTypes.title']);
                                     //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $documentTypes = $this->paginate($documentTypes);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $documentTypes = $this->paginate($documentTypes);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('documentTypes'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $documentType = $this->DocumentTypes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                            ->first();
        
        /**********************************************************************/
        
        $this->set(compact('documentType'));
    }

    public function add()
    {
        $documentType = $this->DocumentTypes->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Consulta TITLE para evitar duplicidade
            $duplicidade = $this->DocumentTypes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                               ->select(['title'])
                                               ->where(['DocumentTypes.title' => $this->request->data['title']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }//if (!empty($duplicidade->toArray()))
            
            /******************************************************************/
            
            $documentType = $this->DocumentTypes->patchEntity($documentType, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $documentType->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $documentType->username      = $this->Auth->user('name');
            $documentType->status        = 'A';
            
            /******************************************************************/
            
            if ($this->DocumentTypes->save($documentType)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->DocumentTypes->save($documentType))

            /******************************************************************/

            //Alerta de erro
            $message = 'DocumentTypesController->add';
            $this->Error->registerError($documentType, $message, true);

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
            
            $documentType = $this->DocumentTypes->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/
            
            if ($this->DocumentTypes->save($documentType)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($documentType, 'add', 'EventTypes');
                
                $mensagem = __('Registro gravado com sucesso');
                $status   = 'ok';
                $id       = $documentType->id;
                $title    = $documentType->title;
                
            } else { 
                
                $mensagem = __('Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente');
                    
                //Alerta de erro
                $message = 'DocumentTypesController->addjson';
                $this->Error->registerError($documentType, $message, true);

            }//else if ($this->DocumentTypes->save($documentType))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'title')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $documentType = $this->DocumentTypes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                            ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //REATIVA REGISTRO INATIVO
            if ($documentType['status'] == 'I') { $this->request->data['status'] = 'A'; }
            
            /******************************************************************/
            
            $documentType = $this->DocumentTypes->patchEntity($documentType, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $documentType->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->DocumentTypes->save($documentType)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->DocumentTypes->save($documentType))

            /******************************************************************/

            //Alerta de erro
            $message = 'DocumentTypesController->edit';
            $this->Error->registerError($documentType, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $this->set(compact('documentType'));
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
        $documentType = $this->DocumentTypes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                            ->first();
        
        /**********************************************************************/
        
        if (!empty($documentType)) {

            //VERIFICA SE O CADASTRO ESTÁ EM USO NOS MOVIMENTOS
            if ($vinc_moviments = $this->consultaMovimentos($id, 'document_types_id')) {
                
                if ($documentType->status != 'I') {
                    
                    $documentType->title    = $documentType->title.' (INATIVO)';
                    $documentType->username = $this->Auth->user('name');
                    $documentType->status   = 'I';
                    
                    if ($this->DocumentTypes->save($documentType)) {
                        
                        $this->Log->gravaLog($documentType, 'inativate', 'DocumentTypes'); //GRAVA LOG
                        
                        $this->Flash->warning(__('Registro inativado. Não pode ser excluído devido a movimentos vinculados'));
                        return $this->redirect($this->referer());
                        
                    } else {

                        //Alerta de erro
                        $message = 'DocumentTypesController->delete, inativate';
                        $this->Error->registerError($documentType, $message, true);
                        
                        $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                        return $this->redirect($this->referer());
                        
                    }//else if ($this->DocumentTypes->save($documentType))
                    
                } else {

                    //Alerta de erro
                    $message = 'DocumentTypesController->delete, inativated';
                    $this->Error->registerError($documentType, $message, true);
                    
                    $this->Flash->warning(__('Registro inativo. Há movimentos vinculados em '.$vinc_moviments));
                    return $this->redirect($this->referer());
                    
                }//else if ($documentType->status != 'I')
                
            }//if ($vinc_moviments = $this->consultaMovimentos($id, 'document_types_id'))
            
            /**********************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($documentType, 'delete', 'DocumentTypes');
            
            /**********************************************************************/
            
            if ($this->DocumentTypes->delete($documentType)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->DocumentTypes->delete($documentType))

        }//if (!empty($documentType))

        /**********************************************************************/

        //Alerta de erro
        $message = 'DocumentTypesController->delete';
        $this->Error->registerError($documentType, $message, true);

        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {           
        $table = 'DocumentTypes';
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
                
                $query[] = '(DocumentTypes.title LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $documentTypes = $this->DocumentTypes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['DocumentTypes.id', 'DocumentTypes.title'])
                                                 ->where(['DocumentTypes.status IN' => ['A', 'T']])
                                                 ->where($query)
                                                 ->order(['DocumentTypes.title']);
            
            $json = [];
            
            foreach ($documentTypes as $data) {
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