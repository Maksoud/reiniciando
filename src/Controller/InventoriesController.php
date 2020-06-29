<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Inventories */
/* File: src/Controller/InventoriesController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class InventoriesController extends AppController
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
        
        $this->loadComponent('InventoriesFunctions');
        $this->InventoryItems = TableRegistry::get('InventoryItems');
    }
    
    public function index()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $inventories = $this->Inventories->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->where($where)
                                         ->order(['Inventories.code']);
                                         //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $inventories = $this->paginate($inventories);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $inventories = $this->paginate($inventories);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('inventories'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $inventory = $this->Inventories->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                       ->first();

        /**********************************************************************/

        $inventoryItems = $this->InventoryItems->findByInventoriesIdAndParametersId($inventory->id, $this->request->Session()->read('sessionParameterControl'))
                                               ->contain(['Products']);

        /**********************************************************************/
        
        $this->set(compact('inventory', 'inventoryItems'));
    }

    public function add()
    {
        $this->Products = TableRegistry::get('Products');
        
        /**********************************************************************/

        $inventory = $this->Inventories->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $inventory = $this->Inventories->patchEntity($inventory, $this->request->getData());
            
            /******************************************************************/

            //LIMPA FORMULÁRIO DE INSERÇÃO DE PRODUTOS
            unset($this->request->data['products_id']);
            unset($this->request->data['unity']);
            unset($this->request->data['quantity']);

            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $this->request->data['username']      = $this->Auth->user('name');
            $this->request->data['status']        = 'A'; // A - active, C - cancelled

            //DEFINE O CÓDIGO SEQUENCIAL
            $max_code = $this->Inventories->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                          ->select(['MAX' => 'MAX(Inventories.code)'])
                                          ->first();
            $this->request->data['code'] = $max_code->MAX + 1;

            /******************************************************************/

            //Remove a lista de itens do objeto
            $productList = $this->request->data['ProductList'];
            unset($this->request->data['ProductList']);
            
            /******************************************************************/
            
            if ($this->Inventories->save($inventory)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($inventory, 'add', 'Inventories');

                //ITENS DO INVENTÁRIO
                $this->InventoriesFunctions->addItems($inventory->id, $productList, $inventory->parameters_id);

                //Registra o estoque
                $this->InventoriesFunctions->stock($inventory);

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Inventories->save($inventory))

            /******************************************************************/

            //Alerta de erro
            $message = 'InventoriesController->add';
            $this->Error->registerError($inventory, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        
        /**********************************************************************/

        $products = $this->Products->find('list')
                                   ->where(['Products.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                   ->order(['Products.title']);
        $products = $products->select(['id', 'title' => $products->func()->concat(['Products.code' => 'identifier', 
                                                                                   ' - (',
                                                                                   'Products.title' => 'identifier',
                                                                                   ')'
                                                                                  ])
                                              ]);
        $this->set('products', $products);
        
        /**********************************************************************/
        
        $max_code = $this->Inventories->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                      ->select(['MAX' => 'MAX(Inventories.code)'])
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
        $code     = null;
        
        if ($this->request->is('post')) {

            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {

                $mensagem = 'Sem permissão para realizar a operação solicitada';

                $this->response->type('json');  
                $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
                return $this->response;

            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/

            //LIMPA FORMULÁRIO DE INSERÇÃO DE PRODUTOS
            unset($this->request->data['products_id']);
            unset($this->request->data['unity']);
            unset($this->request->data['quantity']);

            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $this->request->data['username']      = $this->Auth->user('name');
            $this->request->data['status']        = 'A'; // A - active, C - cancelled

            //DEFINE O CÓDIGO SEQUENCIAL
            $max_code = $this->Inventories->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                          ->select(['MAX' => 'MAX(Inventories.code)'])
                                          ->first();
            $this->request->data['code'] = $max_code->MAX + 1;

            /******************************************************************/

            //Remove a lista de itens do objeto
            $productList = $this->request->data['ProductList'];
            unset($this->request->data['ProductList']);
            
            /******************************************************************/
            
            $inventory = $this->Inventories->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/

            if ($this->Inventories->save($inventory)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($inventory, 'add', 'Inventories');

                //ITENS DA VENDA
                $this->InventoriesFunctions->addItems($inventory->id, $productList, $inventory->parameters_id);

                //Registra o estoque
                $this->InventoriesFunctions->stock($inventory);

                $mensagem = 'Registro gravado com sucesso';
                $status   = 'ok';
                $id       = $inventory->id;
                $code     = $inventory->code;

            } else { 
                
                $mensagem = 'Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente';

                //Alerta de erro
                $message = 'InventoriesController->addjson';
                $this->Error->registerError($inventory, $message, true);

            }//else if ($this->Inventories->save($inventory))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $inventory = $this->Inventories->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                       ->first();
        
        /**********************************************************************/
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))

            /******************************************************************/

            //LIMPA FORMULÁRIO DE INSERÇÃO DE PRODUTOS
            unset($this->request->data['products_id']);
            unset($this->request->data['unity']);
            unset($this->request->data['quantity']);
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE ALTEROU O REGISTRO
            $this->request->data['username']      = $this->Auth->user('name');

            /******************************************************************/

            //Identifica se a lista foi preenchida
            if (empty($this->request->data['ProductList'])) {

                $mensagem = 'Não é possível gravar o registro sem produtos';

                $this->response->type('json');  
                $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
                return $this->response;

            }//if (empty($this->request->data['ProductList']))

            //Armazena os itens
            $productList = $this->request->data['ProductList'];

            //Remove a lista de itens do objeto
            unset($this->request->data['ProductList']);
            
            /******************************************************************/
            
            $inventory = $this->Inventories->patchEntity($inventory, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->Inventories->save($inventory)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($inventory, 'edit', 'Inventories');

                //ITENS DA VENDA
                $this->InventoriesFunctions->updateItems($inventory->id, $productList, $inventory->parameters_id);
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Inventories->save($inventory))

            /******************************************************************/

            //Alerta de erro
            $message = 'InventoriesController->edit';
            $this->Error->registerError($inventory, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        
        /**********************************************************************/

        $inventoryItems = $this->InventoryItems->findByInventoriesIdAndParametersId($inventory->id, $this->request->Session()->read('sessionParameterControl'))
                                               ->contain(['Products']);
        $this->set('inventoryItems', $inventoryItems);
        
        /**********************************************************************/
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($inventory->date)) {
            $inventory->date = date("d/m/Y", strtotime($inventory->date));
        }
        
        /**********************************************************************/
        
        $this->set(compact('inventory'));
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
        $inventory = $this->Inventories->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                       ->first();
        
        /**********************************************************************/

        if (!empty($inventory)) {

            //CANCELA A VENDA
            $inventory->username = $this->Auth->user('name');
            $inventory->status   = 'C'; // A - active, C - cancelled
            
            /******************************************************************/
            
            if ($this->Inventories->save($inventory)) {
                
                $this->Log->gravaLog($inventory, 'deleted', 'Inventories'); //GRAVA LOG
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Inventories->save($inventory))

        }//if (!empty($inventory))

        /**********************************************************************/

        //Alerta de erro
        $message = 'InventoriesController->delete';
        $this->Error->registerError($inventory, $message, true);
  
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }

    public function cancel($id)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            //Consulta o registro
            $inventory = $this->Inventories->get($id);
                
            /******************************************************************/

            //Identifica o status atual do registro
            if ($inventory->status != 'A') { // A - active, C - cancelled
                $this->Flash->error(__('Registro NÃO foi cancelado pois não está ativo'));
                return $this->redirect($this->referer());
            }//if ($inventory->status != 'A')
                
            /******************************************************************/

            //Define o status para cancelado
            $inventory->status = 'C'; // A - active, C - cancelled
                
            /******************************************************************/
            
            if ($this->Inventories->save($inventory)) {

                //Registra o estoque
                $this->InventoriesFunctions->stock($inventory, true);
                
                $this->Flash->warning(__('Registro cancelado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Inventories->save($inventory))

            /******************************************************************/

            //Alerta de erro
            $message = 'InventoriesController->cancel';
            $this->Error->registerError($inventory, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO cancelado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
    }
    
    public function filter($request)
    {
        $table = 'Inventories';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['code_search'])) { 
            $where[] = '('.$table.'.code LIKE "%'.$this->params['code_search'].'%")';
        }

        if (!empty($this->params['status_search'])) { 
            $where[] = '('.$table.'.status = "'.$this->params['status_search'].'")';
        } else {
            $where[] = '('.$table.'.status = "A")'; // A - active, C - cancelled
        }
        
        return $where;
    }
    
    public function json()
    {
        if ($this->request->is('get')) {
            
            if (isset($this->request->query['query'])) {
                
                $query[] = '(Inventories.code LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $inventories = $this->Inventories->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                             ->select(['Inventories.id', 'Inventories.code'])
                                             ->where($query)
                                             ->order(['Inventories.code']);
            
            $json = [];
            
            foreach ($inventories as $data) {
                array_push($json, [
                    'id'    => $data->id,
                    'value' => $data->code
                ]);
            }
            
            echo json_encode($json);
            
        }
        
        $this->autoRender = false;
        die();
    }
}