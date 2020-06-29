<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* MovimentBanks */
/* File: src/Controller/MovimentBanksController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class MovimentBanksController extends AppController
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
        if ($message = $this->SystemFunctions->validaCadastros("banco", $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__($message), ['escape' => false]);
        }//if ($message = $this->SystemFunctions->validaCadastros("banco", $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);
        
        $movimentBanks = $this->MovimentBanks->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                             ->select(['MovimentBanks.id', 'MovimentBanks.ordem', 'MovimentBanks.documento', 'MovimentBanks.banks_id', 
                                                       'MovimentBanks.moviments_id', 'MovimentBanks.moviment_checks_id', 'MovimentBanks.transfers_id', 
                                                       'MovimentBanks.data', 'MovimentBanks.vencimento', 'MovimentBanks.dtbaixa',
                                                       'MovimentBanks.valor', 'MovimentBanks.valorbaixa', 
                                                       'MovimentBanks.historico', 'MovimentBanks.creditodebito', 'MovimentBanks.status',
                                                       'Moviments.id', 'Moviments.ordem', 
                                                       'MovimentChecks.id', 'MovimentChecks.ordem', 
                                                       'Transfers.id', 'Transfers.ordem', 
                                                       'Banks.title',
                                                       'Customers.title', 'Providers.title'
                                                      ])
                                             ->contain(['Moviments', 'MovimentChecks', 'Transfers', 'Banks', 'Customers', 'Providers'])
                                             ->where($where)
                                             ->order(['MovimentBanks.ordem DESC']);
                                             //->limit(200);
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $movimentBanks = $this->paginate($movimentBanks);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $movimentBanks = $this->paginate($movimentBanks);
            
        }
        
        $this->set(compact('movimentBanks'));
    }
    
    public function indexSimple()
    {
        //VERIFICA SE HÁ CARTÕES CADASTRADOS
        if ($message = $this->SystemFunctions->validaCadastros("banco", $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__($message), ['escape' => false]);
        }//if ($message = $this->SystemFunctions->validaCadastros("banco", $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);
        
        $movimentBanks = $this->MovimentBanks->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                             ->select(['MovimentBanks.id', 'MovimentBanks.ordem', 'MovimentBanks.banks_id', 'MovimentBanks.costs_id',
                                                       'MovimentBanks.moviments_id', 'MovimentBanks.moviment_checks_id', 'MovimentBanks.transfers_id', 
                                                       'MovimentBanks.data', 'MovimentBanks.vencimento', 'MovimentBanks.dtbaixa',
                                                       'MovimentBanks.valor', 'MovimentBanks.valorbaixa', 
                                                       'MovimentBanks.historico', 'MovimentBanks.creditodebito', 'MovimentBanks.status',
                                                       'Moviments.id', 'Moviments.ordem', 
                                                       'Transfers.id', 'Transfers.ordem', 
                                                       'Banks.title',
                                                       'Costs.id', 'Costs.title'
                                                      ])
                                             ->contain(['Moviments', 'Transfers', 'Banks', 'Costs'])
                                             ->where($where)
                                             ->order(['MovimentBanks.ordem DESC']);
                                             //->limit(200);
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $movimentBanks = $this->paginate($movimentBanks);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $movimentBanks = $this->paginate($movimentBanks);
            
        }
        
        $this->set(compact('movimentBanks'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $movimentBank = $this->MovimentBanks->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                            ->contain(['Banks', 'EventTypes', 'DocumentTypes', 'Customers', 
                                                       'Providers', 'AccountPlans', 'Costs', 'Transfers', 
                                                       'Moviments', 'MovimentChecks'
                                                      ])
                                            ->first();
        
        /**********************************************************************/
        
        $this->set(compact('movimentBank'));
    }

    public function viewSimple($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $movimentBank = $this->MovimentBanks->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                            ->contain(['Banks', 'Transfers', 'Moviments', 'Costs'])
                                            ->first();
        
        /**********************************************************************/
        
        $this->set(compact('movimentBank'));
    }

    public function add()
    {
        $movimentBank = $this->MovimentBanks->newEntity();
        
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
            $ordem = $this->MovimentBanks->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->select(['MAX' => 'MAX(MovimentBanks.ordem)'])
                                         ->first();
            $ordem = $ordem->MAX;
            $this->request->data['ordem'] = $ordem + 1;
            
            /******************************************************************/
            
            $movimentBank = $this->MovimentBanks->patchEntity($movimentBank, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->MovimentBanks->save($movimentBank)) {
                
                if ($movimentBank->contabil == 'S') {
                    //REGISTRA OS SALDOS
                    $this->GeneralBalance->balance($movimentBank); 
                }//if ($movimentBank->contabil == 'S')
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->MovimentBanks->save($movimentBank))

            /******************************************************************/

            //Alerta de erro
            $message = 'MovimentBanksController->add';
            $this->Error->registerError($movimentBank, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is('post'))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('costs', $this->MovimentBanks->Costs->find('list')->where($conditions));
        $banks = $this->MovimentBanks->Banks->find('list')->where(['Banks.parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'Banks.tipoconta !=' => 'A'])->order(['Banks.title']);
        $banks = $banks->select(['id', 'title' => $banks->func()->concat(['Banks.title' => 'identifier', 
                                                                          ' - (',
                                                                          'Banks.agencia' => 'identifier', 
                                                                          ' / ',
                                                                          'Banks.conta' => 'identifier', 
                                                                          ') '
                                                                         ])
                                ]);
        $this->set('banks', $banks);
        $this->set('documentTypes', $this->MovimentBanks->DocumentTypes->find('list')->where($conditions)->order(['title']));
        $this->set('eventTypes', $this->MovimentBanks->EventTypes->find('list')->where($conditions));
        $this->set('providers', $this->MovimentBanks->Providers->find('list')->where($conditions));
        $accountPlans = $this->MovimentBanks->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
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
        $movimentBank = $this->MovimentBanks->newEntity();
        
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
            $ordem = $this->MovimentBanks->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->select(['MAX' => 'MAX(MovimentBanks.ordem)'])
                                         ->first();
            $ordem = $ordem->MAX;
            $this->request->data['ordem'] = $ordem + 1;
            
            /******************************************************************/
            
            $movimentBank = $this->MovimentBanks->patchEntity($movimentBank, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->MovimentBanks->save($movimentBank)) {
                
                if ($movimentBank->contabil == 'S') {
                    //REGISTRA OS SALDOS
                    $this->GeneralBalance->balance($movimentBank); 
                }//if ($movimentBank->contabil == 'S')
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->MovimentBanks->save($movimentBank))

            /******************************************************************/

            //Alerta de erro
            $message = 'MovimentBanksController->addSimple';
            $this->Error->registerError($movimentBank, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is('post'))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('costs', $this->MovimentBanks->Costs->find('list')->where($conditions));
        $banks = $this->MovimentBanks->Banks->find('list')->where(['Banks.parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'Banks.tipoconta !=' => 'A'])->order(['Banks.title']);
        $banks = $banks->select(['id', 'title' => $banks->func()->concat(['Banks.title' => 'identifier', 
                                                                          ' - (',
                                                                          'Banks.agencia' => 'identifier', 
                                                                          ' / ',
                                                                          'Banks.conta' => 'identifier', 
                                                                          ') '
                                                                         ])
                                ]);
        $this->set('banks', $banks);
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $movimentBank = $this->MovimentBanks->get($id, ['contain' => ['Customers', 'Providers', 'DocumentTypes', 'EventTypes', 'AccountPlans', 'Costs', 'Banks']]);
        
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
            $this->request->data['parameters_id'] = $movimentBank->parameters_id;
            $this->request->data['banks_id']      = $movimentBank->banks_id;
            $this->request->data['data']          = $movimentBank->data;
            //$this->request->data['valor']         = $movimentBank->valor;
            $this->request->data['contabil']      = $movimentBank->contabil;
            $this->request->data['creditodebito'] ? '' : $this->request->data['creditodebito'] = $movimentBank->creditodebito;
            $this->request->data['dtbaixa']       = $movimentBank->dtbaixa;
            //$this->request->data['valorbaixa']    = $movimentBank->valorbaixa;
            $this->request->data['status']        = $movimentBank->status;
            
            /******************************************************************/

            //SÓ PERMITE A ALTERAÇÃO DOS SALDOS QUANDO O REGISTRO NÃO POSSUIR VÍNCULOS
            if (empty($movimentBank->moviments_id) && empty($movimentBank->transfers_id) && empty($movimentBank->moviment_checks_id)) {

                $new_diff_value = null;

                /**************************************************************/

                //Retira máscara do valor
                $source  = ['.', ','];
                $replace = ['', '.'];
                $this->request->data['valor'] = (float) str_replace($source, $replace, $this->request->data['valor']);

                /**************************************************************/

                //VERIFICA SE O VALOR É DIFERENTE
                if ($movimentBank->valor != $this->request->data['valor']) {

                    //Calcula o valor da diferença 
                    $new_diff_value = $this->request->data['valor'] - $movimentBank->valor;

                    //Atualiza o campo valorbaixa
                    $this->request->data['valorbaixa'] = $this->request->data['valor'];

                } else { //MESMO VALOR

                    //Define o valor da diferença 
                    $new_diff_value = 0.00;

                }//else if ($movimentBank->valor != $this->request->data['valor'])

                //VERIFICA SE HOUVE ALTERAÇÕES NO TIPO DE PAGAMENTO (CRÉDITO/DÉBITO)
                if ($movimentBank->valor != $this->request->data['valor'] || $movimentBank->creditodebito != $this->request->data['creditodebito']) {
                
                    //ATUALIZA OS SALDOS
                    $this->GeneralBalance->setBalance($movimentBank, $new_diff_value, $this->request->data['creditodebito']);
                    
                }//if ($movimentBank->valor != $this->request->data['valor'] || $movimentBank->creditodebito != $this->request->data['creditodebito'])

            }//if (empty($movimentBank->moviments_id) && empty($movimentBank->transfers_id) && empty($movimentBank->moviment_checks_id))

            /******************************************************************/

            $movimentBank = $this->MovimentBanks->patchEntity($movimentBank, $this->request->getData());
            
            /******************************************************************/
            
            //NÃO ATUALIZAR O SALDO DO BANCO
            
            if ($this->MovimentBanks->save($movimentBank)) {
                
                //Atualiza os lançamentos do CPR
                $this->MovimentsFunctions->atualizaMovimentos($movimentBank);

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->MovimentBanks->save($movimentBank))

            /******************************************************************/

            //Alerta de erro
            $message = 'MovimentBanksController->edit';
            $this->Error->registerError($movimentBank, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('customers', $this->MovimentBanks->Customers->find('list')->where($conditions)->order(['title']));
        $this->set('providers', $this->MovimentBanks->Providers->find('list')->where($conditions)->order(['title']));
        $this->set('costs', $this->MovimentBanks->Costs->find('list')->where($conditions)->order(['title'])); 
        $this->set('banks', $this->MovimentBanks->Banks->find('list')->where($conditions)->order(['title'])); 
        $this->set('documentTypes', $this->MovimentBanks->DocumentTypes->find('list')->where($conditions)->order(['title'])); 
        $this->set('eventTypes', $this->MovimentBanks->EventTypes->find('list')->where($conditions)->order(['title'])); 
        $this->set('providers', $this->MovimentBanks->Providers->find('list')->where($conditions)->order(['title'])); 
        $accountPlans = $this->MovimentBanks->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
                                                      ->where($conditions)
                                                      ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($movimentBank->data)) {
            $movimentBank->data = date('d/m/Y', strtotime($movimentBank->data));
        }
        if (!empty($movimentBank->vencimento)) {
            $movimentBank->vencimento = date('d/m/Y', strtotime($movimentBank->vencimento));
        }
        if (!empty($movimentBank->dtbaixa)) {
            $movimentBank->dtbaixa = date('d/m/Y', strtotime($movimentBank->dtbaixa));
        }
        
        $this->set(compact('movimentBank'));
    }

    public function editSimple($id)
    {
        //CONSULTA REGISTRO
        $movimentBank = $this->MovimentBanks->get($id, ['contain' => ['Banks', 'Costs']]);
        
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
            $this->request->data['parameters_id'] = $movimentBank->parameters_id;
            $this->request->data['banks_id']      = $movimentBank->banks_id;
            $this->request->data['data']          = $movimentBank->data;
            //$this->request->data['valor']         = $movimentBank->valor;
            $this->request->data['contabil']      = $movimentBank->contabil;
            $this->request->data['creditodebito'] ? '' : $this->request->data['creditodebito'] = $movimentBank->creditodebito;
            $this->request->data['dtbaixa']       = $movimentBank->dtbaixa;
            //$this->request->data['valorbaixa']    = $movimentBank->valorbaixa;
            $this->request->data['status']        = $movimentBank->status;
            
            /******************************************************************/

            //SÓ PERMITE A ALTERAÇÃO DOS SALDOS QUANDO O REGISTRO NÃO POSSUIR VÍNCULOS
            if (empty($movimentBank->moviments_id) && empty($movimentBank->transfers_id) && empty($movimentBank->moviment_checks_id)) {

                $new_diff_value = null;

                /**************************************************************/

                //Retira máscara do valor
                $source  = ['.', ','];
                $replace = ['', '.'];
                $this->request->data['valor'] = (float) str_replace($source, $replace, $this->request->data['valor']);

                /**************************************************************/

                //VERIFICA SE O VALOR É DIFERENTE
                if ($movimentBank->valor != $this->request->data['valor']) {

                    //Calcula o valor da diferença 
                    $new_diff_value = $this->request->data['valor'] - $movimentBank->valor;

                    //Atualiza o campo valorbaixa
                    $this->request->data['valorbaixa'] = $this->request->data['valor'];

                } else { //MESMO VALOR

                    //Define o valor da diferença 
                    $new_diff_value = 0.00;

                }//else if ($movimentBank->valor != $this->request->data['valor'])

                /**************************************************************/

                //VERIFICA SE HOUVE ALTERAÇÕES NO TIPO DE PAGAMENTO (CRÉDITO/DÉBITO)
                if ($movimentBank->valor != $this->request->data['valor'] || $movimentBank->creditodebito != $this->request->data['creditodebito']) {
                
                    //ATUALIZA OS SALDOS
                    $this->GeneralBalance->setBalance($movimentBank, $new_diff_value, $this->request->data['creditodebito']);
                    
                }//if ($movimentBank->valor != $this->request->data['valor'] || $movimentBank->creditodebito != $this->request->data['creditodebito'])

            }//if (empty($movimentBank->moviments_id) && empty($movimentBank->transfers_id) && empty($movimentBank->moviment_checks_id))

            /******************************************************************/

            $movimentBank = $this->MovimentBanks->patchEntity($movimentBank, $this->request->getData());

            /******************************************************************/
            
            //NÃO ATUALIZAR O SALDO DO BANCO
            
            if ($this->MovimentBanks->save($movimentBank)) {
                
                //Atualiza os lançamentos do CPR
                $this->MovimentsFunctions->atualizaMovimentos($movimentBank);

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->MovimentBanks->save($movimentBank))

            /******************************************************************/

            //Alerta de erro
            $message = 'MovimentBanksController->editSimple';
            $this->Error->registerError($movimentBank, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('costs', $this->MovimentBanks->Costs->find('list')->where($conditions)->order(['title']));
        $this->set('banks', $this->MovimentBanks->Banks->find('list')->where($conditions)->order(['title']));
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($movimentBank->data)) {
            $movimentBank->data = date('d/m/Y', strtotime($movimentBank->data));
        }
        if (!empty($movimentBank->vencimento)) {
            $movimentBank->vencimento = date('d/m/Y', strtotime($movimentBank->vencimento));
        }
        if (!empty($movimentBank->dtbaixa)) {
            $movimentBank->dtbaixa = date('d/m/Y', strtotime($movimentBank->dtbaixa));
        }
        
        $this->set(compact('movimentBank'));
    }

    public function delete($id)
    {
        $this->MovimentChecks = TableRegistry::get('MovimentChecks');
        $this->Transfers      = TableRegistry::get('Transfers');
        $this->Moviments      = TableRegistry::get('Moviments');
        
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
        $movimentBank = $this->MovimentBanks->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                            ->first();
        
        /**********************************************************************/

        if (!empty($movimentBank)) {

            // BUSCA MOVIMENTOS DE CHEQUES PELO NÚMERO DE ORDEM
            $MovimentCheck = $this->MovimentChecks->findByIdAndParametersId($movimentBank->moviment_checks_id, $this->request->Session()->read('sessionParameterControl'))
                                                ->first();

            if (!empty($MovimentCheck)) {

                if ($MovimentCheck->status != 'A' && 
                $MovimentCheck->status != 'P' && 
                $MovimentCheck->status != 'C') { $checkBaixados = true; }
                
                //SE HOUVEREM REGISTROS BAIXADOs NÃO DEIXA EXCLUIR, PORÉM RESOLVE O PROBLEMA DE VÍNCULO A TÍTULOS EM ABERTO (17/10/16)
                if ($checkBaixados) {

                    $ordem = str_pad($MovimentCheck->ordem, 6, '0', STR_PAD_LEFT);
                    $link = '<a href="MovimentChecks/View/' . $MovimentCheck->id . '" class="btn_modal" data-loading-text="Carregando...", data-title="Visualizar">' . $ordem.'</a>'; //, data-size = "sm"

                    $this->Flash->error(__('Registro NÃO excluído. Há movimentos vinculados em ' . $link), ['escape' => false]);
                    return $this->redirect($this->referer());

                }//if ($checkBaixados)

            }//if (!empty($MovimentCheck))
            
            /******************************************************************/
            
            // BUSCA MOVIMENTOS DE TRANSFERÊNCIAS PELO NÚMERO DE ORDEM
            $Transfer = $this->Transfers->findByIdAndParametersId($movimentBank->transfers_id, $this->request->Session()->read('sessionParameterControl'))
                                        ->first();

            if (!empty($Transfer)) {

                if ($Transfer->status != 'A' && 
                $Transfer->status != 'P' && 
                $Transfer->status != 'C') { $transferBaixados = true; }
                
                //SE HOUVEREM REGISTROS BAIXADOs NÃO DEIXA EXCLUIR, PORÉM RESOLVE O PROBLEMA DE VÍNCULO A TÍTULOS EM ABERTO (17/10/16)
                if ($transferBaixados) {

                    $ordem = str_pad($Transfer->ordem, 6, '0', STR_PAD_LEFT);
                    $link = '<a href="Transfers/View/' . $Transfer->id . '" class="btn_modal" data-loading-text="Carregando...", data-title="Visualizar">' . $ordem.'</a>'; //, data-size = "sm"

                    $this->Flash->error(__('Registro NÃO excluído. Há movimentos vinculados em ' . $link), ['escape' => false]);
                    return $this->redirect($this->referer());

                }//if ($transferBaixados)

            }//if (!empty($Transfer))
            
            /******************************************************************/
            
            // BUSCA LANÇAMENTOS FINANCEIROS PELO NÚMERO DE ORDEM
            $Moviment = $this->Moviments->findByIdAndParametersId($movimentBank->moviments_id, $this->request->Session()->read('sessionParameterControl'))
                                        ->first();

            if (!empty($Moviment)) {

                if ($Moviment->status != 'A' && 
                $Moviment->status != 'P' && 
                $Moviment->status != 'C') { $movimentBaixados = true; }
                
                //SE HOUVEREM REGISTROS BAIXADOs NÃO DEIXA EXCLUIR, PORÉM RESOLVE O PROBLEMA DE VÍNCULO A TÍTULOS EM ABERTO (17/10/16)
                if ($movimentBaixados) {

                    $ordem = str_pad($Moviment->ordem, 6, '0', STR_PAD_LEFT);
                    $link = '<a href="Moviments/View/' . $Moviment->id.'" class="btn_modal" data-loading-text="Carregando...", data-title="Visualizar">' . $ordem.'</a>'; //, data-size = "sm"

                    $this->Flash->error(__('Registro NÃO excluído. Há movimentos vinculados em ' . $link), ['escape' => false]);
                    return $this->redirect($this->referer());

                }//if ($movimentBaixados)

            }//if (!empty($Moviment))
            
            /******************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($movimentBank, 'delete', 'MovimentBanks');
            
            /******************************************************************/

            if ($this->MovimentBanks->delete($movimentBank)) {
                
                // ATUALIZAÇÃO DOS SALDOS
                $this->GeneralBalance->balance($movimentBank, true);
            
                /**************************************************************/
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->MovimentBanks->delete($movimentBank))

        }//if (!empty($movimentBank))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'MovimentBanksController->delete';
        $this->Error->registerError($movimentBank, $message, true);
        
        /**********************************************************************/

        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'MovimentBanks';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['historico_search'])) { 
            $where[] = '(' . $table.'.historico LIKE "%' . $this->params['historico_search'].
                       '%" OR ' . $table.'.documento LIKE "%' . $this->params['historico_search'] . '%")';
        }
        
        if (!empty($this->params['custprov_search'])) { 
            $where[] = '(Customers.title LIKE "%' . $this->params['custprov_search'].
                       '%" OR Customers.fantasia LIKE "%' . $this->params['custprov_search'].
                       '%" OR Providers.title LIKE "%' . $this->params['custprov_search'].
                       '%" OR Providers.fantasia LIKE "%' . $this->params['custprov_search'] . '%")';
        }
        
        if (!empty($this->params['ordem_search'])) { 
            $where[] = '(' . $table.'.ordem = "'.intval($this->params['ordem_search']).'")';
        }
        
        if (!empty($this->params['valor_search'])) { 
            $this->params['valor_search'] = str_replace(".", "", $this->params['valor_search']);
            $this->params['valor_search'] = str_replace(",", ".", $this->params['valor_search']);
            $where[] = '(' . $table.'.valor = "' . $this->params['valor_search'] . '"'.
                       ' OR ' . $table.'.valorbaixa = "' . $this->params['valor_search'] . '")';
        }
        
        if (!empty($this->params['banks_search'])) { 
            $where[] = '('.'banks.title LIKE "%' . $this->params['banks_search'] . '%")';
        }
        
        if (!empty($this->params['cheque_search'])) { 
            $where[] = '('.'MovimentCheck.cheque = "' . $this->params['cheque_search'] . '")';
        }
        
        if (!empty($this->params['status_search'])) { 
            $where[] = '(' . $table.'.status = "' . $this->params['status_search'] . '")';
        }
        
        if (!empty($this->params['mes_search'])) { 
            $where[] = '('.'MONTH(' . $table.'.data) = '.intval($this->params['mes_search']).
                       ' OR MONTH(' . $table.'.vencimento) = '.intval($this->params['mes_search']).
                       ' OR MONTH(' . $table.'.dtbaixa) = '.intval($this->params['mes_search']).')'; 
        }
        
        if (!empty($this->params['ano_search'])) { 
            $where[] = '('.'YEAR(' . $table.'.data) = '.intval($this->params['ano_search']).
                       ' OR YEAR(' . $table.'.vencimento) = '.intval($this->params['ano_search']).
                       ' OR YEAR(' . $table.'.dtbaixa) = '.intval($this->params['ano_search']).')'; 
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
        $this->Banks         = TableRegistry::get('Banks');
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
            $conditions  = ['MovimentBanks.parameters_id' => $this->request->Session()->read('sessionParameterControl')];
            
            /******************************************************************/
            
            if ($this->request->data['datapesq'] == 'lancamento') {
                $date_find = 'data';
            } elseif ($this->request->data['datapesq'] == 'vencimento') {
                $date_find = 'vencimento';
            } elseif ($this->request->data['datapesq'] == 'consolidacao') {
                $date_find = 'dtbaixa';
            }
            if ($this->request->data['historico']) {
                $conditions[] = 'MovimentBanks.historico LIKE "%' . $this->request->data['historico'] . '%"';
            }
            if ($this->request->data['banks_id']) {
                foreach($this->request->data['banks_id'] as $value):
                    $list_banks[] = $value;
                endforeach;
                $conditions[] = 'MovimentBanks.banks_id IN (' . implode(', ', $list_banks) . ')';
            }
            if ($this->request->data['providers_id']) {
                $conditions[] = 'MovimentBanks.providers_id LIKE ' . $this->request->data['providers_id'];
                
                $provider = $this->Providers->findByIdAndParametersId($this->request->data['providers_id'], $this->request->Session()->read('sessionParameterControl'))
                                            ->select(['Providers.title'])
                                            ->first();
                $this->set('provider', $provider);
            }
            if ($this->request->data['customers_id']) {
                $conditions[] = 'MovimentBanks.customers_id LIKE ' . $this->request->data['customers_id'];
                
                $customer = $this->Customers->findByIdAndParametersId($this->request->data['customers_id'], $this->request->Session()->read('sessionParameterControl'))
                                            ->select(['Customers.title'])
                                            ->first();
                $this->set('customer', $customer);
            }
            if ($this->request->data['account_plans_id']) {
                $conditions[] = 'MovimentBanks.account_plans_id LIKE ' . $this->request->data['account_plans_id'];
                
                $accountPlan = $this->AccountPlans->findByIdAndParametersId($this->request->data['account_plans_id'], $this->request->Session()->read('sessionParameterControl'))
                                                  ->select(['AccountPlans.title'])
                                                  ->first();
                $this->set('accountPlan', $accountPlan);
            }
            if ($this->request->data['document_types_id']) {
                $conditions[] = 'MovimentBanks.document_types_id LIKE ' . $this->request->data['document_types_id'];
                
                $documentType = $this->DocumentTypes->findByIdAndParametersId($this->request->data['document_types_id'], $this->request->Session()->read('sessionParameterControl'))
                                                    ->select(['DocumentTypes.title'])
                                                    ->first();
                $this->set('documentType', $documentType);
            }
            if ($this->request->data['event_types_id']) {
                $conditions[] = 'MovimentBanks.event_types_id LIKE ' . $this->request->data['event_types_id'];
                
                $eventType = $this->EventTypes->findByIdAndParametersId($this->request->data['event_types_id'], $this->request->Session()->read('sessionParameterControl'))
                                              ->select(['EventTypes.title'])
                                              ->first();
                $this->set('eventType', $eventType);
            }
            if ($this->request->data['creditodebito'] != 'A') {
                $conditions[] = 'MovimentBanks.creditodebito LIKE "' . $this->request->data['creditodebito'] . '"';
            }
            if ($this->request->data['costs_id']) {
                $conditions[] = 'MovimentBanks.costs_id LIKE ' . $this->request->data['costs_id'];
                
                $cost = $this->Costs->findByIdAndParametersId($this->request->data['costs_id'], $this->request->Session()->read('sessionParameterControl'))
                                    ->select(['Costs.title'])
                                    ->first();
                $this->set('cost', $cost);
            }
            if (!empty($this->request->data['contabil'])) {
                $conditions[] = 'MovimentBanks.contabil = "' . $this->request->data['contabil'] . '"';
            }
            if ($this->request->data['Ordem'] == 'dtbaixa') {
                $order = 'MovimentBanks.' . $this->request->data['Ordem'] . ', MovimentBanks.creditodebito';
            } elseif ($this->request->data['Ordem'] == 'ordem') {
                $order = 'MovimentBanks.dtbaixa, MovimentBanks.' . $this->request->data['Ordem'] . ', MovimentBanks.creditodebito';
            } else {
                $order = 'MovimentBanks.' . $this->request->data['Ordem'] . ', MovimentBanks.creditodebito';
            }
            
            /******************************************************************/
            
            //BUSCA SALDO INCIAL
            $bal_dtinicial = '2000-01-01';
            $bal_dtfinal   = date('Y-m-d H:i:s', strtotime($dtinicial . '-1 day'));
            
            /******************************************************************/
            
            if (!empty($this->request->data['banks_id'])) {

                //PREPARA LISTA DE BANCOS PARA CONSULTA
                $list_banks    = null;
                $request_banks = $this->request->data['banks_id'];

                /**************************************************************/
            
                if (!empty($request_banks)) {
                    foreach($request_banks as $bank):
                        //$list_banks .= $bank . ', ';
                        $list_banks[] = $bank;
                    endforeach;
                }//if (!empty($request_banks))

                /**************************************************************/

                $conditions_balance = ['Balances.banks_id IS NOT NULL',
                                       'Balances.banks_id IN' => $list_banks
                                      ];

            } else {

                $conditions_balance = ['Balances.banks_id IS NOT NULL'];

            }//else if (!empty($this->request->data['banks_id']))
            
            /******************************************************************/

            $balances = $this->Balances->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['banks_id' => 'DISTINCT(Balances.banks_id)', 
                                                 'Balances.date', 'Balances.value'
                                                ])
                                       ->where($conditions_balance)
                                       ->andWhere(function ($exp, $q) use($bal_dtfinal) {
                                                    return $exp->between('Balances.date', '2000-01-01', $bal_dtfinal);
                                                 })
                                       ->order(['Balances.date ASC'])
                                       ->last();

            /******************************************************************/
            
            $fields = ['MovimentBanks.id',
                       'MovimentBanks.ordem',
                       'MovimentBanks.banks_id',
                       'MovimentBanks.costs_id',
                       'MovimentBanks.event_types_id',
                       'MovimentBanks.moviment_checks_id',
                       'MovimentBanks.transfers_id',
                       'MovimentBanks.moviments_id',
                       'MovimentBanks.providers_id',
                       'MovimentBanks.account_plans_id',
                       'MovimentBanks.creditodebito',
                       'MovimentBanks.data',
                       'MovimentBanks.dtbaixa',
                       'MovimentBanks.vencimento',
                       'MovimentBanks.valor',
                       'MovimentBanks.valorbaixa',
                       'MovimentBanks.documento',
                       'MovimentBanks.historico',
                       'MovimentBanks.contabil',
                       'MovimentBanks.status',
                       'MovimentBanks.username',
                       'Banks.title',
                       'Banks.tipoconta',
                       'Costs.title',
                       'EventTypes.title',
                       'MovimentChecks.historico',
                       'Transfers.historico',
                       'Moviments.historico',
                       'Providers.title',
                       'AccountPlans.title'
                      ];
            
            $movimentBanks = $this->MovimentBanks->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select($fields)
                                                 ->contain(['Banks', 'Costs', 'EventTypes', 'MovimentChecks', 'Transfers', 
                                                            'Moviments', 'Providers', 'AccountPlans', 'Parameters'
                                                           ])
                                                 ->where($conditions)
                                                 ->andWhere(function ($exp, $q) use($dtinicial, $dtfinal, $date_find) {
                                                                return $exp->between('MovimentBanks.' . $date_find, $dtinicial, $dtfinal);
                                                           })
                                                 ->order($order);

            /******************************************************************/
            
            $this->set('balances', $balances);
            $this->set('movimentBanks', $movimentBanks);
            
            /******************************************************************/
            
            if ($this->request->data['banks_id']) {

                $banks = $this->Banks->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->select(['Banks.id', 'Banks.title'])
                                     ->where(['Banks.id IN' => $list_banks]);
                
                foreach($banks as $bank):
                    $return[$bank->id] = $bank->title;
                endforeach;

                $this->set('banks', $return);

            }//if ($this->request->data['banks_id'])
            
            /******************************************************************/
            
            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());
            
            /******************************************************************/
            
            //Evitar página de erro
            $this->render('reports/sem_relatorio');
            
            /******************************************************************/
            
            //MOVIMENTO
            if ($this->request->data['Tipo'] == 'movimento') {
                if ($this->request->data['Detalhamento'] == 'analitico') {
                    $this->render('reports/movimento_analitico');
                } elseif ($this->request->data['Detalhamento'] == 'sintetico') {
                    $this->render('reports/movimento_sintetico');
                }
            } 
            
            //FLUXO
            if ($this->request->data['Tipo'] == 'fluxo') {
                if ($this->request->data['Detalhamento'] == 'analitico') {
                    $this->render('reports/fluxo_analitico');
                } elseif ($this->request->data['Detalhamento'] == 'sintetico') {
                    $this->render('reports/fluxo_sintetico');
                }
            }
        }
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('providers', $this->MovimentBanks->Providers->find('list')->where($conditions)->order(['title']));
        $this->set('customers', $this->MovimentBanks->Customers->find('list')->where($conditions)->order(['title']));
        $this->set('documentTypes', $this->MovimentBanks->DocumentTypes->find('list')->where($conditions)->order(['title']));
        $this->set('costs', $this->MovimentBanks->Costs->find('list')->where($conditions)->order(['title']));
        $this->set('banks', $this->MovimentBanks->Banks->find('list')->where($conditions)->order(['title']));
        $this->set('eventTypes', $this->MovimentBanks->EventTypes->find('list')->where($conditions)->order(['title']));
        $accountPlans = $this->MovimentBanks->AccountPlans->find('list', ['keyField' => 'id', 'valueField' => 'dropdown_accounts'])
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