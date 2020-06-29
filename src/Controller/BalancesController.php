<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Balances */
/* File: src/Controller/BalancesController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class BalancesController extends AppController
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

        $this->Banks     = TableRegistry::get('Banks');
        $this->Boxes     = TableRegistry::get('Boxes');
        $this->Cards     = TableRegistry::get('Cards');
        $this->Plannings = TableRegistry::get('Plannings');
    }
    
    public function index()
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        /* EXCLUIR SELECIONADOS */
        if ($this->request->is('post')) {
            
            $deleted = $nodeleted = 0;
            $delete = $this->request->data;
            
            /******************************************************************/
            
            if (!isset($delete['record']) || !count($delete['record'])) {
                $this->Flash->warning(__('Nenhum registro selecionado'));
                return $this->redirect($this->referer());
            }
            
            /******************************************************************/
            
            foreach($delete['record'] as $reg):
                
                $balances = $this->Balances->findByIdAndParametersId($reg, $this->request->Session()->read('sessionParameterControl'))
                                           ->first();
                
                if ($this->Balances->delete($balances)) {
                    $deleted++;
                } else {
                    $nodeleted++;
                }

            endforeach;
            
            /******************************************************************/
            
            if ($nodeleted == 0) {
                $this->Flash->success($deleted . __(' Registros excluídos com sucesso'));
                return $this->redirect($this->referer());
            } else {
                $this->Flash->error($nodeleted . __(' Registros NÃO excluídos, tente novamente'));
                return $this->redirect($this->referer());
            }
            
        }//if ($this->request->is('post'))
        
        /**********************************************************************/
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $today = null;
        
        /**********************************************************************/
        
        $balances = $this->Balances->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                   ->select(['Balances.id', 'Balances.date', 'Balances.value', 'Balances.parameters_id',
                                             'Balances.banks_id', 'Balances.boxes_id', 'Balances.cards_id', 'Balances.plannings_id', 
                                             'Banks.title', 'Boxes.title', 'Cards.title', 'Plannings.title', 'Parameters.razao'
                                            ])
                                   ->where($where)
                                   ->contain(['Banks', 'Boxes', 'Cards', 'Plannings', 'Parameters'])
                                   ->order(['Balances.parameters_id', 'Balances.banks_id', 'Balances.boxes_id', 
                                            'Balances.cards_id', 'Balances.plannings_id', 'balances.date ASC'
                                           ])
                                   ->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $balances = $this->paginate($balances);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $balances = $this->paginate($balances);
            
        }
        
        $this->set(compact('balances'));
        
        /**********************************************************************/
        //Lista todos os últimos saldos
        
        $balances_today = $this->Balances->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->select(['Balances.id', 'Balances.date', 'Balances.value', 'Balances.parameters_id',
                                                   'Balances.banks_id', 'Balances.boxes_id', 'Balances.cards_id', 'Balances.plannings_id', 
                                                   'Banks.title', 'Boxes.title', 'Cards.title', 'Plannings.title', 'Parameters.razao'
                                                  ])
                                         ->where(['Balances.date' => date('Y-m-d')])
                                         ->group(['Balances.parameters_id', 'Balances.banks_id', 'Balances.boxes_id', 'Balances.cards_id', 
                                                  'Balances.plannings_id', 'Balances.id', 'Balances.date', 'Balances.value'
                                                 ])
                                         ->contain(['Banks', 'Boxes', 'Cards', 'Plannings', 'Parameters'])
                                         ->order(['Balances.parameters_id', 'Balances.banks_id', 'Balances.boxes_id', 
                                                  'Balances.cards_id', 'Balances.plannings_id', 'balances.date DESC'
                                                 ])
                                         ->limit(50);
        
        $this->set(compact('balances_today'));
        
        /**********************************************************************/
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('banks', $this->Banks->find('list')->where($conditions)->order(['Banks.title']));
        $this->set('boxes', $this->Boxes->find('list')->where($conditions)->order(['Boxes.title']));
        $this->set('cards', $this->Cards->find('list')->where($conditions)->order(['Cards.title']));
        $this->set('plannings', $this->Plannings->find('list')->where($conditions)->order(['Plannings.title']));
    }
    
    public function superAddBalance()
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            if (empty($this->request->data['banks_id']) && 
                empty($this->request->data['boxes_id']) && 
                empty($this->request->data['cards_id']) && 
                empty($this->request->data['plannings_id'])
               ) {
                $this->Flash->error(__('Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente'));
                return $this->redirect($this->referer());
            }
        
            /******************************************************************/
            
            //Retira máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['valor'] = str_replace($source, $replace, $this->request->data['valor']);
        
            /******************************************************************/
            
            switch($this->request->data['radio']):
                case 'caixa':
                    unset($this->request->data['banks_id']);
                    unset($this->request->data['cards_id']);
                    unset($this->request->data['plannings_id']);
                    $table_id = 'boxes_id';
                    break;
                case 'banco':
                    unset($this->request->data['boxes_id']);
                    unset($this->request->data['cards_id']);
                    unset($this->request->data['plannings_id']);
                    $table_id = 'banks_id';
                    break;
                case 'cartao':
                    unset($this->request->data['boxes_id']);
                    unset($this->request->data['banks_id']);
                    unset($this->request->data['plannings_id']);
                    $table_id = 'cards_id';
                    break;
                case 'planejamento':
                    unset($this->request->data['boxes_id']);
                    unset($this->request->data['banks_id']);
                    unset($this->request->data['cards_id']);
                    $table_id = 'plannings_id';
                    break;
            endswitch;
        
            /******************************************************************/
            
            $reg_id = $this->request->data[$table_id];
        
            /******************************************************************/

            if (!empty($this->request->data['data'])) { // Correção no formato da data 17/07/2018

                $datepicker = explode("/", $this->request->data['data']);
                $this->request->data['data'] = implode('-', array_reverse($datepicker));
                $dtbaixa = $this->request->data['data'];

            } else {

                $this->Flash->error(__('Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente'));
                return $this->redirect($this->referer());

            }//else if (!empty($this->request->data['data']))
            
            /******************************************************************/
            
            //Define o valor a ser creditado/debitado
            if ($this->request->data['creditodebito'] == 'C') {
                $valor = $this->request->data['valor'];
            } elseif ($this->request->data['creditodebito'] == 'D') {
                $valor = $this->request->data['valor']*-1;
            }//elseif ($this->request->data['creditodebito'] == 'D')
        
            /******************************************************************/
            
            //BUSCA REGISTROS NA TABELA BALANCE
            $balance = $this->Balances->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                      ->select(['Balances.id', 'Balances.value'])
                                      ->where(['Balances.' . $table_id => $reg_id,
                                               'Balances.date'         => $dtbaixa,
                                              ])
                                      ->first();

            /******************************************************************/
            
            //SE NÃO HOUVER REGISTRO
            if (empty($balance)) {
                
                //$balance = $this->GeneralBalance->recordBalance($dtbaixa, $balance, null);
                $balance = $this->GeneralBalance->addBalance($table_id, $reg_id, null, $this->request->Session()->read('sessionParameterControl'), null);
                
            }//if (empty($balance))
        
            /******************************************************************/
            
            //ATUALIZA O REGISTRO
            $balance->value += $valor;
        
            /******************************************************************/
            
            //GRAVA REGISTRO
            if (!$this->Balances->save($balance)) {

                //Alerta de erro
                $message = 'BalancesController->superAddBalance, Balances';
                $this->Error->registerError($balance, $message, true);

            }//if (!$this->Balances->save($balance))
        
            /******************************************************************/
                    
            //TRATAMENTO PARA CARTÕES E PLANEJAMENTOS
            if (!empty($this->request->data['cards_id']) || !empty($this->request->data['plannings_id'])) { //07/07/2017
                
                //EXCLUI REGISTROS ANTERIORES (CARTÃO POSSUI LIMITE E NÃO SALDO!) 17/07/2018
                $conditions = ['Balances.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                               'Balances.' . $table_id  => $reg_id,
                               'Balances.date <'        => date('Y-m-d')
                              ];
                
                $this->Balances->deleteAll($conditions);
                
            } else {

                //LOCALIZA REGISTROS POSTERIORES
                $post_day = $this->Balances->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->select(['Balances.id', 'Balances.value'])
                                           ->where(['Balances.' . $table_id => $reg_id,
                                                    'Balances.date >'       => $dtbaixa,
                                                   ]);

                if (!empty($post_day->toArray())) {

                    foreach ($post_day as $day):

                        //ATUALIZA O REGISTRO
                        $day->value += $valor;

                        //GRAVA REGISTRO
                        if (!$this->Balances->save($day)) {
                            
                            //Alerta de erro
                            $message = 'BalancesController->superAddBalance, $post_day';
                            $this->Error->registerError($day, $message, true);

                        }//if (!$this->Balances->save($day))

                    endforeach;

                }//if (!empty($post_day->toArray()))

            }//if (!empty($this->request->data['cards_id']) || !empty($this->request->data['plannings_id']))
        
            /******************************************************************/
            
            if (!isset($errors)) {
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
            }//if (!isset($errors))
        
            /******************************************************************/
            
            $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
            return $this->redirect($this->referer());
            
        }
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('banks', $this->Balances->Banks->find('list', ['conditions' => $conditions, 'order' => 'title']), ['limit' => 200]);
        $this->set('boxes', $this->Balances->Boxes->find('list', ['conditions' => $conditions, 'order' => 'title']), ['limit' => 200]);
        $this->set('cards', $this->Balances->Cards->find('list', ['conditions' => $conditions, 'order' => 'title']), ['limit' => 200]);
        $this->set('plannings', $this->Balances->Plannings->find('list', ['conditions' => $conditions, 'order' => 'title']), ['limit' => 200]);
    }

    public function checkBalanceBanks()
    {
        $this->MovimentBanks = TableRegistry::get('MovimentBanks');
        $this->Parameters    = TableRegistry::get('Parameters');
        
        /**********************************************************************/

        //Inicializa variáveis
        $mov_bal_banks = [];
        
        /**********************************************************************/

        //Lista todos os perfis ativos
        $parameters = $this->Parameters->find('all')
                                       ->select(['Parameters.id', 'Parameters.razao', 'Parameters.plans_id'])
                                       ->where(['Parameters.dtvalidade >' => date('Y-m-d'),
                                                //'Parameters.id' => '1'
                                               ])
                                       ->order(['Parameters.id']);
        
        /**********************************************************************/

        if (!empty($parameters->toArray())) {

            foreach ($parameters as $parameter):

                //Lista de perfis
                $list_parameters[$parameter->id] = $parameter->razao;
        
                /**************************************************************/

                //Lista todos os cadastros de bancos
                $banks = $this->Banks->find('all')
                                     ->select(['Banks.id', 'Banks.title'])
                                     ->where(['Banks.status' => 'A',
                                              'Banks.parameters_id' => $parameter->id
                                             ])
                                     ->order(['Banks.title']);

                if (!empty($banks->toArray())) {

                    foreach ($banks as $bank):

                        //Inicializa variáveis
                        $mbValor = number_format(floatval(0), 2);
                        $mbDatas = [];
                        
                        /******************************************************/

                        //Lista de bancos
                        $list_banks[$bank->id] = $bank->title;
        
                        /******************************************************/

                        //Lista todos os movimentos de bancos
                        $movimentBanks = $this->MovimentBanks->find('all')
                                                             ->select(['MovimentBanks.id', 'MovimentBanks.dtbaixa', 'MovimentBanks.valorbaixa', 
                                                                       'MovimentBanks.creditodebito', 'MovimentBanks.banks_id'
                                                                      ])
                                                             ->where(['MovimentBanks.parameters_id' => $parameter->id,
                                                                      'MovimentBanks.banks_id' => $bank->id,
                                                                      'MovimentBanks.contabil' => 'S'
                                                                     ])
                                                             ->order(['MovimentBanks.dtbaixa']);

                        if (!empty($movimentBanks->toArray())) {

                            foreach ($movimentBanks as $movimentBank):

                                //Tratamento da data
                                $mbDtbaixa = date("Y-m-d", strtotime($movimentBank->dtbaixa));

                                //Tratamento do valor
                                $mbValorBaixa = (float) number_format(floatval($movimentBank->valorbaixa), 2, ".", "");

                                /**********************************************/

                                //Tratamento do valor
                                if ($movimentBank->creditodebito == 'C') {
                                    $mbValor += $mbValorBaixa;
                                } elseif ($movimentBank->creditodebito == 'D') {
                                    $mbValor -= $mbValorBaixa;
                                }

                                /**********************************************/

                                //Array de datas
                                $mbDatas[] = $mbDtbaixa;

                                /**********************************************/

                                //Array de saldos do movimento
                                $mov_bal_banks[$parameter->id][$bank->id][$mbDtbaixa]['movimentBanks'] = $mbValor;

                            endforeach;

                        }//if (!empty($movimentBanks->toArray()))
        
                        /******************************************************/

                        if (!empty($mbDatas)) {

                            $balanceBanks = $this->Balances->find('all')
                                                           ->select(['Balances.id', 'Balances.date', 'Balances.value', 'Balances.banks_id'])
                                                           ->where(['Balances.parameters_id' => $parameter->id,
                                                                    'Balances.banks_id' => $bank->id,
                                                                    'Balances.date IN' => $mbDatas
                                                                   ])
                                                           ->order(['Balances.date']);

                            if (!empty($balanceBanks->toArray())) {

                                foreach ($balanceBanks as $balanceBank):

                                    //Tratamento da data
                                    $bbDtbaixa = date("Y-m-d", strtotime($balanceBank->date));

                                    //Tratamento do valor
                                    $bbValorBaixa = number_format(floatval($balanceBank->value), 2, ".", "");

                                    /**********************************************/

                                    //Array de resultados
                                    $mov_bal_banks[$parameter->id][$bank->id][$bbDtbaixa]['balanceBanks'] = $bbValorBaixa;

                                endforeach;

                            }//if (!empty($balanceBanks->toArray()))

                        }//if (!empty($mbDatas))

                    endforeach;

                }//if (!empty($banks->toArray()))
                
            endforeach;

        }//if (!empty($parameters->toArray()))
        
        /**********************************************************************/

        //Identifica lançamentos no balanço que não estão no movimento de banco
        //$movBanksSemBalance = array_diff_key($movBanks, $balBanks);

        /**********************************************************************/

        $this->set('mov_bal_banks', $mov_bal_banks);
        $this->set('list_parameters', $list_parameters);
        $this->set('list_banks', $list_banks);

    }

    public function checkBalanceBoxes()
    {
        $this->MovimentBoxes = TableRegistry::get('MovimentBoxes');
        $this->Parameters    = TableRegistry::get('Parameters');
        
        /**********************************************************************/

        //Inicializa variáveis
        $mov_bal_boxes = [];
        
        /**********************************************************************/

        //Lista todos os perfis ativos
        $parameters = $this->Parameters->find('all')
                                       ->select(['Parameters.id', 'Parameters.razao', 'Parameters.plans_id'])
                                       ->where(['Parameters.dtvalidade >' => date('Y-m-d'),
                                                //'Parameters.id' => '1'
                                               ])
                                       ->order(['Parameters.id']);
        
        /**********************************************************************/

        if (!empty($parameters->toArray())) {

            foreach ($parameters as $parameter):

                //Lista de perfis
                $list_parameters[$parameter->id] = $parameter->razao;
        
                /**************************************************************/

                //Lista todos os cadastro de caixas
                $boxes = $this->Boxes->find('all')
                                     ->select(['Boxes.id', 'Boxes.title'])
                                     ->where(['Boxes.status' => 'A',
                                              'Boxes.parameters_id' => $parameter->id
                                             ])
                                     ->order(['Boxes.title']);

                if (!empty($boxes->toArray())) {

                    foreach ($boxes as $box):

                        //Inicializa variáveis
                        $mxValor = number_format(floatval(0), 2);
                        $mxDatas = [];
        
                        /******************************************************/

                        //Lista de bancos
                        $list_boxes[$box->id] = $box->title;
        
                        /******************************************************/

                        //Lista todos os movimentos de caixas
                        $movimentBoxes = $this->MovimentBoxes->find('all')
                                                             ->select(['MovimentBoxes.id', 'MovimentBoxes.dtbaixa', 'MovimentBoxes.valorbaixa', 
                                                                       'MovimentBoxes.creditodebito', 'MovimentBoxes.boxes_id'
                                                                      ])
                                                             ->where(['MovimentBoxes.parameters_id' => $parameter->id,
                                                                      'MovimentBoxes.boxes_id' => $box->id,
                                                                      'MovimentBoxes.contabil' => 'S'
                                                                     ])
                                                             ->order(['MovimentBoxes.dtbaixa']);

                        if (!empty($movimentBoxes->toArray())) {

                            foreach ($movimentBoxes as $movimentBox):

                                //Tratamento da data
                                $mxDtbaixa = date("Y-m-d", strtotime($movimentBox->dtbaixa));

                                //Tratamento do valor
                                $mxValorBaixa = (float) number_format(floatval($movimentBox->valorbaixa), 2, ".", "");

                                /**********************************************/

                                //Tratamento do valor
                                if ($movimentBox->creditodebito == 'C') {
                                    $mxValor += $mxValorBaixa;
                                } elseif ($movimentBox->creditodebito == 'D') {
                                    $mxValor -= $mxValorBaixa;
                                }

                                /**********************************************/

                                //Array de datas
                                $mxDatas[] = $mxDtbaixa;

                                /**********************************************/

                                //Array de resultados
                                $mov_bal_boxes[$parameter->id][$box->id][$mxDtbaixa]['movimentBoxes'] = $mxValor;

                            endforeach;

                        }//if (!empty($movimentBoxes->toArray()))
        
                        /******************************************************/

                        if (!empty($mxDatas)) {

                            $balanceBoxes = $this->Balances->find('all')
                                                           ->select(['Balances.id', 'Balances.date', 'Balances.value', 'Balances.boxes_id'])
                                                           ->where(['Balances.parameters_id' => $parameter->id,
                                                                    'Balances.boxes_id' => $box->id,
                                                                    'Balances.date IN' => $mxDatas
                                                                   ])
                                                           ->order(['Balances.date']);

                            if (!empty($balanceBoxes->toArray())) {

                                foreach ($balanceBoxes as $balanceBox):

                                    //Tratamento da data
                                    $bxDtbaixa = date("Y-m-d", strtotime($balanceBox->date));

                                    //Tratamento do valor
                                    $bxValorBaixa = (float) number_format(floatval($balanceBox->value), 2, ".", "");

                                    /**********************************************/

                                    //Array de resultados
                                    $mov_bal_boxes[$parameter->id][$box->id][$bxDtbaixa]['balanceBoxes'] = $bxValorBaixa;
                                    
                                endforeach;

                            }//if (!empty($balanceBoxes->toArray()))


                        }//if (!empty($mxDatas))
        
                    endforeach;

                }//if (!empty($boxes->toArray()))

            endforeach;

        }//if (!empty($parameters->toArray()))
        
        /**********************************************************************/

        //Identifica lançamentos no balanço que não estão no movimento de caixa
        //$movBoxessSemBalance = array_diff_key($movBoxes, $balBoxes);
        
        /**********************************************************************/

        $this->set('mov_bal_boxes', $mov_bal_boxes);
        $this->set('list_parameters', $list_parameters);
        $this->set('list_boxes', $list_boxes);

    }

    public function delete($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));
            //if (!srtpos($this->request->referer(), 'report_form')) { return $this->redirect($this->referer()); }
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $this->request->allowMethod(['post', 'delete']);
        
        /**********************************************************************/

        $balance = $this->Balances->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                  ->first();
        
        /**********************************************************************/

        if (!empty($balance)) {

            if ($this->Balances->delete($balance)) {

                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
    
            }//if ($this->Balances->delete($balance))

        }//if (!empty($balance))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'BalancesController->delete';
        $this->Error->registerError($balance, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'Balances';
        $where = [];
        $this->prepareParams($request);
        
        if (@$this->params['dtinicial']) { // datepicker
            $datepicker = explode("/", $this->params['dtinicial']);
            $dtinicial = implode('-', array_reverse($datepicker));
        }

        if (@$this->params['dtfinal']) { // datepicker
            $datepicker = explode("/", $this->params['dtfinal']);
            $dtfinal = implode('-', array_reverse($datepicker));
        }
        
        if (!empty($dtinicial) && !empty($dtfinal)) { 
            $where[] = $table.'.date BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"'; 
        }
        
        if (!empty($this->params['banks_id'])) {
            if (is_array($this->params['banks_id'])) { $banks = implode(', ', $this->params['banks_id']); } else { $banks = $this->params['banks_id']; }
            $where[] = $table.'.banks_id IN ('. $banks .')';
        }
        
        if (!empty($this->params['boxes_id'])) {
            if (is_array($this->params['boxes_id'])) { $boxes = implode(', ', $this->params['boxes_id']); } else { $boxes = $this->params['boxes_id']; }
            $where[] = $table.'.boxes_id IN ('. $boxes .')';
        }
        
        if (!empty($this->params['cards_id'])) {
            if (is_array($this->params['cards_id'])) { $cards = implode(', ', $this->params['cards_id']); } else { $cards = $this->params['cards_id']; }
            $where[] = $table.'.cards_id IN ('. $cards .')';
        }
        
        if (!empty($this->params['plannings_id'])) {
            if (is_array($this->params['plannings_id'])) { $plannings = implode(', ', $this->params['plannings_id']); } else { $plannings = $this->params['plannings_id']; }
            $where[] = $table.'.plannings_id IN ('. $plannings .')';
        }
        
        return $where;
    }
    
    public function reportForm()
    {
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('banks', $this->Banks->find('list')->where($conditions)->order(['Banks.title']));
        $this->set('boxes', $this->Boxes->find('list')->where($conditions)->order(['Boxes.title']));
        $this->set('cards', $this->Cards->find('list')->where($conditions)->order(['Cards.title']));
    }
}