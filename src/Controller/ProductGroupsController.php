<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* ProductGroups */
/* File: src/Controller/ProductGroupsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class ProductGroupsController extends AppController
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

        $this->Products = TableRegistry::get('Products');
    }
    
    public function index()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $productGroups = $this->ProductGroups->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                             ->where($where)
                                             ->order(['ProductGroups.title']);
                                             //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $productGroups = $this->paginate($productGroups);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $productGroups = $this->paginate($productGroups);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('productGroups'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $productGroup = $this->ProductGroups->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                            ->first();
        
        /**********************************************************************/
        
        $this->set(compact('productGroup'));
    }

    public function add()
    {
        $productGroup = $this->ProductGroups->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Consulta TITLE para evitar duplicidade
            $duplicidade = $this->ProductGroups->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                               ->select(['title'])
                                               ->where(['ProductGroups.title' => $this->request->data['title']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }//if (!empty($duplicidade->toArray()))
            
            /******************************************************************/
            
            $productGroup = $this->ProductGroups->patchEntity($productGroup, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $productGroup->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $productGroup->username      = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->ProductGroups->save($productGroup)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($productGroup, 'add', 'ProductGroups');
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->ProductGroups->save($productGroup))
            
            /******************************************************************/
            
            //Alerta de erro
            $message = 'ProductGroupsController->add';
            $this->Error->registerError($productGroup, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))

        $max_code = $this->ProductGroups->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                        ->select(['MAX' => 'MAX(ProductGroups.code)'])
                                        ->first();
        $code = $max_code->MAX + 1;
        $this->set('code', $code);
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
            
            /******************************************************************/
            
            $productGroup = $this->ProductGroups->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/
            
            if ($this->ProductGroups->save($productGroup)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($productGroup, 'add', 'ProductGroups');
                
                $mensagem = 'Registro gravado com sucesso';
                $status   = 'ok';
                $id       = $productGroup->id;
                $title    = $productGroup->title;
                
            } else { 

                //GRAVA LOG
                $mensagem = 'Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente';

                //Alerta de erro
                $message = 'ProductGroupsController->addjson';
                $this->Error->registerError($productGroup, $message, true);

            }//else if ($this->ProductGroups->save($productGroup))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'title')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $productGroup = $this->ProductGroups->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                            ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $productGroup = $this->ProductGroups->patchEntity($productGroup, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $productGroup->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->ProductGroups->save($productGroup)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->ProductGroups->save($productGroup))
            
            /******************************************************************/
            
            //Alerta de erro
            $message = 'ProductGroupsController->edit';
            $this->Error->registerError($productGroup, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $this->set(compact('productGroup'));
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
        $productGroup = $this->ProductGroups->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                            ->first();
        
        /**********************************************************************/

        if (!empty($productGroup)) {

            //Consulta produtos que utilizem o grupo
            $products = $this->Products->find('all')
                                       ->where(['Prodcuts.products_groups_id' => $productGroup->id]);

            if (!empty($products->toArray())) {

                $this->Flash->error(__('Registro NÃO excluído, há produtos vinculados ao grupo'));
                return $this->redirect($this->referer());
                
            }//if (!empty($products->toArray()))
        
            /******************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($productGroup, 'delete', 'ProductGroups');

            /******************************************************************/
            
            if ($this->ProductGroups->delete($productGroup)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->ProductGroups->delete($productGroup))

        }//if (!empty($productGroup))
        
        /**********************************************************************/
        
        //Alerta de erro
        $message = 'ProductGroupsController->delete';
        $this->Error->registerError($productGroup, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'ProductGroups';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['code_search'])) { 
            $where[] = '('.$table.'.code LIKE "%'.$this->params['code_search'].'%")';
        }
        
        if (!empty($this->params['title_search'])) { 
            $where[] = '('.$table.'.title LIKE "%'.$this->params['title_search'].'%")';
        }
        
        return $where;
    }
    
    public function json()
    {
        if ($this->request->is('get')) {
            
            if (isset($this->request->query['query'])) {
                
                $query[] = '(ProductGroups.title LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $productGroups = $this->ProductGroups->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['ProductGroups.id', 'ProductGroups.code', 'ProductGroups.title'])
                                                 ->where($query)
                                                 ->order(['ProductGroups.title']);
            
            $json = [];
            
            foreach ($productGroups as $data):
                array_push($json, [
                    'id'    => $data->id,
                    'code'  => $data->code,
                    'value' => $data->title
                ]);
            endforeach;
            
            echo json_encode($json);
            
        }//if ($this->request->is('get'))
        
        $this->autoRender = false;
        die();
    }
}