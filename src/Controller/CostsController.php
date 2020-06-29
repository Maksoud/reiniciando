<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Costs */
/* File: src/Controller/CostsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class CostsController extends AppController
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
        
        $costs = $this->Costs->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                             ->where($where)
                             ->order(['Costs.title']);
                             //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $costs = $this->paginate($costs);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $costs = $this->paginate($costs);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('costs'));
    }
    
    public function indexSimple()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $costs = $this->Costs->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                             ->where($where)
                             ->order(['Costs.title']);
                             //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $costs = $this->paginate($costs);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $costs = $this->paginate($costs);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('costs'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $cost = $this->Costs->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        /**********************************************************************/
        
        $this->set(compact('cost'));
    }
    
    public function viewSimple($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $cost = $this->Costs->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        /**********************************************************************/
        
        $this->set(compact('cost'));
    }
    
    public function add()
    {
        $cost = $this->Costs->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Consulta TITLE para evitar duplicidade
            $duplicidade = $this->Costs->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['title'])
                                       ->where(['Costs.title' => $this->request->data['title']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }//if (!empty($duplicidade->toArray()))
            
            /******************************************************************/
            
            $cost = $this->Costs->patchEntity($cost, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $cost->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $cost->username      = $this->Auth->user('name');
            $cost->status        = 'A';
            
            /******************************************************************/
            
            if ($this->Costs->save($cost)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Costs->save($cost))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'CostsController->add';
            $this->Error->registerError($cost, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
    }
    
    public function addSimple()
    {
        $cost = $this->Costs->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Consulta TITLE para evitar duplicidade
            $duplicidade = $this->Costs->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['title'])
                                       ->where(['Costs.title' => $this->request->data['title']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }//if (!empty($duplicidade->toArray()))
            
            /******************************************************************/
            
            $cost = $this->Costs->patchEntity($cost, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $cost->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $cost->username      = $this->Auth->user('name');
            $cost->status        = 'A';
            
            /******************************************************************/
            
            if ($this->Costs->save($cost)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Costs->save($cost))

            /******************************************************************/

            //Alerta de erro
            $message = 'CostsController->addSimple';
            $this->Error->registerError($cost, $message, true);

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
            
            $cost = $this->Costs->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/
            
            if ($this->Costs->save($cost)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($cost, 'add', 'Costs');
                
                $mensagem = __('Registro gravado com sucesso');
                $status   = 'ok';
                $id       = $cost->id;
                $title    = $cost->title;
                
            } else { 

                $mensagem = __('Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente');
    
                //Alerta de erro
                $message = 'CostsController->addjson';
                $this->Error->registerError($cost, $message, true);

            }//else if ($this->Costs->save($cost))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'title')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $cost = $this->Costs->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //REATIVA REGISTRO INATIVO
            if ($cost['status'] == 'I') { $this->request->data['status'] = 'A'; }
            
            /******************************************************************/
            
            $cost = $this->Costs->patchEntity($cost, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $cost->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->Costs->save($cost)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Costs->save($cost))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'CostsController->edit';
            $this->Error->registerError($cost, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $this->set(compact('cost'));
    }

    public function editSimple($id)
    {
        //CONSULTA REGISTRO
        $cost = $this->Costs->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //REATIVA REGISTRO INATIVO
            if ($cost['status'] == 'I') { $this->request->data['status'] = 'A'; }
            
            /******************************************************************/
            
            $cost = $this->Costs->patchEntity($cost, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $cost->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->Costs->save($cost)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Costs->save($cost))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'CostsController->editSimple';
            $this->Error->registerError($cost, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $this->set(compact('cost'));
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
        $cost = $this->Costs->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        /**********************************************************************/
        
        if (!empty($cost)) {

            //VERIFICA SE O CADASTRO ESTÁ EM USO NOS MOVIMENTOS
            if ($vinc_moviments = $this->consultaMovimentos($id, 'costs_id')) {
                
                if ($cost->status != 'I') {
                    
                    $cost->title    = $cost->title.' (INATIVO)';
                    $cost->username = $this->Auth->user('name');
                    $cost->status   = 'I';
                    
                    if ($this->Costs->save($cost)) {
                        
                        $this->Log->gravaLog($cost, 'inativate', 'Costs'); //GRAVA LOG
                        
                        $this->Flash->warning(__('Registro inativado. Não pode ser excluído devido a movimentos vinculados'));
                        return $this->redirect($this->referer());
                        
                    } else {

                        //Alerta de erro
                        $message = 'Costs->delete, inativate';
                        $this->Error->registerError($cost, $message, true);
                        
                        $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                        return $this->redirect($this->referer());
                        
                    }//else if ($this->Costs->save($cost))
                    
                } else {

                    //Alerta de erro
                    $message = 'Costs->delete, inativated';
                    $this->Error->registerError(null, $message, true);
                    
                    $this->Flash->warning(__('Registro inativo. Há movimentos vinculados em ').$vinc_moviments);
                    return $this->redirect($this->referer());
                    
                }//else if ($cost->status != 'I')
                
            }//if ($vinc_moviments = $this->consultaMovimentos($id, 'costs_id'))
            
            /******************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($cost, 'delete', 'Costs');
            
            /******************************************************************/
            
            if ($this->Costs->delete($cost)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Costs->delete($cost))

        }//if (!empty($cost))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'CostsController->delete';
        $this->Error->registerError($cost, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'Costs';
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
                
                $query[] = '(Costs.title LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $costs = $this->Costs->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                 ->select(['Costs.id', 'Costs.title'])
                                 ->where(['Costs.status IN' => ['A', 'T']])
                                 ->where($query)
                                 ->order(['Costs.title']);
            
            $json = [];
            
            foreach ($costs as $data) {
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