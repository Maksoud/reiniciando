<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Transporters */
/* File: src/Controller/TransportersController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class TransportersController extends AppController
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
        
        $transporters = $this->Transporters->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->where($where)
                                           ->order(['Transporters.title']);
                                           //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $transporters = $this->paginate($transporters);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $transporters = $this->paginate($transporters);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('transporters'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $transporter = $this->Transporters->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                          ->first();
        
        /**********************************************************************/
        
        $this->set(compact('transporter'));
    }

    public function add()
    {
        $transporter = $this->Transporters->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Consulta TITLE para evitar duplicidade
            $duplicidade = $this->Transporters->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                              ->select(['title'])
                                              ->where(['Transporters.title' => $this->request->data['title']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }//if (!empty($duplicidade->toArray()))
            
            /******************************************************************/
            
            $transporter = $this->Transporters->patchEntity($transporter, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $transporter->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $transporter->username      = $this->Auth->user('name');
            $transporter->status        = 'A';
            
            /******************************************************************/
            
            if ($this->Transporters->save($transporter)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($transporter, 'add', 'Transporters');
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Transporters->save($transporter))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'TransportersControler->add';
            $this->Error->registerError($transporter, $message, true);
                
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))
        
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
            
            $transporter = $this->Transporters->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/
            
            if ($this->Transporters->save($transporter)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($transporter, 'add', 'Transporters');
                
                $mensagem = 'Registro gravado com sucesso';
                $status   = 'ok';
                $id       = $transporter->id;
                $title    = $transporter->title;
                
            } else { 

                $mensagem = 'Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente';

                //Alerta de erro
                $message = 'TransportersControler->addjson';
                $this->Error->registerError($transporter, $message, true);

            }//else if ($this->Transporters->save($transporter))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'title')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $transporter = $this->Transporters->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                          ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $transporter = $this->Transporters->patchEntity($transporter, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $transporter->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->Transporters->save($transporter)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Transporters->save($transporter))

            /******************************************************************/

            //Alerta de erro
            $message = 'TransportersControler->edit';
            $this->Error->registerError($transporter, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $this->set(compact('transporter'));
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
        $transporter = $this->Transporters->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                          ->first();

        /**********************************************************************/

        if (!empty($transporter)) {

             //GRAVA LOG
            $this->Log->gravaLog($transporter, 'delete', 'Transporters');
            
            /******************************************************************/
            
            if ($this->Transporters->delete($transporter)) {
                
                $this->Flash->success(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Transporters->delete($transporter))

        }///if (!empty($transporter))

        /**********************************************************************/
        
        //Alerta de erro
        $message = 'TransportersController->delete';
        $this->Error->registerError($transporter, $message, true);

        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'Transporters';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['cpfcnpj_search'])) { 
            $where[] = '('.$table.'.cpfcnpj LIKE "%'.$this->params['cpfcnpj_search'].'%")';
        }
        
        if (!empty($this->params['title_search'])) { 
            $where[] = '('.$table.'.title LIKE "%'.$this->params['title_search'].'%")';
        }
        
        if (!empty($this->params['fantasia_search'])) { 
            $where[] = '('.$table.'.fantasia LIKE "%'.$this->params['fantasia_search'].'%")';
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
                
                $query[] = '(Transporters.title LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $transporters = $this->Transporters->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                               ->select(['Transporters.id', 'Transporters.title'])
                                               ->where(['Transporters.status' => 'A'])
                                               ->where($query)
                                               ->order(['Transporters.title']);
            
            $json = [];
            
            foreach ($transporters as $data) {
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