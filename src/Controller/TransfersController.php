<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Transfers */
/* File: src/Controller/TransfersController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Log\Log;

class TransfersController extends AppController
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
        
        $this->loadComponent('TransfersFunctions');
        $this->loadComponent('MovimentsFunctions');
    }
    
    public function index()
    {
        //VERIFICA SE HÁ BANCOS CADASTRADOS
        if ($message = $this->SystemFunctions->validaCadastros("banco", $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__($message), ['escape' => false]);
        }//if ($message = $this->SystemFunctions->validaCadastros("banco", $this->request->Session()->read('sessionParameterControl')))
        
        //VERIFICA SE HÁ CARTÕES CADASTRADOS
        if ($message = $this->SystemFunctions->validaCadastros("caixa", $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__($message), ['escape' => false]);
        }//if ($message = $this->SystemFunctions->validaCadastros("caixa", $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);

        $fields = ['Transfers.id', 'Transfers.banks_id', 'Transfers.boxes_id', 'Transfers.costs_id',
                   'Transfers.event_types_id','Transfers.banks_dest', 'Transfers.boxes_dest', 'Transfers.costs_dest',
                   'Transfers.ordem', 'Transfers.data', 'Transfers.valor', 'Transfers.documento', 'Transfers.historico',
                   'Transfers.contabil', 'Transfers.status', 'Transfers.username',
                   'Banks.id', 'Banks.title',
                   'Boxes.id', 'Boxes.title',
                   'Banks_Dest.id', 'Banks_Dest.title', 
                   'Boxes_Dest.id', 'Boxes_Dest.title',
                   'Costs.id', 'Costs.title',
                   'CostsDest.id', 'CostsDest.title',
                   'EventTypes.id', 'EventTypes.title', 
                   'Costs.id', 'Costs.title', 'Costs.parameters_id', 
                   'CostsDest.id', 'CostsDest.title', 'CostsDest.parameters_id',
                   'MovimentBanks.id', 'MovimentBanks.banks_id', 'MovimentBanksDest.id', 'MovimentBanksDest.banks_id',
                   'MovimentBoxes.id', 'MovimentBoxes.boxes_id', 'MovimentBoxesDest.id', 'MovimentBoxesDest.boxes_id', 
                   'MovimentBanks.ordem', 'MovimentBanks.data', 'MovimentBanks.vencimento', 'MovimentBanks.documento', 
                   'MovimentBanks.historico', 'MovimentBanks.valorbaixa', 'MovimentBanks.costs_id', 
                   'MovimentBanksDest.ordem', 'MovimentBanksDest.data', 'MovimentBanksDest.vencimento', 'MovimentBanksDest.documento', 
                   'MovimentBanksDest.historico', 'MovimentBanksDest.valorbaixa', 'MovimentBanksDest.costs_id', 
                   'MovimentBoxes.ordem', 'MovimentBoxes.data', 'MovimentBoxes.vencimento', 'MovimentBoxes.documento', 
                   'MovimentBoxes.historico', 'MovimentBoxes.valorbaixa', 'MovimentBoxes.costs_id', 
                   'MovimentBoxesDest.ordem', 'MovimentBoxesDest.data', 'MovimentBoxesDest.vencimento', 'MovimentBoxesDest.documento', 
                   'MovimentBoxesDest.historico', 'MovimentBoxesDest.valorbaixa', 'MovimentBoxesDest.costs_id'
                  ];
        
        $transfers = $this->Transfers->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->select($fields)
                                     ->contain(['Banks', 'Boxes', 'EventTypes',
                                                'AccountPlans', 'Banks_Dest', 'Boxes_Dest'
                                               ])
                                     ->where($where)
                                     ->join(['MovimentBanks' => ['table'      => 'Moviment_Banks',
                                                                 'type'       => 'LEFT',
                                                                 'conditions' => 'MovimentBanks.banks_id = Transfers.banks_id AND MovimentBanks.transfers_id = Transfers.id'
                                                                ],
                                             'MovimentBoxes' => ['table'      => 'Moviment_Boxes',
                                                                 'type'       => 'LEFT',
                                                                 'conditions' => 'MovimentBoxes.boxes_id = Transfers.boxes_id AND MovimentBoxes.transfers_id = Transfers.id'
                                                                ],
                                             'MovimentBanksDest' => ['table'      => 'Moviment_Banks',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'MovimentBanksDest.banks_id = Transfers.banks_dest AND MovimentBanksDest.transfers_id = Transfers.id'
                                                                    ],
                                             'MovimentBoxesDest' => ['table'      => 'Moviment_Boxes',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'MovimentBoxesDest.boxes_id = Transfers.boxes_dest AND MovimentBoxesDest.transfers_id = Transfers.id'
                                                                    ],
                                             'Costs' => ['table'      => 'Costs',
                                                         'type'       => 'LEFT',
                                                         'conditions' => 'MovimentBanks.costs_id = Costs.id OR MovimentBoxes.costs_id = Costs.id'
                                                        ],
                                             'CostsDest' => ['table'      => 'Costs',
                                                             'type'       => 'LEFT',
                                                             'conditions' => 'MovimentBanks.costs_id = CostsDest.id OR MovimentBoxes.costs_id = CostsDest.id'
                                                            ]                                                  
                                            ])
                                     ->order(['Transfers.ordem DESC']);
                                     //->limit(200);
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $transfers = $this->paginate($transfers);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $transfers = $this->paginate($transfers);
            
        }
        
        $this->set(compact('transfers'));
    }
    
    public function indexSimple()
    {
        //VERIFICA SE HÁ BANCOS CADASTRADOS
        if ($message = $this->SystemFunctions->validaCadastros("banco", $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__($message), ['escape' => false]);
        }//if ($message = $this->SystemFunctions->validaCadastros("banco", $this->request->Session()->read('sessionParameterControl')))
        
        //VERIFICA SE HÁ CARTÕES CADASTRADOS
        if ($message = $this->SystemFunctions->validaCadastros("caixa", $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__($message), ['escape' => false]);
        }//if ($message = $this->SystemFunctions->validaCadastros("caixa", $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);

        $fields = ['Transfers.id', 'Transfers.banks_id', 'Transfers.boxes_id', 'Transfers.costs_id',
                   'Transfers.event_types_id','Transfers.banks_dest', 'Transfers.boxes_dest', 'Transfers.costs_dest',
                   'Transfers.ordem', 'Transfers.data', 'Transfers.valor', 'Transfers.documento', 'Transfers.historico',
                   'Transfers.contabil', 'Transfers.status', 'Transfers.username',
                   'Banks.id', 'Banks.title',
                   'Boxes.id', 'Boxes.title',
                   'Banks_Dest.id', 'Banks_Dest.title', 
                   'Boxes_Dest.id', 'Boxes_Dest.title',
                   'Costs.id', 'Costs.title',
                   'CostsDest.id', 'CostsDest.title',
                   'EventTypes.id', 'EventTypes.title', 
                   'Costs.id', 'Costs.title', 'Costs.parameters_id', 
                   'CostsDest.id', 'CostsDest.title', 'CostsDest.parameters_id',
                   'MovimentBanks.id', 'MovimentBanks.banks_id', 'MovimentBanksDest.id', 'MovimentBanksDest.banks_id',
                   'MovimentBoxes.id', 'MovimentBoxes.boxes_id', 'MovimentBoxesDest.id', 'MovimentBoxesDest.boxes_id', 
                   'MovimentBanks.ordem', 'MovimentBanks.data', 'MovimentBanks.vencimento', 'MovimentBanks.documento', 
                   'MovimentBanks.historico', 'MovimentBanks.valorbaixa', 'MovimentBanks.costs_id', 
                   'MovimentBanksDest.ordem', 'MovimentBanksDest.data', 'MovimentBanksDest.vencimento', 'MovimentBanksDest.documento', 
                   'MovimentBanksDest.historico', 'MovimentBanksDest.valorbaixa', 'MovimentBanksDest.costs_id', 
                   'MovimentBoxes.ordem', 'MovimentBoxes.data', 'MovimentBoxes.vencimento', 'MovimentBoxes.documento', 
                   'MovimentBoxes.historico', 'MovimentBoxes.valorbaixa', 'MovimentBoxes.costs_id', 
                   'MovimentBoxesDest.ordem', 'MovimentBoxesDest.data', 'MovimentBoxesDest.vencimento', 'MovimentBoxesDest.documento', 
                   'MovimentBoxesDest.historico', 'MovimentBoxesDest.valorbaixa', 'MovimentBoxesDest.costs_id'
                  ];
        
        $transfers = $this->Transfers->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->select($fields)
                                     ->contain(['Banks', 'Boxes', 'EventTypes',
                                                'AccountPlans', 'Banks_Dest', 'Boxes_Dest'
                                               ])
                                     ->where($where)
                                     ->join(['MovimentBanks' => ['table'      => 'Moviment_Banks',
                                                                 'type'       => 'LEFT',
                                                                 'conditions' => 'MovimentBanks.banks_id = Transfers.banks_id AND MovimentBanks.transfers_id = Transfers.id'
                                                                ],
                                             'MovimentBoxes' => ['table'      => 'Moviment_Boxes',
                                                                 'type'       => 'LEFT',
                                                                 'conditions' => 'MovimentBoxes.boxes_id = Transfers.boxes_id AND MovimentBoxes.transfers_id = Transfers.id'
                                                                ],
                                             'MovimentBanksDest' => ['table'      => 'Moviment_Banks',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'MovimentBanksDest.banks_id = Transfers.banks_dest AND MovimentBanksDest.transfers_id = Transfers.id'
                                                                    ],
                                             'MovimentBoxesDest' => ['table'      => 'Moviment_Boxes',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'MovimentBoxesDest.boxes_id = Transfers.boxes_dest AND MovimentBoxesDest.transfers_id = Transfers.id'
                                                                    ],
                                             'Costs' => ['table'      => 'Costs',
                                                         'type'       => 'LEFT',
                                                         'conditions' => 'MovimentBanks.costs_id = Costs.id OR MovimentBoxes.costs_id = Costs.id'
                                                        ],
                                             'CostsDest' => ['table'      => 'Costs',
                                                             'type'       => 'LEFT',
                                                             'conditions' => 'MovimentBanks.costs_id = CostsDest.id OR MovimentBoxes.costs_id = CostsDest.id'
                                                            ]                                 
                                            ])
                                     ->order(['Transfers.ordem DESC']);
                                     //->limit(200);
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $transfers = $this->paginate($transfers);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $transfers = $this->paginate($transfers);
            
        }
        
        $this->set(compact('transfers'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $transfer = $this->Transfers->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->select(['Transfers.historico', 'Transfers.obs', 'Transfers.programacao', 'Transfers.data',
                                              'Transfers.valor', 'Transfers.document_types_id', 'Transfers.event_types_id', 
                                              'Transfers.cheque', 'Transfers.emissaoch', 'Transfers.nominal', 'Transfers.parameters_id', 
                                              'Transfers.ordem', 'Transfers.documento', 'Transfers.contabil', 'Transfers.status', 
                                              'Transfers.created', 'Transfers.modified', 'Transfers.username', 
                                              'Transfers.banks_id', 'Transfers.banks_dest', 
                                              'Transfers.boxes_id', 'Transfers.boxes_dest', 
                                              'Transfers.account_plans_id', 'Transfers.account_plans_dest', 
                                              'Transfers.costs_id', 'Transfers.costs_dest', 
                                              'DocumentTypes.id', 'DocumentTypes.title', 'DocumentTypes.parameters_id', 
                                              'EventTypes.id', 'EventTypes.title', 'EventTypes.parameters_id', 
                                              'MovimentChecks.id', 'MovimentChecks.data', 'MovimentChecks.cheque', 'MovimentChecks.parameters_id', 
                                              'Banks.id', 'Banks.title', 'Banks.parameters_id', 
                                              'BanksDest.id', 'BanksDest.title', 'BanksDest.parameters_id', 
                                              'Boxes.id', 'Boxes.title', 'Boxes.parameters_id', 
                                              'BoxesDest.id', 'BoxesDest.title', 'BoxesDest.parameters_id', 
                                              'AccountPlans.id', 'AccountPlans.classification', 'AccountPlans.title', 'AccountPlans.parameters_id', 
                                              'AccountPlansDest.id', 'AccountPlansDest.classification', 'AccountPlansDest.title', 'AccountPlansDest.parameters_id', 
                                              'Costs.id', 'Costs.title', 'Costs.parameters_id', 
                                              'CostsDest.id', 'CostsDest.title', 'CostsDest.parameters_id',
                                              'MovimentBanks.id', 'MovimentBanks.banks_id', 'MovimentBanksDest.id', 'MovimentBanksDest.banks_id',
                                              'MovimentBoxes.id', 'MovimentBoxes.boxes_id', 'MovimentBoxesDest.id', 'MovimentBoxesDest.boxes_id', 
                                              'MovimentBanks.ordem', 'MovimentBanks.data', 'MovimentBanks.vencimento', 'MovimentBanks.documento', 'MovimentBanks.historico', 'MovimentBanks.valorbaixa', 
                                              'MovimentBanksDest.ordem', 'MovimentBanksDest.data', 'MovimentBanksDest.vencimento', 'MovimentBanksDest.documento', 'MovimentBanksDest.historico', 'MovimentBanksDest.valorbaixa', 
                                              'MovimentBoxes.ordem', 'MovimentBoxes.data', 'MovimentBoxes.vencimento', 'MovimentBoxes.documento', 'MovimentBoxes.historico', 'MovimentBoxes.valorbaixa', 
                                              'MovimentBoxesDest.ordem', 'MovimentBoxesDest.data', 'MovimentBoxesDest.vencimento', 'MovimentBoxesDest.documento', 'MovimentBoxesDest.historico', 'MovimentBoxesDest.valorbaixa'
                                             ])
                                    ->contain(['EventTypes', 'DocumentTypes'])
                                    ->join(['MovimentChecks' => ['table'      => 'Moviment_Checks',
                                                                 'type'       => 'LEFT',
                                                                 'conditions' => 'Transfers.id = MovimentChecks.transfers_id'
                                                                ],
                                            'Banks' => ['table'      => 'Banks',
                                                        'type'       => 'LEFT',
                                                        'conditions' => 'Transfers.banks_id = Banks.id'
                                                       ],
                                            'BanksDest' => ['table'      => 'Banks',
                                                            'type'       => 'LEFT',
                                                            'conditions' => 'Transfers.banks_dest = BanksDest.id'
                                                           ],
                                            'Boxes' => ['table'      => 'Boxes',
                                                        'type'       => 'LEFT',
                                                        'conditions' => 'Transfers.boxes_id = Boxes.id'
                                                       ],
                                            'BoxesDest' => ['table'      => 'Boxes',
                                                            'type'       => 'LEFT',
                                                            'conditions' => 'Transfers.boxes_dest = BoxesDest.id'
                                                           ],
                                            'AccountPlans' => ['table'      => 'Account_Plans',
                                                               'type'       => 'LEFT',
                                                               'conditions' => 'Transfers.account_plans_id = AccountPlans.id'
                                                              ],
                                            'AccountPlansDest' => ['table'      => 'Account_Plans',
                                                                  'type'       => 'LEFT',
                                                                  'conditions' => 'Transfers.account_plans_dest = AccountPlansDest.id'
                                                                 ],
                                            'MovimentBanks' => ['table'      => 'Moviment_Banks',
                                                                'type'       => 'LEFT',
                                                                'conditions' => 'MovimentBanks.banks_id = Transfers.banks_id AND MovimentBanks.transfers_id = Transfers.id'
                                                               ],
                                            'MovimentBoxes' => ['table'      => 'Moviment_Boxes',
                                                                'type'       => 'LEFT',
                                                                'conditions' => 'MovimentBoxes.boxes_id = Transfers.boxes_id AND MovimentBoxes.transfers_id = Transfers.id'
                                                               ],
                                            'MovimentBanksDest' => ['table'      => 'Moviment_Banks',
                                                                    'type'       => 'LEFT',
                                                                    'conditions' => 'MovimentBanksDest.banks_id = Transfers.banks_dest AND MovimentBanksDest.transfers_id = Transfers.id'
                                                                   ],
                                            'MovimentBoxesDest' => ['table'      => 'Moviment_Boxes',
                                                                    'type'       => 'LEFT',
                                                                    'conditions' => 'MovimentBoxesDest.boxes_id = Transfers.boxes_dest AND MovimentBoxesDest.transfers_id = Transfers.id'
                                                                   ],
                                            'Costs' => ['table'      => 'Costs',
                                                        'type'       => 'LEFT',
                                                        'conditions' => 'MovimentBanks.costs_id = Costs.id OR MovimentBoxes.costs_id = Costs.id'
                                                        ],
                                            'CostsDest' => ['table'      => 'Costs',
                                                            'type'       => 'LEFT',
                                                            'conditions' => 'MovimentBanks.costs_id = CostsDest.id OR MovimentBoxes.costs_id = CostsDest.id'
                                                            ]
                                           ])
                                    ->first();
        
        $this->set(compact('transfer'));
    }

    public function viewSimple($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $transfer = $this->Transfers->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->select(['Transfers.historico', 'Transfers.obs', 'Transfers.programacao', 'Transfers.data',
                                              'Transfers.valor','Transfers.parameters_id', 'Transfers.costs_id', 'Transfers.costs_dest',
                                              'Transfers.ordem', 'Transfers.documento', 'Transfers.contabil', 'Transfers.status', 
                                              'Transfers.created', 'Transfers.modified', 'Transfers.username', 
                                              'Transfers.banks_id', 'Transfers.banks_dest', 
                                              'Transfers.boxes_id', 'Transfers.boxes_dest', 
                                              'Costs.id', 'Costs.title',
                                              'CostsDest.id', 'CostsDest.title',
                                              'Banks.id', 'Banks.title', 'Banks.parameters_id', 
                                              'BanksDest.id', 'BanksDest.title', 'BanksDest.parameters_id', 
                                              'Boxes.id', 'Boxes.title', 'Boxes.parameters_id', 
                                              'BoxesDest.id', 'BoxesDest.title', 'BoxesDest.parameters_id', 
                                              'MovimentBanks.id', 'MovimentBanks.banks_id', 'MovimentBanksDest.id', 'MovimentBanksDest.banks_id',
                                              'MovimentBoxes.id', 'MovimentBoxes.boxes_id', 'MovimentBoxesDest.id', 'MovimentBoxesDest.boxes_id', 
                                              'MovimentBanks.ordem', 'MovimentBanks.data', 'MovimentBanks.vencimento', 'MovimentBanks.documento', 'MovimentBanks.historico', 'MovimentBanks.valorbaixa', 
                                              'MovimentBanksDest.ordem', 'MovimentBanksDest.data', 'MovimentBanksDest.vencimento', 'MovimentBanksDest.historico', 'MovimentBanksDest.valorbaixa', 
                                              'MovimentBoxes.ordem', 'MovimentBoxes.data', 'MovimentBoxes.vencimento', 'MovimentBoxes.historico', 'MovimentBoxes.valorbaixa', 
                                              'MovimentBoxesDest.ordem', 'MovimentBoxesDest.data', 'MovimentBoxesDest.vencimento', 'MovimentBoxesDest.historico', 'MovimentBoxesDest.valorbaixa'
                                             ])
                                    ->contain(['EventTypes', 'DocumentTypes'])
                                    ->join(['Banks' => ['table'      => 'Banks',
                                                        'type'       => 'LEFT',
                                                        'conditions' => 'Transfers.banks_id = Banks.id'
                                                       ],
                                            'BanksDest' => ['table'      => 'Banks',
                                                            'type'       => 'LEFT',
                                                            'conditions' => 'Transfers.banks_dest = BanksDest.id'
                                                           ],
                                            'Boxes' => ['table'      => 'Boxes',
                                                        'type'       => 'LEFT',
                                                        'conditions' => 'Transfers.boxes_id = Boxes.id'
                                                       ],
                                            'BoxesDest' => ['table'      => 'Boxes',
                                                            'type'       => 'LEFT',
                                                            'conditions' => 'Transfers.boxes_dest = BoxesDest.id'
                                                           ],
                                            'MovimentBanks' => ['table'      => 'Moviment_Banks',
                                                                'type'       => 'LEFT',
                                                                'conditions' => 'MovimentBanks.banks_id = Transfers.banks_id AND MovimentBanks.transfers_id = Transfers.id'
                                                               ],
                                            'MovimentBoxes' => ['table'      => 'Moviment_Boxes',
                                                                'type'       => 'LEFT',
                                                                'conditions' => 'MovimentBoxes.boxes_id = Transfers.boxes_id AND MovimentBoxes.transfers_id = Transfers.id'
                                                               ],
                                            'MovimentBanksDest' => ['table'      => 'Moviment_Banks',
                                                                    'type'       => 'LEFT',
                                                                    'conditions' => 'MovimentBanksDest.banks_id = Transfers.banks_dest AND MovimentBanksDest.transfers_id = Transfers.id'
                                                                   ],
                                            'MovimentBoxesDest' => ['table'      => 'Moviment_Boxes',
                                                                    'type'       => 'LEFT',
                                                                    'conditions' => 'MovimentBoxesDest.boxes_id = Transfers.boxes_dest AND MovimentBoxesDest.transfers_id = Transfers.id'
                                                                   ],
                                            'Costs' => ['table'      => 'Costs',
                                                        'type'       => 'LEFT',
                                                        'conditions' => 'MovimentBanks.costs_id = Costs.id OR MovimentBoxes.costs_id = Costs.id'
                                                        ],
                                            'CostsDest' => ['table'      => 'Costs',
                                                            'type'       => 'LEFT',
                                                            'conditions' => 'MovimentBanks.costs_id = CostsDest.id OR MovimentBoxes.costs_id = CostsDest.id'
                                                            ]
                                           ])
                                    ->first();
        
        $this->set(compact('transfer'));
    }

    public function add()
    {
        $transfer = $this->Transfers->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $transfer = $this->Transfers->patchEntity($transfer, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE OS CAMPOS
            $transfer->username      = $this->Auth->user('name');
            $transfer->status        = 'B';
            $transfer->coins_id      = '1';
            $transfer->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            /******************************************************************/
            
            // ORIGEM
            if ($transfer->radio_origem == 'banco_origem') {
                
                $banks = $transfer->banks_id;
                $transfer->boxes_id = null;
                
            } elseif ($transfer->radio_origem == 'caixa_origem') {
                
                $boxes = $transfer->boxes_id;
                $transfer->banks_id = null;
                
            }//elseif ($transfer->radio_origem == 'caixa_origem')
            
            /******************************************************************/
            
            // DESTINO
            if ($transfer->radio_destino == 'banco_destino') {
                
                $banks_dest = $transfer->banks_dest;
                $transfer->boxes_dest = null;
                
            } elseif ($transfer->radio_destino == 'caixa_destino') {
                
                $boxes_dest = $transfer->boxes_dest;
                $transfer->banks_dest = null;
                
            }//elseif ($transfer->radio_destino == 'caixa_destino')
            
            /******************************************************************/
            
            //IDENTIFICA SE OS CAMPOS OBRIGATÓRIOS FORAM PREENCHIDOS
            if (empty($banks) && empty($boxes)) {
                $this->Flash->error(__('Registro NÃO gravado, Banco/Caixa não selecionado'));
                return $this->redirect($this->referer());
            }//if (empty($banks) && empty($boxes))
            if (empty($banks_dest) && empty($boxes_dest)) {
                $this->Flash->error(__('Registro NÃO gravado, Banco/Caixa de destino não selecionado'));
                return $this->redirect($this->referer());
            }//if (empty($banks_dest) && empty($boxes_dest))
            
            /******************************************************************/
            
            $source  = ['.', ','];
            $replace = ['', '.'];
            $transfer->valor = (float) str_replace($source, $replace, $transfer->valor);
            
            $transfer->valorbaixa = $transfer->valor*-1;
            $transfer->dtbaixa    = $transfer->data; //new Time(strtotime($transfer->data));
            
            /******************************************************************/
            
            //DEFINE O VALOR DA ORDEM
            $ordem = $this->Transfers->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->select(['MAX' => 'MAX(Transfers.ordem)'])
                                     ->first();
            $ordem = $ordem->MAX;
            $transfer->ordem = $ordem + 1;
            
            /******************************************************************/
            
            // REGISTRA CHEQUES
            if (empty($transfer->programacao) && !empty($transfer->cheque)) {
                $this->RegisterMoviments->movimentCheck($transfer, $ordem + 1); 
            }//if (empty($transfer->programacao) && !empty($transfer->cheque))
            
            /******************************************************************/
            
            if ($this->Transfers->save($transfer)) {
                
                //TRANSFERÊNCIA PROGRAMADA
                if (empty($transfer->programacao)) {
                    
                    // REGISTRA OS SALDOS
                    $this->GeneralBalance->balance($transfer);
                    
                    // REGISTRA MOVIMENTOS BANCÁRIOS E CAIXAS
                    $this->TransfersFunctions->transfer($transfer);
                    
                }//if (empty($transfer->programacao))
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Transfers->save($transfer))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'TransfersControler->add';
            $this->Error->registerError($transfer, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('documentTypes', $this->Transfers->DocumentTypes->find('list')->where($conditions)->order(['title']));
        $this->set('eventTypes', $this->Transfers->EventTypes->find('list')->where($conditions)->order(['title']));
        $this->set('boxes', $this->Transfers->Boxes->find('list')->where($conditions)->order(['title']));
        $banks = $this->Transfers->Banks->find('list')->where(['Banks.parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'Banks.tipoconta !=' => 'A'])->order(['Banks.title']);
        $banks = $banks->select(['id', 'title' => $banks->func()->concat(['Banks.title' => 'identifier', 
                                                                          ' - (',
                                                                          'Banks.agencia' => 'identifier', 
                                                                          ' / ',
                                                                          'Banks.conta' => 'identifier', 
                                                                          ') '
                                                                         ])
                                ]);
        $this->set('banks', $banks);
        $this->set('costs', $this->Transfers->Costs->find('list')->where($conditions)->order(['title']));
        
        $this->set('boxes_dest', $this->Transfers->Boxes_Dest->find('list')->where($conditions)->order(['title']));
        $this->set('banks_dest', $this->Transfers->Banks_Dest->find('list')->where($conditions)->order(['title']));
        $banks_dest = $this->Transfers->Banks_Dest->find('list')->where(['Banks.parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'Banks.tipoconta !=' => 'A'])->order(['Banks.title']);
        $banks_dest = $banks->select(['id', 'title' => $banks_dest->func()->concat(['Banks.title' => 'identifier', 
                                                                                    ' - (',
                                                                                    'Banks.agencia' => 'identifier', 
                                                                                    ' / ',
                                                                                    'Banks.conta' => 'identifier', 
                                                                                    ') '
                                                                                   ])
                                     ]);
        $this->set('banks_dest', $banks_dest);
        $this->set('costs_dest', $this->Transfers->Costs_Dest->find('list')->where($conditions)->order(['title']));
        $accountPlans = $this->Transfers->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
                                                      ->where($conditions)
                                                      ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        
        $this->set('accountPlans', $accountPlans->toArray());
        $this->set('account_plans_dest', $accountPlans->toArray());
    }

    public function addSimple()
    {
        $transfer = $this->Transfers->newEntity();
        
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
            
            $transfer = $this->Transfers->patchEntity($transfer, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE OS CAMPOS
            $transfer->username      = $this->Auth->user('name');
            $transfer->status        = 'B';
            $transfer->coins_id      = '1';
            $transfer->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            /******************************************************************/
            
            // ORIGEM
            if ($transfer->radio_origem == 'banco_origem') {
                
                $banks = $transfer->banks_id;
                $transfer->boxes_id = null;
                
            } elseif ($transfer->radio_origem == 'caixa_origem') {
                
                $boxes = $transfer->boxes_id;
                $transfer->banks_id = null;
                
            }//elseif ($transfer->radio_origem == 'caixa_origem')
            
            /******************************************************************/
            
            // DESTINO
            if ($transfer->radio_destino == 'banco_destino') {
                
                $banks_dest = $transfer->banks_dest;
                $transfer->boxes_dest = null;
                
            } elseif ($transfer->radio_destino == 'caixa_destino') {
                
                $boxes_dest = $transfer->boxes_dest;
                $transfer->banks_dest = null;
                
            }//elseif ($transfer->radio_destino == 'caixa_destino')
            
            /******************************************************************/
            
            //IDENTIFICA SE OS CAMPOS OBRIGATÓRIOS FORAM PREENCHIDOS
            if (empty($banks) && empty($boxes)) {
                $this->Flash->error(__('Registro NÃO gravado, Banco/Caixa não selecionado'));
                return $this->redirect($this->referer());
            }//if (empty($banks) && empty($boxes))
            if (empty($banks_dest) && empty($boxes_dest)) {
                $this->Flash->error(__('Registro NÃO gravado, Banco/Caixa de destino não selecionado'));
                return $this->redirect($this->referer());
            }//if (empty($banks_dest) && empty($boxes_dest))
            
            /******************************************************************/
            
            $source  = ['.', ','];
            $replace = ['', '.'];
            $transfer->valor = (float) str_replace($source, $replace, $transfer->valor);
            
            $transfer->valorbaixa = $transfer->valor*-1;
            $transfer->dtbaixa    = $transfer->data; //new Time(strtotime($transfer->data));
            $transfer->costs_dest = $transfer->costs_id;

            /******************************************************************/
            
            //DEFINE O VALOR DA ORDEM
            $ordem = $this->Transfers->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->select(['MAX' => 'MAX(Transfers.ordem)'])
                                     ->first();
            $ordem = $ordem->MAX;
            $transfer->ordem = $ordem + 1;
            
            /******************************************************************/
            
            // REGISTRA CHEQUES
            if (empty($transfer->programacao) && !empty($transfer->cheque)) {
                $this->RegisterMoviments->movimentCheck($transfer, $ordem + 1); 
            }//if (empty($transfer->programacao) && !empty($transfer->cheque))
            
            /******************************************************************/
            
            if ($this->Transfers->save($transfer)) {
                
                //TRANSFERÊNCIA PROGRAMADA
                if (empty($transfer->programacao)) {
                    
                    // REGISTRA OS SALDOS
                    $this->GeneralBalance->balance($transfer);
                    
                    // REGISTRA MOVIMENTOS BANCÁRIOS E CAIXAS
                    $this->TransfersFunctions->transfer($transfer);
                    
                }//if (empty($transfer->programacao))
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Transfers->save($transfer))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'TransfersControler->addSimple';
            $this->Error->registerError($transfer, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('costs', $this->Transfers->Costs->find('list')->where($conditions)->order(['title']));
        $this->set('boxes', $this->Transfers->Boxes->find('list')->where($conditions)->order(['title']));
        $banks = $this->Transfers->Banks->find('list')->where(['Banks.parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'Banks.tipoconta !=' => 'A'])->order(['Banks.title']);
        $banks = $banks->select(['id', 'title' => $banks->func()->concat(['Banks.title' => 'identifier', 
                                                                          ' - (',
                                                                          'Banks.agencia' => 'identifier', 
                                                                          ' / ',
                                                                          'Banks.conta' => 'identifier', 
                                                                          ') '
                                                                         ])
                                ]);
        $this->set('banks', $banks);
        $this->set('boxes_dest', $this->Transfers->Boxes_Dest->find('list')->where($conditions)->order(['title']));
        $this->set('banks_dest', $this->Transfers->Banks_Dest->find('list')->where($conditions)->order(['title']));
        $banks_dest = $this->Transfers->Banks_Dest->find('list')->where(['Banks.parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'Banks.tipoconta !=' => 'A'])->order(['Banks.title']);
        $banks_dest = $banks->select(['id', 'title' => $banks_dest->func()->concat(['Banks.title' => 'identifier', 
                                                                                    ' - (',
                                                                                    'Banks.agencia' => 'identifier', 
                                                                                    ' / ',
                                                                                    'Banks.conta' => 'identifier', 
                                                                                    ') '
                                                                                   ])
                                     ]);
        $this->set('banks_dest', $banks_dest);
        
    }
    
    public function confirm($id)
    {
        $transfer = $this->Transfers->get($id, ['contain' => ['Banks', 'Boxes']]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {

            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $transfer = $this->Transfers->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                        ->first();
            
            /******************************************************************/
            
            //RETIRA DATA DE PROGRAMAÇÃO PARA FAZER O LANÇAMENTO
            $transfer->data        = $transfer->programacao;
            $transfer->programacao = null;
            
            /******************************************************************/
            
            //REALIZA TRANSFERÊNCIA
            if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) {
                
                return $this->redirect($this->add());
                
            } elseif ($this->request->Session()->read('sessionPlan') == 1) {
                
                return $this->redirect($this->addSimple());
                
            }//elseif ($this->request->Session()->read('sessionPlan') == 1)
            
        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $this->Flash->error(__('Registro NÃO alterado, tente novamente'));
        return $this->redirect($this->referer());
    }

    public function edit($id)
    {
        $transfer = $this->Transfers->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
        							->contain(['AccountPlans_Dest', 'Costs_Dest', 'Banks_Dest', 'Boxes_Dest'])
                                    ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $this->request->data['username'] = $this->Auth->user('name');
            
            /******************************************************************/
            
            //PROGRAMAÇÃO DE TRANSFERÊNCIAS
            if ($this->request->data['prog']) {
                $this->request->data['status'] = 'P';
            }//if ($this->request->data['prog'])
            
            if (!empty($transfer['programacao']) && empty($this->request->data['programacao'])) {
                //NÃO PERMITE REMOVER DATA DE PROGRAMAÇÃO
                $this->request->data['programacao'] = $transfer['programacao'];
            }//if (!empty($transfer['programacao']) && empty($this->request->data['programacao']))
            
            //CAMPOS QUE NÃO PERMITEM ALTERAÇÃO
            $this->request->data['parameters_id'] = $transfer->parameters_id;
            $this->request->data['boxes_id']      = $transfer->boxes_id;
            $this->request->data['boxes_dest']    = $transfer->boxes_dest;
            $this->request->data['banks_id']      = $transfer->banks_id;
            $this->request->data['banks_dest']    = $transfer->banks_dest;
            $this->request->data['radio_origem']  = $transfer->radio_origem;
            $this->request->data['radio_destino'] = $transfer->radio_destino;
            $this->request->data['data']          = $transfer->data;
            $this->request->data['valor']         = $transfer->valor;
            $this->request->data['cheque']        = $transfer->cheque; //certeza?
            $this->request->data['nominal']       = $transfer->nominal; //certeza?
            $this->request->data['emissaoch']     = $transfer->emissaoch; //certeza?
            $this->request->data['contabil']      = $transfer->contabil; //certeza?
            //$this->request->data['status']        = $transfer->status; //certeza?
            
            /******************************************************************/
            
            $transfer = $this->Transfers->patchEntity($transfer, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->Transfers->save($transfer)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Transfers->save($transfer))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'TransfersControler->edit';
            $this->Error->registerError($transfer, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('documentTypes', $this->Transfers->DocumentTypes->find('list')->where($conditions)->order(['title'])); 
        $this->set('eventTypes', $this->Transfers->EventTypes->find('list')->where($conditions)->order(['title'])); 
        $this->set('costs', $this->Transfers->Costs->find('list')->where($conditions)->order(['title'])); 
        $this->set('boxes', $this->Transfers->Boxes->find('list')->where($conditions)->order(['title'])); 
        $this->set('banks', $this->Transfers->Banks->find('list')->where($conditions)->order(['title'])); 
        
        $this->set('boxes_dest', $this->Transfers->Boxes_Dest->find('list')->where($conditions)->order(['title'])); 
        $this->set('banks_dest', $this->Transfers->Banks_Dest->find('list')->where($conditions)->order(['title'])); 
        $this->set('costs_dest', $this->Transfers->Costs_Dest->find('list')->where($conditions)->order(['title'])); 
        $accountPlans = $this->Transfers->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
                                                      ->where($conditions)
                                                      ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
        $this->set('account_plans_dest', $accountPlans->toArray());
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($transfer->data)) {
            $transfer->data = date('d/m/Y', strtotime($transfer->data));
        }
        if (!empty($transfer->programacao)) {
            $transfer->programacao = date('d/m/Y', strtotime($transfer->programacao));
        }
        if (!empty($transfer->emissaoch)) {
            $transfer->emissaoch = date('d/m/Y', strtotime($transfer->emissaoch));
        }
        
        $this->set(compact('transfer'));
    }

    public function editSimple($id)
    {
        $transfer = $this->Transfers->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
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
            
            $this->request->data['username'] = $this->Auth->user('name');
            
            /******************************************************************/
            
            //PROGRAMAÇÃO DE TRANSFERÊNCIAS
            if ($this->request->data['prog']) {
                $this->request->data['status'] = 'P';
            }//if ($this->request->data['prog'])
            
            if (!empty($transfer['programacao']) && empty($this->request->data['programacao'])) {
                //NÃO PERMITE REMOVER DATA DE PROGRAMAÇÃO
                $this->request->data['programacao'] = $transfer['programacao'];
            }//if (!empty($transfer['programacao']) && empty($this->request->data['programacao']))
            
            //CAMPOS QUE NÃO PERMITEM ALTERAÇÃO
            $this->request->data['parameters_id'] = $transfer->parameters_id;
            $this->request->data['boxes_id']      = $transfer->boxes_id;
            $this->request->data['boxes_dest']    = $transfer->boxes_dest;
            $this->request->data['banks_id']      = $transfer->banks_id;
            $this->request->data['banks_dest']    = $transfer->banks_dest;
            $this->request->data['radio_origem']  = $transfer->radio_origem;
            $this->request->data['radio_destino'] = $transfer->radio_destino;
            $this->request->data['data']          = $transfer->data;
            $this->request->data['valor']         = $transfer->valor;
            $this->request->data['contabil']      = $transfer->contabil; 
            $this->request->data['status']        = $transfer->status; 
            
            /******************************************************************/
            
            $transfer = $this->Transfers->patchEntity($transfer, $this->request->getData());

            //Preenche os campos não informados no formulário
            $transfer->costs_dest = $transfer->costs_id;
            
            /******************************************************************/
            
            if ($this->Transfers->save($transfer)) {

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Transfers->save($transfer))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'TransfersControler->editSimple';
            $this->Error->registerError($transfer, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('costs', $this->Transfers->Costs->find('list')->where($conditions)->order(['title']));
        $this->set('boxes', $this->Transfers->Boxes->find('list')->where($conditions)->order(['title'])); 
        $this->set('banks', $this->Transfers->Banks->find('list')->where($conditions)->order(['title'])); 
        
        $this->set('boxes_dest', $this->Transfers->Boxes_Dest->find('list')->where($conditions)->order(['title'])); 
        $this->set('banks_dest', $this->Transfers->Banks_Dest->find('list')->where($conditions)->order(['title'])); 
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($transfer->data)) {
            $transfer->data = date('d/m/Y', strtotime($transfer->data));
        }//if (!empty($transfer->data))
        if (!empty($transfer->programacao)) {
            $transfer->programacao = date('d/m/Y', strtotime($transfer->programacao));
        }//if (!empty($transfer->programacao))
        
        $this->set(compact('transfer'));
    }
    
    public function editBaixado($id) 
    {
        $transfer = $this->Transfers->get($id, ['contain' => ['DocumentTypes', 'EventTypes', 'AccountPlans', 'Costs', 'AccountPlans_Dest', 'Costs_Dest', 'Banks', 'Boxes']]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
        
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $this->request->data['username'] = $this->Auth->user('name');
            
            /******************************************************************/
            
            if (!empty($this->request->data['prog'])) { 
                $this->request->data['status'] = 'P';
            }//if (!empty($this->request->data['prog']))
            
            //CAMPOS QUE NÃO PERMITEM ALTERAÇÃO
            $this->request->data['parameters_id'] = $transfer->parameters_id;
            $this->request->data['boxes_id']      = $transfer->boxes_id;
            $this->request->data['boxes_dest']    = $transfer->boxes_dest;
            $this->request->data['banks_id']      = $transfer->banks_id;
            $this->request->data['banks_dest']    = $transfer->banks_dest;
            $this->request->data['radio_origem']  = $transfer->radio_origem;
            $this->request->data['radio_destino'] = $transfer->radio_destino;
            $this->request->data['data']          = $transfer->data;
            $this->request->data['valor']         = $transfer->valor;
            $this->request->data['cheque']        = $transfer->cheque;
            $this->request->data['nominal']       = $transfer->nominal;
            $this->request->data['emissaoch']     = $transfer->emissaoch;
            $this->request->data['contabil']      = $transfer->contabil;
            $this->request->data['status']        = $transfer->status;
            
            /******************************************************************/
            
            $transfer = $this->Transfers->patchEntity($transfer, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->Transfers->save($transfer)) {
                
                //Atualiza os movimentos de banco, caixa, cheque e CPR
                $this->MovimentsFunctions->atualizaMovimentos($transfer);
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Transfers->save($transfer))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'TransfersControler->editBaixado';
            $this->Error->registerError($transfer, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('boxes', $this->Transfers->Boxes->find('list')->where($conditions)->order(['title']));
        $this->set('banks', $this->Transfers->Banks->find('list')->where($conditions)->order(['title']));
        $this->set('costs', $this->Transfers->Costs->find('list')->where($conditions)->order(['title']));
        $this->set('documentTypes', $this->Transfers->DocumentTypes->find('list', ['keyField' => 'id', 'valueField' => 'title'])->where($conditions)->order(['title']));
        $this->set('eventTypes', $this->Transfers->EventTypes->find('list', ['keyField' => 'id', 'valueField' => 'title'])->where($conditions)->order(['title']));

        $this->set('boxes_dest', $this->Transfers->Boxes_Dest->find('list')->where($conditions)->order(['title']));
        $this->set('banks_dest', $this->Transfers->Banks_Dest->find('list')->where($conditions)->order(['title']));
        $this->set('costs_dest', $this->Transfers->Costs_Dest->find('list')->where($conditions)->order(['title']));
        
        $accountPlans = $this->Transfers->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
                                                      ->where($conditions)
                                                      ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
        $this->set('account_plans_dest', $accountPlans->toArray());
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($transfer->data)) {
            $transfer->data = date('d/m/Y', strtotime($transfer->data));
        }
        if (!empty($transfer->programacao)) {
            $transfer->programacao = date('d/m/Y', strtotime($transfer->programacao));
        }
        if (!empty($transfer->emissaoch)) {
            $transfer->emissaoch = date('d/m/Y', strtotime($transfer->emissaoch));
        }
        
        $this->set(compact('transfer'));
    }
    
    public function editBaixadoSimple($id) 
    {
        $transfer = $this->Transfers->get($id, ['contain' => ['Banks', 'Boxes']]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
        
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
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
            
            $this->request->data['username'] = $this->Auth->user('name');
            
            /******************************************************************/
            
            if (!empty($this->request->data['prog'])) { 
                $this->request->data['status'] = 'P';
            }//if (!empty($this->request->data['prog']))
            
            //CAMPOS QUE NÃO PERMITEM ALTERAÇÃO
            $this->request->data['parameters_id'] = $transfer->parameters_id;
            $this->request->data['boxes_id']      = $transfer->boxes_id;
            $this->request->data['boxes_dest']    = $transfer->boxes_dest;
            $this->request->data['banks_id']      = $transfer->banks_id;
            $this->request->data['banks_dest']    = $transfer->banks_dest;
            $this->request->data['radio_origem']  = $transfer->radio_origem;
            $this->request->data['radio_destino'] = $transfer->radio_destino;
            $this->request->data['data']          = $transfer->data;
            $this->request->data['valor']         = $transfer->valor;
            $this->request->data['contabil']      = $transfer->contabil;
            $this->request->data['status']        = $transfer->status;
            
            /******************************************************************/
            
            $transfer = $this->Transfers->patchEntity($transfer, $this->request->getData());
            
            //Preenche os campos não informados no formulário
            $transfer->costs_dest = $transfer->costs_id;
            
            /******************************************************************/
            
            if ($this->Transfers->save($transfer)) {
                
                //Atualiza os movimentos de banco, caixa, cheque e CPR
                $this->MovimentsFunctions->atualizaMovimentos($transfer);
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Transfers->save($transfer))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'TransfersControler->editBaixadoSimple';
            $this->Error->registerError($transfer, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('costs', $this->Transfers->Costs->find('list')->where($conditions)->order(['title']));
        $this->set('boxes', $this->Transfers->Boxes->find('list')->where($conditions)->order(['title']));
        $this->set('banks', $this->Transfers->Banks->find('list')->where($conditions)->order(['title']));

        $this->set('boxes_dest', $this->Transfers->Boxes_Dest->find('list')->where($conditions)->order(['title']));
        $this->set('banks_dest', $this->Transfers->Banks_Dest->find('list')->where($conditions)->order(['title']));
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($transfer->data)) {
            $transfer->data = date('d/m/Y', strtotime($transfer->data));
        }
        if (!empty($transfer->programacao)) {
            $transfer->programacao = date('d/m/Y', strtotime($transfer->programacao));
        }
        
        $this->set(compact('transfer'));
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
        
        //Consulta registro para obter a ordem vinculada
        $transfer = $this->Transfers->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->first();
        
        /**********************************************************************/

        if (!empty($transfer)) {

            if ($transfer->status != 'P') {
                //EXCLUI MOVIMENTO DE BANCOS E CAIXAS
                $this->TransfersFunctions->deleteDependency($transfer);
            }//if ($transfer->status != 'P')
            
            /******************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($transfer, 'delete', 'Transfers');
            
            /******************************************************************/
            
            if ($this->Transfers->delete($transfer)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Transfers->delete($transfer))

        }//if (!empty($transfer))

        /**********************************************************************/

        //Alerta de erro
        $message = 'TransfersController->delete';
        $this->Error->registerError($transfer, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'Transfers';
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
        
        if (!empty($this->params['status_search'])) { 
            $where[] = '('.$table.'.status = "'.$this->params['status_search'].'")';
        }
        
        if (!empty($this->params['mes_search'])) { 
            $where[] = '('.'MONTH('.$table.'.data) = "'.intval($this->params['mes_search']).'")'; 
        }
        
        if (!empty($this->params['ano_search'])) { 
            $where[] = '('.'YEAR('.$table.'.data) = "'.intval($this->params['ano_search']).'")'; 
        }
        
        return $where;
    }
    
    public function reportForm()
    {
        $this->AccountPlans  = TableRegistry::get('AccountPlans');
        $this->Costs         = TableRegistry::get('Costs');
        $this->DocumentTypes = TableRegistry::get('DocumentTypes');
        $this->EventTypes    = TableRegistry::get('EventTypes');
        $this->Balances      = TableRegistry::get('Balances');
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
            $conditions  = ['Transfers.parameters_id' => $this->request->Session()->read('sessionParameterControl')];

            if ($this->request->data['dtinicial'] && $this->request->data['dtfinal']) {
                $date_find = 'data';
                //$data = ['Transfers.data BETWEEN ? AND ?' => [$dtinicial, $dtfinal]];
                //$conditions = array_merge($conditions, $data);
            }
            if ($this->request->data['account_plans_id']) {
                $accountPlans = ['Transfers.account_plans_id LIKE' => $this->request->data['account_plans_id']];
                $conditions = array_merge($conditions, $accountPlans);
                
                $accountPlan = $this->AccountPlans->findByIdAndParametersId($this->request->data['account_plans_id'], $this->request->Session()->read('sessionParameterControl'))
                                                   ->select(['AccountPlans.title'])
                                                   ->first();
                $this->set('accountPlan', $accountPlan);
            }
            if ($this->request->data['costs_id']) {
                $costs = ['Transfers.costs_id LIKE' => $this->request->data['costs_id']];
                $conditions = array_merge($conditions, $costs);
                
                $cost = $this->Costs->findByIdAndParametersId($this->request->data['costs_id'], $this->request->Session()->read('sessionParameterControl'))
                                     ->select(['Costs.title'])
                                     ->first();
                $this->set('cost', $cost);
            }
            if ($this->request->data['account_plans_dest']) {
                $accountPlans_dest = ['Transfers.account_plans_dest LIKE' => $this->request->data['account_plans_dest']];
                $conditions = array_merge($conditions, $accountPlans_dest);
                
                $accountPlans_dest = $this->AccountPlans->findByIdAndParametersId($this->request->data['account_plans_dest'], $this->request->Session()->read('sessionParameterControl'))
                                                       ->select(['AccountPlans.title'])
                                                       ->first();
                $this->set('accountPlans_dest', $accountPlans_dest);
            }
            if ($this->request->data['costs_dest']) {
                $costs_dest = ['Transfers.costs_dest LIKE' => $this->request->data['costs_dest']];
                $conditions = array_merge($conditions, $costs_dest);
                
                $costs_dest = $this->Costs->findByIdAndParametersId($this->request->data['costs_dest'], $this->request->Session()->read('sessionParameterControl'))
                                         ->select(['Costs.title'])
                                         ->first();
                $this->set('costs_dest', $costs_dest);
            }
            if (@$this->request->data['document_types_id']) {
                $documentTypes = ['Transfers.document_types_id LIKE' => $this->request->data['document_types_id']];
                $conditions = array_merge($conditions, $documentTypes);
                
                $documentType = $this->DocumentTypes->findByIdAndParametersId($this->request->data['document_types_id'], $this->request->Session()->read('sessionParameterControl'))
                                                    ->select(['DocumentTypes.title'])
                                                    ->first();
                $this->set('documentType', $documentType);
            }
            if (@$this->request->data['event_types_id']) {
                $eventTypes = ['Transfers.event_types_id LIKE' => $this->request->data['event_types_id']];
                $conditions = array_merge($conditions, $eventTypes);
                
                $eventType = $this->EventTypes->findByIdAndParametersId($this->request->data['event_types_id'], $this->request->Session()->read('sessionParameterControl'))
                                              ->select(['EventTypes.title'])
                                              ->first();
                $this->set('eventType', $eventType);
            }
            if (!empty($this->request->data['valor'])) {
                $valor = ['Transfers.valor LIKE' => '%'.$this->request->data['valor'].'%'];
                $conditions = array_merge($conditions, $valor);
            }
            if (!empty($this->request->data['historico'])) {
                $historico = ['Transfers.historico LIKE' => "%".$this->request->data['historico']."%"];
                $conditions = array_merge($conditions, $historico);
            }
            if (!empty($this->request->data['contabil'])) {
                $contabil = ['Transfers.contabil' => $this->request->data['contabil']];
                $conditions = array_merge($conditions, $contabil);
            }
            if ($this->request->data['Ordem']) {
                $order = 'Transfers.'.$this->request->data['Ordem'];
            }
            
            /******************************************************************/

            //BUSCA SALDO INCIAL
            $date = date('Y-m-d', strtotime($dtinicial.'-1 day'));
            
            $balances = $this->Balances->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                    ->select(['Balances.banks_id', 'Balances.value', 'Balances.date'])
                    ->where([//'Balances.date BETWEEN ? AND ?' => ['2000-01-01', $date],
                             'Balances.banks_id IS NOT NULL'
                            ])
                    ->andWhere(function ($exp, $q) use($date) {
                                return $exp->between('Balances.date', '2000-01-01', $date);
                              })
                    ->order(['Balances.banks_id, Balances.date desc']);
            
            /******************************************************************/
            
            $fields = ['Transfers.id', 'Transfers.banks_id', 'Transfers.boxes_id', 'Transfers.costs_id',
                       'Transfers.event_types_id','Transfers.banks_dest', 'Transfers.boxes_dest', 'Transfers.costs_dest',
                       'Transfers.ordem', 'Transfers.data', 'Transfers.valor', 'Transfers.documento', 'Transfers.historico',
                       'Transfers.contabil', 'Transfers.status', 'Transfers.username',
                       'Banks.id', 'Banks.title',
                       'Boxes.id', 'Boxes.title',
                       'Banks_Dest.id', 'Banks_Dest.title', 
                       'Boxes_Dest.id', 'Boxes_Dest.title',
                       'Costs.id', 'Costs.title',
                       'CostsDest.id', 'CostsDest.title',
                       'EventTypes.id', 'EventTypes.title', 
                       'Costs.id', 'Costs.title', 'Costs.parameters_id', 
                       'CostsDest.id', 'CostsDest.title', 'CostsDest.parameters_id',
                       'MovimentBanks.id', 'MovimentBanks.banks_id', 'MovimentBanksDest.id', 'MovimentBanksDest.banks_id',
                       'MovimentBoxes.id', 'MovimentBoxes.boxes_id', 'MovimentBoxesDest.id', 'MovimentBoxesDest.boxes_id', 
                       'MovimentBanks.ordem', 'MovimentBanks.data', 'MovimentBanks.vencimento', 'MovimentBanks.documento', 
                       'MovimentBanks.historico', 'MovimentBanks.valorbaixa', 'MovimentBanks.costs_id', 
                       'MovimentBanksDest.ordem', 'MovimentBanksDest.data', 'MovimentBanksDest.vencimento', 'MovimentBanksDest.documento', 
                       'MovimentBanksDest.historico', 'MovimentBanksDest.valorbaixa', 'MovimentBanksDest.costs_id', 
                       'MovimentBoxes.ordem', 'MovimentBoxes.data', 'MovimentBoxes.vencimento', 'MovimentBoxes.documento', 
                       'MovimentBoxes.historico', 'MovimentBoxes.valorbaixa', 'MovimentBoxes.costs_id', 
                       'MovimentBoxesDest.ordem', 'MovimentBoxesDest.data', 'MovimentBoxesDest.vencimento', 'MovimentBoxesDest.documento', 
                       'MovimentBoxesDest.historico', 'MovimentBoxesDest.valorbaixa', 'MovimentBoxesDest.costs_id'
                      ];
            
            $transfers = $this->Transfers->find('all')
            							 ->select($fields)
                                         ->where(function ($exp, $q) use($dtinicial, $dtfinal, $date_find) {
                                                  return $exp->between('Transfers.'.$date_find, $dtinicial, $dtfinal);
                                                 })
            							 ->where($conditions)
            							 ->contain(['Banks', 'Boxes', 'EventTypes',
            							 			'Banks_Dest', 'Boxes_Dest'
            							 		   ])
                                         ->join(['MovimentBanks' => ['table'      => 'Moviment_Banks',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'MovimentBanks.banks_id = Transfers.banks_id AND MovimentBanks.transfers_id = Transfers.id'
                                                                    ],
                                                 'MovimentBoxes' => ['table'      => 'Moviment_Boxes',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'MovimentBoxes.boxes_id = Transfers.boxes_id AND MovimentBoxes.transfers_id = Transfers.id'
                                                                    ],
                                                 'MovimentBanksDest' => ['table'      => 'Moviment_Banks',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'MovimentBanksDest.banks_id = Transfers.banks_dest AND MovimentBanksDest.transfers_id = Transfers.id'
                                                                        ],
                                                 'MovimentBoxesDest' => ['table'      => 'Moviment_Boxes',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'MovimentBoxesDest.boxes_id = Transfers.boxes_dest AND MovimentBoxesDest.transfers_id = Transfers.id'
                                                                        ],
                                                 'Costs' => ['table'      => 'Costs',
                                                             'type'       => 'LEFT',
                                                             'conditions' => 'MovimentBanks.costs_id = Costs.id OR MovimentBoxes.costs_id = Costs.id'
                                                            ],
                                                 'CostsDest' => ['table'      => 'Costs',
                                                                 'type'       => 'LEFT',
                                                                 'conditions' => 'MovimentBanks.costs_id = CostsDest.id OR MovimentBoxes.costs_id = CostsDest.id'
                                                                ],
                                                 'AccountPlans' => ['table'      => 'Costs',
                                                                    'type'       => 'LEFT',
                                                                    'conditions' => 'MovimentBanks.account_plans_id = AccountPlans.id OR MovimentBoxes.account_plans_id = AccountPlans.id'
                                                                   ],
                                                 'AccountPlansDest' => ['table'      => 'Costs',
                                                                        'type'       => 'LEFT',
                                                                        'conditions' => 'MovimentBanks.account_plans_id = AccountPlansDest.id OR MovimentBoxes.account_plans_id = AccountPlansDest.id'
                                                                       ]
                                                ])
            							 ->order($order);
            
            /******************************************************************/
            
            $this->set('balances', $balances);
            $this->set('transfers', $transfers);
            
            /******************************************************************/
            
            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());
            
            /******************************************************************/
            
            if ($this->request->data['Tipo'] == 'Movimentos_Transf') {
                $this->render('reports/Movimentos_Transf');
            }
            
        }
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('boxes', $this->Transfers->Boxes->find('list')->where($conditions)->order(['title']));
        $this->set('banks', $this->Transfers->Banks->find('list')->where($conditions)->order(['title']));
        $this->set('costs', $this->Transfers->Costs->find('list')->where($conditions)->order(['title']));
        $this->set('documentTypes', $this->Transfers->DocumentTypes->find('list')->where($conditions)->order(['title']));
        $this->set('eventTypes', $this->Transfers->EventTypes->find('list')->where($conditions)->order(['title']));
        $this->set('accountPlans', $this->Transfers->AccountPlans->find('list')->where($conditions)->order(['title']));

        $this->set('boxes_dest', $this->Transfers->Boxes_Dest->find('list')->where($conditions)->order(['title']));
        $this->set('banks_dest', $this->Transfers->Banks_Dest->find('list')->where($conditions)->order(['title']));
        $this->set('costs_dest', $this->Transfers->Costs_Dest->find('list')->where($conditions)->order(['title']));
        $this->set('accountPlans_dest', $this->Transfers->AccountPlans_Dest->find('list')->where($conditions)->order(['title']));
    }
    
    public function reportFormSimple()
    {
        $this->AccountPlans  = TableRegistry::get('AccountPlans');
        $this->Costs         = TableRegistry::get('Costs');
        $this->DocumentTypes = TableRegistry::get('DocumentTypes');
        $this->EventTypes    = TableRegistry::get('EventTypes');
        $this->Balances      = TableRegistry::get('Balances');
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
            $conditions  = ['Transfers.parameters_id' => $this->request->Session()->read('sessionParameterControl')];

            if ($this->request->data['dtinicial'] && $this->request->data['dtfinal']) {
                $date_find = 'data';
                //$data = ['Transfers.data BETWEEN ? AND ?' => [$dtinicial, $dtfinal]];
                //$conditions = array_merge($conditions, $data);
            }
            if (@$this->request->data['account_plans_id']) {
                $accountPlans = ['Transfers.account_plans_id LIKE' => $this->request->data['account_plans_id']];
                $conditions = array_merge($conditions, $accountPlans);
                
                $accountPlan = $this->AccountPlans->findByIdAndParametersId($this->request->data['account_plans_id'], $this->request->Session()->read('sessionParameterControl'))
                                                   ->select(['AccountPlans.title'])
                                                   ->first();
                $this->set('accountPlan', $accountPlan);
            }
            if ($this->request->data['costs_id']) {
                $costs = ['Transfers.costs_id LIKE' => $this->request->data['costs_id']];
                $conditions = array_merge($conditions, $costs);
                
                $cost = $this->Costs->findByIdAndParametersId($this->request->data['costs_id'], $this->request->Session()->read('sessionParameterControl'))
                                     ->select(['Costs.title'])
                                     ->first();
                $this->set('cost', $cost);
            }
            if (@$this->request->data['account_plans_dest']) {
                $accountPlans_dest = ['Transfers.account_plans_dest LIKE' => $this->request->data['account_plans_dest']];
                $conditions = array_merge($conditions, $accountPlans_dest);
                
                $accountPlans_dest = $this->AccountPlans->findByIdAndParametersId($this->request->data['account_plans_dest'], $this->request->Session()->read('sessionParameterControl'))
                                                       ->select(['AccountPlans.title'])
                                                       ->first();
                $this->set('accountPlans_dest', $accountPlans_dest);
            }
            if (@$this->request->data['costs_dest']) {
                $costs_dest = ['Transfers.costs_dest LIKE' => $this->request->data['costs_dest']];
                $conditions = array_merge($conditions, $costs_dest);
                
                $costs_dest = $this->Costs->findByIdAndParametersId($this->request->data['costs_dest'], $this->request->Session()->read('sessionParameterControl'))
                                         ->select(['Costs.title'])
                                         ->first();
                $this->set('costs_dest', $costs_dest);
            }
            if (@$this->request->data['document_types_id']) {
                $documentTypes = ['Transfers.document_types_id LIKE' => $this->request->data['document_types_id']];
                $conditions = array_merge($conditions, $documentTypes);
                
                $documentType = $this->DocumentTypes->findByIdAndParametersId($this->request->data['document_types_id'], $this->request->Session()->read('sessionParameterControl'))
                                                    ->select(['DocumentTypes.title'])
                                                    ->first();
                $this->set('documentType', $documentType);
            }
            if (@$this->request->data['event_types_id']) {
                $eventTypes = ['Transfers.event_types_id LIKE' => $this->request->data['event_types_id']];
                $conditions = array_merge($conditions, $eventTypes);
                
                $eventType = $this->EventTypes->findByIdAndParametersId($this->request->data['event_types_id'], $this->request->Session()->read('sessionParameterControl'))
                                              ->select(['EventTypes.title'])
                                              ->first();
                $this->set('eventType', $eventType);
            }
            if (!empty($this->request->data['valor'])) {
                $valor = ['Transfers.valor LIKE' => '%'.$this->request->data['valor'].'%'];
                $conditions = array_merge($conditions, $valor);
            }
            if (!empty($this->request->data['historico'])) {
                $historico = ['Transfers.historico LIKE' => "%".$this->request->data['historico']."%"];
                $conditions = array_merge($conditions, $historico);
            }
            if (!empty($this->request->data['contabil'])) {
                $contabil = ['Transfers.contabil' => $this->request->data['contabil']];
                $conditions = array_merge($conditions, $contabil);
            }
            if ($this->request->data['Ordem']) {
                $order = 'Transfers.'.$this->request->data['Ordem'];
            }
            
            /******************************************************************/

            //BUSCA SALDO INCIAL
            $date = date('Y-m-d', strtotime($dtinicial.'-1 day'));
            
            $balances = $this->Balances->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                    ->select(['Balances.banks_id', 'Balances.value', 'Balances.date'])
                    ->where([//'Balances.date BETWEEN ? AND ?' => ['2000-01-01', $date],
                             'Balances.banks_id IS NOT NULL'
                            ])
                    ->andWhere(function ($exp, $q) use($date) {
                                return $exp->between('Balances.date', '2000-01-01', $date);
                              })
                    ->order(['Balances.banks_id, Balances.date desc']);
            
            /******************************************************************/
            
            $fields = ['Transfers.id', 'Transfers.banks_id', 'Transfers.boxes_id', 'Transfers.costs_id',
                       'Transfers.event_types_id','Transfers.banks_dest', 'Transfers.boxes_dest', 'Transfers.costs_dest',
                       'Transfers.ordem', 'Transfers.data', 'Transfers.valor', 'Transfers.documento', 'Transfers.historico',
                       'Transfers.contabil', 'Transfers.status', 'Transfers.username',
                       'Banks.id', 'Banks.title',
                       'Boxes.id', 'Boxes.title',
                       'Banks_Dest.id', 'Banks_Dest.title', 
                       'Boxes_Dest.id', 'Boxes_Dest.title',
                       'Costs.id', 'Costs.title',
                       'CostsDest.id', 'CostsDest.title',
                       'EventTypes.id', 'EventTypes.title', 
                       'Costs.id', 'Costs.title', 'Costs.parameters_id', 
                       'CostsDest.id', 'CostsDest.title', 'CostsDest.parameters_id',
                       'MovimentBanks.id', 'MovimentBanks.banks_id', 'MovimentBanksDest.id', 'MovimentBanksDest.banks_id',
                       'MovimentBoxes.id', 'MovimentBoxes.boxes_id', 'MovimentBoxesDest.id', 'MovimentBoxesDest.boxes_id', 
                       'MovimentBanks.ordem', 'MovimentBanks.data', 'MovimentBanks.vencimento', 'MovimentBanks.documento', 
                       'MovimentBanks.historico', 'MovimentBanks.valorbaixa', 'MovimentBanks.costs_id', 
                       'MovimentBanksDest.ordem', 'MovimentBanksDest.data', 'MovimentBanksDest.vencimento', 'MovimentBanksDest.documento', 
                       'MovimentBanksDest.historico', 'MovimentBanksDest.valorbaixa', 'MovimentBanksDest.costs_id', 
                       'MovimentBoxes.ordem', 'MovimentBoxes.data', 'MovimentBoxes.vencimento', 'MovimentBoxes.documento', 
                       'MovimentBoxes.historico', 'MovimentBoxes.valorbaixa', 'MovimentBoxes.costs_id', 
                       'MovimentBoxesDest.ordem', 'MovimentBoxesDest.data', 'MovimentBoxesDest.vencimento', 'MovimentBoxesDest.documento', 
                       'MovimentBoxesDest.historico', 'MovimentBoxesDest.valorbaixa', 'MovimentBoxesDest.costs_id'
                      ];
            
            $transfers = $this->Transfers->find('all')
            							 ->select($fields)
                                         ->where(function ($exp, $q) use($dtinicial, $dtfinal, $date_find) {
                                                  return $exp->between('Transfers.'.$date_find, $dtinicial, $dtfinal);
                                                 })
            							 ->where($conditions)
            							 ->contain(['Banks', 'Boxes', 'EventTypes',
            							 			'AccountPlans', 'Banks_Dest', 'Boxes_Dest'
                                                   ])
                                         ->join(['MovimentBanks' => ['table'      => 'Moviment_Banks',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'MovimentBanks.banks_id = Transfers.banks_id AND MovimentBanks.transfers_id = Transfers.id'
                                                                    ],
                                                 'MovimentBoxes' => ['table'      => 'Moviment_Boxes',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'MovimentBoxes.boxes_id = Transfers.boxes_id AND MovimentBoxes.transfers_id = Transfers.id'
                                                                    ],
                                                 'MovimentBanksDest' => ['table'      => 'Moviment_Banks',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'MovimentBanksDest.banks_id = Transfers.banks_dest AND MovimentBanksDest.transfers_id = Transfers.id'
                                                                        ],
                                                 'MovimentBoxesDest' => ['table'      => 'Moviment_Boxes',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'MovimentBoxesDest.boxes_id = Transfers.boxes_dest AND MovimentBoxesDest.transfers_id = Transfers.id'
                                                                        ],
                                                 'Costs' => ['table'      => 'Costs',
                                                             'type'       => 'LEFT',
                                                             'conditions' => 'MovimentBanks.costs_id = Costs.id OR MovimentBoxes.costs_id = Costs.id'
                                                            ],
                                                 'CostsDest' => ['table'      => 'Costs',
                                                                 'type'       => 'LEFT',
                                                                 'conditions' => 'MovimentBanks.costs_id = CostsDest.id OR MovimentBoxes.costs_id = CostsDest.id'
                                                                ]
                                                        
                                                ])
            							 ->order($order);
            
            /******************************************************************/
            
            $this->set('balances', $balances);
            $this->set('transfers', $transfers);
            
            /******************************************************************/
            
            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());
            
            /******************************************************************/
            
            if ($this->request->data['Tipo'] == 'Movimentos_Transf') {
                $this->render('reports/simples/Movimentos_Transf_simples');
            }//if ($this->request->data['Tipo'] == 'Movimentos_Transf')
            
        }
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('boxes', $this->Transfers->Boxes->find('list')->where($conditions)->order(['title']));
        $this->set('banks', $this->Transfers->Banks->find('list')->where($conditions)->order(['title']));
        $this->set('costs', $this->Transfers->Costs->find('list')->where($conditions)->order(['title']));
        $this->set('documentTypes', $this->Transfers->DocumentTypes->find('list')->where($conditions)->order(['title']));
        $this->set('eventTypes', $this->Transfers->EventTypes->find('list')->where($conditions)->order(['title']));
        $this->set('accountPlans', $this->Transfers->AccountPlans->find('list')->where($conditions)->order(['title']));

        $this->set('boxes_dest', $this->Transfers->Boxes_Dest->find('list')->where($conditions)->order(['title']));
        $this->set('banks_dest', $this->Transfers->Banks_Dest->find('list')->where($conditions)->order(['title']));
        $this->set('costs_dest', $this->Transfers->Costs_Dest->find('list')->where($conditions)->order(['title']));
        $this->set('accountPlans_dest', $this->Transfers->AccountPlans_Dest->find('list')->where($conditions)->order(['title']));
    }
}