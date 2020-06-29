<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* ProductTypes */
/* File: src/Controller/ProductTypesController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class ProductTypesController extends AppController
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
        
        $productTypes = $this->ProductTypes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->where($where)
                                           ->order(['ProductTypes.title']);
                                           //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $productTypes = $this->paginate($productTypes);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $productTypes = $this->paginate($productTypes);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('productTypes'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $productType = $this->ProductTypes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                          ->first();
        
        /**********************************************************************/
        
        $this->set(compact('productType'));
    }

    public function add()
    {
        $productType = $this->ProductTypes->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Consulta TITLE para evitar duplicidade
            $duplicidade = $this->ProductTypes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                              ->select(['title'])
                                              ->where(['ProductTypes.title' => $this->request->data['title']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }//if (!empty($duplicidade->toArray()))
            
            /******************************************************************/
            
            $productType = $this->ProductTypes->patchEntity($productType, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $productType->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $productType->username      = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->ProductTypes->save($productType)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($productType, 'add', 'ProductTypes');
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->ProductTypes->save($productType))
            
            /******************************************************************/
            
            //Alerta de erro
            $message = 'ProductTypesController->add';
            $this->Error->registerError($productType, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))

        $max_code = $this->ProductTypes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                        ->select(['MAX' => 'MAX(ProductTypes.code)'])
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
            
            $productType = $this->ProductTypes->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/
            
            if ($this->ProductTypes->save($productType)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($productType, 'add', 'ProductTypes');
                
                $mensagem = 'Registro gravado com sucesso';
                $status   = 'ok';
                $id       = $productType->id;
                $title    = $productType->title;
                
            } else { 

                //GRAVA LOG
                $mensagem = 'Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente';

                //Alerta de erro
                $message = 'ProductTypesController->addjson';
                $this->Error->registerError($productType, $message, true);

            }//else if ($this->ProductTypes->save($productType))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'title')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $productType = $this->ProductTypes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                          ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $productType = $this->ProductTypes->patchEntity($productType, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $productType->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->ProductTypes->save($productType)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->ProductTypes->save($productType))
            
            /******************************************************************/
            
            //Alerta de erro
            $message = 'ProductTypesController->edit';
            $this->Error->registerError($productType, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $this->set(compact('productType'));
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
        $productType = $this->ProductTypes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                          ->first();
        
        /**********************************************************************/

        if (!empty($productType)) {

            //Consulta produtos que utilizem o grupo
            $products = $this->Products->find('all')
                                       ->where(['Prodcuts.products_types_id' => $productType->id]);

            if (!empty($products->toArray())) {

                $this->Flash->error(__('Registro NÃO excluído, há produtos vinculados ao tipo'));
                return $this->redirect($this->referer());
                
            }//if (!empty($products->toArray()))

            /******************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($productType, 'delete', 'ProductTypes');
        
            /******************************************************************/
            
            if ($this->ProductTypes->delete($productType)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->ProductTypes->delete($productType))

        }//if (!empty($productType))
        
        /**********************************************************************/
        
        //Alerta de erro
        $message = 'ProductTypesController->delete';
        $this->Error->registerError($productType, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'ProductTypes';
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
                
                $query[] = '(ProductTypes.title LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $productTypes = $this->ProductTypes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                               ->select(['ProductTypes.id', 'ProductTypes.code', 'ProductTypes.title'])
                                               ->where($query)
                                               ->order(['ProductTypes.title']);
            
            $json = [];
            
            foreach ($productTypes as $data):
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