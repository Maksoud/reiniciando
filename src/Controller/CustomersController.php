<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Customers */
/* File: src/Controller/CustomersController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class CustomersController extends AppController
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

        $customers = $this->Customers->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->where($where)
                                     ->order(['Customers.title']);
                                     //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $customers = $this->paginate($customers);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $customers = $this->paginate($customers);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('customers'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))

        /**********************************************************************/

        $customer = $this->Customers->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->first();
        
        /**********************************************************************/
        
        $this->set(compact('customer'));
    }

    public function add()
    {
        $customer = $this->Customers->newEntity();

        if ($this->request->is('post')) {

            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))

            /******************************************************************/

            //Consulta CPF/CNPJ para evitar duplicidade
            $duplicidade = $this->Customers->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->select(['cpfcnpj'])
                                           ->where(['Customers.cpfcnpj' => $this->request->data['cpfcnpj']]);

            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com CPF/CNPJ já cadastrado'));
                return $this->redirect($this->referer());
            }//if (!empty($duplicidade->toArray()))

            /******************************************************************/

            $customer = $this->Customers->patchEntity($customer, $this->request->getData());

            /******************************************************************/

            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $customer->parameters_id = $this->request->Session()->read('sessionParameterControl');

            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $customer->username      = $this->Auth->user('name');
            $customer->status        = 'A';

            //PREENCHE O NOME FANTASIA, QUANDO DEIXADO EM BRANCO
            if (empty($customer->fantasia)) {
                $customer->fantasia = $customer->title;
            }//if (empty($customer->fantasia))

            /******************************************************************/

            if ($this->Customers->save($customer)) {

                //GRAVA LOG
                $this->Log->gravaLog($customer, 'add', 'Customers');

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Customers->save($customer))

            /******************************************************************/

            //Alerta de erro
            $message = 'CustomersController->add';
            $this->Error->registerError($customer, $message, true);

            /******************************************************************/

            $this->Flash->error(__('Registro NÃO gravado, tente novamente '));
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
            
            $customer = $this->Customers->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $customer->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            /******************************************************************/
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $customer->username      = $this->Auth->user('name');
            $customer->status        = 'A';
            
            /******************************************************************/
            
            //PREENCHE O NOME FANTASIA, QUANDO DEIXADO EM BRANCO
            if (empty($customer->fantasia)) {
                $customer->fantasia = $customer->title;
            }
            
            /******************************************************************/
            
            if ($this->Customers->save($customer)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($customer, 'add', 'Customers');
                
                $mensagem = __('Registro gravado com sucesso');
                $status   = 'ok';
                $id       = $customer->id;
                $title    = $customer->title;
                $cpfcnpj  = $customer->cpfcnpj;
                
            } else {
                
                $mensagem = __('Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente');
                
                //Alerta de erro
                $message = 'CustomersController->addjson';
                $this->Error->registerError($customer, $message, true);

            }//if ($this->Customers->save($customer))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'title', 'cpfcnpj')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $customer = $this->Customers->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
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
            }//if (empty($this->request->data['fantasia']))

            /******************************************************************/

            $customer = $this->Customers->patchEntity($customer, $this->request->getData());

            /******************************************************************/

            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $customer->username = $this->Auth->user('name');

            /******************************************************************/

            if ($this->Customers->save($customer)) {

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Customers->save($customer))

            /******************************************************************/

            //Alerta de erro
            $message = 'CustomersController->edit';
            $this->Error->registerError($customer, $message, true);

            /******************************************************************/

            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }

        $this->set(compact('customer'));
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
        $customer = $this->Customers->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->first();

        /**********************************************************************/

        if (!empty($customer)) {

            //CONSULTA REGISTRO PARA GRAVAÇÃO DE LOG E CONSULTA DE MOVIMENTOS
            if ($vinc_moviments = $this->consultaMovimentos($id, 'customers_id')) {

                if ($customer->status != 'I') {

                    $customer->title    = $customer->title.' (INATIVO)';
                    $customer->fantasia = $customer->fantasia.' (INATIVO)';
                    $customer->username = $this->Auth->user('name');
                    $customer->status   = 'I';

                    if ($this->Customers->save($customer)) {

                        //GRAVA LOG
                        $this->Log->gravaLog($customer, 'inativate', 'Customers');

                        $this->Flash->warning(__('Registro inativado. Não pode ser excluído devido a movimentos vinculados'));
                        return $this->redirect($this->referer());

                    } else {

                        //Alerta de erro
                        $message = 'CustomersController->delete, inativate';
                        $this->Error->registerError($customer, $message, true);

                        $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                        return $this->redirect($this->referer());

                    }//else if ($this->Customers->save($customer))

                } else {

                    //Alerta de erro
                    $message = 'CustomersController->delete, inativated';
                    $this->Error->registerError($customer, $message, true);

                    $this->Flash->warning(__('Registro inativo. Há movimentos vinculados em '.$vinc_moviments));
                    return $this->redirect($this->referer());

                }//else if ($customer->status != 'I')

            }//if ($vinc_moviments = $this->consultaMovimentos($id, 'customers_id'))

            /******************************************************************/

            //GRAVA LOG
            $this->Log->gravaLog($customer, 'delete', 'Customers');

            /******************************************************************/

            if ($this->Customers->delete($customer)) {

                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Customers->delete($customer))

        }//if (!empty($customer))

        /**********************************************************************/

        //Alerta de erro
        $message = 'CustomersController->delete';
        $this->Error->registerError($customer, $message, true);

        /**********************************************************************/

        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }

    public function filter($request)
    {
        $table = 'Customers';
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
                
                $query[] = '(Customers.title LIKE "%'.$this->request->query['query'].'%"'.
                           'OR Customers.cpfcnpj LIKE "%'.$this->request->query['query'].'%")';

            } else {

                $query = null;

            }//else if (isset($this->request->query['query']))

            $customers = $this->Customers->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->select(['Customers.id', 'Customers.title', 'Customers.cpfcnpj'])
                                         ->where(['Customers.status IN' => ['A', 'T']])
                                         ->where($query)
                                         ->order(['Customers.title']);

            $json = [];

            foreach ($customers as $data) {
				
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
					
            }//foreach ($customers as $data)

            echo json_encode($json);

        }

        $this->autoRender = false;
        die();
    }
}