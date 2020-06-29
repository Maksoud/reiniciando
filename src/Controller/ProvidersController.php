<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Providers */
/* File: src/Controller/ProvidersController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class ProvidersController extends AppController
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
        
        $providers = $this->Providers->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->where($where)
                                     ->order(['Providers.title']);
                                     //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $providers = $this->paginate($providers);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $providers = $this->paginate($providers);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('providers'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $provider = $this->Providers->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->first();
        
        $this->set(compact('provider'));
    }

    public function add()
    {
        $provider = $this->Providers->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Consulta CPF/CNPJ para evitar duplicidade
            $duplicidade = $this->Providers->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->select(['title'])
                                           ->where(['Providers.cpfcnpj' => $this->request->data['cpfcnpj']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('CPF/CNPJ já cadastrado'));
                return $this->redirect($this->referer());
            }//if (!empty($duplicidade->toArray()))
            
            /******************************************************************/
            
            $provider = $this->Providers->patchEntity($provider, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $provider->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $provider->username      = $this->Auth->user('name');
            $provider->status        = 'A';
            
            //PREENCHE O NOME FANTASIA, QUANDO DEIXADO EM BRANCO
            if (empty($provider->fantasia)) {
                $provider->fantasia = $provider->title;
            }//if (empty($provider->fantasia))
            
            /******************************************************************/
            
            if ($this->Providers->save($provider)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($provider, 'add', 'Providers');
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Providers->save($provider))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'ProvidersController->add';
            $this->Error->registerError($provider, $message, true);
            
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
        $cpfcnpj  = null;
        
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
            
            /******************************************************************/
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $this->request->data['username']      = $this->Auth->user('name');
            $this->request->data['status']        = 'A';
            
            /******************************************************************/
            
            //PREENCHE O NOME FANTASIA, QUANDO DEIXADO EM BRANCO
            if (empty($this->request->data['fantasia'])) {
                $this->request->data['fantasia'] = $this->request->data['title'];
            }
            
            /******************************************************************/
            
            $provider = $this->Providers->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/
            
            if ($this->Providers->save($provider)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($provider, 'add', 'Providers');

                $mensagem = 'Registro gravado com sucesso';
                $status   = 'ok';
                $id       = $provider->id;
                $title    = $provider->title;
                $cpfcnpj  = $provider->cpfcnpj;
                
            } else { 
                
                $mensagem = 'Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente';

                //Alerta de erro
                $message = 'ProvidersController->addjson';
                $this->Error->registerError($provider, $message, true);

            }//else if ($this->Providers->save($provider))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'title', 'cpfcnpj')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $provider = $this->Providers->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //COMPLETA CADASTRO
            if (empty($this->request->data['fantasia'])) {
                $this->request->data['fantasia'] = $this->request->data['title'];
            }
            
            /******************************************************************/
            
            $provider = $this->Providers->patchEntity($provider, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $provider->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->Providers->save($provider)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Providers->save($provider))
            
            /******************************************************************/
            
            //Alerta de erro
            $message = 'ProvidersController->edit';
            $this->Error->registerError($provider, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }
        
        $this->set(compact('provider'));
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
        $provider = $this->Providers->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->first();
        
        /**********************************************************************/

        if (!empty($provider)) {

            //CONSULTA REGISTRO PARA GRAVAÇÃO DE LOG E CONSULTA DE MOVIMENTOS
            if ($vinc_moviments = $this->consultaMovimentos($id, 'providers_id')) {
                
                if ($provider->status != 'I') { 
                    
                    $provider->title    = $provider->title.' (INATIVO)';
                    $provider->fantasia = $provider->fantasia.' (INATIVO)';
                    $provider->username = $this->Auth->user('name');
                    $provider->status   = 'I';
                    
                    if ($this->Providers->save($provider)) {
                        
                        //GRAVA LOG
                        $this->Log->gravaLog($provider, 'inativate', 'Providers'); 
                        
                        $this->Flash->warning(__('Registro inativado. Não pode ser excluído devido a movimentos vinculados'));
                        return $this->redirect($this->referer());
                        
                    } else {

                        //Alerta de erro
                        $message = 'ProvidersController->delete, inativate';
                        $this->Error->registerError($provider, $message, true);
                        
                        $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                        return $this->redirect($this->referer());
                        
                    }//else if ($this->Providers->save($provider))
                    
                } else {

                    //Alerta de erro
                    $message = 'ProvidersController->delete, inativated';
                    $this->Error->registerError($provider, $message, true);
                    
                    $this->Flash->warning(__('Registro inativo. Há movimentos vinculados em '.$vinc_moviments));
                    return $this->redirect($this->referer());
                    
                }//else if ($provider->status != 'I')
                
            }//if ($vinc_moviments = $this->consultaMovimentos($id, 'providers_id'))
            
            /**********************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($provider, 'delete', 'Providers');
            
            /**********************************************************************/
            
            if ($this->Providers->delete($provider)) {
                
                $this->Flash->success(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Providers->delete($provider))

        }//if (!empty($provider))

        /**********************************************************************/
        
        //Alerta de erro
        $message = 'ProvidersController->delete';
        $this->Error->registerError($provider, $message, true);
            
        /******************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request) 
    {
        $table = 'Providers';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['title_search'])) { 
            $where[] = '('.$table.'.title LIKE "%'.$this->params['title_search'].'%")';
        }
        
        if (!empty($this->params['cpfcnpj_search'])) { 
            $where[] = '('.$table.'.cpfcnpj LIKE "%'.$this->params['cpfcnpj_search'].'%")';
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
                
                $query[] = '(Providers.title LIKE "%'.$this->request->query['query'].'%"'.
                           'OR Providers.cpfcnpj LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $providers = $this->Providers->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->select(['Providers.id', 'Providers.title', 'Providers.cpfcnpj'])
                                         ->where(['Providers.status IN' => ['A', 'T']])
                                         ->where($query)
                                         ->order(['Providers.title']);
            
            $json = [];
            
            foreach ($providers as $data) {
                
                if (!empty($data->cpfcnpj)) {
                    
                    array_push($json, [
                        'id'    => $data->id,
                        'value' => $data->title.' ('.$data->cpfcnpj.')'
                    ]);
                    
                } else {
                    
                    array_push($json, [
                        'id'    => $data->id,
                        'value' => $data->title
                    ]);
                    
                }
                
            }//foreach ($providers as $data)
            
            echo json_encode($json);
            
        }
        
        $this->autoRender = false;
        die();
    }
}