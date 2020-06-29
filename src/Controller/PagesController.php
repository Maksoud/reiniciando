<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Pages */
/* File: src/Controller/PagesController.php */

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\I18n;
use Cake\Log\Log;

class PagesController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['login', 'logout', 'cadastrar', 'reenviaSenha', 'recuperaSenha']);

        $this->loadComponent('EmailFunctions');
    }
    
    public function home()
    {
        //SESSION
        $this->set('version', $this->request->Session()->read('version'));
        
        //DEBUG
        //$this->set('debug', Configure::read('debug'));
        
        //VERIFICA SE O CADASTRO ESTÁ COMPLETO
        if ($message = $this->SystemFunctions->validaCadastros("cadastro", $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__($message), ['escape' => false]);
        }
        
        /**********************************************************************/
        /* MODELS LOADINGS */
        
        $this->Moviments          = TableRegistry::get('Moviments');
        $this->MovimentRecurrents = TableRegistry::get('MovimentRecurrents');
        $this->MovimentMergeds    = TableRegistry::get('MovimentMergeds');
        $this->MovimentBanks      = TableRegistry::get('MovimentBanks');
        $this->MovimentBoxes      = TableRegistry::get('MovimentBoxes');
        $this->AccountPlans       = TableRegistry::get('AccountPlans');
        $this->Plannings          = TableRegistry::get('Plannings');
        $this->Transfers          = TableRegistry::get('Transfers');
        $this->Balances           = TableRegistry::get('Balances');
        $this->Knowledges         = TableRegistry::get('Knowledges');
        
        /**********************************************************************/
        $this->set('username', $this->Auth->user('name'));
        /**********************************************************************/
        /* MOVIMENTOS RECORRENTES */
        
        $movimentRecurrents = $this->MovimentRecurrents->findByParametersId($this->request->Session()->read('sessionParameterControl'));
        $this->set('movimentRecurrents', $movimentRecurrents->toArray());
        
        /**********************************************************************/
        /* ACCOUNTPLANS */
        
        $accountPlans = $this->AccountPlans->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->select(['AccountPlans.id', 'AccountPlans.classification', 'AccountPlans.title'])
                                           ->order(['AccountPlans.classification']);
        
        /**********************************************************************/
        /**********************************************************************/
        /* MOVIMENTOS VINCULADOS/PARCIAIS */
        
        $movimentMergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                           'Moviments.id', 'Moviments.valorbaixa', 'Moviments.valor', 'Moviments.vencimento', 'Moviments.status', 
                                                           'Moviment_Mergeds.id', 'Moviment_Mergeds.ordem', 'Moviment_Mergeds.valor', 'Moviment_Mergeds.valorbaixa', 
                                                           'Moviment_Mergeds.data', 'Moviment_Mergeds.dtbaixa', 'Moviment_Mergeds.vencimento', 'Moviment_Mergeds.status',
                                                           'Moviment_Mergeds.documento', 'Moviment_Mergeds.historico'
                                                          ])
                                                 ->order(['Moviments.vencimento, Moviments.id DESC'])
                                                 ->join(['Moviments' => ['table'      => 'Moviments',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                        ],
                                                         'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                              ]
                                                        ]);
        
        $this->set('movimentMergeds', $movimentMergeds);
        
        /**********************************************************************/
        
        $dtinicial = date('Y-m-d', strtotime(date('Y-m-01')));
        $dtfinal   = date('Y-m-t');
        
        /**********************************************************************/
        
        $movplans = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                    ->select(['Moviments.id', 'Moviments.valor', 'Moviments.status', 
                                              'Moviments.account_plans_id', 'AccountPlans.id', 
                                              'AccountPlans.title'
                                             ])
                                    ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                             return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                            })
                                    ->where(['Moviments.status IN' => ['A', 'P', 'G'],
                                             'Moviments.dtbaixa IS NULL'
                                            ])
                                    ->order(['Moviments.vencimento DESC'])
                                    ->contain(['AccountPlans']);
        
        if (!empty($accountPlans->toArray())) {
            
            foreach ($accountPlans as $index => $accountPlan):
                //$accountPlan = array_merge($accountPlan, ['valor' => '0.00'));
                $accountPlan->set(['valor' => '0.00']);
                $valorpago = 0;
                
                foreach ($movplans as $moviment):
                    
                    if ($moviment->account_plans_id == $accountPlan->id) {
                        
                        if ($moviment->status == 'P') {
                            
                            foreach ($movimentMergeds as $merged):
                                
                                if ($merged->moviments_id == $moviment->id) {
                                    if ($merged->status == 'O' || $merged->status == 'B') {
                                        $valorpago += $merged->valorbaixa;
                                    }
                                }//if ($merged->moviments_id == $moviment->id)
                                
                            endforeach;
                            $accountPlan->valor += $moviment->valor - $valorpago;
                            
                        } else {
                            $accountPlan->valor += $moviment->valor;
                        }
                        
                    }//if ($moviment->account_plans_id == $accountPlan->id)
                    
                endforeach;
                
                //$accountPlans[$index] = $accountPlan;
            endforeach;
            
            $this->set('accountPlans', $accountPlans->toArray());
        }
        
        /**********************************************************************/
        
        /* BALANCE */
        
        //Saldos de bancos e caixas
        $this->set('saldos', $this->saldos());
        
        /**********************************************************************/
        /**********************************************************************/
        /* MOVIMENTOS */

        $inicio     = "1986-02-08";
        $fim        = date("Y-m-t");
        
        /**********************************************************************/
        
        $moviments  = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                      ->where(function ($exp, $q) use($inicio, $fim) {
                                               return $exp->between('Moviments.vencimento', $inicio, $fim);
                                              })
                                      ->where(['Moviments.status IN' => ['A', 'P', 'G']])
                                      ->contain(['Customers', 'Providers'])
                                      ->order(['Moviments.vencimento, Moviments.id DESC']);
        
        /**********************************************************************/
        
        /* CRÉDITOS */
        if (!empty($moviments->toArray())) {

            foreach ($moviments as $index => $moviment):
                if ($moviment->creditodebito == 'C') {
                    $creditos[$index] = $moviment;
                }
            endforeach;

        }//if (!empty($moviments->toArray()))
        
        if (isset($creditos)) {
            $this->set('creditos', $creditos);
        }
        
        /**********************************************************************/
        
        /* DÉBITOS */
        if (!empty($moviments->toArray())) {
            
            foreach ($moviments as $index => $moviment):
                if ($moviment->creditodebito == 'D') {
                    $debitos[$index] = $moviment;
                }
            endforeach;

        }//if (!empty($moviments->toArray()))
        
        if (isset($debitos)) {
            $this->set('debitos', $debitos);
        }
        
        /**********************************************************************/
        /**********************************************************************/
        
        $dtinicial = $dtfinal = date('Y-m-d');
        
        /**********************************************************************/
        
        /* CRÉDITOS NO DIA ATUAL */
        $creditos_dia = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                        ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                  return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                                })
                                        ->where(['Moviments.status IN' => ['A', 'P'],
                                                 'Moviments.creditodebito LIKE' => 'C'
                                                ])
                                        ->order(['Moviments.vencimento DESC']);
        
        $this->set('creditos_dia', $creditos_dia->toArray());
        
        /**********************************************************************/
        
        /* DÉBITOS NO DIA ATUAL */
        $debitos_dia = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                               })
                                       ->where(['Moviments.status IN' => ['A', 'P'],
                                                'Moviments.creditodebito LIKE' => 'D'
                                               ])
                                       ->order(['Moviments.vencimento DESC']);
        
        $this->set('debitos_dia', $debitos_dia->toArray());
        
        /**********************************************************************/
        /**********************************************************************/
        
        $dtfinal = date('Y-m-d', strtotime($dtinicial) - 86400);
        $dtinicial =  '1986-02-08';
        
        /**********************************************************************/
        
        /* DÉBITOS EM ATRASO */
        $debitos_late = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                        ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                 return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                                })
                                        ->where(['Moviments.status IN' => ['A', 'P'],
                                                 'Moviments.creditodebito LIKE' => 'D'
                                                ])
                                        ->order(['Moviments.vencimento DESC']);
        
        $this->set('debitos_late', $debitos_late->toArray());
        
        /**********************************************************************/
        
        /* CRÉDITOS EM ATRASO */
        $creditos_late = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                  return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                                 })
                                         ->where(['Moviments.status IN' => ['A', 'P'],
                                                  'Moviments.creditodebito LIKE' => 'C'
                                                 ])
                                         ->order(['Moviments.vencimento DESC']); 
        
        $this->set('creditos_late', $creditos_late->toArray());
        
        /**********************************************************************/
        /**********************************************************************/
        
        $dtinicial = date('Y-m-d', strtotime(date('Y-m-d')) + 86400);
        $dtfinal    = date('Y-m-t');
        
        /**********************************************************************/
        
        /* DÉBITOS FUTUROS */
        $debitos_future = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                          ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                   return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                                  })
                                          ->where(['Moviments.status IN' => ['A', 'P'],
                                                   'Moviments.creditodebito LIKE' => 'D'
                                                  ])
                                          ->order(['Moviments.vencimento DESC']);
        
        $this->set('debitos_future', $debitos_future->toArray());
        
        /**********************************************************************/
        
        /* CRÉDITOS FUTUROS*/
        $creditos_future = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                    return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                                   })
                                           ->where(['Moviments.status IN' => ['A', 'P'],
                                                    'Moviments.creditodebito LIKE' => 'C'
                                                   ])
                                           ->order(['Moviments.vencimento DESC']);
        
        $this->set('creditos_future', $creditos_future->toArray());
        
        /**********************************************************************/
        
        /* PROGRAMAÇÕES FINANCEIRAS */
        $transfers = $this->Transfers->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->where(['Transfers.programacao IS NOT NULL']);
        
        $this->set('transfers', $transfers->toArray());
        
        /**********************************************************************/
        /**********************************************************************/
        
        /* FATURAS DE CARTÕES DE CRÉDITO */
        $dtinicial = date('Y-m-t', strtotime("-3 years"));
        $dtfinal   = date('Y-m-t', strtotime("+60 days"));
        
        /**********************************************************************/
        
        $faturas_cartoes = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->select(['Moviments.status', 'Moviments.cards_id', 'Moviments.vencimento', 
                                                     'Moviments.parameters_id', 'Moviments.valor', 'Moviments.id',  
                                                     'Cards.id', 'Cards.title', 'Cards.status'
                                                    ])
                                           ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                    return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                                   })
                                           ->where(['Moviments.status IN' => ['A', 'P'],
                                                    'Moviments.cards_id IS NOT NULL'
                                                   ])
                                           ->contain(['Cards'])
                                           ->order(['Moviments.vencimento, Moviments.cards_id']);
        
        $this->set('faturas_cartoes', $faturas_cartoes);
        
        /**********************************************************************/
        /**********************************************************************/
        
        /* SAÚDE FINANCEIRA - GRÁFICO */
        $dtinicial = date('Y-01-01');
        $dtfinal   = date('Y-12-31');
        
        /**********************************************************************/
        
        //INICIALIZAÇÃO DAS VARIÁVEIS
        $m = 1;
        while ($m <= 12) {
            $m                   = str_pad($m, 2, "0", STR_PAD_LEFT);
            $receitas[$m]        = 0; //Receitas Orçadas
            $despesas[$m]        = 0; //Despesas Orçadas
            $receitas_r[$m]      = 0; //Receitas Realizadas
            $despesas_r[$m]      = 0; //Despesas Realizadas
            $orcado[$m]          = 0; //Resumo Orçado
            $realizado[$m]       = 0; //Resumo Realizado
            $saude_media_ano[$m] = 0; //Orçado quando não realizado
            $m++;
        }
        
        /**********************************************************************/
        
        //MOVIMENTOS FINANCEIROS
        $moviments_venc = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                          ->select(['Moviments.id', 'Moviments.ordem', 'Moviments.parameters_id', 
                                                    'Moviments.data', 'Moviments.vencimento', 'Moviments.dtbaixa', 
                                                    'Moviments.valor', 'Moviments.valorbaixa', 'Moviments.creditodebito', 
                                                    'Moviments.contabil', 'Moviments.status'
                                                   ])
                                          ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                   return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                                  })
                                          ->order(['Moviments.vencimento'])
                                          ->toArray();//Utilizado devido ao array_push abaixo 08/02/2018
        
        if (!empty($moviments_venc)) {
            
            //MOVIMENTOS FINANCEIROS RECORRENTES
            $movimentRecurrents = $this->MovimentRecurrents->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                           ->select(['Moviments.id', 'Moviments.parameters_id', 'Moviments.ordem', 'Moviments.banks_id', 
                                                                     'Moviments.boxes_id', 'Moviments.cards_id', 'Moviments.costs_id', 'Moviments.event_types_id', 
                                                                     'Moviments.providers_id', 'Moviments.customers_id', 'Moviments.document_types_id', 
                                                                     'Moviments.account_plans_id', 'Moviments.data', 'Moviments.vencimento', 
                                                                     'Moviments.dtbaixa', 'Moviments.historico', 'Moviments.valor', 'Moviments.valorbaixa', 
                                                                     'Moviments.documento', 'Moviments.cheque', 'Moviments.nominal', 'Moviments.emissaoch', 
                                                                     'Moviments.creditodebito', 'Moviments.contabil', 'Moviments.status', 
                                                                     'Banks.title', 'Boxes.title', 'Cards.title', 'Costs.title', 'EventTypes.title', 'Providers.title', 
                                                                     'Customers.title', 'DocumentTypes.title', 'AccountPlans.id', 'AccountPlans.title', 
                                                                     'AccountPlans.classification', 'AccountPlans.parameters_id', 'Parameters.id'
                                                                    ])
                                                           ->join(['Moviments' => ['table'      => 'Moviments',
                                                                                   'type'       => 'LEFT',
                                                                                   'conditions' => 'Moviments.id = MovimentRecurrents.moviments_id'
                                                                                  ],
                                                                   'Banks' => ['table'      => 'Banks',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'Banks.id = Moviments.banks_id'
                                                                              ],
                                                                   'Boxes' => ['table'      => 'Boxes',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'Boxes.id = Moviments.boxes_id'
                                                                              ],
                                                                   'Cards' => ['table'      => 'Cards',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'Cards.id = Moviments.cards_id'
                                                                              ],
                                                                   'Costs' => ['table'      => 'Costs',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'Costs.id = Moviments.costs_id'
                                                                              ],
                                                                   'EventTypes' => ['table'      => 'event_types',
                                                                                    'type'       => 'LEFT',
                                                                                    'conditions' => 'EventTypes.id = Moviments.event_types_id'
                                                                                   ],
                                                                   'Providers' => ['table'      => 'Providers',
                                                                                   'type'       => 'LEFT',
                                                                                   'conditions' => 'Providers.id = Moviments.providers_id'
                                                                                  ],
                                                                   'Customers' => ['table'      => 'Customers',
                                                                                   'type'       => 'LEFT',
                                                                                   'conditions' => 'Customers.id = Moviments.customers_id'
                                                                                  ],
                                                                   'DocumentTypes' => ['table'      => 'document_types',
                                                                                       'type'       => 'LEFT',
                                                                                       'conditions' => 'DocumentTypes.id = Moviments.document_types_id'
                                                                                      ],
                                                                   'AccountPlans' => ['table'      => 'account_plans',
                                                                                      'type'       => 'LEFT',
                                                                                      'conditions' => 'AccountPlans.id = Moviments.account_plans_id'
                                                                                     ],
                                                                   'Parameters' => ['table'      => 'Parameters',
                                                                                    'type'       => 'LEFT',
                                                                                    'conditions' => 'Parameters.id = Moviments.parameters_id'
                                                                                   ]
                                                                  ]);
            
            /******************************************************************/
            
            if (!empty($movimentRecurrents->toArray())) {
                
                //IDENTIFICA OS MOVIMENTOS RECORRENTES
                foreach ($movimentRecurrents as $movimentRecurrent):
                    
                    for($count = 1; $count < 12; $count++) {
                        
                        if ($movimentRecurrent->Moviments['contabil'] == 'S') { //CONTABILIZA APENAS LANÇAMENTOS CONTÁBEIS
                            
                            $movimentRecurrent->Moviments['vencimento'] = date("Y-m-d", strtotime("+1 month", strtotime($movimentRecurrent->Moviments['vencimento'])));
                            $movimentRecurrent->Moviments['id']         = '0';
                            $movimentRecurrent->Moviments['ordem']      = 'RECORRENTE';
                            $movimentRecurrent->Moviments['dtbaixa']    = null; //CONTROLE DE LANÇAMENTOS EM ABERTO
                            
                            //ADICIONA PROVISIONAMENTO DEVIDO A RECORRÊNCIA
                            array_push($moviments_venc, (object)$movimentRecurrent->Moviments);
                            
                        }//if ($movimentRecurrent->Moviments['contabil'] == 'S')
                        
                    }//for($count = 1; $count < 12; $count++)
                    
                endforeach;
                
            }
            
            /******************************************************************/
            
            foreach ($moviments_venc as $moviment):
                
                $vencimento = explode("-", $moviment->vencimento);
                $mes = $vencimento[1];
                $ano = $vencimento[0];
                
                if (empty($moviment->dtbaixa)) {
                    
                    if ($ano == date('Y')) { 
                        
                        if ($moviment->contabil == 'S') { //CONTABILIZA APENAS LANÇAMENTOS CONTÁBEIS
                            
                            if ($moviment->creditodebito == 'C') {
                                
                                $receitas[$mes] += $moviment->valor; //orçado
                                //if ($mes=='02') {echo $moviment->ordem.': +'.$moviment->valor.'<br>';}
                                
                            } elseif ($moviment->creditodebito == 'D') {
                                
                                $despesas[$mes] += $moviment->valor; //orçado
                                //if ($mes=='02') {echo $moviment->ordem.': -'.$moviment->valor.'<br>';}
                                
                            }//if ($moviment->creditodebito == 'C')
                            
                            //DEDUZ BAIXAS PARCIAIS
                            foreach($movimentMergeds as $mergeds):
                                
                                if ($moviment->id == $mergeds->Moviments['id']) {
                                    
                                    if ($moviment->creditodebito == 'C') {
                                        
                                        $receitas[$mes] -= $mergeds->Moviment_Mergeds['valorbaixa']; //orçado
                                        //if ($mes=='02') {echo 'Merged: +'.$moviment->valor.'<br>';}
                                        
                                    } elseif ($moviment->creditodebito == 'D') {
                                        
                                        $despesas[$mes] -= $mergeds->Moviment_Mergeds['valorbaixa']; //orçado
                                        //if ($mes=='02') {echo 'Merged: -'.$moviment->valor.'<br>';}
                                        
                                    }
                                    
                                }//if ($moviment->id == $mergeds->Moviments['id'])
                                
                            endforeach;
                            
                        }//if ($moviment->contabil == 'S')
                        
                    }//if ($vencimento[0] == date('Y'))
                    
                } else {
                    
                    $dtpgto = explode("-", $moviment->dtbaixa);
                    $pmes = $dtpgto[1];
                    $pano = $dtpgto[0];
                    
                    if ($pano == date('Y')) { 
                        
                        if ($moviment->contabil == 'S') { //CONTABILIZA APENAS LANÇAMENTOS CONTÁBEIS
                            
                            if ($moviment->creditodebito == 'C') {
                                
                                $receitas[$mes] += $moviment->valor; //orçado
                                
                            } elseif ($moviment->creditodebito == 'D') {
                                
                                $despesas[$mes] += $moviment->valor; //orçado
                                
                            }//if ($moviment->creditodebito == 'C')
                            
                        }//if ($moviment->contabil == 'S')
                        
                    }//if ($ano == date('Y'))
                    
                }//if (empty($moviment->dtbaixa))
                
            endforeach;
            
        }//if (!empty($moviments_venc))
        
        /**********************************************************************/
        
        //MOVIMENTOS DE BANCOS
        $moviment_banks = $this->MovimentBanks->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                              ->select(['MovimentBanks.creditodebito', 'MovimentBanks.dtbaixa', 'MovimentBanks.valorbaixa', 
                                                        'MovimentBanks.valor', 'MovimentBanks.parameters_id', 'MovimentBanks.contabil', 
                                                        'MovimentBanks.ordem', 'MovimentBanks.transfers_id', 'MovimentBanks.status'
                                                       ])
                                              ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                        return $exp->between('MovimentBanks.dtbaixa', $dtinicial, $dtfinal);
                                                      })
                                              ->order(['MovimentBanks.dtbaixa']);
        
        if (!empty($moviment_banks->toArray())) {
            
            foreach ($moviment_banks as $moviment_bank):
                
                $dtbaixa = explode("-", $moviment_bank->dtbaixa);

                if ($dtbaixa[0] == date('Y')) {
                    
                    $mes = $dtbaixa[1];
                    
                    if ($moviment_bank->contabil == 'S' && empty($moviment_bank->transfers_id)) { //CONTABILIZA APENAS LANÇAMENTOS CONTÁBEIS
                        
                        if ($moviment_bank->creditodebito == 'C') {
                            
                            //$receitas[$mes]   += $moviment_bank->valor;      //orçado
                            $receitas_r[$mes] += $moviment_bank->valorbaixa; //realizado
                            
                        } elseif ($moviment_bank->creditodebito == 'D') {
                            
                            //$despesas[$mes]   += $moviment_bank->valor;      //orçado
                            $despesas_r[$mes] += $moviment_bank->valorbaixa; //realizado
                            
                        }//if ($moviment_bank->creditodebito == 'C')
                        
                    }//if ($moviment_bank->contabil == 'S')
                    
                }//if ($dtbaixa[0] == date('Y'))
                
            endforeach;
            
        }//if (!empty($moviment_banks->toArray()))
        
        /**********************************************************************/
        
        //MOVIMENTOS DE CAIXAS
        $moviment_boxes = $this->MovimentBoxes->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                              ->select(['MovimentBoxes.creditodebito', 'MovimentBoxes.dtbaixa', 'MovimentBoxes.valorbaixa', 
                                                        'MovimentBoxes.valor', 'MovimentBoxes.parameters_id', 'MovimentBoxes.contabil', 
                                                        'MovimentBoxes.ordem', 'MovimentBoxes.transfers_id', 'MovimentBoxes.status'
                                                       ])
                                              ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                        return $exp->between('MovimentBoxes.dtbaixa', $dtinicial, $dtfinal);
                                                      })
                                              ->order(['MovimentBoxes.dtbaixa']);
        
        if (!empty($moviment_boxes->toArray())) {
            
            foreach ($moviment_boxes as $moviment_box): 
                
                $dtbaixa = explode("-", $moviment_box->dtbaixa);
                
                if ($dtbaixa[0] == date('Y')) {
                    
                    $mes = $dtbaixa[1];
                    
                    if ($moviment_box->contabil == 'S' && empty($moviment_box->transfers_id)) { //CONTABILIZA APENAS LANÇAMENTOS CONTÁBEIS
                        
                        if ($moviment_box->creditodebito == 'C') {
                            
                            //$receitas[$mes]   += $moviment_box->valor;      //orçado
                            $receitas_r[$mes] += $moviment_box->valorbaixa; //realizado
                            
                        } elseif ($moviment_box->creditodebito == 'D') {
                            
                            //$despesas[$mes]   += $moviment_box->valor;      //orçado
                            $despesas_r[$mes] += $moviment_box->valorbaixa; //realizado
                            
                        }//if ($moviment_box->creditodebito == 'C')
                        
                    }//if ($moviment_box->contabil == 'S')
                    
                }//if ($dtbaixa[0] == date('Y'))
                
            endforeach; 
            
        }//if (!empty($moviment_boxes->toArray()))
        
        /**********************************************************************/
        
        //echo 'Receitas Orçadas: '.'<br>';
        //debug($receitas);
        //echo 'Despesas Orçadas: '.'<br>';
        //debug($despesas);
        //echo 'Receitas Realizadas: '.'<br>';
        //debug($receitas_r);
        //echo 'Despesas Realizadas: '.'<br>';
        //debug($despesas_r);
        
        $m = 1;
        while ($m <= 12) {
            
            $m = str_pad($m, 2, "0", STR_PAD_LEFT);
            
            if ($receitas[$m] > 0 && $despesas[$m] > 0) { //orçado
                $orcado[$m] = number_format((100 - ($despesas[$m] * 100) / $receitas[$m]), 0, '.', '');
            } else {
                if ($receitas[$m] > 0) {$orcado[$m] = 100;}
                if ($despesas[$m] > 0) {$orcado[$m] = -100;}
            }
            
            if ($receitas_r[$m] > 0 && $despesas_r[$m] > 0) { //realizado
                $realizado[$m] = number_format((100 - ($despesas_r[$m] * 100) / $receitas_r[$m]), 0, '.', '');
            } else {
                if ($receitas_r[$m] > 0) {$realizado[$m] = 100;}
                if ($despesas_r[$m] > 0) {$realizado[$m] = 0;}
            }
            
            //SAÚDE MÉDIA ANUAL - ORÇADO QUANDO NÃO REALIZADO
            if ($receitas_r[$m] > 0 && $despesas_r[$m] > 0) {
                $saude_media_ano[$m] += $realizado[$m];
            } elseif ($receitas[$m] > 0 && $despesas[$m] > 0) {
                $saude_media_ano[$m] += $orcado[$m];
            }
            
            //echo 'Mês: ' . $m . '<br>';
            //echo 'Saúde Média: ' . $saude_media_ano[$m] . '<br>';
            //echo 'Saúde Média (%): ' . round(array_sum($saude_media_ano) / 12) . '<br>';
            //echo 'Receita Orçado: ' . $receitas[$m] . '<br>';
            //echo 'Despesa Orçado: ' . $despesas[$m] . '<br>';
            //echo 'Receita Realizado: ' . $receitas_r[$m] . '<br>';
            //echo 'Despesa Realizado: ' . $despesas_r[$m] . '<br>';
            //echo 'Orçado: ' . $orcado[$m] . '<br>';
            //echo 'Realizado: ' . $realizado[$m] . '<br>';
            //echo '-----------' . '<br>';
            $m++;
        }
        //debug($orcado);
        //debug($realizado);
        
        $this->set('saude_orcado', $orcado); //orçado
        $this->set('saude_realizado', $realizado); //realizado
        $this->set('saude_media_ano', round(array_sum($saude_media_ano) / 12)); //orçado quando não realizado
        
        /**********************************************************************/
        
        /* SAÚDE FINANCEIRA NO MÊS ATUAL */
        
        $receitas = $despesas   = 0;
        $receitas_mes_orcado    = $despesas_mes_orcado = 0;
        $receitas_mes_realizado = $despesas_mes_realizado = 0;
        $receitas_mes_aberto    = $despesas_mes_aberto = 0;
        
        /********/
        
        if (!empty($moviments_venc)) {
            
            foreach ($moviments_venc as $moviment): 
                
                $vencimento = explode("-", $moviment->vencimento);
                $mes = $vencimento[1];
                $ano = $vencimento[0];
                
                if (empty($moviment->dtbaixa)) {
                    
                    if ($ano == date('Y') && $mes == date('m')) {
                        
                        if ($moviment->contabil == 'S') { //CONTABILIZA APENAS LANÇAMENTOS CONTÁBEIS
                            
                            //Controlar os movimento
                            $movimentos[] = $moviment->id;
                            
                            if ($moviment->creditodebito == 'C') {
                                
                                $receitas += $moviment->valor; //orçado
                                $receitas_mes_orcado += $moviment->valor; //orçado
                                $receitas_mes_aberto += $moviment->valor; //aberto
                                
                            } elseif ($moviment->creditodebito == 'D') {
                                
                                $despesas += $moviment->valor; //orçado
                                $despesas_mes_orcado += $moviment->valor; //orçado
                                $despesas_mes_aberto += $moviment->valor; //aberto
                                
                            }//if ($moviment->creditodebito == 'C')
                            
                            //DEDUZ BAIXAS PARCIAIS
                            foreach($movimentMergeds as $mergeds):
                                
                                if ($moviment->id == $mergeds->Moviments['id']) {
                                    
                                    if ($moviment->creditodebito == 'C') {
                                        
                                        $receitas_mes_aberto -= $mergeds->Moviment_Mergeds['valorbaixa']; //orçado
                                        
                                    } elseif ($moviment->creditodebito == 'D') {
                                        
                                        $despesas_mes_aberto -= $mergeds->Moviment_Mergeds['valorbaixa']; //orçado
                                        
                                    }
                                    
                                }//if ($moviment->id == $mergeds->Moviments['id'])
                                
                            endforeach;
                            
                        }//if ($moviment->contabil == 'S')
                        
                    }//if ($vencimento[0] == date('Y') && $vencimento[1] == date('m'))
                    
                } else {
                    
                    $dtpgto = explode("-", $moviment->dtbaixa);
                    $pmes = $dtpgto[1];
                    $pano = $dtpgto[0];
                    
                    if ($pano == date('Y') && $mes == date('m')) { 
                        
                        if ($moviment->contabil == 'S' && $moviment->status != 'P' && $moviment->status != 'O') { //CONTABILIZA APENAS LANÇAMENTOS CONTÁBEIS, NÃO PARCIAIS
                            
                            $movimentos[] = $moviment->id;
                            
                            if ($moviment->creditodebito == 'C') {
                                
                                $receitas_mes_orcado += $moviment->valor; //orçado
                                
                            } elseif ($moviment->creditodebito == 'D') {
                                
                                $despesas_mes_orcado += $moviment->valor; //orçado
                                
                            }//if ($moviment->creditodebito == 'C')
                            
                        }//if ($moviment->contabil == 'S')
                        
                    }//if ($vencimento[0] == date('Y') && $vencimento[1] == date('m'))
                    
                }//if (empty($moviment->dtbaixa))
                
            endforeach;
            
        }//if (!empty($moviments_venc->toArray()))
        
        /********/
        
        if (!empty($moviment_banks->toArray())) {
            
           foreach ($moviment_banks as $moviment_bank): 
               
                $dtbaixa = explode("-", $moviment_bank->dtbaixa);
                
                if ($dtbaixa[0] == date('Y') && $dtbaixa[1] == date('m')) { 
                    
                    if ($moviment_bank->contabil == 'S' && empty($moviment_bank->transfers_id)) { //CONTABILIZA APENAS LANÇAMENTOS CONTÁBEIS
                        
                        if ($moviment_bank->creditodebito == 'C') {
                            
                            $receitas += $moviment_bank->valorbaixa; //realizado
                            $receitas_mes_realizado += $moviment_bank->valorbaixa; //realizado
                            
                        } elseif ($moviment_bank->creditodebito == 'D') {
                            
                            $despesas += $moviment_bank->valorbaixa; //realizado
                            $despesas_mes_realizado += $moviment_bank->valorbaixa; //realizado
                            
                        }
                        
                    }//if ($moviment_bank->contabil == 'S')
                    
                }//if ($dtbaixa[0] == date('Y') && $dtbaixa[1] == date('m'))
                
            endforeach; 
            
        }//if (!empty($moviment_banks->toArray()))
        
        /********/
        
        if (!empty($moviment_boxes->toArray())) {
            
           foreach ($moviment_boxes as $moviment_box): 
               
                $dtbaixa = explode("-", $moviment_box->dtbaixa);
                
                if ($dtbaixa[0] == date('Y') && $dtbaixa[1] == date('m')) { 
                    
                    if ($moviment_box->contabil == 'S' && empty($moviment_box->transfers_id)) { //CONTABILIZA APENAS LANÇAMENTOS CONTÁBEIS
                        
                        if ($moviment_box->creditodebito == 'C') {
                            
                            $receitas += $moviment_box->valorbaixa; //realizado
                            $receitas_mes_realizado += $moviment_box->valorbaixa; //realizado
                            
                        } elseif ($moviment_box->creditodebito == 'D') {
                            
                            $despesas += $moviment_box->valorbaixa; //realizado
                            $despesas_mes_realizado += $moviment_box->valorbaixa; //realizado
                            
                        }//if ($moviment_box->creditodebito == 'C')
                        
                    }//if ($moviment_box->contabil == 'S')
                    
                }//if ($dtbaixa[0] == date('Y') && $dtbaixa[1] == date('m'))
                
            endforeach; 
        }
        
        /********/
        
        //echo '<br><br>';
        //echo 'Receitas: ' . $receitas;
        //echo '<br>';
        //echo 'Despesas: ' . $despesas;
        //echo '<br><br>';

        //Inicializa as variáveis
        $per_orcado    = null;
        $per_realizado = null;
        $per_aberto    = null;
        $percent       = null;
        
        /********/
        
        //CÁLCULO DO PERCENTUAL DA SAÚDE FINANCEIRA DO MÊS
        if ($receitas > 0 && $despesas > 0) {
            $percent = 100 - (($despesas * 100) / $receitas);
        } else {
            if ($receitas > 0) {$percent = 100;}
            if ($despesas > 0) {$percent = 0;}
            if ($receitas == 0 && $despesas == 0) {$percent = 0;}
        }
        
        /********/
        
        //CÁLCULO DO PERCENTUAL ORÇADO
        if ($receitas_mes_orcado > 0 && $despesas_mes_orcado > 0) {
            $per_orcado = 100 - (($despesas_mes_orcado * 100) / $receitas_mes_orcado);
        } else {
            if ($receitas_mes_orcado > 0) {$per_orcado = 100;}
            if ($despesas_mes_orcado > 0) {$per_orcado = 0;}
            if ($receitas_mes_orcado == 0 && $despesas_mes_orcado == 0) {$per_orcado = 0;}
        }
        
        /********/
        
        //CÁLCULO DO PERCENTUAL REALIZADO
        if ($receitas_mes_realizado > 0 && $despesas_mes_realizado > 0) {
            $per_realizado = 100 - (($despesas_mes_realizado * 100) / $receitas_mes_realizado);
        } else {
            if ($receitas_mes_realizado > 0) {$per_realizado = 100;}
            if ($despesas_mes_realizado > 0) {$per_realizado = 0;}
            if ($receitas_mes_realizado == 0 && $despesas_mes_realizado == 0) {$per_realizado = 0;}
        }
        
        /********/
        
        //CÁLCULO DO PERCENTUAL EM ABERTO
        if ($receitas_mes_aberto > 0 && $despesas_mes_aberto > 0) {
            $per_aberto = 100 - (($despesas_mes_aberto * 100) / $receitas_mes_aberto);
        } else {
            if ($receitas_mes_aberto > 0) {$per_aberto = 100;}
            if ($despesas_mes_aberto > 0) {$per_aberto = 0;}
            if ($receitas_mes_aberto == 0 && $despesas_mes_aberto == 0) {$per_aberto = 0;}
        }
        
        /********/
        
        //Limita as casas decimais
        $per_orcado    = number_format($per_orcado, 0);
        $per_realizado = number_format($per_realizado, 0);
        $per_aberto    = number_format($per_aberto, 0);
        $percent       = number_format($percent, 0);
        
        /********/
        
        //echo 'Receitas Orçadas: <br>';
        //echo $receitas_mes_orcado.'<br>';
        //echo 'Despesas Orçadas: <br>';
        //echo $despesas_mes_orcado.'<br>';
        //echo $per_orcado.'%<br>';
        //echo 'Receitas Realizadas: <br>';
        //echo $receitas_mes_realizado.'<br>';
        //echo 'Despesas Realizadas: <br>';
        //echo $despesas_mes_realizado.'<br>';
        //echo $per_realizado.'%<br>';
        //echo 'Receitas Em Aberto: <br>';
        //echo $receitas_mes_aberto.'<br>';
        //echo 'Despesas Em Aberto: <br>';
        //echo $despesas_mes_aberto.'<br>';
        //echo $per_aberto.'%<br>';
        
        /********/
        
        $this->set('saude_mes', $percent);
        $this->set(compact('receitas_mes_orcado', 'despesas_mes_orcado', 'receitas_mes_realizado', 'despesas_mes_realizado', 
                           'receitas_mes_aberto', 'despesas_mes_aberto', 'per_orcado', 'per_realizado', 'per_aberto'
                          )
                  );
        
        /********/
        
        unset($receitas_mes_orcado);
        unset($despesas_mes_orcado);
        unset($receitas_mes_realizado);
        unset($despesas_mes_realizado);
        unset($receitas_mes_aberto);
        unset($despesas_mes_aberto);
        unset($per_orcado);
        unset($per_realizado);
        unset($per_aberto);
        unset($receitas);
        unset($despesas);
        unset($percent);
        
        /**********************************************************************/
        /**********************************************************************/
        
        /* PLANEJAMENTOS FINANCEIROS */
        $plannings = $this->Plannings->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->where(['Plannings.status IN' => ['A', 'P']])
                                     ->order(['Plannings.data']);
        
        $this->set(compact('plannings'));
        
        /********/
        
        if (!empty($plannings->toArray())) {
            
            foreach ($plannings as $index => $value):
                $plans[$index] = $value['id'];
            endforeach;
            
        }//if (!empty($plannings->toArray()))
        
        /********/

        if (!empty($plans)) {
            
            $balance_plannings = $this->Balances->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                ->where(['Balances.plannings_id IN' => $plans]);
            $balance_plannings                  ->select(['Balances.id', 
                                                          'Balances.value', 
                                                          //'MAX' => $balance_plannings->func()->max('Balances.id'), 
                                                          'Balances.plannings_id'
                                                         ]);
            
            $this->set(compact('balance_plannings'));
            
            /********/
            
            $moviment_plannings = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                  ->where(['Moviments.plannings_id IN' => $plans,
                                                           'Moviments.vencimento <' => date('Y-m-t'),
                                                           'Moviments.dtbaixa IS NULL'
                                                          ]);
            
            $this->set(compact('moviment_plannings'));
            
        }//if (!empty($plans))
        
        /**********************************************************************/
        
        //ATUALIZADO 05/04/2017
        //Knowledge - Base de Conhecimento
        $knowledges = $this->Knowledges->find('all')
                                       ->toArray();
        shuffle($knowledges);
        
        if (!empty($knowledges)) {
        
            $this->set('knowledges', $knowledges[0]['title']);
        
        }//if (!empty($knowledges))
        
        /**********************************************************************/
        
        //ATUALIZADO 05/04/2017
        //EXIBE TUTORIAL
        $this->Users = TableRegistry::get('Users');
        
        /**********************************************************************/
        
        //$users  = $this->Users->find('all', ['conditions' => ['id' => $this->Auth->user('id'))));
        $users  = $this->Users->findById($this->Auth->user('id'));
        
        /**********************************************************************/
        
        $users_row = $users->first();
        
        /**********************************************************************/
        
        $this->set('tutorial', $users_row->tutorial);
        
        /**********************************************************************/
    }

    public function extratos()
    {
        //Resumo de contas a pagar/receber em aberto, vencendo e vencido
        /**********************************************************************/
        /* MODELS LOADINGS */
        
        $this->Moviments          = TableRegistry::get('Moviments');
        $this->MovimentRecurrents = TableRegistry::get('MovimentRecurrents');
        $this->MovimentMergeds    = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        /**********************************************************************/
        /* MOVIMENTOS RECORRENTES */
        
        $movimentRecurrents = $this->MovimentRecurrents->findByParametersId($this->request->Session()->read('sessionParameterControl'));
        $this->set('movimentRecurrents', $movimentRecurrents->toArray());
        
        /**********************************************************************/

        $dtfinal   = date('Y-m-d');
        $dtinicial = '1986-02-08';
        
        /**********************************************************************/
        /* MOVIMENTOS VINCULADOS */
        
        $movimentMergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                           'Moviments.id', 'Moviments.valorbaixa', 'Moviments.valor', 'Moviments.vencimento', 'Moviments.status', 
                                                           'Moviment_Mergeds.id', 'Moviment_Mergeds.ordem', 'Moviment_Mergeds.valor', 'Moviment_Mergeds.valorbaixa', 
                                                           'Moviment_Mergeds.data', 'Moviment_Mergeds.dtbaixa', 'Moviment_Mergeds.vencimento', 'Moviment_Mergeds.status',
                                                           'Moviment_Mergeds.documento', 'Moviment_Mergeds.historico'
                                                          ])
                                                 ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                            return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                                         })
                                                 ->order(['Moviments.vencimento, Moviments.id DESC'])
                                                 ->join(['Moviments' => ['table'      => 'Moviments',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                        ],
                                                         'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                              ]
                                                        ]);
        
        
        $this->set('movimentMergeds', $movimentMergeds);
        
        /**********************************************************************/
        /**********************************************************************/
        /* MOVIMENTOS */

        $inicio     = "1986-02-08";
        $fim        = date("Y-m-t");
        
        /**********************************************************************/
        
        $moviments  = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                      ->where(function ($exp, $q) use($inicio, $fim) {
                                               return $exp->between('Moviments.vencimento', $inicio, $fim);
                                              })
                                      ->where(['Moviments.status IN' => ['A', 'P', 'G']])
                                      ->contain(['Customers', 'Providers'])
                                      ->order(['Moviments.vencimento, Moviments.id DESC']);
        
        /**********************************************************************/
        /**********************************************************************/
        /* CRÉDITOS */
        
        if (!empty($moviments->toArray())) {
            foreach ($moviments as $index => $moviment):
                if ($moviment->creditodebito == 'C') {
                    $creditos[$index] = $moviment;
                }
            endforeach;
        }
        
        if (isset($creditos)) {
            $this->set('creditos', $creditos);
        }
        
        /**********************************************************************/
        /* DÉBITOS */
        
        if (!empty($moviments->toArray())) {
            foreach ($moviments as $index => $moviment):
                if ($moviment->creditodebito == 'D') {
                    $debitos[$index] = $moviment;
                }
            endforeach;
        }
        
        if (isset($debitos)) {
            $this->set('debitos', $debitos);
        }
        
        /**********************************************************************/
        /**********************************************************************/
        
        $dtinicial = $dtfinal = date('Y-m-d');
        
        /**********************************************************************/
        /* CRÉDITOS NO DIA ATUAL */
        
        $creditos_dia = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                        ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                  return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                                })
                                        ->where(['Moviments.status IN' => ['A', 'P'],
                                                 'Moviments.creditodebito LIKE' => 'C'
                                                ])
                                        ->order(['Moviments.vencimento DESC']);
        
        $this->set('creditos_dia', $creditos_dia->toArray());
        
        /**********************************************************************/
        /* DÉBITOS NO DIA ATUAL */
        
        $debitos_dia = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                               })
                                       ->where(['Moviments.status IN' => ['A', 'P'],
                                                'Moviments.creditodebito LIKE' => 'D'
                                               ])
                                       ->order(['Moviments.vencimento DESC']);
        
        $this->set('debitos_dia', $debitos_dia->toArray());
        
        /**********************************************************************/
        /**********************************************************************/
        
        $dtfinal = date('Y-m-d', strtotime($dtinicial) - 86400);
        $dtinicial =  '1986-01-01';
        
        /**********************************************************************/
        /* DÉBITOS EM ATRASO */
        
        $debitos_late = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                        ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                 return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                                })
                                        ->where(['Moviments.status IN' => ['A', 'P'],
                                                 'Moviments.creditodebito LIKE' => 'D'
                                                ])
                                        ->order(['Moviments.vencimento DESC']);
        
        $this->set('debitos_late', $debitos_late->toArray());
        
        /**********************************************************************/
        /* CRÉDITOS EM ATRASO */
        
        $creditos_late = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                  return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                                 })
                                         ->where(['Moviments.status IN' => ['A', 'P'],
                                                  'Moviments.creditodebito LIKE' => 'C'
                                                 ])
                                         ->order(['Moviments.vencimento DESC']); 
        
        $this->set('creditos_late', $creditos_late->toArray());
        
        /**********************************************************************/
        /**********************************************************************/
        
        $dtinicial = date('Y-m-d', strtotime(date('Y-m-d')) + 86400);
        $dtfinal    = date('Y-m-t');
        
        /**********************************************************************/
        /* DÉBITOS FUTUROS */
        
        $debitos_future = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                          ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                   return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                                  })
                                          ->where(['Moviments.status IN' => ['A', 'P'],
                                                   'Moviments.creditodebito LIKE' => 'D'
                                                  ])
                                          ->order(['Moviments.vencimento DESC']);
        
        $this->set('debitos_future', $debitos_future->toArray());
        
        /**********************************************************************/
        /* CRÉDITOS FUTUROS*/
        
        $creditos_future = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                    return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                                   })
                                           ->where(['Moviments.status IN' => ['A', 'P'],
                                                    'Moviments.creditodebito LIKE' => 'C'
                                                   ])
                                           ->order(['Moviments.vencimento DESC']);
        
        $this->set('creditos_future', $creditos_future->toArray());
        
        /**********************************************************************/
    }
    
    public function faturaCartoes()
    {
        
        $this->Moviments          = TableRegistry::get('Moviments');
        $this->MovimentMergeds    = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        /* FATURAS DE CARTÕES DE CRÉDITO */
        $dtinicial = date('Y-m-t', strtotime("-3 years"));
        $dtfinal   = date('Y-m-t', strtotime("+60 days"));
        
        /**********************************************************************/
        
        $faturas_cartoes = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->select(['Moviments.status', 'Moviments.cards_id', 'Moviments.vencimento', 
                                                     'Moviments.parameters_id', 'Moviments.valor', 'Moviments.id', 
                                                     'Moviments.ordem', 
                                                     'Cards.id', 'Cards.title', 'Cards.status'
                                                    ])
                                           ->where(function ($exp, $q) use($dtinicial, $dtfinal) {
                                                    return $exp->between('Moviments.vencimento', $dtinicial, $dtfinal);
                                                   })
                                           ->where(['Moviments.status IN' => ['A', 'P'],
                                                    'Moviments.cards_id IS NOT NULL'
                                                   ])
                                           ->contain(['Cards'])
                                           ->order(['Moviments.vencimento, Moviments.cards_id']);
        
        $this->set('faturas_cartoes', $faturas_cartoes);
        
        /**********************************************************************/
        /* MOVIMENTOS VINCULADOS */
        
        $movimentMergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                           'Moviments.id', 'Moviments.valorbaixa', 'Moviments.valor', 'Moviments.vencimento', 'Moviments.status', 
                                                           'Moviment_Mergeds.id', 'Moviment_Mergeds.ordem', 'Moviment_Mergeds.valor', 'Moviment_Mergeds.valorbaixa', 
                                                           'Moviment_Mergeds.data', 'Moviment_Mergeds.dtbaixa', 'Moviment_Mergeds.vencimento', 'Moviment_Mergeds.status',
                                                           'Moviment_Mergeds.documento', 'Moviment_Mergeds.historico'
                                                          ])
                                                 ->order(['Moviments.vencimento, Moviments.id DESC'])
                                                 ->join(['Moviments' => ['table'      => 'Moviments',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                        ],
                                                         'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                              ]
                                                        ]);
        
        
        $this->set('movimentMergeds', $movimentMergeds);
    }
    
    public function saldosBancarios()
    {
        //Saldos de bancos e caixas
        $this->set('saldos', $this->saldos());
    }
    
    public function saldosCartoes()
    {
        //Saldos de bancos e caixas
        $this->set('saldos', $this->saldos());
    }
    
    public function saldosPlanejamentos()
    {
        //Planejamentos
        $this->Plannings = TableRegistry::get('Plannings');
        
        /**********************************************************************/
        
        $plannings = $this->Plannings->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->select(['Plannings.id', 'Plannings.ordem', 'Plannings.parameters_id',
                                               'Plannings.account_plans_id', 'Plannings.costs_id', 'Plannings.creditodebito', 
                                               'Plannings.customers_id', 'Plannings.providers_id', 
                                               'Plannings.title', 'Plannings.data', 'Plannings.vencimento', 'Plannings.valor', 
                                               'Plannings.parcelas', 'Plannings.obs', 'Plannings.username', 'Plannings.status'
                                              ])
                                     ->where(['Plannings.status IN' => ['A', 'P']])
                                     ->order(['Plannings.id, Plannings.status, Plannings.title ASC']);
        
        /**********************************************************************/
        
        $this->set(compact('plannings'));
        
        /**********************************************************************/
        
        //Saldos de planejamentos
        $this->set('saldos', $this->saldos());
    }

    public function pedidos()
    {
        //Relação de Pedidos
        $this->Purchases = TableRegistry::get('Purchases');
        $this->Sells     = TableRegistry::get('Sells');

        /**********************************************************************/

        $purchases = $this->Purchases->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->where(['Purchases.status IN' => ['P', 'A']]) // P - pending, E - partial delivery, D - in delivery, C - cancelled, F - finalized
                                     ->contain(['Providers'])
                                     ->order(['Purchases.code']);

        /**********************************************************************/

        $sells = $this->Sells->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                             ->where(['Sells.status IN' => ['P', 'D', 'E']]) // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
                             ->contain(['Customers'])
                             ->order(['Sells.code']);

        /**********************************************************************/

        $this->set(compact('purchases'));
        $this->set(compact('sells'));

    }

    public function solicitacoes()
    {
        //Relação de Solicitações de Compras
        $this->PurchaseRequests = TableRegistry::get('PurchaseRequests');

        /**********************************************************************/

        $purchaseRequests = $this->PurchaseRequests->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                   ->where(['PurchaseRequests.status IN' => ['P', 'A']]) // P - pending, A - in progress, C - cancelled, F - finalized
                                                   ->contain(['Industrializations'])
                                                   ->order(['PurchaseRequests.code']);
        
        /**********************************************************************/

        $this->set(compact('purchaseRequests'));
        
    }
    
    public function dismissTutorial()
    {
        //ATUALIZADO 05/04/2017
        $this->Users = TableRegistry::get('Users');
        
        /**********************************************************************/
        
        //Acessa a tabela de usuários
        $user = $this->Users->get($this->Auth->user('id'));
        
        /**********************************************************************/
        
        //Remove o tutorial
        $user->tutorial = 0;
        
        /**********************************************************************/
        
        //Salva
        if (!$this->Users->save($user)) {

            //Alerta de erro
            $message = 'PagesController->dismissTutorial';
            $this->Error->registerError($user, $message, true);

        }//if (!$this->Users->save($user))
        
        /**********************************************************************/
        
        //NÃO BUSCA A VIEW
        $this->autoRender = false;
    }
    
    public function login() 
    {
        if ($this->request->is('post')) {
            
            $user = $this->Auth->identify();
            
            if ($user) {
                
                $this->Auth->setUser($user);
                
                //LOGA EM UMA EMPRESA
                $this->session(null, $this->request->data);
                
                //REDIRECIONA PARA PÁGINA INICIAL
                return $this->redirect($this->Auth->redirectUrl());
                
            } else {

                //ENVIA E-MAIL COM TENTATIVA DE LOGON
                $sendMail = ['subject'  => 'SISTEMA R2: Tentativa de logon no sistema',
                             'template' => 'tentativa_logon',
                             'vars'     => ['request_data' => $this->request->data],
                             'toEmail'  => null
                            ];

                $this->EmailFunctions->sendMail($sendMail);

            }//else if ($user)
            
            //GRAVA LOG
            $this->Log->gravaLog($this->request->data(), 'noLogin');
            
            $this->Flash->error(__('Usuário/senha incorreto, tente novamente'));
            return $this->redirect($this->Auth->logout());
        }
    }
    
    public function logout() 
    {
        $this->request->Session()->destroy();
        
        $this->Flash->success(__('Sessão Finalizada'));
        return $this->redirect($this->Auth->logout());
    }
    
    public function cadastrar()
    {
        if ($this->request->is('post')) {

            //CALL MODELS
            $this->Users            = TableRegistry::get('Users');
            $this->UsersParameters  = TableRegistry::get('UsersParameters');
            $this->Banks            = TableRegistry::get('Banks');
            $this->Boxes            = TableRegistry::get('Boxes');
            $this->Costs            = TableRegistry::get('Costs');
            $this->Parameters       = TableRegistry::get('Parameters');
            
            /******************************************************************/
            
            //USUÁRIO SERÁ O E-MAIL PARA QUE SEJA ÚNICO
            $this->request->data['username'] = $this->request->data['username'];
            
            /******************************************************************/
            
            //CONSULTA DUPLICIDADE DE USUÁRIO
            $double_user = $this->Users->findByUsername($this->request->data['username'])->first();
            
            if (!empty($double_user)) {

                //Envia e-mail da tentativa de cadastro
                $sendMail = ['subject'  => 'SISTEMA R2: Tentativa de recadastro no sistema',
                             'template' => 'tentativa_logon',
                             'vars'     => ['request_data' => ['username' => $this->request->data['username'],
                                                               'password' => $this->request->data['password']
                                                              ]],
                             'toEmail'  => null
                            ];

                $this->EmailFunctions->sendMail($sendMail);

                /**************************************************************/

                $this->Flash->warning(__('Você já é cadastrado! Envie um e-mail para Suporte@Reiniciando.com.br e solicite acesso'));
                return $this->redirect($this->referer());

            }//if (!empty($double_user))
            
            /******************************************************************/
            
            ////////////////////////////////////////////////////////////////////
            // EMPRESAS                                                       //
            ////////////////////////////////////////////////////////////////////
            
            $Parameter = $this->Parameters->newEntity();
            
            $Parameter->razao           = $this->request->data['name'];
            $Parameter->tipo            = 'F';
            $Parameter->email_cobranca  = $this->request->data['username'];
            $Parameter->dtvalidade      = date("Y-m-d", strtotime("+1 year")); //1 ANO DE USO GRÁTIS
            $Parameter->username        = $this->request->data['name'];
            $Parameter->plans_id        = '4'; //Plano Pessoal - Limitado
            $Parameter->systemver       = '2';

            //GRAVA USUÁRIOS
            if (!$this->Parameters->save($Parameter)) {

                //Alerta de erro
                $message = 'PagesController->cadastrar, Parameters';
                $this->Error->registerError($Parameter, $message, true);

            }//if (!$this->Parameters->save($Parameter))

            //Define o parameters_id para ser utilizado nos cadastros seguintes.
            $parameters_id = $Parameter->id;
            
            ////////////////////////////////////////////////////////////////////
            // USUÁRIOS                                                       //
            ////////////////////////////////////////////////////////////////////
            
            $User = $this->Users->newEntity();
            
            $User->name          = $this->request->data['name'];
            $User->username      = $this->request->data['username'];
            $User->password      = $this->request->data['password'];
            $User->parameters_id = $parameters_id;
            $User->language      = 'pt_BR';
            $User->module        = 'F'; //Adicionado em 04-10-2018
            
            if (!$this->Users->save($User)) {

                //Alerta de erro
                $message = 'PagesController->cadastrar, Users';
                $this->Error->registerError($User, $message, true);

            }//if (!$this->Users->save($User))

            //Define o users_id para fazer o login no final do script
            $users_id = $User->id;
            
            ////////////////////////////////////////////////////////////////////
            // VÍNCULO DE USUÁRIO AO CADASTRO DE EMPRESA                      //
            ////////////////////////////////////////////////////////////////////
            
            $UsersParameter = $this->UsersParameters->newEntity();
            
            $UsersParameter->users_id      = $users_id;
            $UsersParameter->parameters_id = $parameters_id;
            $UsersParameter->rules_id      = '2'; //O primeiro usuário será sempre o administrador
            $UsersParameter->username      = $this->request->data['username']; //Usuário que efetuou o cadastro
            
            if (!$this->UsersParameters->save($UsersParameter)) {

                //Alerta de erro
                $message = 'PagesController->cadastrar, UsersParameters';
                $this->Error->registerError($UsersParameter, $message, true);

            }//if (!$this->UsersParameters->save($UsersParameter))
            
            ////////////////////////////////////////////////////////////////////
            // CAIXAS                                                         //
            ////////////////////////////////////////////////////////////////////

            $box = $this->Boxes->newEntity();

            $box->title         = 'Carteira';
            $box->status        = 'A';
            $box->username      = $this->request->data['name'];
            $box->parameters_id = $parameters_id;

            if (!$this->Boxes->save($box)) {

                //Alerta de erro
                $message = 'PagesController->cadastrar, Boxes';
                $this->Error->registerError($box, $message, true);

            }//if (!$this->Boxes->save($box))

            ////////////////////////////////////////////////////////////////////
            // CATEGORIAS                                                     //
            ////////////////////////////////////////////////////////////////////

            $count = 0;
            $cost_descriptions = [0 => 'DIVERSOS',
                                  1 => 'CARTÕES DE CRÉDITO',
                                  2 => 'TAXAS E ANUIDADES',
                                  3 => 'ALIMENTAÇÃO',
                                  4 => 'EDUCAÇÃO',
                                  5 => 'SAÚDE',
                                  6 => 'VIAGENS E LAZER'
                                 ];

            while ($count < count($cost_descriptions)) {

                $cost = $this->Costs->newEntity();

                $cost->title         = $cost[$count];
                $cost->status        = 'A';
                $cost->username      = $this->request->data['name'];
                $cost->parameters_id = $parameters_id;

                if (!$this->Costs->save($cost)) {

                    //Alerta de erro
                    $message = 'PagesController->cadastrar, Costs';
                    $this->Error->registerError($cost, $message, true);

                }//if (!$this->Costs->save($cost))

                $count++;

            }//while ($count < count($cost_descriptions))

            ////////////////////////////////////////////////////////////////////
            // EMITE AVISO DE NOVO CADASTRO                                   //
            ////////////////////////////////////////////////////////////////////
            
            //Envia e-mail de boas vindas
            $sendMail = ['subject'  => 'SISTEMA R2: '.sprintf('Bem-vindo, %s', $User->name),
                         'template' => 'boas_vindas',
                         'vars'     => ['user' => json_decode(json_encode($User), true)],
                         'toEmail'  => $User->username
                        ];

            $this->EmailFunctions->sendMail($sendMail);

            //Envia e-mail de novo cliente
            $sendMail = ['subject'  => 'SISTEMA R2: Novo Cliente',
                         'template' => 'novo_cliente',
                         'vars'     => ['user' => json_decode(json_encode($User), true)],
                         'toEmail'  => null
                        ];

            $this->EmailFunctions->sendMail($sendMail);
            
            ////////////////////////////////////////////////////////////////////
            // EFETUA O LOGIN                                                 //
            ////////////////////////////////////////////////////////////////////

            //Consulta o usuário para login
            $user_login = $this->Users->findById($users_id)
                                      ->first();
            
            $user = ['id'              => $user_login->id,
                     'created'         => $user_login->created,
                     'modified'        => $user_login->modified,
                     'name'            => $user_login->name,
                     'username'        => $user_login->username,
                    //  'sendmail'        => 'S',
                     'redefinir_senha' => null,
                     'tutorial'        => '1',
                     'language'        => 'pt_BR'
                    ];

            //Loga o usuário na session
            $this->Auth->setUser($user);

            if (!$this->Auth->user()) {
                $this->Auth->config('authError', false);
            } else {
                
                //LOGA EM UMA EMPRESA
                $this->session($parameters_id);
                
                //REDIRECIONA PARA PÁGINA INICIAL
                return $this->redirect($this->Auth->redirectUrl());

            }//if (!$this->Auth->user())

        }//if ($this->request->is('post'))
    }

    public function avisoGratis()
    {
        //Exibe o modal com a informação para adiquirir a versão paga do sistema
        $this->Parameters      = TableRegistry::get('Parameters');
        $this->UsersParameters = TableRegistry::get('UsersParameters');
        $this->Users           = TableRegistry::get('Users');
        $this->Plans           = TableRegistry::get('Plans');
        
        /**********************************************************************/

        $Parameter = $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))
                                      ->select(['Parameters.id', 'Parameters.razao', 'Parameters.cpfcnpj',
                                                'Parameters.telefone', 'Parameters.endereco', 'Parameters.bairro',
                                                'Parameters.cidade', 'Parameters.estado', 'Parameters.cep',
                                                'Parameters.fundacao'
                                               ])
                                      ->first();

        $Parameter->username = $this->request->Session()->read('username');
        $Parameter->name     = $this->request->Session()->read('user_name');
        
        /**********************************************************************/

        $Plans = $this->Plans->find('all')
                             ->select(['Plans.id', 'Plans.title', 'Plans.value'])
                             ->order(['Plans.id']);
        
        /**********************************************************************/

        $estados = ['AC' => 'AC', 'AL' => 'AL', 'AP' => 'AP', 'AM' => 'AM', 
                    'BA' => 'BA', 'BH' => 'BH', 'CE' => 'CE', 'DF' => 'DF', 
                    'ES' => 'ES', 'GO' => 'GO', 'MA' => 'MA', 'MT' => 'MT', 
                    'MS' => 'MS', 'MG' => 'MG', 'PA' => 'PA', 'PB' => 'PB', 
                    'PR' => 'PR', 'PE' => 'PE', 'PI' => 'PI', 'RJ' => 'RJ', 
                    'RN' => 'RN', 'RS' => 'RS', 'RO' => 'RO', 'RR' => 'RR', 
                    'SC' => 'SC', 'SP' => 'SP', 'SE' => 'SE', 'TO' => 'TO', 
                    'EX' => 'EX'
                ];
        
        /**********************************************************************/

        $this->set('estados', $estados);
        $this->set('plans', $Plans);
        $this->set('parameter', $Parameter);
        
        /**********************************************************************/
        /**********************************************************************/

        $pagamento = $this->request->getData('pagamento');
        $fatura    = $this->request->getData('fatura');
        $data      = [];
        
        /**********************************************************************/

        //Dados da fatura
        $data['fatura']['nome']           = $fatura['nome'];//$plano->nome.' por '.$plano->dias_normal.' dias';
        $data['fatura']['valor']          = $fatura['valor'];//$plano->valor;
        $data['fatura']['tipo_pagamento'] = $pagamento['tipo'];
        //$data['fatura']['cliente_id']     = $novo->cliente_id;

        /**********************************************************************/

        if ($pagamento['tipo'] == 'BO') {

            //Dados do cliente
            $data['cliente'] = $pagamento['bo']['cliente'];
            // Nome, CPF, dt nascimento, E-mail, Telefone

            $data_hoje = new Date();
            $data['fatura']['vencimento'] = $data_hoje->modify('+5 days')->format('Y-m-d');
            $mensagem .= 'Agora é so aguardar pela aprovação da publicação do veículo juntamente com a confirmação de pagamento pelo anúncio.';

        } elseif ($pagamento['tipo'] == 'CC') {

            //Dados do cliente
            $data['cliente'] = $pagamento['cc']['cliente'];

            $data['fatura']['token'] = $pagamento['token'];
            $mensagem .= 'Agora é so aguardar pela aprovação da publicação do veículo';

        }//elseif ($pagamento['tipo'] == 'CC')
        
        /**********************************************************************/

        //$fatura = $this->GerenciarFatura->adicionar($data);
        
        /**********************************************************************/

        //$fatura_id  = $fatura->id;
        //$url_boleto = $fatura->url_boleto;

    }

    public function systemCustomers()
    {
        //Consulta os models
        $this->Users = TableRegistry::get('Users');
        $this->Regs  = TableRegistry::get('Regs');
        
        /**********************************************************************/

        //Consulta os usuários
        $users = $this->Users->find('all')
                             ->select(['Users.id', 'Users.name', 'Users.username', 
                                       'UsersParameters.users_id', 'UsersParameters.parameters_id', 'UsersParameters.rules_id', 
                                       'Rules.id', 'Rules.rule', 
                                       'Parameters.id', 'Parameters.razao', 'Parameters.cpfcnpj', 'Parameters.tipo', 'Parameters.dtvalidade', 'Parameters.plans_id', 
                                       'Plans.id', 'Plans.title' 
                                      ])
                             ->where(['Parameters.dtvalidade >' => date('Y-m-d')])
                             ->join(['UsersParameters' => ['table'      => 'users_parameters',
                                                           'type'       => 'LEFT',
                                                           'conditions' => ['Users.id = UsersParameters.users_id']
                                                          ],
                                     'Parameters'      => ['table'      => 'parameters',
                                                           'type'       => 'LEFT',
                                                           'conditions' => ['UsersParameters.parameters_id = Parameters.id']
                                                          ],
                                     'Rules'           => ['table'      => 'rules',
                                                           'type'       => 'LEFT',
                                                           'conditions' => ['UsersParameters.rules_id = rules.id']
                                                          ],
                                     'Plans'           => ['table'      => 'plans',
                                                           'type'       => 'LEFT',
                                                           'conditions' => ['Parameters.plans_id = plans.id']
                                                          ]
                                    ]);
        
        /**********************************************************************/

        //Define o last_login
        foreach($users as $user):

            //Consulta a tabela de registros
            $last_login = $this->Regs->find('all')
                                     ->select(['last_login'        => 'MAX(Regs.created)'])
                                     ->where(['Regs.users_id'      => $user->id, 
                                              'Regs.parameters_id' => $user->Parameters['id']
                                             ])
                                     ->first();
            
            if (!empty($last_login->toArray())) {
                $user->last_login = $last_login->last_login;
            }//if (!empty($last_login->toArray()))
            
        endforeach;
        
        /**********************************************************************/
        
        //ELABORAÇÃO E ENVIO DE E-MAIL
        $sendMail = ['subject'  => 'SISTEMA R2: Relação de Clientes do Sistema Financeiro',
                     'template' => 'system_customers',
                     'vars'     => ['data' => $users],
                     'toEmail'  => null
                    ];

        if ($this->EmailFunctions->sendMail($sendMail)) {

            $this->Flash->success(__('Relação de clientes enviada por e-mail'));
            return $this->redirect($this->referer());

        }//if ($this->EmailFunctions->sendMail($sendMail))
        
        /**********************************************************************/

        $this->Flash->error(__('Houve uma falha no envio da relação de clientes por e-mail'));
        return $this->redirect($this->referer());
    }
    
    public function recuperaSenha()
    {
        //Acessa a tabelas
        $this->Users = TableRegistry::get('Users');

        /**********************************************************************/

        //Identifica as variáveis
        $q_hash  = $this->request->query('h');
        $q_email = $this->request->query('mail');
        
        /**********************************************************************/

        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //Consulta o usuário
            $user = $this->Users->find('all')
                                ->where(['Users.username' => $q_email])
                                ->first();
        
            /******************************************************************/
            
            if ($this->SystemFunctions->GETuserRules($user->id, $this->request->Session()->read('sessionParameterControl')) == 'super') { //NÃO PERMITE MUDAR DADOS DO DESENVOLVEDOR
                $this->Flash->error(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if ($this->SystemFunctions->GETuserRules($User->id, $this->request->Session()->read('sessionParameterControl')) == 'super')
        
            /******************************************************************/
            
            $user = $this->Users->patchEntity($user, $this->request->getData());
        
            /******************************************************************/

            //Valida token
            if ($q_hash == $user->redefinir_senha) {
                
                //Limpa campo de redifinição de senha
                $user->redefinir_senha = null;
                
                //Salva alterações
                if ($this->Users->save($user)) {

                    $this->Flash->success(__('Senha alterada com sucesso'));
                    return $this->redirect($this->Auth->logout());

                }//if (!$this->Users->save($user))
                
            }//if ($q_hash == $user->redefinir_senha)
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PagesController->recuperaSenha, Users';
            $this->Error->registerError($user, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Senha NÃO alterada, tente novamente'));
            return $this->redirect($this->Auth->logout());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
    }
    
    public function reenviaSenha()
    {
        //Acessa a tabelas
        $this->Users = TableRegistry::get('Users');
        
        /**********************************************************************/
            
        if ($this->request->is('post')) {

            $username = $this->request->data['username'];
            
            if (!empty($username)) {

                //Consulta o usuário
                $user = $this->Users->findByUsername($username)
                                    ->first();

                /***************************************************************/

                if (!empty($user)) {

                    //Cria o token de validação
                    $token = bin2hex(random_bytes(16));

                    /***********************************************************/

                    //Grava token gerado no banco
                    $user->redefinir_senha = $token;

                    //Salva alterações
                    if (!$this->Users->save($user)) {

                        //Alerta de erro
                        $message = 'PagesController->reenviaSenha';
                        $this->Error->registerError($user, $message, true);

                    }//if (!$this->Users->save($user))

                    /***********************************************************/

                    //Envia e-mail com senha
                    $sendMail = ['subject'  => 'SISTEMA R2: Recuperar senha do controle financeiro',
                                 'template' => 'reenvia_senha',
                                 'vars'     => ['nome'  => $user->name, 
                                                'email' => $user->username, 
                                                'hash'  => $token
                                                ],
                                  'toEmail'  => $user->username
                                ];

                    /***********************************************************/
    
                    if ($this->EmailFunctions->sendMail($sendMail)) {
                        
                        $this->Flash->success(__('E-mail enviado! Verifique sua caixa de entrada'));
                        return $this->redirect($this->referer());
    
                    }//if ($Email->send())
    
                }//if (!empty($user))

            }//if (!empty($this->request->data['username']))

            /*******************************************************************/
            
            $this->Flash->error(__('Houve uma falha na recuperação da senha! Entre em contato com o suporte@reiniciando.com.br'));
            return $this->redirect($this->referer());

        }//if ($this->request->is('post'))
        
        $this->set(compact('user'));
    }
    
    public function download($file, $localizacao = null)
    {
        if ($localizacao == 'backup') { 
            if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        }//if ($localizacao == 'backup')
        
        $this->response->file($localizacao . '/' . utf8_decode($file));
        
        return $this->response;
    }
    
    public function update() 
    {
        if ($this->request->is(['get'])) {
            
            if ($this->request->query['token'] == 'y5eehc123avse6463asd35k3cb6') { 
                
                //CRIA DIRETÓRIO SE NÃO EXISTIR 
                if (!file_exists('log.log')) {
                    @fopen('log.log', 'x+');
                }
                
                //O USO DESSA OPÇÃO É PREJUDICIAL AOS ARQUIVOS DE LOG QUE SERÃO SOBRESCRITOS
                //shell_exec("git reset --hard FETCH_HEAD 2>&1");
                //shell_exec("git clean -df 2>&1");
                
                $shell = shell_exec("git pull origin master 2>&1");
                
                $textoLog  = PHP_EOL . '================================================ <br />';
                $textoLog .= PHP_EOL . "Data: " . date('d'."/".'m'."/".'Y'." - ".'H'.":".'i'.":".'s') . '<br>';
                $textoLog .= PHP_EOL . $shell . '<br>';
                $textoLog .= PHP_EOL . '================================================ <br />';
                
                $arquivoLog = fopen('log.log', 'r+');
                fwrite($arquivoLog, $textoLog);
                fclose($arquivoLog);
                
                //Executa Função de atualização dos arquivos de banco de dados
                $this->updateBD();
                
                //Atualiza data de validade
                //$this->Users->query('UPDATE parameters SET parameters.dtvalidade = ' . date('Y-m-d', strtotime('Y-m-d' + 864000)));
                                
                $this->Flash->success(__('Atualização realizada com sucesso'));
                return $this->redirect($this->referer());  
            }
            
        }
        
        $this->Flash->error(__('Sistema NÃO atualizado'));
        return $this->redirect($this->referer());
    }
    
    public function updateBD()
    {
        $conn = ConnectionManager::get('default');
        
        //CRIA DIRETÓRIO SE NÃO EXISTIR
        if (!file_exists('database/')) {
            umask(0); 
            @mkdir("database", 0777, true);
        }
        
        //Lista arquivos do diretório database, dentro de webroot
        $dir = 'database/';
        
        try {

            if (!@scandir($dir)) {

                throw new Exception(__('Diretório inexistente ou não localizado'));

            } else {

                foreach(scandir($dir) as $file):

                    if (filetype($dir.$file) == 'file') {

                        //Caminho do arquivo .sql
                        $filename = $dir . $file;

                        //Abre e lê o arquivo de script SQL
                        $updateSQL = fopen($filename, 'r+');
                        $conteudo  = fread($updateSQL, filesize ($filename));
                        $exception = null;
                        $result    = null;
                        
                        if (count(explode('/*', $conteudo)) == 1) {

                            //Executa Query
                            try{

                                $result = @$conn->execute($conteudo);

                            } catch (Exception $ex) {

                                $exception = $ex->getMessage();

                                //Alerta de erro
                                $message = 'PagesController->updateBD, execute query' . $ex->getMessage();
                                $this->Error->registerError(null, $message, true);

                            }
                            
                            //Comenta arquivo após execução
                            if (!empty($result)) {$result = 'Comando Executado ';} else {$result = 'Comando Não Executado ';}
                            
                            //Montagem do arquivo de Log
                            $textoLog  = PHP_EOL . '================================================ <br />';
                            $textoLog .= PHP_EOL . "Data: " . date('d'."/".'m'."/".'Y'." - ".'H'.":".'i'.":".'s');
                            $textoLog .= PHP_EOL . $result . $filename . '<br>';
                            $textoLog .= PHP_EOL . $conteudo . '<br>';
                            $textoLog .= PHP_EOL . $exception . '<br>';
                            $textoLog .= PHP_EOL . '================================================ <br />';

                            //Grava Log
                            $arquivoLog = fopen('logBD.log', 'r+');
                            fwrite($arquivoLog, $textoLog);

                            //Fecha os arquivos
                            fclose($arquivoLog);
                            fclose($updateSQL);
                            unlink($filename);

                        } else {

                            //Fecha os arquivos
                            fclose($updateSQL);

                        }//else if (count(explode('/*', $conteudo)) == 1)

                    }//if (filetype($dir.$file) == 'file')

                endforeach;

            }//else if (!@scandir($dir))

        } catch (Exception $e) {

            //Montagem do arquivo de Log
            $textoLog  = PHP_EOL . "Data: " . date('d'."/".'m'."/".'Y'." - ".'H'.":".'i'.":".'s');
            $textoLog .= 'Exceção capturada: '. $e->getMessage(). "<br>";

            //Alerta de erro
            $message = 'PagesController->updateBD ' . $e->getMessage();
            $this->Error->registerError(null, $message, true);
            
            //Grava Log
            $arquivoLog = fopen('logBD.log', 'r+');
            fwrite($arquivoLog, $textoLog);
            
            //FECHA ARQUIVO
            fclose($arquivoLog);

        }
    }
    
    public function viewSystemLog()
    {
        $dir        = new Folder(LOGS);
        $log_file   = new File($dir->pwd() . DS . 'error.log');
        $debug_file = new File($dir->pwd() . DS . 'debug.log');
        
        ////////////////////////////////////////////////////////////////////////
        
        //LIMPAR O ARQUIVO DE LOG
        if (isset($_GET['clearLog'])) {

            //Limpa error.log
            $log_file->write('');
            $log_file->close();
            
            //Limpa debug.log
            $debug_file->write('');
            $debug_file->close();
            
            //Reload removendo os parâmetros
            header("Refresh:0; url=" . $_SERVER['HTTP_REFERER']);

        }//if (isset($_GET['clearLog']))
        
        ////////////////////////////////////////////////////////////////////////
        
        //$content .= '<<<<< LOG DO SISTEMA >>>>>' . PHP_EOL;
        $content['system'][] = $log_file->read();
       
        ////////////////////////////////////////////////////////////////////////
        
        //$content .= '<<<<< DEBUG DO SISTEMA >>>>>' . PHP_EOL;
        $content['debug'][] = $debug_file->read();
        
        ////////////////////////////////////////////////////////////////////////
        
        $log_file->close();
        $debug_file->close();
        
        ////////////////////////////////////////////////////////////////////////
        
        $this->set('viewSystemLog', $content);
        //NÃO BUSCA A VIEW
        //$this->autoRender = false;
    }
    
    public function viewUpdateLog()
    {
	    $dir        = new Folder(WWW_ROOT);
        $log_file   = new File($dir->pwd() . DS . 'log.log');
        $bd_file    = new File($dir->pwd() . DS . 'logBD.log');
        
        //LIMPAR O ARQUIVO DE LOG
        if (isset($_GET['clearLog'])) {
	        
            //Limpa error.log
            $log_file->write('File Empty');
            $log_file->close();
            
            //Limpa debug.log
            $bd_file->write('File Empty');
            $bd_file->close();
            
            //Reload removendo os parâmetros
            header("Refresh:0; url=" . $_SERVER['HTTP_REFERER']);
            
        }//if (isset($_GET['clearLog']))
        
        ////////////////////////////////////////////////////////////////////////
        
        //$content = '<<<<< LOG DO SISTEMA >>>>>' . PHP_EOL;
        $content['system'][] = $log_file->read();
       
        ////////////////////////////////////////////////////////////////////////
        
        //$content = '<<<<< LOG BD >>>>>' . PHP_EOL;
        $content['db'][] = $bd_file->read();
        
        ////////////////////////////////////////////////////////////////////////
        
        $log_file->close();
        $bd_file->close();
        
        ////////////////////////////////////////////////////////////////////////
        
        $this->set('viewUpdateLog', $content);
        //NÃO BUSCA A VIEW
        //$this->autoRender = false;
    }
    
    public function debugMode()
    {
        $debug = Configure::read('debug');
        
        if ($debug) {
            
            Configure::write('debug', false);
            $this->Flash->warning(__('Modo DEBUG desativado!'));
            
        } else {
            
            Configure::write('debug', true);
            $this->Flash->warning(__('Modo DEBUG ativo!'));
            
        }//else if ($debug)
        
        $this->request->Session()->write('debug', $debug);
        
        return $this->redirect($this->referer());
    }
    
    public function changeLocale()
    {
        $this->Users = TableRegistry::get('Users');
        
        /**********************************************************************/
        
        $lang = $this->Users->findById($this->Auth->user('id'))
                                ->select(['Users.id', 'Users.language'])
                            ->first();
        
        /**********************************************************************/
        
        if (empty($lang->language)) {
            
            $lang->language = 'pt_BR';
            
            if (!$this->Users->save($lang)) {

                //Alerta de erro
                $message = 'PagesController->changeLocale, empty';
                $this->Error->registerError($lang, $message, true);

            }//if (!$this->Users->save($lang))
            
        }//if (!empty($lang->language))
        
        /**********************************************************************/
        
        if ($this->request->Session()->read('locale') == 'en_US') {
            
            $lang->language = 'pt_BR';
            
        } elseif ($this->request->Session()->read('locale') == 'pt_BR') {
            
            $lang->language = 'en_US';
            
        }//if ($this->request->Session()->read('locale') == 'en_US'/'pt_BR')
        
        /**********************************************************************/
        
        $this->request->Session()->write('locale', $lang->language);
        
        /**********************************************************************/
        
        if (!$this->Users->save($lang)) {

            //Alerta de erro
            $message = 'PagesController->changeLocale';
            $this->Error->registerError($lang, $message, true);

        }//if (!$this->Users->save($lang))
        
        /**********************************************************************/
        
        return $this->redirect($this->referer());
    }
    
    public function display(...$path)
    {
        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }
}
