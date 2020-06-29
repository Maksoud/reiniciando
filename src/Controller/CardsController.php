<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Cards */
/* File: src/Controller/CardsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class CardsController extends AppController
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
        
        $this->loadComponent('MovimentCardsFunctions');
    }
    
    public function index()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $cards = $this->Cards->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                             ->where($where)
                             ->order(['Cards.title']);
                             //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $cards = $this->paginate($cards);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $cards = $this->paginate($cards);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('cards'));
    }
    
    public function indexSimple()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $cards = $this->Cards->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                             ->where($where)
                             ->order(['Cards.title']);
                             //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $cards = $this->paginate($cards);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $cards = $this->paginate($cards);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('cards'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $card = $this->Cards->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        /**********************************************************************/
        
        $this->set(compact('card'));
    }

    public function viewSimple($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $card = $this->Cards->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        /**********************************************************************/
        
        $this->set(compact('card'));
    }

    public function add()
    {
        $card = $this->Cards->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Consulta TITLE para evitar duplicidade
            $duplicidade = $this->Cards->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['title'])
                                       ->where(['Cards.title' => $this->request->data['title']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }//if (!empty($duplicidade->toArray()))
            
            /******************************************************************/
            
            //Retira máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['limite'] = str_replace($source, $replace, $this->request->data['limite']);
            
            /******************************************************************/
            
            $card = $this->Cards->patchEntity($card, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $card->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $card->username      = $this->Auth->user('name');
            $card->status        = 'A';
            
            /******************************************************************/
            
            //CRIA FORNECEDOR PARA VÍNCULO FUTURO NO CONTAS A PAGAR
            $card->providers_id = $this->Register->addProvider($card->title, $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            //CRIA CENTRO DE CUSTOS PARA VÍNCULO FUTURO NO CONTAS A PAGAR
            $card->costs_id = $this->Register->addCost($card->title, $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            if ($this->Cards->save($card)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($card, 'add', 'Cards');
                
                //CRIA NOVO REGISTRO NA TABELA DE SALDOS
                $this->GeneralBalance->addBalance('cards_id', $card->id, $card->limite, $this->request->Session()->read('sessionParameterControl'));
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Cards->save($card))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'CardsController->add';
            $this->Error->registerError($card, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
    }

    public function addSimple()
    {
        $card = $this->Cards->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Consulta TITLE para evitar duplicidade
            $duplicidade = $this->Cards->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['title'])
                                       ->where(['Cards.title' => $this->request->data['title']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }//if (!empty($duplicidade->toArray()))
            
            /******************************************************************/
            
            //Retira máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['limite'] = str_replace($source, $replace, $this->request->data['limite']);
            
            /******************************************************************/
            
            $card = $this->Cards->patchEntity($card, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $card->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $card->username      = $this->Auth->user('name');
            $card->status        = 'A';
            
            /******************************************************************/
            
            //CRIA FORNECEDOR PARA VÍNCULO FUTURO NO CONTAS A PAGAR
            $card->providers_id = $this->Register->addProvider($card->title, $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            //CRIA CENTRO DE CUSTOS PARA VÍNCULO FUTURO NO CONTAS A PAGAR
            $card->costs_id = $this->Register->addCost($card->title, $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            if ($this->Cards->save($card)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($card, 'add', 'Cards');
                
                //CRIA NOVO REGISTRO NA TABELA DE SALDOS
                $this->GeneralBalance->addBalance('cards_id', $card->id, $card->limite, $this->request->Session()->read('sessionParameterControl'));
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Cards->save($card))

            /******************************************************************/

            //Alerta de erro
            $message = 'CardsController->addSimple';
            $this->Error->registerError($card, $message, true);
            
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
            
            //Retira máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['limite'] = str_replace($source, $replace, $this->request->data['limite']);
            
            /******************************************************************/
            
            $card = $this->Cards->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/
            
            //CRIA FORNECEDOR PARA VÍNCULO FUTURO NO CONTAS A PAGAR
            $card->providers_id = $this->Register->addProvider($card->title, $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            //CRIA CENTRO DE CUSTOS PARA VÍNCULO FUTURO NO CONTAS A PAGAR
            $card->costs_id = $this->Register->addCost($card->title, $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            if ($this->Cards->save($card)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($card, 'add', 'Cards');
                
                //CRIA NOVO REGISTRO NA TABELA DE SALDOS
                $this->GeneralBalance->addBalance('cards_id', $card->id, $card->limite, $this->request->Session()->read('sessionParameterControl'));
                
                $mensagem = __('Registro gravado com sucesso');
                $status   = 'ok';
                $id       = $card->id;
                $title    = $card->title;
                
            } else { 

                $mensagem = __('Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente');
    
                //Alerta de erro
                $message = 'CardsController->addjson';
                $this->Error->registerError($card, $message, true);

            }//else if ($this->Cards->save($card))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'title')));
        return $this->response;
    }
    
    public function editLimit($id)
    {   
        //CONSULTA REGISTRO
        $card = $this->Cards->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Retira máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['limite'] = str_replace($source, $replace, $this->request->data['limite']);
            
            /******************************************************************/
            
            //ATUALIZA LIMITE DO CARTÃO
            $this->MovimentCardsFunctions->cardAddLimit($id, $this->request->data['limite'], $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            $card = $this->Cards->patchEntity($card, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $card->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->Cards->save($card)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Cards->save($card))
        
            /**********************************************************************/

            //Alerta de erro
            $message = 'CardsController->editLimit';
            $this->Error->registerError($card, $message, true);
        
            /**********************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }
        
        $this->set(compact('card'));
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $card = $this->Cards->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $card = $this->Cards->patchEntity($card, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $card->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->Cards->save($card)) {
                
                //ATUALIZA O CADASTRO DE FORNECEDOR E CENTRO DE CUSTOS DO CARTÃO
                $this->Register->editProvider($card);
                $this->Register->editCost($card);
            
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Cards->save($card))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'CardsController->edit';
            $this->Error->registerError($card, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }
        
        $this->set(compact('card'));
    }

    public function editSimple($id)
    {
        //CONSULTA REGISTRO
        $card = $this->Cards->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $card = $this->Cards->patchEntity($card, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $card->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->Cards->save($card)) {
                
                //ATUALIZA O CADASTRO DE FORNECEDOR E CENTRO DE CUSTOS DO CARTÃO
                $this->Register->editProvider($card);
                $this->Register->editCost($card);
            
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Cards->save($card))
            /**********************************************************************/

            //Alerta de erro
            $message = 'CardsController->editSimple';
            $this->Error->registerError($card, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }
        
        $this->set(compact('card'));
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
        $card = $this->Cards->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        /**********************************************************************/
        
        if (!empty($card)) {

            //VERIFICA SE O CADASTRO ESTÁ EM USO NOS MOVIMENTOS
            if ($vinc_moviments = $this->consultaMovimentos($id, 'cards_id')) {
                
                if ($card->status != 'I') {
                    
                    $card->title    = $card->title.' (INATIVO)';
                    $card->username = $this->Auth->user('name');
                    $card->status   = 'I';
                    
                    if ($this->Cards->save($card)) {
                        
                        //ATUALIZA O CADASTRO DE FORNECEDOR E CENTRO DE CUSTOS DO CARTÃO
                        $this->Register->editProvider($card);
                        $this->Register->editCost($card);
                        
                        $this->Log->gravaLog($card, 'inativate', 'Cards'); //GRAVA LOG
                        
                        $this->Flash->warning(__('Registro inativado. Não pode ser excluído devido a movimentos vinculados'));
                        return $this->redirect($this->referer());
                        
                    } else {

                        //Alerta de erro
                        $message = 'CardsController->delete, inativate';
                        $this->Error->registerError($card, $message, true);
                        
                        $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                        return $this->redirect($this->referer());
                        
                    }//else if ($this->Cards->save($card))
                    
                } else {

                    //Alerta de erro
                    $message = 'CardsController->delete, inativated';
                    $this->Error->registerError(null, $message, true);
                    
                    $this->Flash->warning(__('Registro inativo. Há movimentos vinculados em '.$vinc_moviments));
                    return $this->redirect($this->referer());
                    
                }//else if ($card->status != 'I')
                
            }//if ($vinc_moviments = $this->consultaMovimentos($id, 'cards_id'))
        
            /******************************************************************/
            
            //Exclui cadastro de fornecedor
            $this->Register->deleteProvider($card->providers_id, $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            //Exclui cadastro de centro de custos
            $this->Register->deleteCost($card->costs_id, $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            //Exclui limite de cartão
            $this->GeneralBalance->deleteBalance('cards_id', $id, $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($card, 'delete', 'Cards');
            
            /******************************************************************/
            
            if ($this->Cards->delete($card)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Cards->delete($card))

        }//if (!empty($card))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'CardsController->delete';
        $this->Error->registerError($card, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'Cards';
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
                
                $query[] = '(Cards.title LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $cards = $this->Cards->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                 ->select(['Cards.id', 'Cards.title'])
                                 ->where(['Cards.status' => 'A'])
                                 ->where($query)
                                 ->order(['Cards.title']);
            
            $json = [];
            
            foreach ($cards as $data) {
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