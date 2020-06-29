<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Banks */
/* File: src/Controller/BanksController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class BanksController extends AppController
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
        
        $banks = $this->Banks->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                             ->where($where)
                             ->order(['Banks.title']);
                             //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $banks = $this->paginate($banks);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $banks = $this->paginate($banks);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('banks'));
    }
    
    public function indexSimple()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $banks = $this->Banks->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                             ->where($where)
                             ->order(['Banks.title']);
                             //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $banks = $this->paginate($banks);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $banks = $this->paginate($banks);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('banks'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $bank = $this->Banks->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        /**********************************************************************/
        
        $this->set(compact('bank'));
    }

    public function viewSimple($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $bank = $this->Banks->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        /**********************************************************************/
        
        $this->set(compact('bank'));
    }

    public function add()
    {
        $bank = $this->Banks->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Consulta TITLE para evitar duplicidade
            $duplicidade = $this->Banks->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['title'])
                                       ->where(['Banks.title' => $this->request->data['title']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }
            
            /******************************************************************/
            
            //DEFINE CAMPOS
            $banco = explode(" - ", $this->request->data['banco']);
            $this->request->data['numbanco'] = $banco[0];
            $this->request->data['banco']    = $banco[1];
            
            /******************************************************************/
            
            //CRIA ENTIDADE PARA CADASTRO
            $bank = $this->Banks->patchEntity($bank, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $bank->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $bank->username      = $this->Auth->user('name');
            $bank->status        = 'A';
            
            /******************************************************************/
            
            if ($this->Banks->save($bank)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($bank, 'add', 'Banks');
                
                //CRIA NOVO REGISTRO NA TABELA DE SALDOS
                $this->GeneralBalance->addBalance('banks_id', $bank->id, null, $this->request->Session()->read('sessionParameterControl')); 
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Banks->save($bank))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'BanksController->add';
            $this->Error->registerError($bank, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }
    }

    public function addSimple()
    {
        $bank = $this->Banks->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Consulta TITLE para evitar duplicidade
            $duplicidade = $this->Banks->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['title'])
                                       ->where(['Banks.title' => $this->request->data['title']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }
            
            /******************************************************************/
            
            //DEFINE CAMPOS
            $banco = explode(" - ", $this->request->data['banco']);
            $this->request->data['numbanco'] = $banco[0];
            $this->request->data['banco']    = $banco[1];
            
            /******************************************************************/
            
            //CRIA ENTIDADE PARA CADASTRO
            $bank = $this->Banks->patchEntity($bank, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $bank->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $bank->username      = $this->Auth->user('name');
            $bank->status        = 'A';
            
            /******************************************************************/
            
            if ($this->Banks->save($bank)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($bank, 'add', 'Banks');
                
                //CRIA NOVO REGISTRO NA TABELA DE SALDOS
                $this->GeneralBalance->addBalance('banks_id', $bank->id, null, $this->request->Session()->read('sessionParameterControl')); 
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Banks->save($bank))

            /******************************************************************/

            //Alerta de erro
            $message = 'BanksController->addSimple';
            $this->Error->registerError($bank, $message, true);
            
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
        $agencia  = null;
        $conta    = null;
        
        if ($this->request->is('post')) {

            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {

                $mensagem = 'Sem permissão para realizar a operação solicitada';

                $this->response->type('json');  
                $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
                return $this->response;

            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //DEFINE CAMPOS
            $banco = explode(" - ", $this->request->data['banco']);
            $this->request->data['numbanco'] = $banco[0];
            $this->request->data['banco']    = $banco[1];
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $this->request->data['username']      = $this->Auth->user('name');
            $this->request->data['status']        = 'A';
            
            /******************************************************************/
            
            $bank = $this->Banks->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/
            
            if ($this->Banks->save($bank)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($bank, 'add', 'Banks');
                
                //CRIA NOVO REGISTRO NA TABELA DE SALDOS
                $this->GeneralBalance->addBalance('banks_id', $bank->id, null, $this->request->Session()->read('sessionParameterControl')); 

                $mensagem = 'Registro gravado com sucesso';
                $status   = 'ok';
                $id       = $bank->id;
                $title    = $bank->title;
                $agencia  = $bank->agencia;
                $conta    = $bank->conta;
                
            } else { 

                $mensagem = __('Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente');

                /***************************************************************/
    
                //Alerta de erro
                $message = 'BanksController->addjson';
                $this->Error->registerError($bank, $message, true);

            }//else if ($this->Banks->save($bank))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'title', 'agencia', 'conta')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $bank = $this->Banks->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //DEFINE CAMPOS DE DADOS DO BANCO
            $banco = explode(" - ", $this->request->data['banco']);
            $this->request->data['numbanco'] = $banco[0];
            $this->request->data['banco']    = $banco[1];
            
            /******************************************************************/
            
            $bank = $this->Banks->patchEntity($bank, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $bank->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->Banks->save($bank)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Banks->save($bank))

            /******************************************************************/

            //Alerta de erro
            $message = 'BanksController->edit';
            $this->Error->registerError($bank, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        //DEFINE CAMPOS
        $bank->banco = $bank->numbanco . " - " . $bank->banco;
        
        $this->set(compact('bank'));
    }

    public function editSimple($id)
    {
        //CONSULTA REGISTRO
        $bank = $this->Banks->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //DEFINE CAMPOS DE DADOS DO BANCO
            $banco = explode(" - ", $this->request->data['banco']);
            $this->request->data['numbanco'] = $banco[0];
            $this->request->data['banco']    = $banco[1];
            
            /******************************************************************/
            
            $bank = $this->Banks->patchEntity($bank, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $bank->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->Banks->save($bank)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Banks->save($bank))

            /******************************************************************/

            //Alerta de erro
            $message = 'BanksController->editSimple';
            $this->Error->registerError($bank, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        //DEFINE CAMPOS
        $bank->banco = $bank->numbanco . " - " . $bank->banco;
        
        $this->set(compact('bank'));
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
        $bank = $this->Banks->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        /**********************************************************************/
        
        if (!empty($bank)) {

            //VERIFICA SE O CADASTRO ESTÁ EM USO NOS MOVIMENTOS
            if ($vinc_moviments = $this->consultaMovimentos($id, 'banks_id')) {
                
                if ($bank->status != 'I') {
                    
                    $bank->title    = $bank->title.' (INATIVO)';
                    $bank->username = $this->Auth->user('name');
                    $bank->status   = 'I';
                    
                    if ($this->Banks->save($bank)) {
                        
                        $this->Log->gravaLog($bank, 'inativate', 'Banks'); //GRAVA LOG
                        
                        $this->Flash->warning(__('Registro inativado. Não pode ser excluído devido a movimentos vinculados'));
                        return $this->redirect($this->referer());
                        
                    } else {

                        //Alerta de erro
                        $message = 'BanksController->delete, inativate';
                        $this->Error->registerError($bank, $message, true);

                        /**********************************************************/
                        
                        $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                        return $this->redirect($this->referer());
                        
                    }//else if ($this->Banks->save($bank))

                } else {

                    /**************************************************************/

                    //Alerta de erro
                    $message = 'BanksController->delete, inativated';
                    $this->Error->registerError(null, $message, true);

                    /**************************************************************/
                    
                    $this->Flash->warning(__('Registro inativo. Há movimentos vinculados em '.$vinc_moviments));
                    return $this->redirect($this->referer());
                    
                }
                
            }//if ($vinc_moviments = $this->consultaMovimentos($id, 'banks_id'))
            
            /**********************************************************************/
            
            //Exclui Saldos
            $this->GeneralBalance->deleteBalance('banks_id', $id, $this->request->Session()->read('sessionParameterControl'));
            
            /**********************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($bank, 'delete', 'Banks');
            
            /**********************************************************************/
            
            if ($this->Banks->delete($bank)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Banks->delete($bank))
            
        }//if (!empty($bank))

        /**********************************************************************/

        //Alerta de erro
        $message = 'BanksController->delete';
        $this->Error->registerError($bank, $message, true);

        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'Banks';
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
                
                $query[] = '(Banks.title LIKE "%'.$this->request->query['query'].'%"'.
                           'OR Banks.agencia LIKE "%'.$this->request->query['query'].'%"'.
                           'OR Banks.conta LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $banks = $this->Banks->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                 ->select(['Banks.id', 'Banks.title', 'Banks.agencia', 'Banks.conta'])
                                 ->where(['Banks.status' => 'A'])
                                 ->where($query)
                                 ->order(['Banks.title']);
            
            $json = [];
            
            foreach ($banks as $data) {
                array_push($json, [
                    'id'    => $data->id,
                    'value' => $data->title.' ('.$data->agencia.'/'.$data->conta.')'
                ]);
            }
            
            echo json_encode($json);
            
        }
        
        $this->autoRender = false;
        die();
    }
}