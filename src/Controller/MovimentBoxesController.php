<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* MovimentBoxesControlle */
/* File: src/Controller/MovimentBoxesController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class MovimentBoxesController extends AppController
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

        $this->loadComponent('MovimentsFunctions');
    }
    
    public function index()
    {
        //VERIFICA SE HÁ CARTÕES CADASTRADOS
        if ($message = $this->SystemFunctions->validaCadastros("caixa", $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__($message), ['escape' => false]);
        }//if ($message = $this->SystemFunctions->validaCadastros("caixa", $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);
        
        $movimentBoxes = $this->MovimentBoxes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                             ->select(['MovimentBoxes.id', 'MovimentBoxes.ordem', 'MovimentBoxes.documento',
                                                       'MovimentBoxes.moviments_id', 'MovimentBoxes.transfers_id', 'MovimentBoxes.boxes_id',
                                                       'MovimentBoxes.data', 'MovimentBoxes.vencimento', 'MovimentBoxes.dtbaixa',
                                                       'MovimentBoxes.valor', 'MovimentBoxes.valorbaixa', 
                                                       'MovimentBoxes.creditodebito', 'MovimentBoxes.historico', 'MovimentBoxes.status', 
                                                       'Moviments.id', 'Moviments.ordem', 'Transfers.id', 'Transfers.ordem', 'Boxes.title',
                                                       'MovimentBoxes.parameters_id',
                                                       'Customers.title', 'Providers.title'
                                                      ])
                                             ->contain(['Moviments', 'Transfers', 'Boxes', 'Customers', 'Providers'])
                                             ->where($where)
                                             ->order(['MovimentBoxes.ordem DESC']);
                                     //->limit(200);
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $movimentBoxes = $this->paginate($movimentBoxes);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $movimentBoxes = $this->paginate($movimentBoxes);
            
        }
        
        $this->set(compact('movimentBoxes'));
    }
    
    public function indexSimple()
    {
        //VERIFICA SE HÁ CARTÕES CADASTRADOS
        if ($message = $this->SystemFunctions->validaCadastros("caixa", $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__($message), ['escape' => false]);
        }//if ($message = $this->SystemFunctions->validaCadastros("caixa", $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);
        
        $movimentBoxes = $this->MovimentBoxes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                             ->select(['MovimentBoxes.id', 'MovimentBoxes.ordem', 'MovimentBoxes.costs_id',
                                                       'MovimentBoxes.moviments_id', 'MovimentBoxes.transfers_id', 'MovimentBoxes.boxes_id',
                                                       'MovimentBoxes.data', 'MovimentBoxes.vencimento', 'MovimentBoxes.dtbaixa',
                                                       'MovimentBoxes.valor', 'MovimentBoxes.valorbaixa', 'MovimentBoxes.parameters_id',
                                                       'MovimentBoxes.creditodebito', 'MovimentBoxes.historico', 'MovimentBoxes.status', 
                                                       'Moviments.id', 'Moviments.ordem', 
                                                       'Transfers.id', 'Transfers.ordem', 
                                                       'Boxes.title',
                                                       'Costs.id', 'Costs.title'
                                                      ])
                                             ->contain(['Moviments', 'Transfers', 'Boxes', 'Costs'])
                                             ->where($where)
                                             ->order(['MovimentBoxes.ordem DESC']);
                                     //->limit(200);
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $movimentBoxes = $this->paginate($movimentBoxes);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $movimentBoxes = $this->paginate($movimentBoxes);
            
        }
        
        $this->set(compact('movimentBoxes'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $movimentBox = $this->MovimentBoxes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                           ->contain(['Boxes', 'EventTypes', 'DocumentTypes', 'Customers', 
                                                      'Providers', 'AccountPlans', 'Costs', 'Transfers', 
                                                      'Moviments', 'MovimentChecks'
                                                     ])
                                           ->first();
        
        /**********************************************************************/
        
        $this->set(compact('movimentBox'));
    }

    public function viewSimple($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $movimentBox = $this->MovimentBoxes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                           ->contain(['Boxes', 'Transfers', 'Moviments', 'Costs'])
                                           ->first();
        
        /**********************************************************************/
        
        $this->set(compact('movimentBox'));
    }

    public function add()
    {
        $movimentBox = $this->MovimentBoxes->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            $this->request->data['username'] = $this->Auth->user('name');
            $this->request->data['status']   = 'B';
            $this->request->data['coins_id'] = '1';
            
            /******************************************************************/
            
            //Preenche o vencimento, em caso de não preenchimento
            if (empty($this->request->data['vencimento'])) {
                $this->request->data['vencimento'] = $this->request->data['data'];
            }//if (empty($this->request->data['vencimento']))
            
            /******************************************************************/
            
            //Controle de preenchimento de Cliente/Fornecedor
            if ($this->request->data['creditodebito'] == 'C') {
                $this->request->data['providers_id'] = null;
            } elseif ($this->request->data['creditodebito'] == 'D') {
                $this->request->data['customers_id'] = null;
            }//elseif ($this->request->data['creditodebito'] == 'D')
            
            /******************************************************************/
            
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['valor']      = str_replace($source, $replace, $this->request->data['valor']);
            $this->request->data['dtbaixa']    = $this->request->data['data'];
            $this->request->data['valorbaixa'] = $this->request->data['valor'];
            
            /******************************************************************/
            
            //DEFINE O VALOR DA ORDEM
            $ordem = $this->MovimentBoxes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->select(['MAX' => 'MAX(MovimentBoxes.ordem)'])
                                         ->first();
            $ordem = $ordem->MAX;
            $this->request->data['ordem'] = $ordem + 1;
            
            /******************************************************************/
            
            $movimentBox = $this->MovimentBoxes->patchEntity($movimentBox, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->MovimentBoxes->save($movimentBox)) {
                
                if ($movimentBox->contabil == 'S') {
                    //REGISTRA OS SALDOS
                    $this->GeneralBalance->balance($movimentBox); 
                }//if ($movimentBox->contabil == 'S')
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->MovimentBoxes->save($movimentBox))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'MovimentBoxesController->add';
            $this->Error->registerError($movimentBox, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is('post'))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('costs', $this->MovimentBoxes->Costs->find('list')->where($conditions));
        $this->set('boxes', $this->MovimentBoxes->Boxes->find('list')->where($conditions)->order(['title']));
        $this->set('documentTypes', $this->MovimentBoxes->DocumentTypes->find('list')->where($conditions)->order(['title']));
        $this->set('eventTypes', $this->MovimentBoxes->EventTypes->find('list')->where($conditions));
        $accountPlans = $this->MovimentBoxes->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
                                                          ->where($conditions)
                                                          ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
    }

    public function addSimple()
    {
        $movimentBox = $this->MovimentBoxes->newEntity();
        
        if ($this->request->is('post')) {

            //VERSÃO SIMPLIFICADA
            $this->request->data['documento']         = null;
            $this->request->data['providers_id']      = null;
            $this->request->data['customers_id']      = null;
            $this->request->data['event_types_id']    = null;
            $this->request->data['document_types_id'] = null;
            $this->request->data['account_plans_id']  = null;
            $this->request->data['cheque']            = null;
            $this->request->data['emissaoch']         = null;
            $this->request->data['nominal']           = null;
            
            /******************************************************************/
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            $this->request->data['username'] = $this->Auth->user('name');
            $this->request->data['status']   = 'B';
            $this->request->data['coins_id'] = '1';
            
            /******************************************************************/
            
            //Preenche o vencimento, em caso de não preenchimento
            if (empty($this->request->data['vencimento'])) {
                $this->request->data['vencimento'] = $this->request->data['data'];
            }//if (empty($this->request->data['vencimento']))
            
            /******************************************************************/
            
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['valor']      = str_replace($source, $replace, $this->request->data['valor']);
            $this->request->data['dtbaixa']    = $this->request->data['data'];
            $this->request->data['valorbaixa'] = $this->request->data['valor'];
            
            /******************************************************************/
            
            //DEFINE O VALOR DA ORDEM
            $ordem = $this->MovimentBoxes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->select(['MAX' => 'MAX(MovimentBoxes.ordem)'])
                                         ->first();
            $ordem = $ordem->MAX;
            $this->request->data['ordem'] = $ordem + 1;
            
            /******************************************************************/
            
            $movimentBox = $this->MovimentBoxes->patchEntity($movimentBox, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->MovimentBoxes->save($movimentBox)) {
                
                if ($movimentBox->contabil == 'S') {
                    //REGISTRA OS SALDOS
                    $this->GeneralBalance->balance($movimentBox); 
                }//if ($movimentBox->contabil == 'S')
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->MovimentBoxes->save($movimentBox))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'MovimentBoxesController->addSimple';
            $this->Error->registerError($movimentBox, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is('post'))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('boxes', $this->MovimentBoxes->Boxes->find('list')->where($conditions)->order(['title']));
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $movimentBox = $this->MovimentBoxes->get($id, ['contain' => ['Customers', 'Providers', 'DocumentTypes', 'EventTypes', 'AccountPlans', 'Costs', 'Boxes']]);
        
        /**********************************************************************/
        
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //Registra usuário que está realizando alteração no registro
            $this->request->data['username'] = $this->Auth->user('name');
            
            /******************************************************************/
            
            //Controle de preenchimento de Cliente/Fornecedor
            if ($this->request->data['creditodebito'] == 'C') {
                $this->request->data['providers_id'] = null;
            } elseif ($this->request->data['creditodebito'] == 'D') {
                $this->request->data['customers_id'] = null;
            }//elseif ($this->request->data['creditodebito'] == 'D')
            
            /******************************************************************/
            
            //CAMPOS QUE NÃO PERMITEM ALTERAÇÃO
            $this->request->data['parameters_id'] = $movimentBox->parameters_id;
            $this->request->data['boxes_id']      = $movimentBox->boxes_id;
            $this->request->data['data']          = $movimentBox->data;
            //$this->request->data['valor']         = $movimentBox->valor;
            $this->request->data['contabil']      = $movimentBox->contabil;
            $this->request->data['creditodebito'] ? '' : $this->request->data['creditodebito'] = $movimentBox->creditodebito;
            $this->request->data['dtbaixa']       = $movimentBox->dtbaixa;
            //$this->request->data['valorbaixa']    = $movimentBox->valorbaixa;
            $this->request->data['status']        = $movimentBox->status;
            
            /******************************************************************/
            
            //SÓ PERMITE A ALTERAÇÃO DOS SALDOS QUANDO O REGISTRO NÃO POSSUIR VÍNCULOS
            if (empty($movimentBox->moviments_id) && empty($movimentBox->transfers_id) && empty($movimentBox->moviment_checks_id)) {

                $new_diff_value = null;

                /**************************************************************/

                //Retira máscara do valor
                $source  = ['.', ','];
                $replace = ['', '.'];
                $this->request->data['valor'] = (float) str_replace($source, $replace, $this->request->data['valor']);

                /**************************************************************/

                //VERIFICA SE O VALOR É DIFERENTE
                if ($movimentBox->valor != $this->request->data['valor']) {

                    //Calcula o valor da diferença 
                    $new_diff_value = $this->request->data['valor'] - $movimentBox->valor;

                    //Atualiza o campo valorbaixa
                    $this->request->data['valorbaixa'] = $this->request->data['valor'];

                } else { //MESMO VALOR

                    //Define o valor da diferença 
                    $new_diff_value = 0.00;

                }//else if ($movimentBox->valor != $this->request->data['valor'])

                //VERIFICA SE HOUVE ALTERAÇÕES NO TIPO DE PAGAMENTO (CRÉDITO/DÉBITO)
                if ($movimentBox->valor != $this->request->data['valor'] || $movimentBox->creditodebito != $this->request->data['creditodebito']) {
                
                    //ATUALIZA OS SALDOS
                    $this->GeneralBalance->setBalance($movimentBox, $new_diff_value, $this->request->data['creditodebito']);
                    
                }//if ($movimentBox->valor != $this->request->data['valor'] || $movimentBox->creditodebito != $this->request->data['creditodebito'])

            }//if (empty($movimentBox->moviments_id) && empty($movimentBox->transfers_id) && empty($movimentBox->moviment_checks_id))
            
            /******************************************************************/
            
            $movimentBox = $this->MovimentBoxes->patchEntity($movimentBox, $this->request->getData());
            
            //NÃO ATUALIZAR O SALDO DO CAIXA
            
            /******************************************************************/
            
            if ($this->MovimentBoxes->save($movimentBox)) {
                
                //Atualiza os lançamentos do CPR
                $this->MovimentsFunctions->atualizaMovimentos($movimentBox);

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->MovimentBoxes->save($movimentBox))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'MovimentBoxesController->edit';
            $this->Error->registerError($movimentBox, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('customers', $this->MovimentBoxes->Customers->find('list')->where($conditions)->order(['title']));
        $this->set('providers', $this->MovimentBoxes->Providers->find('list')->where($conditions)->order(['title']));
        $this->set('costs', $this->MovimentBoxes->Costs->find('list')->where($conditions)->order(['title']));
        $this->set('boxes', $this->MovimentBoxes->Boxes->find('list')->where($conditions)->order(['title']));
        $this->set('documentTypes', $this->MovimentBoxes->DocumentTypes->find('list')->where($conditions)->order(['title']));
        $this->set('eventTypes', $this->MovimentBoxes->EventTypes->find('list')->where($conditions)->order(['title']));
        $accountPlans = $this->MovimentBoxes->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
                                                      ->where($conditions)
                                                      ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($movimentBox->data)) {
            $movimentBox->data = date('d/m/Y', strtotime($movimentBox->data));
        }
        if (!empty($movimentBox->vencimento)) {
            $movimentBox->vencimento = date('d/m/Y', strtotime($movimentBox->vencimento));
        }
        if (!empty($movimentBox->dtbaixa)) {
            $movimentBox->dtbaixa = date('d/m/Y', strtotime($movimentBox->dtbaixa));
        }
        
        $this->set(compact('movimentBox'));
    }

    public function editSimple($id)
    {
        //CONSULTA REGISTRO
        $movimentBox = $this->MovimentBoxes->get($id, ['contain' => ['Boxes', 'Costs']]);
        
        /**********************************************************************/
        
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        if ($this->request->is(['patch', 'post', 'put'])) {

            //VERSÃO SIMPLIFICADA
            $this->request->data['documento']         = null;
            $this->request->data['providers_id']      = null;
            $this->request->data['customers_id']      = null;
            $this->request->data['event_types_id']    = null;
            $this->request->data['document_types_id'] = null;
            $this->request->data['account_plans_id']  = null;
            $this->request->data['cheque']            = null;
            $this->request->data['emissaoch']         = null;
            $this->request->data['nominal']           = null;
            
            /******************************************************************/
            
            //Registra usuário que está realizando alteração no registro
            $this->request->data['username'] = $this->Auth->user('name');
            
            /******************************************************************/
            
            //CAMPOS QUE NÃO PERMITEM ALTERAÇÃO
            $this->request->data['parameters_id'] = $movimentBox->parameters_id;
            $this->request->data['boxes_id']      = $movimentBox->boxes_id;
            $this->request->data['data']          = $movimentBox->data;
            //$this->request->data['valor']         = $movimentBox->valor;
            $this->request->data['contabil']      = $movimentBox->contabil;
            $this->request->data['creditodebito'] ? '' : $this->request->data['creditodebito'] = $movimentBox->creditodebito;
            $this->request->data['dtbaixa']       = $movimentBox->dtbaixa;
            //$this->request->data['valorbaixa']    = $movimentBox->valorbaixa;
            $this->request->data['status']        = $movimentBox->status;
            
            /******************************************************************/

            //SÓ PERMITE A ALTERAÇÃO DOS SALDOS QUANDO O REGISTRO NÃO POSSUIR VÍNCULOS
            if (empty($movimentBox->moviments_id) && empty($movimentBox->transfers_id) && empty($movimentBox->moviment_checks_id)) {

                $new_diff_value = null;

                /**************************************************************/

                //Retira máscara do valor
                $source  = ['.', ','];
                $replace = ['', '.'];
                $this->request->data['valor'] = (float) str_replace($source, $replace, $this->request->data['valor']);

                /**************************************************************/

                //VERIFICA SE O VALOR É DIFERENTE
                if ($movimentBox->valor != $this->request->data['valor']) {

                    //Calcula o valor da diferença 
                    $new_diff_value = $this->request->data['valor'] - $movimentBox->valor;

                    //Atualiza o campo valorbaixa
                    $this->request->data['valorbaixa'] = $this->request->data['valor'];

                } else { //MESMO VALOR

                    //Define o valor da diferença 
                    $new_diff_value = 0.00;

                }//else if ($movimentBox->valor != $this->request->data['valor'])

                //VERIFICA SE HOUVE ALTERAÇÕES NO TIPO DE PAGAMENTO (CRÉDITO/DÉBITO)
                if ($movimentBox->valor != $this->request->data['valor'] || $movimentBox->creditodebito != $this->request->data['creditodebito']) {
                
                    //ATUALIZA OS SALDOS
                    $this->GeneralBalance->setBalance($movimentBox, $new_diff_value, $this->request->data['creditodebito']);
                    
                }//if ($movimentBox->valor != $this->request->data['valor'] || $movimentBox->creditodebito != $this->request->data['creditodebito'])

            }//if (empty($movimentBox->moviments_id) && empty($movimentBox->transfers_id) && empty($movimentBox->moviment_checks_id))
            
            /******************************************************************/
            
            $movimentBox = $this->MovimentBoxes->patchEntity($movimentBox, $this->request->getData());
            
            //NÃO ATUALIZAR O SALDO DO CAIXA
            
            /******************************************************************/
            
            if ($this->MovimentBoxes->save($movimentBox)) {
                
                //Atualiza os lançamentos do CPR
                $this->MovimentsFunctions->atualizaMovimentos($movimentBox);

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->MovimentBoxes->save($movimentBox))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'MovimentBoxesController->editSimple';
            $this->Error->registerError($movimentBox, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('boxes', $this->MovimentBoxes->Boxes->find('list')->where($conditions)->order(['title']));
        $this->set('costs', $this->MovimentBoxes->Costs->find('list')->where($conditions)->order(['title']));
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($movimentBox->data)) {
            $movimentBox->data = date('d/m/Y', strtotime($movimentBox->data));
        }
        if (!empty($movimentBox->vencimento)) {
            $movimentBox->vencimento = date('d/m/Y', strtotime($movimentBox->vencimento));
        }
        if (!empty($movimentBox->dtbaixa)) {
            $movimentBox->dtbaixa = date('d/m/Y', strtotime($movimentBox->dtbaixa));
        }
        
        $this->set(compact('movimentBox'));
    }
    
    public function delete($id)
    {
        $this->Moviments = TableRegistry::get('Moviments');
        $this->Transfers = TableRegistry::get('Transfers');
        
        /**********************************************************************/
        
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('delete', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('delete', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $this->request->allowMethod(['post', 'delete']);
        
        /**********************************************************************/
        
        //Consulta registro para obter a ordem vinculada
        $movimentBox = $this->MovimentBoxes->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                           ->first();
        
        /**********************************************************************/

        if (!empty($movimentBox)) {

            // BUSCA MOVIMENTOS DE TRANSFERÊNCIAS PELO NÚMERO DE ORDEM
            $Transfer = $this->Transfers->findByIdAndParametersId($movimentBox->transfers_id, $this->request->Session()->read('sessionParameterControl'))
                                        ->first();

            if (!empty($Transfer)) {

                if ($Transfer->status != 'A' && 
                $Transfer->status != 'P' && 
                $Transfer->status != 'C') { $transferBaixados = true; }
                
                //SE HOUVEREM REGISTROS BAIXADOs NÃO DEIXA EXCLUIR, PORÉM RESOLVE O PROBLEMA DE VÍNCULO A TÍTULOS EM ABERTO (17/10/16)
                if ($transferBaixados) {
                    
                    $ordem = str_pad($Transfer->ordem, 6, '0', STR_PAD_LEFT);
                    $link = '<a href="Transfers/View/'.$Transfer->id.'" class="btn_modal" data-loading-text="Carregando...", data-title="Visualizar">'.$ordem.'</a>'; //, data-size = "sm"
                    
                    $this->Flash->error(__('Registro NÃO excluído. Há movimentos vinculados em ' . $link), ['escape' => false]);
                    return $this->redirect($this->referer());

                }//if ($transferBaixados)

            }//if (!empty($Transfer))
        
            /******************************************************************/
            
            // BUSCA LANÇAMENTOS FINANCEIROS PELO NÚMERO DE ORDEM
            $Moviment = $this->Moviments->findByIdAndParametersId($movimentBox->moviments_id, $this->request->Session()->read('sessionParameterControl'))
                                        ->first();

            if (!empty($Moviment)) {

                if ($Moviment->status != 'A' && 
                $Moviment->status != 'P' && 
                $Moviment->status != 'C') { $movimentBaixados = true; }
                
                //SE HOUVEREM REGISTROS BAIXADOs NÃO DEIXA EXCLUIR, PORÉM RESOLVE O PROBLEMA DE VÍNCULO A TÍTULOS EM ABERTO (17/10/16)
                if ($movimentBaixados) {
                    
                    $ordem = str_pad($Moviment->ordem, 6, '0', STR_PAD_LEFT);
                    $link = '<a href="Moviments/View/'.$Moviment->id.'" class="btn_modal" data-loading-text="Carregando...", data-title="Visualizar">'.$ordem.'</a>'; //, data-size = "sm"
                    
                    $this->Flash->error(__('Registro NÃO excluído. Há movimentos vinculados em ' . $link), ['escape' => false]);
                    return $this->redirect($this->referer());

                }//if ($movimentBaixados)

            }//if (!empty($Moviment))
        
            /******************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($movimentBox, 'delete', 'MovimentBoxes');
        
            /******************************************************************/
            
            if ($this->MovimentBoxes->delete($movimentBox)) {
                
                // ATUALIZAÇÃO DOS SALDOS
                $this->GeneralBalance->balance($movimentBox, true);
        
                /**************************************************************/
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->MovimentBoxes->delete($movimentBox))

        }//if (!empty($movimentBox))
        
        /**********************************************************************/
        
        //Alerta de erro
        $message = 'MovimentBoxesController->delete';
        $this->Error->registerError($movimentBox, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'MovimentBoxes';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['historico_search'])) { 
            $where[] = '('.$table.'.historico LIKE "%'.$this->params['historico_search'].
                       '%" OR '.$table.'.documento LIKE "%'.$this->params['historico_search'].'%")';
        }
        
        if (!empty($this->params['custprov_search'])) { 
            $where[] = '(Customers.title LIKE "%'.$this->params['custprov_search'].
                       '%" OR Customers.fantasia LIKE "%'.$this->params['custprov_search'].
                       '%" OR Providers.title LIKE "%'.$this->params['custprov_search'].
                       '%" OR Providers.fantasia LIKE "%'.$this->params['custprov_search'].'%")';
        }
        
        if (!empty($this->params['ordem_search'])) { 
            $where[] = '('.$table.'.ordem = "'.intval($this->params['ordem_search']).'")';
        }
        
        if (!empty($this->params['valor_search'])) { 
            $this->params['valor_search'] = str_replace(".", "", $this->params['valor_search']);
            $this->params['valor_search'] = str_replace(",", ".", $this->params['valor_search']);
            $where[] = '('.$table.'.valor = "'.$this->params['valor_search'].'"'.
                       ' OR '.$table.'.valorbaixa = "'.$this->params['valor_search'].'")';
        }
        
        if (!empty($this->params['boxes_search'])) { 
            $where[] = '('.'box.title LIKE "%'.$this->params['boxes_search'].'%")';
        }
        
        if (!empty($this->params['cheque_search'])) { 
            $where[] = '('.'MovimentCheck.cheque = "'.$this->params['cheque_search'].'")';
        }
        
        if (!empty($this->params['status_search'])) { 
            $where[] = '('.$table.'.status = "'.$this->params['status_search'].'")';
        }
        
        if (!empty($this->params['mes_search'])) { 
            $where[] = '('.'MONTH('.$table.'.data) = '.intval($this->params['mes_search']).
                       ' OR MONTH('.$table.'.vencimento) = '.intval($this->params['mes_search']).
                       ' OR MONTH('.$table.'.dtbaixa) = '.intval($this->params['mes_search']).')'; 
        }
        
        if (!empty($this->params['ano_search'])) { 
            $where[] = '('.'YEAR('.$table.'.data) = '.intval($this->params['ano_search']).
                       ' OR YEAR('.$table.'.vencimento) = '.intval($this->params['ano_search']).
                       ' OR YEAR('.$table.'.dtbaixa) = '.intval($this->params['ano_search']).')'; 
        }
        
        return $where;
    }
    
    public function reportForm() //Adicionar período
    {
        $this->Providers     = TableRegistry::get('Providers');
        $this->Customers     = TableRegistry::get('Customers');
        $this->AccountPlans  = TableRegistry::get('AccountPlans');
        $this->DocumentTypes = TableRegistry::get('DocumentTypes');
        $this->EventTypes    = TableRegistry::get('EventTypes');
        $this->Costs         = TableRegistry::get('Costs');
        $this->Balances      = TableRegistry::get('Balances');
        $this->Boxes         = TableRegistry::get('Boxes');
        $this->Parameters    = TableRegistry::get('Parameters');
                
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            if ($this->request->data['dtinicial']) { // datepicker
                $datepicker = explode("/", $this->request->data['dtinicial']);
                $dtinicial = implode('-', array_reverse($datepicker));
            }
            if ($this->request->data['dtfinal']) { // datepicker
                $datepicker = explode("/", $this->request->data['dtfinal']);
                $dtfinal = implode('-', array_reverse($datepicker));
            }
            
            /******************************************************************/
            
            // MONTAGEM DO SQL
            $conditions  = ['MovimentBoxes.parameters_id' => $this->request->Session()->read('sessionParameterControl')];

            if ($this->request->data['datapesq'] == 'lancamento') {
                $date_find = 'data';
            } elseif ($this->request->data['datapesq'] == 'vencimento') {
                $date_find = 'vencimento';
            } elseif ($this->request->data['datapesq'] == 'consolidacao') {
                $date_find = 'dtbaixa';
            }
            if ($this->request->data['historico']) {
                $conditions[] = 'MovimentBoxes.historico LIKE "%' . $this->request->data['historico'] . '%"';
            }
            if ($this->request->data['boxes_id']) {
                foreach($this->request->data['boxes_id'] as $value):
                    $list_boxes[] = $value;
                endforeach;
                $conditions[] = 'MovimentBoxes.boxes_id IN (' . implode(', ', $list_boxes) . ')';
            }
            if ($this->request->data['providers_id']) {
                $conditions[] = 'MovimentBoxes.providers_id LIKE ' . $this->request->data['providers_id'];
                
                $providers = $this->Providers->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                             ->select(['Providers.title'])
                                             ->where(['Providers.id' => $this->request->data['providers_id']])
                                             ->first();
                $this->set('provider', $providers);
            }
            if ($this->request->data['customers_id']) {
                $conditions[] = 'MovimentBoxes.customers_id LIKE ' . $this->request->data['customers_id'];
                
                $customers = $this->Customers->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                             ->select(['Customers.title'])
                                             ->where(['Customers.id' => $this->request->data['customers_id']])
                                             ->first();
                $this->set('customer', $customers);
            }
            if ($this->request->data['account_plans_id']) {
                $conditions[] = 'MovimentBoxes.account_plans_id LIKE ' . $this->request->data['account_plans_id'];
                
                $accountPlans = $this->AccountPlans->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                   ->select(['AccountPlans.title'])
                                                   ->where(['AccountPlans.id' => $this->request->data['account_plans_id']])
                                                   ->first();
                $this->set('accountPlan', $accountPlans);
            }
            if ($this->request->data['document_types_id']) {
                $conditions[] = 'MovimentBoxes.document_types_id LIKE ' . $this->request->data['document_types_id'];
                
                $documentTypes = $this->DocumentTypes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                     ->select(['DocumentTypes.title'])
                                                     ->where(['DocumentTypes.id' => $this->request->data['document_types_id']])
                                                     ->first();
                $this->set('documentType', $documentTypes);
            }
            if ($this->request->data['event_types_id']) {
                $conditions[] = 'MovimentBoxes.event_types_id LIKE ' . $this->request->data['event_types_id'];
                
                $eventTypes = $this->EventTypes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                               ->select(['EventTypes.title'])
                                               ->where(['EventTypes.id' => $this->request->data['event_types_id']])
                                               ->first();
                $this->set('eventType', $eventTypes);
            }
            if ($this->request->data['creditodebito'] != 'A') {
                $conditions[] = 'MovimentBoxes.creditodebito LIKE "' . $this->request->data['creditodebito'] . '"';
            }
            if ($this->request->data['costs_id']) {
                $conditions[] = 'MovimentBoxes.costs_id LIKE ' . $this->request->data['costs_id'];
                
                $costs = $this->Costs->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->select(['Costs.title'])
                                     ->where(['Costs.id' => $this->request->data['costs_id']])
                                     ->first();
                $this->set('cost', $costs);
            }
            if (!empty($this->request->data['contabil'])) {
                $conditions[] = 'MovimentBoxes.contabil = "' . $this->request->data['contabil'] . '"';
            }
            if ($this->request->data['Ordem']) {
                $order = ['MovimentBoxes.'.$this->request->data['Ordem'],
                          'MovimentBoxes.creditodebito'
                         ];
            } else {
                $order = ['MovimentBoxes.ordem', 'MovimentBoxes.creditodebito'];
            }
            
            /******************************************************************/
            
            //BUSCA SALDO INCIAL
            $bal_dtinicial = '2000-01-01';
            $bal_dtfinal   = date('Y-m-d', strtotime($dtinicial . '-1 day'));
            
            /******************************************************************/

            if (!empty($this->request->data['boxes_id'])) {

                //PREPARA LISTA DE CAIXAS PARA CONSULTA
                $list_boxes    = null;
                $request_boxes = $this->request->data['boxes_id'];

                /**************************************************************/
            
                if (!empty($request_boxes)) {
                    foreach($request_boxes as $box):
                        //$list_boxes .= $box . ', ';
                        $list_boxes[] = $box;
                    endforeach;
                }//if (!empty($request_boxes))

                /**************************************************************/

                $conditions_balance = ['Balances.boxes_id IS NOT NULL',
                                       'Balances.boxes_id IN' => $list_boxes
                                      ];

            } else {

                $conditions_balance = ['Balances.boxes_id IS NOT NULL'];

            }//else if (!empty($this->request->data['boxes_id']))
            
            /******************************************************************/
            
            $balances = $this->Balances->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['boxes_id' => 'DISTINCT(Balances.boxes_id)', 
                                                 'Balances.date', 'Balances.value'
                                                ])
                                       ->where($conditions_balance)
                                       ->andWhere(function ($exp, $q) use($bal_dtfinal) {
                                                    return $exp->between('Balances.date', '2000-01-01', $bal_dtfinal);
                                                  })
                                       ->order(['Balances.date ASC'])
                                       ->last();
            
            /******************************************************************/
            
            $fields = ['MovimentBoxes.id',
                       'MovimentBoxes.ordem',
                       'MovimentBoxes.boxes_id',
                       'MovimentBoxes.costs_id',
                       'MovimentBoxes.event_types_id',
                       'MovimentBoxes.moviment_checks_id',
                       'MovimentBoxes.transfers_id',
                       'MovimentBoxes.moviments_id',
                       'MovimentBoxes.account_plans_id',
                       'MovimentBoxes.creditodebito',
                       'MovimentBoxes.data',
                       'MovimentBoxes.vencimento',
                       'MovimentBoxes.dtbaixa',
                       'MovimentBoxes.valor',
                       'MovimentBoxes.valorbaixa',
                       'MovimentBoxes.documento',
                       'MovimentBoxes.historico',
                       'MovimentBoxes.contabil',
                       'MovimentBoxes.status',
                       'MovimentBoxes.username',
                       'Boxes.title',
                       'Costs.title',
                       'EventTypes.title',
                       'MovimentChecks.historico',
                       'Transfers.historico',
                       'Moviments.historico',
                       'AccountPlans.title'
                      ];
            
            $movimentBoxes = $this->MovimentBoxes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select($fields)
                                                 ->contain(['Boxes', 'Costs', 'EventTypes', 'MovimentChecks', 
                                                            'Transfers', 'Moviments', 'AccountPlans', 'Parameters'
                                                           ])
                                                 ->where($conditions)
                                                 ->andWhere(function ($exp, $q) use($dtinicial, $dtfinal, $date_find) {
                                                                return $exp->between('MovimentBoxes.'.$date_find, $dtinicial, $dtfinal);
                                                            })
                                                 ->order($order);
            
            /******************************************************************/
            
            $this->set('balances', $balances);
            $this->set('movimentBoxes', $movimentBoxes);
            
            /******************************************************************/
            
            if ($this->request->data['boxes_id']) {

                $boxes = $this->Boxes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->order(['Boxes.id, Boxes.title'])
                                     ->where(['Boxes.id IN' => $list_boxes]);
                
                foreach($boxes as $box):
                    $return[$box->id] = $box->title;
                endforeach;
                
                $this->set('boxes', $return);

            }//if ($this->request->data['boxes_id'])

            /******************************************************************/
            
            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());
            
            /******************************************************************/
            
            //Evitar página de erro
            $this->render('reports/sem_relatorio');
            
            /******************************************************************/
            
            if ($this->request->data['Tipo'] == 'movimento') {
                if ($this->request->data['Detalhamento'] == 'analitico') {
                    $this->render('reports/movimento_analitico');
                } elseif ($this->request->data['Detalhamento'] == 'sintetico') {
                    $this->render('reports/movimento_sintetico');
                }
            } elseif ($this->request->data['Tipo'] == 'fluxo') {
                if ($this->request->data['Detalhamento'] == 'analitico') {
                    $this->render('reports/fluxo_analitico');
                } elseif ($this->request->data['Detalhamento'] == 'sintetico') {
                    $this->render('reports/fluxo_sintetico');
                }
            }
        }
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('providers', $this->MovimentBoxes->Providers->find('list')->where($conditions)->order(['title']));
        $this->set('customers', $this->MovimentBoxes->Customers->find('list')->where($conditions)->order(['title']));
        $this->set('documentTypes', $this->MovimentBoxes->DocumentTypes->find('list')->where($conditions)->order(['title']));
        $this->set('costs', $this->MovimentBoxes->Costs->find('list')->where($conditions)->order(['title']));
        $this->set('boxes', $this->MovimentBoxes->Boxes->find('list')->where($conditions)->order(['title']));
        $this->set('eventTypes', $this->MovimentBoxes->EventTypes->find('list')->where($conditions)->order(['title']));
        $accountPlans = $this->MovimentBoxes->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
                                                      ->where($conditions)
                                                      ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
    }
}