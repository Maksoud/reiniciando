<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* MovimentCards */
/* File: src/Controller/MovimentCardsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Date;
use Cake\Log\Log;

class MovimentCardsController extends AppController
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
        $this->loadComponent('MovimentRecurrentsFunctions');
        
        $this->Cards = TableRegistry::get('Cards');
    }
    
    public function index()
    {
        $this->MovimentRecurrents = TableRegistry::get('MovimentRecurrents');
        
        /**********************************************************************/
        
        //VERIFICA SE HÁ CARTÕES CADASTRADOS
        if ($message = $this->SystemFunctions->validaCadastros("cartão", $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__($message), ['escape' => false]);
        }//if ($message = $this->SystemFunctions->validaCadastros("cartão", $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $movimentRecurrents = $this->MovimentRecurrents->findByParametersId($this->request->Session()->read('sessionParameterControl'));
        $this->set(compact('movimentRecurrents'));
        
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);
        
        $movimentCards = $this->MovimentCards->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                             ->select(['MovimentCards.id', 'MovimentCards.ordem', 'MovimentCards.documento',
                                                       'MovimentCards.title', 'MovimentCards.data', 'MovimentCards.vencimento',
                                                       'MovimentCards.valor', 'MovimentCards.status', 'MovimentCards.creditodebito', 
                                                       'MovimentCards.cards_id', 'MovimentCards.moviments_id',
                                                       'Cards.title', 'Moviments.id', 'Moviments.ordem'
                                                      ])
                                             ->contain(['Cards', 'Moviments'])
                                             ->where($where)
                                             ->order(['MovimentCards.ordem DESC, MovimentCards.vencimento DESC']);
                                     //->limit(200);
        
        /**********************************************************************/
        
        $cards = $this->Cards->find('list')
                             ->where(['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 
                                      'status IN' => ['A', 'T']
                                     ])
                             ->order(['Cards.title']);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        /**********************************************************************/
        
        try {
            
            $movimentCards = $this->paginate($movimentCards);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $movimentCards = $this->paginate($movimentCards);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('movimentCards', 'cards'));
        
    }
    
    public function indexSimple()
    {
        $this->MovimentRecurrents = TableRegistry::get('MovimentRecurrents');
        
        /**********************************************************************/
        
        //VERIFICA SE HÁ CARTÕES CADASTRADOS
        if ($message = $this->SystemFunctions->validaCadastros("cartão", $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__($message), ['escape' => false]);
        }//if ($message = $this->SystemFunctions->validaCadastros("cartão", $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $movimentRecurrents = $this->MovimentRecurrents->findByParametersId($this->request->Session()->read('sessionParameterControl'));
        $this->set(compact('movimentRecurrents'));
        
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);
        
        $movimentCards = $this->MovimentCards->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                             ->select(['MovimentCards.id', 'MovimentCards.ordem', 'MovimentCards.costs_id', 
                                                       'MovimentCards.title', 'MovimentCards.data', 'MovimentCards.vencimento',
                                                       'MovimentCards.valor', 'MovimentCards.status', 'MovimentCards.creditodebito', 
                                                       'MovimentCards.cards_id', 'MovimentCards.moviments_id',
                                                       'Cards.id', 'Cards.title', 
                                                       'Costs.id', 'Costs.title', 
                                                       'Moviments.id', 'Moviments.ordem'
                                                      ])
                                             ->contain(['Cards', 'Moviments', 'Costs'])
                                             ->where($where)
                                             ->order(['MovimentCards.ordem DESC, MovimentCards.vencimento DESC']);
                                     //->limit(200);
        
        /**********************************************************************/
        
        $cards = $this->Cards->find('list')
                             ->where(['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 
                                      'status IN' => ['A', 'T']
                                     ])
                             ->order(['Cards.title']);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        /**********************************************************************/
        
        try {
            
            $movimentCards = $this->paginate($movimentCards);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $movimentCards = $this->paginate($movimentCards);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('movimentCards', 'cards'));
        
    }

    public function view($id)
    {
        $this->MovimentsMovimentCards = TableRegistry::get('MovimentsMovimentCards');
        $this->Moviments              = TableRegistry::get('Moviments');
        
        /**********************************************************************/
        
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $movimentCard = $this->MovimentCards->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                            ->contain(['Parameters', 'Banks', 'Boxes', 
                                                       'Cards', 'Costs', 'EventTypes', 
                                                       'DocumentTypes', 'AccountPlans', 
                                                       'Moviments', 'Customers', 'Providers'
                                                      ])
                                            ->first();
        
        /**********************************************************************/
        
        //CONSULTA O REGISTRO NO CONTAS A PAGAR
        $movimentsmc = $this->MovimentsMovimentCards->find('all')
                                                    ->where(['MovimentsMovimentCards.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                             'MovimentsMovimentCards.cards_id'      => $movimentCard->cards_id,
                                                             'MovimentsMovimentCards.vencimento'    => $movimentCard->vencimento
                                                            ])
                                                    ->first();
        
        /**********************************************************************/
        
        $moviment = $this->Moviments->findByIdAndParametersId($movimentsmc->moviments_id, $this->request->Session()->read('sessionParameterControl'))
                                    ->first();
        
        /**********************************************************************/
        
        $this->set(compact('movimentCard'));
        $this->set(compact('movimentsmc'));
        $this->set(compact('moviment'));
    }

    public function viewSimple($id)
    {
        $this->MovimentsMovimentCards = TableRegistry::get('MovimentsMovimentCards');
        $this->Moviments              = TableRegistry::get('Moviments');
        
        /**********************************************************************/
        
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $movimentCard = $this->MovimentCards->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                            ->contain(['Parameters', 'Banks', 'Boxes', 'Cards', 'Moviments', 'Costs'])
                                            ->first();
        
        /**********************************************************************/
        
        //CONSULTA O REGISTRO NO CONTAS A PAGAR
        $movimentsmc = $this->MovimentsMovimentCards->find('all')
                                                    ->where(['MovimentsMovimentCards.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                             'MovimentsMovimentCards.cards_id'      => $movimentCard->cards_id,
                                                             'MovimentsMovimentCards.vencimento'    => $movimentCard->vencimento
                                                            ])
                                                    ->first();
        
        /**********************************************************************/
        
        $moviment = $this->Moviments->findByIdAndParametersId($movimentsmc->moviments_id, $this->request->Session()->read('sessionParameterControl'))
                                    ->first();
        
        /**********************************************************************/
        
        $this->set(compact('movimentCard'));
        $this->set(compact('movimentsmc'));
        $this->set(compact('moviment'));
    }

    public function add()
    {
        //Acessa a tabela Moviments
        $this->Moviments = TableRegistry::get('Moviments');
        
        /**********************************************************************/
        
        $movimentCard = $this->MovimentCards->newEntity();
        
        /**********************************************************************/
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            $this->request->data['username'] = $_SESSION['Auth']['User']['name'];
            $this->request->data['status']   = 'A';
            $this->request->data['coins_id'] = '1'; //Campo utilizado na versão 1.0 do sistema
            
            /******************************************************************/
            
            if (empty($this->request->data['cards_id'])) { 
                
                $this->Flash->error(__('Desculpe, ocorreu um erro e o registro não foi salvo. Cartão não foi informado'));   
                return $this->redirect($this->referer());
                
            }//if (empty(($this->request->data['cards_id']))
            
            /******************************************************************/

            //Controle de preenchimento de Cliente/Fornecedor
            if ($this->request->data['creditodebito'] == 'C') {

                unset($this->request->data['providers_id']);

                if ($this->request->data['customers_id'] == null) {
                    $this->Flash->warning(__('Desculpe, ocorreu um erro e o registro não foi salvo. Cliente não foi informado'));
                    return $this->redirect($this->referer());
                }//if ($this->request->data['customers_id'] == null)

            } elseif ($this->request->data['creditodebito'] == 'D') {

                unset($this->request->data['customers_id']);

                if ($this->request->data['providers_id'] == null) {
                    $this->Flash->warning(__('Desculpe, ocorreu um erro e o registro não foi salvo. Fornecedor não foi informado'));
                    return $this->redirect($this->referer());
                }//if ($this->request->data['providers_id'] == null)

            }//elseif ($this->request->data['creditodebito'] == 'D')
            
            /******************************************************************/
            
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['valor'] = str_replace($source, $replace, $this->request->data['valor']);
            
            /******************************************************************/
            
            //DEFINE O VALOR DA ORDEM
            $ordem = $this->MovimentCards->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->select(['MAX' => 'MAX(MovimentCards.ordem)'])
                                         ->first();
            $ordem = $ordem->MAX;
            
            /******************************************************************/
            
            //CONTAS RECORRENTES
            if ($this->request->data['dd'] == 'R') {
                
                //CRIA UM NOVO CADASTRO
                $movimentCards = $this->MovimentCards->newEntity();
                
                $movimentCards->ordem      = $ordem += 1;
                $movimentCards->vencimento = $this->MovimentCardsFunctions->calculaVenc($this->request->data['cards_id'], $this->request->data['data'], $this->request->Session()->read('sessionParameterControl')); //CALCULA O VENCIMENTO
                $movimentCards->parameters_id = $this->request->Session()->read('sessionParameterControl');
                
                /**************************************************************/
                
                //SALVA O NOVO REGISTRO
                if (!$this->MovimentCards->save($movimentCards)) {

                    //Alerta de erro
                    $message = 'MovimentCardsController->add, recorrente';
                    $this->Error->registerError($movimentCards, $message, true);
                
                    /**********************************************************/

                    $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                    return $this->redirect($this->referer());

                }//if (!$this->MovimentCards->save($movimentCards))
                
                /**************************************************************/
                
                //REGISTRA MOVIMENTOS RECORRENTES
                $this->MovimentRecurrentsFunctions->addMovimentCardRecurrents($movimentCards->id, $this->request->Session()->read('sessionParameterControl'));
                
                /**************************************************************/
                
                //REGISTRA OS SALDOS - Deduz do limite de crédito (DATA PARA CÁLCULO SERÁ O VENCIMENTO)
                $this->GeneralBalance->balance($movimentCards);
                
                /**************************************************************/
                
                //REGISTRA A CONTA A PAGAR NO CPR
                $this->MovimentCardsFunctions->moviments_moviment_cards($movimentCards);
                
                /**************************************************************/
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            } else { //CONTAS NÃO RECORRENTES
                
                //Entradas parceladas
                $parcela       = 1;
                $parcelas      = $this->request->data['parcelas'];
                $historico     = $this->request->data['title'];
                $documento     = $this->request->data['documento'];
                $data          = new Date(implode('-', array_reverse(explode("/", $this->request->data['data']))));
                $ordem_parcela = $ordem; //Número de ordem crescente nas parcelas
                
                while ($parcela <= $parcelas) {
                    
                    //CRIA UM NOVO CADASTRO
                    $movimentCards = $this->MovimentCards->newEntity($this->request->getData());
                
                    /**********************************************************/
                    
                    //DEFINE VARIÁVEIS
                    $movimentCards->ordem         = $ordem_parcela += 1; //DEFINE O VALOR DA ORDEM
                    $movimentCards->vencimento    = $this->MovimentCardsFunctions->calculaVenc($this->request->data['cards_id'], $data, $this->request->Session()->read('sessionParameterControl'));
                    $movimentCards->coins_id      = '1'; //Campo utilizado na versão 1.0 do sistema
                    $movimentCards->parameters_id = $this->request->Session()->read('sessionParameterControl');
                
                    /**********************************************************/
                    
                    if ($parcelas > 1) {
                        //Modifica o HISTÓRICO e DOCUMENTO adicionando o número de parcelas
                        $movimentCards->title     = $historico . ' (' . $parcela . '/' . $parcelas . ')';
                        $movimentCards->documento = $documento . ' (' . $parcela . '/' . $parcelas . ')';
                    }
                
                    /**********************************************************/
                    
                    //SALVA REGISTROS
                    if (!$this->MovimentCards->save($movimentCards)) {
                        
                        //Alerta de erro
                        $message = 'MovimentCardsController->add, não recorrente';
                        $this->Error->registerError($movimentCards, $message, true);
                
                        /******************************************************/
                        
                        $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                        return $this->redirect($this->referer());

                    }//if (!$this->MovimentCards->save($movimentCards))
                
                    /**********************************************************/
                    
                    //REGISTRA OS SALDOS - Deduz do limite de crédito (DATA PARA CÁLCULO SERÁ O VENCIMENTO)
                    $this->GeneralBalance->balance($movimentCards);
                
                    /**********************************************************/
                    
                    //REGISTRA A CONTA A PAGAR NO CPR (Gravado dentro da função)
                    $this->MovimentCardsFunctions->moviments_moviment_cards($movimentCards);
                    
                    /**********************************************************/
                    
                    if ($parcelas > 1) {
                        //Adiciona periodicidade das parcelas
                        if ($this->request->data['dd'] == '30') {
                            $data = $data->addMonth(1);
                        } elseif ($this->request->data['dd'] == '10') {
                            $data = $data->addDays(10);
                        } elseif ($this->request->data['dd'] == '15') {
                            $data = $data->addDays(15);
                        } elseif ($this->request->data['dd'] == 'bim') {
                            $data = $data->addMonth(2);
                        } elseif ($this->request->data['dd'] == 'tri') {
                            $data = $data->addMonth(3);
                        } elseif ($this->request->data['dd'] == 'sem') {
                            $data = $data->addMonth(6);
                        } elseif ($this->request->data['dd'] == 'anu') {
                            $data = $data->addYear(1);
                        }
                    }//if ($parcelas > 1)
                    
                    $parcela += 1;
                    
                }//while($parcela <= $parcelas)
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
            }
        }
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('customers', $this->MovimentCards->Customers->find('list')->where($conditions)->order(['title']));
        $this->set('providers', $this->MovimentCards->Providers->find('list')->where($conditions)->order(['title']));
        $this->set('cards', $this->MovimentCards->Cards->find('list')->where($conditions)->order(['title']));
        $this->set('costs', $this->MovimentCards->Costs->find('list')->where($conditions)->order(['title']));
        $accountPlans = $this->MovimentCards->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
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
        //Acessa a tabela Moviments
        $this->Moviments = TableRegistry::get('Moviments');
        
        /**********************************************************************/
        
        $movimentCard = $this->MovimentCards->newEntity();
        
        /**********************************************************************/
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/

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
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            $this->request->data['username'] = $_SESSION['Auth']['User']['name'];
            $this->request->data['status']   = 'A';
            $this->request->data['coins_id'] = '1'; //Campo utilizado na versão 1.0 do sistema
            if (empty($this->request->data['contabil'])) { $this->request->data['contabil'] = 'S'; } //Versão gratuita não exibe o campo

            /******************************************************************/
            
            if (empty($this->request->data['cards_id'])) { 
                
                $this->Flash->error(__('Desculpe, ocorreu um erro e o registro não foi salvo. Cartão não foi informado'));   
                return $this->redirect($this->referer());
                
            }//if (empty(($this->request->data['cards_id']))
            
            /******************************************************************/
            
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['valor'] = str_replace($source, $replace, $this->request->data['valor']);
            
            /******************************************************************/
            
            //DEFINE O VALOR DA ORDEM
            $ordem = $this->MovimentCards->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->select(['MAX' => 'MAX(MovimentCards.ordem)'])
                                         ->first();
            $ordem = $ordem->MAX;
            
            /******************************************************************/

            $data = new Date(implode('-', array_reverse(explode("/", $this->request->data['data']))));

            /******************************************************************/
            
            //CONTAS RECORRENTES
            if ($this->request->data['dd'] == 'R') {
                
                //CRIA UM NOVO CADASTRO
                $movimentCards = $this->MovimentCards->newEntity($this->request->getData());
                
                $movimentCards->ordem      = $ordem += 1;
                $movimentCards->vencimento = $this->MovimentCardsFunctions->calculaVenc($this->request->data['cards_id'], $data, $this->request->Session()->read('sessionParameterControl')); //CALCULA O VENCIMENTO
                $movimentCards->parameters_id = $this->request->Session()->read('sessionParameterControl');
                
                /**************************************************************/
                
                //SALVA O NOVO REGISTRO
                if (!$this->MovimentCards->save($movimentCards)) {

                    //Alerta de erro
                    $message = 'MovimentCardsController->addSimple, recorrente';
                    $this->Error->registerError($movimentCards, $message, true);
                
                    /**********************************************************/

                    $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                    return $this->redirect($this->referer());

                }//if (!$this->MovimentCards->save($movimentCards))
                
                /**************************************************************/
                
                //REGISTRA MOVIMENTOS RECORRENTES
                $this->MovimentRecurrentsFunctions->addMovimentCardRecurrents($movimentCards->id, $this->request->Session()->read('sessionParameterControl'));
                
                /**************************************************************/
                
                //REGISTRA OS SALDOS - Deduz do limite de crédito (DATA PARA CÁLCULO SERÁ O VENCIMENTO)
                $this->GeneralBalance->balance($movimentCards);
                
                /**************************************************************/
                
                //REGISTRA A CONTA A PAGAR NO CPR
                $this->MovimentCardsFunctions->moviments_moviment_cards($movimentCards);
                
                /**************************************************************/
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            } else { //CONTAS NÃO RECORRENTES
                
                //Entradas parceladas
                $parcela       = 1;
                $parcelas      = $this->request->data['parcelas'];
                $historico     = $this->request->data['title'];
                $documento     = $this->request->data['documento'];
                $data          = new Date(implode('-', array_reverse(explode("/", $this->request->data['data']))));
                $ordem_parcela = $ordem; //Número de ordem crescente nas parcelas
                
                while ($parcela <= $parcelas) {
                    
                    //CRIA UM NOVO CADASTRO
                    $movimentCards = $this->MovimentCards->newEntity($this->request->getData());
                
                    /**********************************************************/
                    
                    //DEFINE VARIÁVEIS
                    $movimentCards->ordem         = $ordem_parcela += 1; //DEFINE O VALOR DA ORDEM
                    $movimentCards->vencimento    = $this->MovimentCardsFunctions->calculaVenc($this->request->data['cards_id'], $data, $this->request->Session()->read('sessionParameterControl'));
                    $movimentCards->coins_id      = '1'; //Campo utilizado na versão 1.0 do sistema
                    $movimentCards->parameters_id = $this->request->Session()->read('sessionParameterControl');
                
                    /**********************************************************/
                    
                    if ($parcelas > 1) {
                        //Modifica o HISTÓRICO e DOCUMENTO adicionando o número de parcelas
                        $movimentCards->title     = $historico . ' (' . $parcela . '/' . $parcelas . ')';
                    }
                
                    /**********************************************************/

                    //SALVA REGISTROS
                    if (!$this->MovimentCards->save($movimentCards)) {
                        
                        //Alerta de erro
                        $message = 'MovimentCardsController->addSimple, não recorrente';
                        $this->Error->registerError($movimentCards, $message, true);

                        $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                        return $this->redirect($this->referer());

                    }//if (!$this->MovimentCards->save($movimentCards))
                    
                    /**********************************************************/
                    
                    //REGISTRA OS SALDOS - Deduz do limite de crédito (DATA PARA CÁLCULO SERÁ O VENCIMENTO)
                    $this->GeneralBalance->balance($movimentCards);
                
                    /**********************************************************/
                    
                    //REGISTRA A CONTA A PAGAR NO CPR (Gravado dentro da função)
                    $this->MovimentCardsFunctions->moviments_moviment_cards($movimentCards);
                    
                    /**********************************************************/
                    
                    if ($parcelas > 1) {
                        //Adiciona periodicidade das parcelas
                        if ($this->request->data['dd'] == '30') {
                            $data = $data->addMonth(1);
                        } elseif ($this->request->data['dd'] == '10') {
                            $data = $data->addDays(10);
                        } elseif ($this->request->data['dd'] == '15') {
                            $data = $data->addDays(15);
                        } elseif ($this->request->data['dd'] == 'bim') {
                            $data = $data->addMonth(2);
                        } elseif ($this->request->data['dd'] == 'tri') {
                            $data = $data->addMonth(3);
                        } elseif ($this->request->data['dd'] == 'sem') {
                            $data = $data->addMonth(6);
                        } elseif ($this->request->data['dd'] == 'anu') {
                            $data = $data->addYear(1);
                        }
                    }//if ($parcelas > 1)
                    
                    $parcela += 1;
                    
                }//while($parcela <= $parcelas)
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
            }
        }
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('cards', $this->MovimentCards->Cards->find('list')->where($conditions)->order(['title']));
    }

    public function edit($id)
    {
        $movimentCard = $this->MovimentCards->get($id, ['contain' => ['Customers', 'Providers', 'AccountPlans', 'Costs', 'Cards']]);
        
        /**********************************************************************/
        
        if ($this->request->is(['patch', 'post', 'put'])) {
        
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /**********************************************************************/
            
            if ($movimentCard->status != 'A') {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));
                return $this->redirect($this->referer());
            }//if ($movimentCard->status != 'A')
            
            /******************************************************************/
            
            //Registra usuário que está realizando alteração no registro
            $this->request->data['username'] = $_SESSION['Auth']['User']['name'];
            
            /******************************************************************/
            
            //CAMPOS QUE NÃO PERMITEM ALTERAÇÃO
            $this->request->data['parameters_id']     = $movimentCard->parameters_id;
            $this->request->data['banks_id']          = $movimentCard->banks_id;
            $this->request->data['boxes_id']          = $movimentCard->boxes_id;
            $this->request->data['document_types_id'] = $movimentCard->document_types_id;
            $this->request->data['event_types_id']    = $movimentCard->event_types_id;
            $this->request->data['cards_id']          = $movimentCard->cards_id;
            $this->request->data['moviments_id']      = $movimentCard->moviments_id;
            $this->request->data['data']              = $movimentCard->data;
            //$this->request->data['valor']             = $movimentCard->valor; 24/05/2018
            $this->request->data['vencimento']        = $movimentCard->vencimento;
            $this->request->data['contabil']          = $movimentCard->contabil;
            $this->request->data['creditodebito'] ? '' : $this->request->data['creditodebito'] = $movimentCard->creditodebito;
            $this->request->data['dtbaixa']           = $movimentCard->dtbaixa;
            //$this->request->data['valorbaixa']        = $movimentCard->valorbaixa;
            $this->request->data['status']            = $movimentCard->status;
            
            /******************************************************************/
            
            $new_diff_value = null;
            
            //Retira máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['valor'] = (float) str_replace($source, $replace, $this->request->data['valor']);

            /******************************************************************/

            //VERIFICA SE O VALOR É DIFERENTE
            if ($movimentCard->valor != $this->request->data['valor']) {

                //Calcula o valor da diferença 
                $new_diff_value = $this->request->data['valor'] - $movimentCard->valor;

                //Atualiza o campo valorbaixa
                $this->request->data['valorbaixa'] = $this->request->data['valor'];

            } else { //MESMO VALOR

                //Define o valor da diferença 
                $new_diff_value = 0.00;

            }//else if ($movimentCard->valor != $this->request->data['valor'])

            /******************************************************************/

            //VERIFICA SE HOUVE ALTERAÇÕES NO TIPO DE PAGAMENTO (CRÉDITO/DÉBITO)
            if ($movimentCard->valor != $this->request->data['valor'] || $movimentCard->creditodebito != $this->request->data['creditodebito']) {
            
                //ATUALIZA OS SALDOS
                $this->GeneralBalance->setBalance($movimentCard, $new_diff_value, $this->request->data['creditodebito']);
                
            }//if ($movimentCard->valor != $this->request->data['valor'] || $movimentCard->creditodebito != $this->request->data['creditodebito'])

            /******************************************************************/
            
            $movimentCard = $this->MovimentCards->patchEntity($movimentCard, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->MovimentCards->save($movimentCard)) {
                
                if (!empty($new_diff_value)) {
                    
                    //ATUALIZA O VALOR NO MOVIMENTO
                    $this->MovimentCardsFunctions->editValue($movimentCard->moviments_id, $new_diff_value, $this->request->data['creditodebito'], $movimentCard->parameters_id);
                    
                }//if (!empty($new_diff_value))
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->MovimentCards->save($movimentCard))
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('customers', $this->MovimentCards->Customers->find('list')->where($conditions)->order(['title']));
        $this->set('providers', $this->MovimentCards->Providers->find('list')->where($conditions)->order(['title']));
        $this->set('costs', $this->MovimentCards->Costs->find('list')->where($conditions)->order(['title']));
        $this->set('cards', $this->MovimentCards->Cards->find('list')->where($conditions)->order(['title']));
        $accountPlans = $this->MovimentCards->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
                                                      ->where($conditions)
                                                      ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($movimentCard->data)) {
            $movimentCard->data = date("d/m/Y", strtotime($movimentCard->data));
        }//if (!empty($movimentCard->data))
        if (!empty($movimentCard->vencimento)) {
            $movimentCard->vencimento = date("d/m/Y", strtotime($movimentCard->vencimento));
        }//if (!empty($movimentCard->vencimento))
        
        $this->set(compact('movimentCard'));
        
    }

    public function editSimple($id)
    {
        $movimentCard = $this->MovimentCards->get($id, ['contain' => ['Cards', 'Costs']]);
        
        /**********************************************************************/
        
        if ($this->request->is(['patch', 'post', 'put'])) {
        
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /**********************************************************************/

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
            
            if ($movimentCard->status != 'A') {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));
                return $this->redirect($this->referer());
            }//if ($movimentCard->status != 'A')
            
            /******************************************************************/
            
            //Registra usuário que está realizando alteração no registro
            $this->request->data['username'] = $_SESSION['Auth']['User']['name'];

            /******************************************************************/
            
            //CAMPOS QUE NÃO PERMITEM ALTERAÇÃO
            $this->request->data['parameters_id']     = $movimentCard->parameters_id;
            $this->request->data['banks_id']          = $movimentCard->banks_id;
            $this->request->data['boxes_id']          = $movimentCard->boxes_id;
            $this->request->data['cards_id']          = $movimentCard->cards_id;
            $this->request->data['moviments_id']      = $movimentCard->moviments_id;
            $this->request->data['data']              = $movimentCard->data;
            //$this->request->data['valor']             = $movimentCard->valor; 24/05/2018
            $this->request->data['vencimento']        = $movimentCard->vencimento;
            $this->request->data['contabil']          = $movimentCard->contabil;
            $this->request->data['creditodebito'] ? '' : $this->request->data['creditodebito'] = $movimentCard->creditodebito;
            $this->request->data['dtbaixa']           = $movimentCard->dtbaixa;
            //$this->request->data['valorbaixa']        = $movimentCard->valorbaixa;
            $this->request->data['status']            = $movimentCard->status;
            
            /******************************************************************/
            
            $new_diff_value = null;
            
            //Retira máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['valor'] = (float) str_replace($source, $replace, $this->request->data['valor']);

            /******************************************************************/

            //VERIFICA SE O VALOR É DIFERENTE
            if ($movimentCard->valor != $this->request->data['valor']) {

                //Calcula o valor da diferença 
                $new_diff_value = $this->request->data['valor'] - $movimentCard->valor;

                //Atualiza o campo valorbaixa
                $this->request->data['valorbaixa'] = $this->request->data['valor'];

            } else { //MESMO VALOR

                //Define o valor da diferença 
                $new_diff_value = 0.00;

            }//else if ($movimentCard->valor != $this->request->data['valor'])

            /******************************************************************/

            //VERIFICA SE HOUVE ALTERAÇÕES NO TIPO DE PAGAMENTO (CRÉDITO/DÉBITO)
            if ($movimentCard->valor != $this->request->data['valor'] || $movimentCard->creditodebito != $this->request->data['creditodebito']) {
            
                //ATUALIZA OS SALDOS
                $this->GeneralBalance->setBalance($movimentCard, $new_diff_value, $this->request->data['creditodebito']);
                
            }//if ($movimentCard->valor != $this->request->data['valor'] || $movimentCard->creditodebito != $this->request->data['creditodebito'])

            /******************************************************************/
            
            $movimentCard = $this->MovimentCards->patchEntity($movimentCard, $this->request->getData());

            /******************************************************************/
            
            if ($this->MovimentCards->save($movimentCard)) {
                
                if (!empty($new_diff_value)) {
                    
                    //ATUALIZA O VALOR NO MOVIMENTO
                    $this->MovimentCardsFunctions->editValue($movimentCard->moviments_id, $new_diff_value, $this->request->data['creditodebito'], $movimentCard->parameters_id);
                    
                }//if (!empty($new_diff_value))
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->MovimentCards->save($movimentCard))
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('costs', $this->MovimentCards->Costs->find('list')->where($conditions)->order(['title']));
        $this->set('cards', $this->MovimentCards->Cards->find('list')->where($conditions)->order(['title']));
        
        /**********************************************************************/
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($movimentCard->data)) {
            $movimentCard->data = date("d/m/Y", strtotime($movimentCard->data));
        }//if (!empty($movimentCard->data))
        if (!empty($movimentCard->vencimento)) {
            $movimentCard->vencimento = date("d/m/Y", strtotime($movimentCard->vencimento));
        }//if (!empty($movimentCard->vencimento))
        
        /**********************************************************************/
        
        $this->set(compact('movimentCard'));
        
    }
    
    public function editaVenc($id, $direction) //changevenc
    {
        $return = $this->MovimentCardsFunctions->editaVenc($id, $direction, $this->request->Session()->read('sessionParameterControl'));
        
        /**********************************************************************/
        
        if ($return) {
            
            $this->Flash->success(__('Vencimento alterado com sucesso'));
            return $this->redirect($this->referer());
            
        } else {
            
            $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
            return $this->redirect($this->referer());
            
        }//else if ($return)

    }
    
    public function delete($id)
    {
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
        
        $movimentCard = $this->MovimentCards->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                            ->first();
        
        /**********************************************************************/

        if (!empty($movimentCard)) {

            //REGISTRA OS SALDOS - Repõe ao limite de crédito
            $this->GeneralBalance->balance($movimentCard, true);
            
            /******************************************************************/
            
            //REGISTRA A CONTA A PAGAR NO CPR
            $this->MovimentCardsFunctions->moviments_moviment_cards($movimentCard, true);
            
            /******************************************************************/
            
            //EXCLUI DA LISTA DE LANÇAMENTOS RECORRENTES
            $this->MovimentRecurrentsFunctions->deleteMovimentRecurrents($id, $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($movimentCard, 'delete', 'MovimentCards');
            
            /******************************************************************/
            
            if ($this->MovimentCards->delete($movimentCard)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->MovimentCards->delete($movimentCard))

        }//if (!empty($movimentCard))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'MovimentCardsController->delete';
        $this->Error->registerError($movimentCard, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table   = 'MovimentCards';
        $where   = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['title_search'])) { 
            $where[] = '('.$table.'.title LIKE "%'.$this->params['title_search'].
                       '%" OR '.$table.'.documento LIKE "%'.$this->params['title_search'].'%")';
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
        
        if (!empty($this->params['cards_id_search'])) { 
            $where[] = '('.'cards.id = "'.$this->params['cards_id_search'].'")';
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
        $this->Costs        = TableRegistry::get('Costs');
        $this->AccountPlans = TableRegistry::get('AccountPlans');
        $this->Balances     = TableRegistry::get('Balances');
        $this->Parameters   = TableRegistry::get('Parameters');
            
        /**********************************************************************/
        
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
            $conditions  = ['MovimentCards.parameters_id' => $this->request->Session()->read('sessionParameterControl')];

            if (!empty($dtinicial) && !empty($dtfinal)) {
                $data = ['MovimentCards.vencimento BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"'];
                $conditions = array_merge($conditions, $data);
            }
            
            if ($this->request->data['cards_id']) {
                $cartao = ['MovimentCards.cards_id IN (' . implode(', ', $this->request->data['cards_id']) . ')'];
                $conditions = array_merge($conditions, $cartao);
            }
            
            if ($this->request->data['creditodebito']) {
                $creditodebito = ['MovimentCards.creditodebito LIKE' => $this->request->data['creditodebito']];
                $conditions = array_merge($conditions, $creditodebito);
            }
            
            if ($this->request->data['account_plans_id']) {
                $accountPlans = ['MovimentCards.account_plans_id LIKE' => $this->request->data['account_plans_id']];
                $conditions = array_merge($conditions, $accountPlans);
                
                $accountPlan = $this->AccountPlans->findByIdAndParametersId($this->request->data['account_plans_id'], $this->request->Session()->read('sessionParameterControl'))
                                                  ->select(['AccountPlan.title'])
                                                  ->first();
                $this->set('accountPlan', $accountPlan);
            }
            
            if ($this->request->data['costs_id']) {
                $costs = ['MovimentCards.costs_id LIKE' => $this->request->data['costs_id']];
                $conditions = array_merge($conditions, $costs);
                
                $cost = $this->Costs->findByIdAndParametersId($this->request->data['costs_id'], $this->request->Session()->read('sessionParameterControl'))
                                    ->select(['Cost.title'])
                                    ->first();
                $this->set('cost', $cost);
            }
            
            if (!empty($this->request->data['contabil'])) {
                $contabil = ['MovimentCards.contabil' => $this->request->data['contabil']];
                $conditions = array_merge($conditions, $contabil);
            }
            //if ($this->request->data['Ordem']) {
                $order = 'MovimentCards.cards_id, MovimentCards.vencimento';
            //}
            if ($this->request->data['Situação'] == 'aberto') {
                $situacao = ['MovimentCards.status' => 'A',
                             'MovimentCards.dtbaixa IS NULL',
                             'MovimentCards.valorbaixa IS NULL'
                            ];
                $conditions = array_merge($conditions, $situacao);
            } elseif ($this->request->data['Situação'] == 'baixado') {
                $situacao = ['MovimentCards.status' => 'B',
                             //'MovimentCards.dtbaixa BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"',
                             //'MovimentCards.valorbaixa IS NOT NULL'
                            ];
                $conditions = array_merge($conditions, $situacao);
            }
            
            /******************************************************************/
            
            //BUSCA SALDO INCIAL
            $bal_dtinicial = '2000-01-01 00:00:00';
            $bal_dtfinal   = date('Y-m-d', strtotime($dtinicial.'-1 day'));
            
            /******************************************************************/
            
            $balances = $this->Balances->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['Balances.cards_id', 'Balances.value'])
                                       ->where(function ($exp, $q) use ($bal_dtinicial, $bal_dtfinal) {
                                                return $exp->between('Balances.date', $bal_dtinicial, $bal_dtfinal);
                                               })
                                       ->where(['Balances.cards_id IS NOT NULL'])
                                       ->order(['Balances.cards_id']);
            
            /******************************************************************/
            
            $fields = ['MovimentCards.id',
                       'MovimentCards.cards_id',
                       'MovimentCards.costs_id',
                       'MovimentCards.account_plans_id',
                       'MovimentCards.data',
                       'MovimentCards.vencimento',
                       'MovimentCards.creditodebito',
                       'MovimentCards.valor',
                       'MovimentCards.ordem',
                       'MovimentCards.documento',
                       'MovimentCards.title',
                       'MovimentCards.contabil',
                       'MovimentCards.status',
                       'MovimentCards.username',
                       'Cards.title',
                       'Costs.title',
                       'AccountPlans.title'
                      ];
            
            $movimentCards = $this->MovimentCards->find('all')
                                                 ->select($fields)
                                                 ->where($conditions)
                                                 ->contain(['Cards', 'Costs', 'AccountPlans'])
                                                 ->order($order);
            
            foreach($movimentCards as $value):
                $cards[$value->cards_id] = $value->Cards['title'];
            endforeach;
            
            /******************************************************************/
            
            $this->set(compact('cards', 'balances', 'movimentCards'));
            
            /******************************************************************/
            
            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());
            
            /******************************************************************/
            
            if ($this->request->data['Tipo'] == 'movimentCard') {
                $this->render('reports/movimentCard');
            }
            
        }
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('cards', $this->MovimentCards->Cards->find('list', ['conditions' => $conditions, 'order' => 'title']));
        $this->set('costs', $this->MovimentCards->Costs->find('list', ['conditions' => $conditions, 'order' => 'title']));
        $accountPlans = $this->MovimentCards->AccountPlans->find('list', ['keyField' => 'id', 'valueField' => 'dropdown_accounts'])
                                                          ->where($conditions)
                                                          ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
    }
    
    public function reportFormSimple() //Adicionar período
    {
        $this->Costs        = TableRegistry::get('Costs');
        $this->Balances     = TableRegistry::get('Balances');
        $this->Parameters   = TableRegistry::get('Parameters');
            
        /**********************************************************************/
        
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
            
            //Versão gratuita não exibe o campo
            if (empty($this->request->data['contabil'])) { 
                $this->request->data['contabil'] = 'S'; 
            } 

            /******************************************************************/
            
            // MONTAGEM DO SQL
            $conditions  = ['MovimentCards.parameters_id' => $this->request->Session()->read('sessionParameterControl')];

            if (!empty($dtinicial) && !empty($dtfinal)) {
                $data = ['MovimentCards.vencimento BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"'];
                $conditions = array_merge($conditions, $data);
            }
            
            if ($this->request->data['cards_id']) {
                $cartao = ['MovimentCards.cards_id IN (' . implode(', ', $this->request->data['cards_id']) . ')'];
                $conditions = array_merge($conditions, $cartao);
            }
            
            if ($this->request->data['creditodebito']) {
                $creditodebito = ['MovimentCards.creditodebito LIKE' => $this->request->data['creditodebito']];
                $conditions = array_merge($conditions, $creditodebito);
            }
            
            if ($this->request->data['costs_id']) {
                $costs = ['MovimentCards.costs_id LIKE' => $this->request->data['costs_id']];
                $conditions = array_merge($conditions, $costs);
                
                $cost = $this->Costs->findByIdAndParametersId($this->request->data['costs_id'], $this->request->Session()->read('sessionParameterControl'))
                                    ->select(['Cost.title'])
                                    ->first();
                $this->set('cost', $cost);
            }
            
            if (!empty($this->request->data['contabil'])) {
                $contabil = ['MovimentCards.contabil' => $this->request->data['contabil']];
                $conditions = array_merge($conditions, $contabil);
            }
            //if ($this->request->data['Ordem']) {
                $order = 'MovimentCards.cards_id, MovimentCards.vencimento';
            //}
            if ($this->request->data['Situação'] == 'aberto') {
                $situacao = ['MovimentCards.status' => 'A',
                             'MovimentCards.dtbaixa IS NULL',
                             'MovimentCards.valorbaixa IS NULL'
                            ];
                $conditions = array_merge($conditions, $situacao);
            } elseif ($this->request->data['Situação'] == 'baixado') {
                $situacao = ['MovimentCards.status' => 'B',
                             //'MovimentCards.dtbaixa BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"',
                             //'MovimentCards.valorbaixa IS NOT NULL'
                            ];
                $conditions = array_merge($conditions, $situacao);
            }
            
            /******************************************************************/
            
            //BUSCA SALDO INCIAL
            $bal_dtinicial = '2000-01-01 00:00:00';
            $bal_dtfinal   = date('Y-m-d', strtotime($dtinicial.'-1 day'));
            
            /******************************************************************/
            
            $balances = $this->Balances->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['Balances.cards_id', 'Balances.value'])
                                       ->where(function ($exp, $q) use ($bal_dtinicial, $bal_dtfinal) {
                                                return $exp->between('Balances.date', $bal_dtinicial, $bal_dtfinal);
                                               })
                                       ->where(['Balances.cards_id IS NOT NULL'])
                                       ->order(['Balances.cards_id']);
            
            /******************************************************************/
            
            $fields = ['MovimentCards.id',
                       'MovimentCards.cards_id',
                       'MovimentCards.costs_id',
                       'MovimentCards.data',
                       'MovimentCards.vencimento',
                       'MovimentCards.creditodebito',
                       'MovimentCards.valor',
                       'MovimentCards.ordem',
                       'MovimentCards.documento',
                       'MovimentCards.title',
                       'MovimentCards.contabil',
                       'MovimentCards.status',
                       'MovimentCards.username',
                       'Cards.title',
                       'Costs.title',
                       'AccountPlans.title'
                      ];
            
            $movimentCards = $this->MovimentCards->find('all')
                                                 ->select($fields)
                                                 ->where($conditions)
                                                 ->contain(['Cards', 'Costs', 'AccountPlans'])
                                                 ->order($order);
            
            foreach($movimentCards as $value):
                $cards[$value->cards_id] = $value->Cards['title'];
            endforeach;
            
            /******************************************************************/
            
            $this->set(compact('cards', 'balances', 'movimentCards'));
            
            /******************************************************************/
            
            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());
            
            /******************************************************************/
            
            if ($this->request->data['Tipo'] == 'movimentCard') {
                $this->render('reports/simple/movimentCard');
            }
            
        }
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('cards', $this->MovimentCards->Cards->find('list', ['conditions' => $conditions, 'order' => 'title']));
        $this->set('costs', $this->MovimentCards->Costs->find('list', ['conditions' => $conditions, 'order' => 'title']));
        
    }
    
    public function calculaVencJson()
    {
        //EM DESENVOLVIMENTO 02/04/2018
        if ($this->request->is('get')) {
            
            if (isset($this->request->query['cards_id']) && isset($this->request->query['dt_lancamento'])) {
                
                //Formata a data do lançamento
                $dt_lancamento = implode('-', array_reverse(explode('/', $this->request->query['dt_lancamento'])));
                $dt_lancamento = new Date(date("Y-m-d", strtotime($dt_lancamento)));
                
                //Envia para o component para cálculo
                $dt_vencimento = $this->MovimentCardsFunctions->calculaVenc($this->request->query['cards_id'], $dt_lancamento, $this->request->Session()->read('sessionParameterControl'));
                
                //Formata a data do vencimento
                $dt_vencimento = date('d/m/Y', strtotime($dt_vencimento));
                
            }//if (isset($this->request->query['cards_id']) && isset($this->request->query['dt_lancamento']))
            
            echo json_encode($dt_vencimento);
            
        }//if ($this->request->is('get'))
        
        $this->autoRender = false;
        die();
    }
    
}