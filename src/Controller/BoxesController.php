<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Boxes */
/* File: src/Controller/BoxesController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class BoxesController extends AppController
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
        
        $boxes = $this->Boxes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                             ->where($where)
                             ->order(['Boxes.title']);
                             //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $boxes = $this->paginate($boxes);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $boxes = $this->paginate($boxes);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('boxes'));
    }
    
    public function indexSimple()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $boxes = $this->Boxes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                             ->where($where)
                             ->order(['Boxes.title']);
                             //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $boxes = $this->paginate($boxes);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $boxes = $this->paginate($boxes);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('boxes'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $box = $this->Boxes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                           ->first();
        
        /**********************************************************************/
        
        $this->set(compact('box'));
    }

    public function viewSimple($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $box = $this->Boxes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                           ->first();
        
        /**********************************************************************/
        
        $this->set(compact('box'));
    }

    public function add()
    {
        $box = $this->Boxes->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Consulta TITLE para evitar duplicidade
            $duplicidade = $this->Boxes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['title'])
                                       ->where(['Boxes.title' => $this->request->data['title']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }
            
            /******************************************************************/
            
            $box = $this->Boxes->patchEntity($box, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $box->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $box->username      = $this->Auth->user('name');
            $box->status        = 'A';
            
            /******************************************************************/
            
            if ($this->Boxes->save($box)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($box, 'add', 'Boxes');
                
                //CRIA NOVO REGISTRO NA TABELA DE SALDOS
                $this->GeneralBalance->addBalance('boxes_id', $box->id, null, $this->request->Session()->read('sessionParameterControl'));
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }////if ($this->Boxes->save($box))
            
            /******************************************************************/
            
            //Alerta de erro
            $message = 'BoxesController->add';
            $this->Error->registerError($box, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }
    }

    public function addSimple()
    {
        $box = $this->Boxes->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Consulta TITLE para evitar duplicidade
            $duplicidade = $this->Boxes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['title'])
                                       ->where(['Boxes.title' => $this->request->data['title']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }//if (!empty($duplicidade->toArray()))
            
            /******************************************************************/
            
            $box = $this->Boxes->patchEntity($box, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $box->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $box->username      = $this->Auth->user('name');
            $box->status        = 'A';
            
            /******************************************************************/
            
            if ($this->Boxes->save($box)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($box, 'add', 'Boxes');
                
                //CRIA NOVO REGISTRO NA TABELA DE SALDOS
                $this->GeneralBalance->addBalance('boxes_id', $box->id, null, $this->request->Session()->read('sessionParameterControl'));
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Boxes->save($box))

            /******************************************************************/
            
            //Alerta de erro
            $message = 'BoxesController->addSimple';
            $this->Error->registerError($box, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }
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
            $this->request->data['status']        = 'A';
            
            /******************************************************************/
            
            $box = $this->Boxes->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/
            
            if ($this->Boxes->save($box)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($box, 'add', 'Boxes');
                
                //CRIA NOVO REGISTRO NA TABELA DE SALDOS
                $this->GeneralBalance->addBalance('boxes_id', $box->id, null, $this->request->Session()->read('sessionParameterControl'));

                $mensagem = 'Registro gravado com sucesso';
                $status   = 'ok';
                $id       = $box->id;
                $title    = $box->title;
                
            } else { 
                
                $mensagem = 'Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente';
                
                //Alerta de erro
                $message = 'BoxesController->addjson';
                $this->Error->registerError($box, $message, true);

            }//else if ($this->Boxes->save($box))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'title')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $box = $this->Boxes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                           ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $box = $this->Boxes->patchEntity($box, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $box->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->Boxes->save($box)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Boxes->save($box))
            
            /******************************************************************/
            
            //Alerta de erro
            $message = 'BoxesController->edit';
            $this->Error->registerError($box, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $this->set(compact('box'));
    }

    public function editSimple($id)
    {
        //CONSULTA REGISTRO
        $box = $this->Boxes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                           ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $box = $this->Boxes->patchEntity($box, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $box->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->Boxes->save($box)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Boxes->save($box))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'BoxesController->editSimple';
            $this->Error->registerError($box, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $this->set(compact('box'));
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
        $box = $this->Boxes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                           ->first();
        
        /**********************************************************************/
        
        if (!empty($box)) {

            //VERIFICA SE O CADASTRO ESTÁ EM USO NOS MOVIMENTOS
            if ($vinc_moviments = $this->consultaMovimentos($id, 'boxes_id')) {
                
                if ($box->status != 'I') {
                    
                    $box->title    = $box->title.' (INATIVO)';
                    $box->username = $this->Auth->user('name');
                    $box->status   = 'I';
                    
                    if ($this->Boxes->save($box)) {
                        
                        $this->Log->gravaLog($box, 'inativate', 'Boxes'); //GRAVA LOG
                        
                        $this->Flash->warning(__('Registro inativado. Não pode ser excluído devido a movimentos vinculados'));
                        return $this->redirect($this->referer());
                        
                    } else {

                        //Alerta de erro
                        $message = 'BoxesController->delete, inativate';
                        $this->Error->registerError($box, $message, true);
                        
                        $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                        return $this->redirect($this->referer());
                        
                    }//else if ($this->Boxes->save($box))
                    
                } else {

                    //Alerta de erro
                    $message = 'BoxesController->delete, inativated';
                    $this->Error->registerError(null, $message, true);
                    
                    $this->Flash->warning(__('Registro inativo. Há movimentos vinculados em '.$vinc_moviments));
                    return $this->redirect($this->referer());
                    
                }
                
            }//if ($vinc_moviments = $this->consultaMovimentos($id, 'boxes_id'))
            
            /**********************************************************************/
            
            //Exclui Saldos
            $this->GeneralBalance->deleteBalance('boxes_id', $id, $this->request->Session()->read('sessionParameterControl'));
            
            /**********************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($box, 'delete', 'Boxes');
            
            /**********************************************************************/
            
            if ($this->Boxes->delete($box)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Boxes->delete($box))

        }//if (!empty($box))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'BoxesController->delete';
        $this->Error->registerError($box, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'Boxes';
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
                
                $query[] = '(Boxes.title LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $boxes = $this->Boxes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                 ->select(['Boxes.id', 'Boxes.title'])
                                 ->where(['Boxes.status' => 'A'])
                                 ->where($query)
                                 ->order(['Boxes.title']);
            
            $json = [];
            
            foreach ($boxes as $data) {
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