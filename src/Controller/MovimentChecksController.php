<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* MovimentChecks */
/* File: src/Controller/MovimentChecksController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class MovimentChecksController extends AppController
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
        
        $this->loadComponent('MovimentChecksFunctions');
        $this->loadComponent('MovimentsFunctions');
    }
    
    public function index()
    {
        //VERIFICA SE HÁ BANCOS CADASTRADOS
        if ($message = $this->SystemFunctions->validaCadastros("banco", $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__($message), ['escape' => false]);
        }
        
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);
        
        $movimentChecks = $this->MovimentChecks->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                               ->select(['MovimentChecks.id', 'MovimentChecks.ordem', 'MovimentChecks.documento',
                                                         'MovimentChecks.historico', 'MovimentChecks.data', 'MovimentChecks.valor', 
                                                         'MovimentChecks.status', 'MovimentChecks.moviments_id', 'MovimentChecks.transfers_id', 
                                                         'MovimentChecks.banks_id', 'MovimentChecks.cheque', 
                                                         'Transfers.id', 'Transfers.ordem', 'Moviments.id', 'Moviments.ordem', 
                                                         'Banks.id', 'Banks.title',
                                                         'Moviments.id', 'Moviments.customers_id', 'Moviments.providers_id',
                                                         'Customers.title', 'Providers.title'
                                                        ])
                                               ->contain(['Banks', 'Transfers'])
                                               ->join(['Moviments' => ['table'      => 'Moviments',
                                                                       'type'       => 'LEFT',
                                                                       'conditions' => 'Moviments.id = MovimentChecks.moviments_id'
                                                                      ],
                                                       'Customers' => ['table'      => 'Customers',
                                                                       'type'       => 'LEFT',
                                                                       'conditions' => 'Customers.id = Moviments.customers_id'
                                                                      ],
                                                       'Providers' => ['table'      => 'Providers',
                                                                       'type'       => 'LEFT',
                                                                       'conditions' => 'Providers.id = Moviments.providers_id'
                                                                      ],
                                                      ])
                                               ->where($where)
                                               ->order(['MovimentChecks.ordem DESC']);
                                     //->limit(200);
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $movimentChecks = $this->paginate($movimentChecks);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $movimentChecks = $this->paginate($movimentChecks);
            
        }
        
        $this->set(compact('movimentChecks'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $movimentCheck = $this->MovimentChecks->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                              ->contain(['Banks', 'Boxes', 'EventTypes', 'Costs', 
                                         'Providers', 'AccountPlans', 'Transfers', 
                                         'Moviments'
                                        ])
                               ->first();
        
        $this->set(compact('movimentCheck'));
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $movimentCheck = $this->MovimentChecks->get($id, ['contain' => ['EventTypes', 'AccountPlans', 'Costs']]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
        
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $this->request->data['username'] = $this->Auth->user('name');
            
            //CAMPOS QUE NÃO PERMITEM ALTERAÇÃO
            $this->request->data['parameters_id'] = $movimentCheck->parameters_id;
            $this->request->data['data']          = $movimentCheck->data;
            $this->request->data['cheque']        = $movimentCheck->cheque;
            $this->request->data['banks_id']      = $movimentCheck->banks_id;
            $this->request->data['boxes_id']      = $movimentCheck->boxes_id;
            $this->request->data['valor']         = $movimentCheck->valor;
            $this->request->data['nominal']       = $movimentCheck->nominal;
            $this->request->data['contabil']      = $movimentCheck->contabil;
            
            /******************************************************************/
            
            $movimentCheck = $this->MovimentChecks->patchEntity($movimentCheck, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->MovimentChecks->save($movimentCheck)) {
                
                //Atualiza os lançamentos do CPR
                $this->MovimentsFunctions->atualizaMovimentos($movimentCheck);

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->MovimentChecks->save($movimentCheck))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'MovimentChecksController->edit';
            $this->Error->registerError($movimentCheck, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('costs', $this->MovimentChecks->Costs->find('list')->where($conditions)->order(['title']));
        $this->set('boxes', $this->MovimentChecks->Boxes->find('list')->where($conditions)->order(['title']));
        $this->set('banks', $this->MovimentChecks->Banks->find('list')->where($conditions)->order(['title']));
        $this->set('eventTypes', $this->MovimentChecks->EventTypes->find('list')->where($conditions)->order(['title']));
        $accountPlans = $this->MovimentChecks->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
                                                      ->where($conditions)
                                                      ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($movimentCheck->data)) {
            $movimentCheck->data = date('d/m/Y', strtotime($movimentCheck->data));
        }
        
        $this->set(compact('movimentCheck'));
    }

    public function delete($id)
    {
        $this->Transfers = TableRegistry::get('Transfers');
        $this->Moviments = TableRegistry::get('Moviments');
        
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
        $movimentChecks = $this->MovimentChecks->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                               ->first();
        
        /**********************************************************************/

        if (!empty($movimentChecks)) {

            // BUSCA MOVIMENTOS DE TRANSFERÊNCIAS PELO NÚMERO DE ORDEM
            $Transfer = $this->Transfers->findByIdAndParametersId($movimentChecks->transfers_id, $this->request->Session()->read('sessionParameterControl'))
                                        ->first();

            if (!empty($Transfer)) {
                
                $ordem = str_pad($Transfer->ordem, 6, '0', STR_PAD_LEFT);
                $link = '<a href="Transfers/View/'.$Transfer->id.'" class="btn_modal" data-loading-text="Carregando...", data-title="Visualizar">'.$ordem.'</a>'; //, data-size = "sm"
                
                $this->Flash->error(__('Registro NÃO excluído. Há movimentos vinculados em ') . $link, ['escape' => false]);
                return $this->redirect($this->referer());

            }//if (!empty($Transfer))
            
            /**********************************************************************/
            
            // BUSCA LANÇAMENTOS FINANCEIROS PELO NÚMERO DE ORDEM
            $Moviment = $this->Moviments->findByIdAndParametersId($movimentChecks->moviments_id, $this->request->Session()->read('sessionParameterControl'))
                                        ->first();

            if (!empty($Moviment)) {

                $ordem = str_pad($Moviment->ordem, 6, '0', STR_PAD_LEFT);
                $link = '<a href="Moviments/View/'.$Moviment->id.'" class="btn_modal" data-loading-text="Carregando...", data-title="Visualizar">'.$ordem.'</a>'; //, data-size = "sm"
                
                $this->Flash->error(__('Registro NÃO excluído. Há movimentos vinculados em ') . $link, ['escape' => false]);
                return $this->redirect($this->referer());

            }//if (!empty($Moviment))
            
            /**********************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($movimentChecks, 'delete', 'MovimentChecks');
            
            /**********************************************************************/
            
            if ($this->MovimentChecks->delete($movimentChecks)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->MovimentChecks->delete($movimentChecks))

        }//if (!empty($movimentChecks))
            
        /******************************************************************/

        //Alerta de erro
        $message = 'MovimentChecksController->delete';
        $this->Error->registerError($movimentCheck, $message, true);
            
        /******************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'MovimentChecks';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['historico_search'])) { 
            $where[] = '('.$table.'.historico LIKE "%'.$this->params['historico_search'].
                       '%" OR '.$table.'.documento LIKE "%'.$this->params['historico_search'].'%")';
        }
        
        if (!empty($this->params['ordem_search'])) { 
            $where[] = '('.$table.'.ordem = "'.intval($this->params['ordem_search']).'")';
        }
        
        if (!empty($this->params['valor_search'])) { 
            $this->params['valor_search'] = str_replace(".", "", $this->params['valor_search']);
            $this->params['valor_search'] = str_replace(",", ".", $this->params['valor_search']);
            $where[] = '('.$table.'.valor = "'.$this->params['valor_search'].'")';
        }
        
        if (!empty($this->params['banks_search'])) { 
            $where[] = '('.'banks.title LIKE "%'.$this->params['banks_search'].'%")';
        }
        
        if (!empty($this->params['cheque_search'])) { 
            $where[] = '('.$table.'.cheque LIKE "%'.$this->params['cheque_search'].'%")';
        }
        
        if (!empty($this->params['status_search'])) { 
            $where[] = '('.$table.'.status = "'.$this->params['status_search'].'")';
        }
        
        if (!empty($this->params['mes_search'])) { 
            $where[] = '('.'MONTH('.$table.'.data) = '.intval($this->params['mes_search']).')'; 
        }
        
        if (!empty($this->params['ano_search'])) { 
            $where[] = '('.'YEAR('.$table.'.data) = '.intval($this->params['ano_search']).')'; 
        }
        
        return $where;
    }
    
    public function reportForm() //Adicionar período
    {
        $this->Balances   = TableRegistry::get('Balances');
        $this->Parameters = TableRegistry::get('Parameters');
            
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
            
            $table = 'MovimentChecks';
            
            /******************************************************************/

            // MONTAGEM DO SQL
            $conditions  = [$table.'.parameters_id' => $this->request->Session()->read('sessionParameterControl')];

            if ($this->request->data['dtinicial'] && $this->request->data['dtfinal']) {
                $date_find = 'data';
            }
            if ($this->request->data['valor']) {
                $valor = [$table.'.valor LIKE' => '%'.$this->request->data['valor'].'%'];
                $conditions = array_merge($conditions, $valor);
            }
            if ($this->request->data['cheque']) {
                $cheque = [$table.'.cheque LIKE' => "%".$this->request->data['cheque']."%"];
                $conditions = array_merge($conditions, $cheque);
            }
            if ($this->request->data['nominal']) {
                $nominal = [$table.'.nominal LIKE' => "%".$this->request->data['nominal']."%"];
                $conditions = array_merge($conditions, $nominal);
            }
            if ($this->request->data['historico']) {
                $historico = [$table.'.historico LIKE' => "%".$this->request->data['historico']."%"];
                $conditions = array_merge($conditions, $historico);
            }
            if ($this->request->data['banks_id']) {
                $banks = [$table.'.banks_id LIKE' => $this->request->data['banks_id']];
                $conditions = array_merge($conditions, $banks);
            }
            if ($this->request->data['account_plans_id']) {
                $accountPlans = [$table.'.account_plans_id LIKE' => $this->request->data['account_plans_id']];
                $conditions = array_merge($conditions, $accountPlans);
            }
            if ($this->request->data['providers_id']) {
                $providers = [$table.'.providers_id LIKE' => $this->request->data['providers_id']];
                $conditions = array_merge($conditions, $providers);
            }
            if ($this->request->data['costs_id']) {
                $costs = [$table.'.costs_id LIKE' => $this->request->data['costs_id']];
                $conditions = array_merge($conditions, $costs);
            }
            if (!empty($this->request->data['contabil'])) {
                $contabil = [$table.'.contabil' => $this->request->data['contabil']];
                $conditions = array_merge($conditions, $contabil);
            }
            if ($this->request->data['Ordem']) {
                $order = $table.'.ordem,'.$this->request->data['Ordem'].', banks_id';
            }
            
            /******************************************************************/
            
            //BUSCA SALDO INCIAL
            $bal_dtinicial = '2000-01-01 00:00:00';
            $bal_dtfinal   = date('Y-m-d', strtotime($dtinicial.'-1 day'));
            
            $balances = $this->Balances->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['Balances.banks_id', 'Balances.value'])
                                       ->where(function ($exp, $q) use($bal_dtinicial, $bal_dtfinal) {
                                                return $exp->between('Balances.date', $bal_dtinicial, $bal_dtfinal);
                                               })
                                       ->where(['Balances.banks_id IS NOT NULL'])
                                       ->order(['Balances.banks_id']);
            
            $fields = ['MovimentChecks.id',
                       'MovimentChecks.ordem',
                       'MovimentChecks.parameters_id',
                       'MovimentChecks.banks_id',
                       'MovimentChecks.boxes_id',
                       'MovimentChecks.costs_id',
                       'MovimentChecks.event_types_id',
                       'MovimentChecks.providers_id',
                       'MovimentChecks.account_plans_id',
                       'MovimentChecks.cheque',
                       'MovimentChecks.nominal',
                       'MovimentChecks.data',
                       'MovimentChecks.valor',
                       'MovimentChecks.documento',
                       'MovimentChecks.historico',
                       'MovimentChecks.contabil',
                       'MovimentChecks.status',
                       'MovimentChecks.username',
                       'Banks.id',
                       'Banks.title',
                       'Boxes.id',
                       'Boxes.title',
                       'Costs.id',
                       'Costs.title',
                       'EventTypes.id',
                       'EventTypes.title',
                       'Providers.id',
                       'Providers.title',
                       'AccountPlans.id',
                       'AccountPlans.title'
                      ];
            
            $movimentChecks = $this->MovimentChecks->find('all')
                                                   ->select($fields)
                                                   ->contain(['Banks', 'Boxes', 'Costs', 'EventTypes', 
                                                              'Providers', 'AccountPlans', 'Parameters'
                                                             ])
                                                   ->where(function ($exp, $q) use($dtinicial, $dtfinal, $date_find) {
                                                            return $exp->between('MovimentChecks.'.$date_find, $dtinicial, $dtfinal);
                                                           })
                                                   ->where($conditions)
                                                   ->order($order);
            
            /******************************************************************/
                                                           
            $this->set('balances', $balances);
            $this->set('movimentChecks', $movimentChecks);
            
            /******************************************************************/
            
            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());
            
            /******************************************************************/
            
            if ($this->request->data['Tipo'] == 'movimentoCheque_cheque') {
                $this->render('reports/movimentoCheque_cheque');
            }
            
            if ($this->request->data['Tipo'] == 'movimentoCheque_cancelado') {
                $this->render('reports/movimentoCheque_cancelado');
            }
            
        }
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('costs', $this->MovimentChecks->Costs->find('list', ['conditions' => $conditions, 'order' => 'title']));
        $this->set('boxes', $this->MovimentChecks->Boxes->find('list', ['conditions' => $conditions, 'order' => 'title']));
        $this->set('banks', $this->MovimentChecks->Banks->find('list', ['conditions' => $conditions, 'order' => 'title', 'conditions' => ['emitecheque' => 'S']]));
        $this->set('eventTypes', $this->MovimentChecks->EventTypes->find('list', ['conditions' => $conditions, 'order' => 'title']));
        $this->set('providers', $this->MovimentChecks->Providers->find('list', ['conditions' => $conditions, 'order' => 'title']));
        $accountPlans = $this->MovimentChecks->AccountPlans->find('list', ['keyField' => 'id', 'valueField' => 'dropdown_accounts'])
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