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
/* File: src/Controller/MovimentsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\I18n\FrozenTime;
use Cake\I18n\FrozenDate;
use Cake\Network\Exception\NotFoundException;
use Cake\Log\Log;

class MovimentsController extends AppController
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
        $this->loadComponent('MovimentRecurrentsFunctions');
        $this->loadComponent('MovimentCardsFunctions');
        $this->loadComponent('MovimentChecksFunctions');
    }
    
    public function index()
    {
        $this->MovimentRecurrents = TableRegistry::get('MovimentRecurrents');
        $this->MovimentMergeds    = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        //VERIFICA SE HÁ BANCOS CADASTRADOS
        if ($message = $this->SystemFunctions->validaCadastros("banco", $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__($message), ['escape' => false]);
        }
        
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $moviments = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->contain(['Providers', 'Customers', 'DocumentTypes'])
                                     ->where($where)
                                     ->order(['Moviments.ordem DESC']);
                                     //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $moviments = $this->paginate($moviments);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $moviments = $this->paginate($moviments);
            
        }
        
        /**********************************************************************/
        
        //IDENTIFICA TODOS OS ID'S DA CONSULTA PARA FILTRAR AS CONSULTAS ABAIXO
        if (!empty($moviments->toArray())) {
            
            foreach($moviments as $moviment):
                $moviments_id[] = $moviment->id;
            endforeach;
            
            $whereMergeds    = ['MovimentMergeds.moviments_id IN' => $moviments_id];
            $whereRecurrents = ['MovimentRecurrents.moviments_id IN' => $moviments_id];
            
        } else {
            
            $whereMergeds    = [];
            $whereRecurrents = [];
            
        }
        
        /**********************************************************************/
        
        //Consulta de títulos vinculados
        $movimentMergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                           'Moviments.id', 'Moviments.ordem', 'Moviment_Mergeds.id', 'Moviment_Mergeds.valorbaixa', 'Moviment_Mergeds.status'
                                                          ])
                                                 ->join(['Moviments' => ['table'      => 'Moviments',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                        ],
                                                         'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                              ]
                                                        ])
                                                 ->where($whereMergeds);
        
        /**********************************************************************/
        
        $movimentRecurrents = $this->MovimentRecurrents->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                       ->select(['MovimentRecurrents.moviments_id', 'Moviments.id', 'Moviments.ordem'])
                                                       ->join(['Moviments' => ['table'      => 'Moviments',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'MovimentRecurrents.moviments_id = Moviments.id'
                                                                              ]
                                                              ])
                                                       ->where($whereRecurrents);
        
        /**********************************************************************/
        
        $this->set(compact('movimentMergeds','movimentRecurrents','moviments'));
    }
    
    public function indexSimple()
    {
        $this->MovimentRecurrents = TableRegistry::get('MovimentRecurrents');
        $this->MovimentMergeds    = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        //VERIFICA SE HÁ BANCOS CADASTRADOS
        if ($message = $this->SystemFunctions->validaCadastros("banco", $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__($message), ['escape' => false]);
        }
        
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $moviments = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->where($where)
                                     ->contain(['Costs'])
                                     ->order(['Moviments.ordem DESC']);
                                     //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $moviments = $this->paginate($moviments);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $moviments = $this->paginate($moviments);
            
        }
        
        /**********************************************************************/
        
        //IDENTIFICA TODOS OS ID'S DA CONSULTA PARA FILTRAR AS CONSULTAS ABAIXO
        if (!empty($moviments->toArray())) {
            
            foreach($moviments as $moviment):
                $moviments_id[] = $moviment->id;
            endforeach;
            
            $whereMergeds    = ['MovimentMergeds.moviments_id IN' => $moviments_id];
            $whereRecurrents = ['MovimentRecurrents.moviments_id IN' => $moviments_id];
            
        } else {
            
            $whereMergeds    = [];
            $whereRecurrents = [];
            
        }
        
        /**********************************************************************/
        
        //Consulta de títulos vinculados
        $movimentMergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                           'Moviments.id', 'Moviments.ordem', 'Moviment_Mergeds.id', 'Moviment_Mergeds.valorbaixa', 'Moviment_Mergeds.status'
                                                          ])
                                                 ->join(['Moviments' => ['table'      => 'Moviments',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                        ],
                                                         'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                              ]
                                                        ])
                                                 ->where($whereMergeds);
        
        /**********************************************************************/
        
        $movimentRecurrents = $this->MovimentRecurrents->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                       ->select(['MovimentRecurrents.moviments_id', 'Moviments.id', 'Moviments.ordem'])
                                                       ->join(['Moviments' => ['table'      => 'Moviments',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'MovimentRecurrents.moviments_id = Moviments.id'
                                                                              ]
                                                              ])
                                                       ->where($whereRecurrents);
        
        /**********************************************************************/
        
        $this->set(compact('movimentMergeds','movimentRecurrents','moviments'));
    }
    
    public function json()
    {
        FrozenTime::setJsonEncodeFormat('dd/MM/yyyy');
        FrozenDate::setJsonEncodeFormat('dd/MM/yyyy');
        
        /**********************************************************************/
        
        $this->MovimentRecurrents = TableRegistry::get('MovimentRecurrents');
        $this->MovimentMergeds    = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        if ($this->request->is('get')) {
            
            if (isset($this->request->query['query'])) {
                
                $this->filter($this->request->query['query']);
                
            } else {
                
                $query = null;
                
            }
            
            $itens = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->contain(['Providers', 'Customers', 'DocumentTypes'])
                                         ->where($query)
                                         ->order(['Moviments.ordem DESC']);
            
            $page = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
            $this->paginate = ['page' => $page,'limit' => 20];
            $moviments = $this->paginate($itens)->toArray();
            
            /*
            foreach ($moviments as $moviments):
                $moviments->ordem = str_pad($moviments->ordem, 6, '0', STR_PAD_LEFT);
            endforeach;
            */
            
            /**********************************************************************/
            
            //IDENTIFICA TODOS OS ID'S DA CONSULTA PARA FILTRAR AS CONSULTAS ABAIXO
            if (!empty($moviments->toArray())) {

                foreach($moviments as $moviment):
                    $moviments_id[] = $moviment->id;
                endforeach;

                $whereMergeds    = ['MovimentMergeds.moviments_id IN' => $moviments_id];
                $whereRecurrents = ['MovimentRecurrents.moviments_id IN' => $moviments_id];

            } else {

                $whereMergeds    = [];
                $whereRecurrents = [];

            }

            /**********************************************************************/

            //Consulta de títulos vinculados
            $movimentMergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                     ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                               'Moviments.id', 'Moviments.ordem', 'Moviment_Mergeds.id', 'Moviment_Mergeds.valorbaixa', 'Moviment_Mergeds.status'
                                                              ])
                                                     ->join(['Moviments' => ['table'      => 'Moviments',
                                                                             'type'       => 'LEFT',
                                                                             'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                            ],
                                                             'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                                   'type'       => 'LEFT',
                                                                                   'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                                  ]
                                                            ])
                                                     ->where($whereMergeds);

            /**********************************************************************/

            $movimentRecurrents = $this->MovimentRecurrents->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                           ->select(['MovimentRecurrents.moviments_id', 'Moviments.id', 'Moviments.ordem'])
                                                           ->join(['Moviments' => ['table'      => 'Moviments',
                                                                                   'type'       => 'LEFT',
                                                                                   'conditions' => 'MovimentRecurrents.moviments_id = Moviments.id'
                                                                                  ]
                                                                  ])
                                                           ->where($whereRecurrents);

            /**********************************************************************/

        }
        
        $this->set(compact('movimentMergeds','movimentRecurrents','moviments'));
   
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $this->MovimentCards   = TableRegistry::get('MovimentCards');
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        $moviment = $this->Moviments->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->select(['Moviments.id', 'Moviments.ordem', 'Moviments.parameters_id', 'Moviments.created', 'Moviments.modified', 'Moviments.banks_id', 'Moviments.boxes_id', 
                                              'Moviments.cards_id', 'Moviments.plannings_id', 'Moviments.costs_id', 'Moviments.event_types_id', 'Moviments.providers_id', 'Moviments.customers_id', 
                                              'Moviments.document_types_id', 'Moviments.account_plans_id', 'Moviments.coins_id', 'Moviments.documento', 'Moviments.cheque', 'Moviments.nominal', 
                                              'Moviments.emissaoch', 'Moviments.creditodebito', 'Moviments.data', 'Moviments.vencimento', 'Moviments.dtbaixa', 'Moviments.valor', 'Moviments.valorbaixa', 
                                              'Moviments.historico', 'Moviments.contabil', 'Moviments.status', 'Moviments.username', 'Moviments.userbaixa', 'Moviments.obs', 
                                              'AccountPlans.id', 'AccountPlans.parameters_id', 'AccountPlans.classification', 'AccountPlans.title', 'AccountPlans.receitadespesa', 'AccountPlans.status', 
                                              'DocumentTypes.id', 'DocumentTypes.parameters_id', 'DocumentTypes.title', 'DocumentTypes.vinculapgto', 'DocumentTypes.duplicadoc', 'DocumentTypes.status', 
                                              'Customers.id', 'Customers.parameters_id', 'Customers.tipo', 'Customers.title', 'Customers.fantasia', 'Customers.cpfcnpj', 'Customers.status', 
                                              'Providers.id', 'Providers.parameters_id', 'Providers.tipo', 'Providers.title', 'Providers.fantasia', 'Providers.cpfcnpj', 'Providers.status', 
                                              'EventTypes.id', 'EventTypes.parameters_id', 'EventTypes.title', 'EventTypes.status', 
                                              'Plannings.id', 'Plannings.parameters_id', 'Plannings.data', 'Plannings.title', 'Plannings.valor',  'Plannings.parcelas',  'Plannings.status', 
                                              'Costs.id', 'Costs.parameters_id', 'Costs.title', 'Costs.status', 
                                              'Cards.id', 'Cards.parameters_id', 'Cards.vencimento', 'Cards.title', 'Cards.bandeira', 'Cards.melhor_dia', 'Cards.limite', 'Cards.status', 
                                              'Boxes.id', 'Boxes.parameters_id', 'Boxes.title', 'Boxes.status', 
                                              'Banks.id', 'Banks.parameters_id', 'Banks.title', 'Banks.banco', 'Banks.agencia', 'Banks.conta', 'Banks.tipoconta', 'Banks.numbanco', 'Banks.emitecheque', 'Banks.status', 
                                              'Parameters.id', 'Parameters.razao', 'Parameters.cpfcnpj', 'Parameters.tipo', 
                                              'MovimentBanks.id', 'MovimentBanks.parameters_id', 'MovimentBanks.ordem', 'MovimentBanks.creditodebito', 'MovimentBanks.data', 'MovimentBanks.dtbaixa', 'MovimentBanks.valor', 
                                              'MovimentBanks.valorbaixa', 'MovimentBanks.vencimento', 'MovimentBanks.documento', 'MovimentBanks.historico', 'MovimentBanks.contabil', 'MovimentBanks.obs', 'MovimentBanks.status', 
                                              'MovimentBoxes.id', 'MovimentBoxes.parameters_id', 'MovimentBoxes.ordem', 'MovimentBoxes.creditodebito', 'MovimentBoxes.data', 'MovimentBoxes.dtbaixa', 'MovimentBoxes.valor', 
                                              'MovimentBoxes.valorbaixa', 'MovimentBoxes.vencimento', 'MovimentBoxes.documento', 'MovimentBoxes.historico', 'MovimentBoxes.contabil', 'MovimentBoxes.obs', 'MovimentBoxes.status', 
                                              'MovimentChecks.id', 'MovimentChecks.parameters_id', 'MovimentChecks.ordem', 'MovimentChecks.caixaforn', 'MovimentChecks.cheque', 'MovimentChecks.nominal', 'MovimentChecks.data', 
                                              'MovimentChecks.valor', 'MovimentChecks.documento', 'MovimentChecks.historico', 'MovimentChecks.contabil', 'MovimentChecks.obs', 'MovimentChecks.status', 
                                              'MovimentCards.id', 'MovimentCards.parameters_id', 'MovimentCards.ordem', 'MovimentCards.vencimento', 'MovimentCards.title', 'MovimentCards.documento', 'MovimentCards.creditodebito', 
                                              'MovimentCards.valor', 'MovimentCards.valorbaixa', 'MovimentCards.data', 'MovimentCards.dtbaixa', 'MovimentCards.contabil', 'MovimentCards.obs', 'MovimentCards.status', 
                                             ])
                                    ->join(['MovimentBanks' => ['table'      => 'moviment_banks',
                                                                'type'       => 'LEFT',
                                                                'conditions' => 'MovimentBanks.moviments_id = Moviments.id'
                                                               ],
                                            'MovimentBoxes' => ['table'      => 'moviment_boxes',
                                                                'type'       => 'LEFT',
                                                                'conditions' => 'MovimentBoxes.moviments_id = Moviments.id'
                                                               ],
                                            'MovimentChecks' => ['table'      => 'moviment_checks',
                                                                 'type'       => 'LEFT',
                                                                 'conditions' => 'MovimentChecks.moviments_id = Moviments.id'
                                                                ],
                                            'MovimentCards' => ['table'      => 'moviment_cards',
                                                                 'type'       => 'LEFT',
                                                                 'conditions' => 'MovimentCards.moviments_id = Moviments.id'
                                                                ]
                                           ])
                                    ->contain(['Parameters', 'Banks', 'Boxes', 'Cards', 'Costs', 'Plannings', 
                                               'EventTypes', 'Providers', 'Customers', 'DocumentTypes', 'AccountPlans'
                                              ])
                                    ->first();
        
        /**********************************************************************/
        
        $movimentMergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                           'Moviments.id', 'Moviment_Mergeds.id', 'Moviment_Mergeds.ordem', 'Moviment_Mergeds.valor', 'Moviment_Mergeds.valorbaixa', 
                                                           'Moviment_Mergeds.data', 'Moviment_Mergeds.dtbaixa', 'Moviment_Mergeds.vencimento', 'Moviment_Mergeds.status',
                                                           'Moviment_Mergeds.documento', 'Moviment_Mergeds.historico'
                                                          ])
                                                 ->where(['MovimentMergeds.moviments_id' => $id])
                                                 ->join(['Moviments' => ['table'      => 'Moviments',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                        ],
                                                         'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                              ]
                                                        ]);
        
        /**********************************************************************/
        
        //Consulta de títulos pelo id do vínculo
        $mergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->where(['MovimentMergeds.moviments_merged' => $id])
                                         ->contain(['Moviments'])
                                         ->first();
        
        /**********************************************************************/
        
        //Consulta de títulos pelo id do vínculo
        if (!empty($mergeds)) {
            $mmergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                              ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                        'Moviments.id', 'Moviment_Mergeds.id', 
                                                        'Moviments.ordem', 'Moviments.valor', 'Moviments.valorbaixa', 
                                                        'Moviments.data', 'Moviments.dtbaixa', 'Moviments.vencimento', 'Moviments.status',
                                                        'Moviments.documento', 'Moviments.historico',
                                                        'Moviment_Mergeds.ordem', 'Moviment_Mergeds.valor', 'Moviment_Mergeds.valorbaixa', 
                                                        'Moviment_Mergeds.data', 'Moviment_Mergeds.dtbaixa', 'Moviment_Mergeds.vencimento', 'Moviment_Mergeds.status',
                                                        'Moviment_Mergeds.documento', 'Moviment_Mergeds.historico'
                                                       ])
                                              ->where(['MovimentMergeds.moviments_id' => $mergeds->Moviments['id'],
                                                       'MovimentMergeds.moviments_merged <>' => $id
                                                      ])
                                              ->join(['Moviments' => ['table'      => 'Moviments',
                                                                      'type'       => 'LEFT',
                                                                      'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                     ],
                                                      'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                            'type'       => 'LEFT',
                                                                            'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                           ]
                                                     ]);
        }//if (!empty($mergeds))
        
        /**********************************************************************/
        
        //Consulta de títulos pela data de vencimento
        $movimentCards = $this->MovimentCards->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                             ->where(['MovimentCards.moviments_id' => $moviment->id,
                                                      'MovimentCards.cards_id'     => $moviment->cards_id
                                                     ])
                                             ->order(['MovimentCards.data']);
        
        /**********************************************************************/
        
        $movimentos = $this->MovimentsFunctions->consultaMovimentos($moviment->id, $moviment->parameters_id);
        
        
        /**********************************************************************/
        
        $this->set(compact('movimentos'));
        $this->set(compact('moviment'));
        $this->set(compact('mergeds'));
        $this->set(compact('mmergeds'));
        $this->set(compact('movimentMergeds'));
        $this->set(compact('movimentCards'));
    }

    public function viewSimple($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $this->MovimentCards   = TableRegistry::get('MovimentCards');
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        $moviment = $this->Moviments->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->select(['Moviments.id', 'Moviments.ordem', 'Moviments.parameters_id', 'Moviments.created', 'Moviments.modified', 'Moviments.banks_id', 'Moviments.boxes_id', 
                                              'Moviments.cards_id', 'Moviments.plannings_id', 'Moviments.costs_id', 
                                              'Moviments.creditodebito', 'Moviments.data', 'Moviments.vencimento', 'Moviments.dtbaixa', 'Moviments.valor', 'Moviments.valorbaixa', 
                                              'Moviments.historico', 'Moviments.contabil', 'Moviments.status', 'Moviments.username', 'Moviments.userbaixa', 'Moviments.obs', 
                                              'Plannings.id', 'Plannings.parameters_id', 'Plannings.data', 'Plannings.title', 'Plannings.valor',  'Plannings.parcelas',  'Plannings.status', 
                                              'Costs.id', 'Costs.parameters_id', 'Costs.title', 'Costs.status', 
                                              'Cards.id', 'Cards.parameters_id', 'Cards.vencimento', 'Cards.title', 'Cards.bandeira', 'Cards.melhor_dia', 'Cards.limite', 'Cards.status', 
                                              'Boxes.id', 'Boxes.parameters_id', 'Boxes.title', 'Boxes.status', 
                                              'Banks.id', 'Banks.parameters_id', 'Banks.title', 'Banks.banco', 'Banks.agencia', 'Banks.conta', 'Banks.tipoconta', 'Banks.numbanco', 'Banks.emitecheque', 'Banks.status', 
                                              'Parameters.id', 'Parameters.razao', 'Parameters.cpfcnpj', 'Parameters.tipo', 
                                              'MovimentBanks.id', 'MovimentBanks.parameters_id', 'MovimentBanks.ordem', 'MovimentBanks.creditodebito', 'MovimentBanks.data', 'MovimentBanks.dtbaixa', 'MovimentBanks.valor', 
                                              'MovimentBanks.valorbaixa', 'MovimentBanks.vencimento', 'MovimentBanks.historico', 'MovimentBanks.contabil', 'MovimentBanks.obs', 'MovimentBanks.status', 
                                              'MovimentBoxes.id', 'MovimentBoxes.parameters_id', 'MovimentBoxes.ordem', 'MovimentBoxes.creditodebito', 'MovimentBoxes.data', 'MovimentBoxes.dtbaixa', 'MovimentBoxes.valor', 
                                              'MovimentBoxes.valorbaixa', 'MovimentBoxes.vencimento', 'MovimentBoxes.historico', 'MovimentBoxes.contabil', 'MovimentBoxes.obs', 'MovimentBoxes.status', 
                                              'MovimentCards.id', 'MovimentCards.parameters_id', 'MovimentCards.ordem', 'MovimentCards.vencimento', 'MovimentCards.title', 'MovimentCards.creditodebito', 
                                              'MovimentCards.valor', 'MovimentCards.valorbaixa', 'MovimentCards.data', 'MovimentCards.dtbaixa', 'MovimentCards.contabil', 'MovimentCards.obs', 'MovimentCards.status', 
                                             ])
                                    ->join(['MovimentBanks' => ['table'      => 'moviment_banks',
                                                                'type'       => 'LEFT',
                                                                'conditions' => 'MovimentBanks.moviments_id = Moviments.id'
                                                               ],
                                            'MovimentBoxes' => ['table'      => 'moviment_boxes',
                                                                'type'       => 'LEFT',
                                                                'conditions' => 'MovimentBoxes.moviments_id = Moviments.id'
                                                               ],
                                            'MovimentCards' => ['table'      => 'moviment_cards',
                                                                 'type'       => 'LEFT',
                                                                 'conditions' => 'MovimentCards.moviments_id = Moviments.id'
                                                                ]
                                           ])
                                    ->contain(['Parameters', 'Banks', 'Boxes', 'Cards', 'Plannings', 'Costs'])
                                    ->first();
        
        /**********************************************************************/
        
        $movimentMergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                           'Moviments.id', 'Moviment_Mergeds.id', 'Moviment_Mergeds.ordem', 'Moviment_Mergeds.valor', 'Moviment_Mergeds.valorbaixa', 
                                                           'Moviment_Mergeds.data', 'Moviment_Mergeds.dtbaixa', 'Moviment_Mergeds.vencimento', 'Moviment_Mergeds.status',
                                                           'Moviment_Mergeds.historico'
                                                          ])
                                                 ->where(['MovimentMergeds.moviments_id' => $id])
                                                 ->join(['Moviments' => ['table'      => 'Moviments',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                        ],
                                                         'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                              ]
                                                        ]);
        
        /**********************************************************************/
        
        //Consulta de títulos pelo id do vínculo
        $mergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->where(['MovimentMergeds.moviments_merged' => $id])
                                         ->contain(['Moviments'])
                                         ->first();
        
        /**********************************************************************/
        
        //Consulta de títulos pelo id do vínculo
        if (!empty($mergeds)) {
            $mmergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                              ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                        'Moviments.id', 'Moviment_Mergeds.id', 
                                                        'Moviments.ordem', 'Moviments.valor', 'Moviments.valorbaixa', 
                                                        'Moviments.data', 'Moviments.dtbaixa', 'Moviments.vencimento', 'Moviments.status',
                                                        'Moviments.historico',
                                                        'Moviment_Mergeds.ordem', 'Moviment_Mergeds.valor', 'Moviment_Mergeds.valorbaixa', 
                                                        'Moviment_Mergeds.data', 'Moviment_Mergeds.dtbaixa', 'Moviment_Mergeds.vencimento', 'Moviment_Mergeds.status',
                                                        'Moviment_Mergeds.documento', 'Moviment_Mergeds.historico'
                                                       ])
                                              ->where(['MovimentMergeds.moviments_id' => $mergeds->Moviments['id'],
                                                       'MovimentMergeds.moviments_merged <>' => $id
                                                      ])
                                              ->join(['Moviments' => ['table'      => 'Moviments',
                                                                      'type'       => 'LEFT',
                                                                      'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                     ],
                                                      'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                            'type'       => 'LEFT',
                                                                            'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                           ]
                                                     ]);
        }//if (!empty($mergeds))
        
        /**********************************************************************/
        
        //Consulta de títulos pela data de vencimento
        $movimentCards = $this->MovimentCards->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                             ->where(['MovimentCards.moviments_id' => $moviment->id,
                                                      'MovimentCards.cards_id'     => $moviment->cards_id
                                                     ])
                                             ->order(['MovimentCards.data']);
        
        /**********************************************************************/
        
        $movimentos = $this->MovimentsFunctions->consultaMovimentos($moviment->id, $moviment->parameters_id);
        
        
        /**********************************************************************/
        
        $this->set(compact('movimentos'));
        $this->set(compact('moviment'));
        $this->set(compact('mergeds'));
        $this->set(compact('mmergeds'));
        $this->set(compact('movimentMergeds'));
        $this->set(compact('movimentCards'));
    }
    
    public function low($id)
    {
        //Consulta de títulos vinculados
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        $moviment = $this->Moviments->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->contain(['Parameters', 'Banks', 'Boxes', 'Cards', 'Costs', 
                                               'Plannings', 'EventTypes', 'Providers', 'Customers',
                                               'DocumentTypes', 'AccountPlans', 'MovimentCards'
                                              ])
                                    ->first();
        
        /**********************************************************************/
        
        //Consulta título vinculados pela ID (MOVIMENTS_ID)
        /* Listas os movimentos que possuem este ID como vinculador */
        $movimentMergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                           'Moviments.id', 'Moviments.ordem', 'Moviments.valorbaixa', 'Moviments.status', 
                                                           'Moviment_Mergeds.id', 'Moviment_Mergeds.ordem', 'Moviment_Mergeds.valorbaixa', 'Moviment_Mergeds.status'
                                                          ])
                                                 ->where(['MovimentMergeds.moviments_id'  => $moviment->id])
                                                 ->join(['Moviments' => ['table'      => 'Moviments',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'Moviments.id = MovimentMergeds.moviments_id'
                                                                         ],
                                                         'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'Moviment_Mergeds.id = MovimentMergeds.moviments_merged'
                                                                              ]
                                                        ]);
        
        /**********************************************************************/
        
        $valorpago = 0;
        foreach($movimentMergeds as $value):
            
            if ($value->Moviment_Mergeds['status'] == 'O' || $value->Moviment_Mergeds['status'] == 'B') {
                
                //Incrementa com valores pagos em faturas anteriores
                $valorpago += $value->Moviment_Mergeds['valorbaixa'];
                
            }//if ($value->Moviment_Mergeds['status'] == 'O' || $value->Moviment_Mergeds['status'] == 'B')
            
        endforeach;
        
        /**********************************************************************/
        
        //ACRESCENTA A VARIÁVEL NO REQUEST PARA CONTABILIZAÇÃO DOS VALORES NA VIEW 18/05/2016
        $moviment->valorpago = $valorpago;
        
        /**********************************************************************/
        
        //Não baixa documento baixado, nem cancelado
        if ($moviment->status == 'O' || $moviment->status == 'V' ||
           $moviment->status == 'B' || $moviment->status == 'C') { 
            $this->Flash->warning(__('Documento baixado/cancelado, ação não permitida'));
            return $this->redirect($this->referer());
        } //if ($moviment->status == 'O' || $moviment->status == 'V' || $moviment->status == 'B' || $moviment->status == 'C')
        
        /**********************************************************************/
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Cria Entidade
            $moviment = $this->Moviments->patchEntity($moviment, $this->request->getData());
            
            /******************************************************************/
            
            //Retira máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $moviment->valorbaixa = (float) str_replace($source, $replace, $this->request->data['valorbaixa']);
                    
            /******************************************************************/
            
            //Controle de preenchimento de Banco/Caixa
            if ($this->request->data['radio_bc'] == 'banco') {
                
                unset($moviment->boxes_id);
                
                if ($this->request->data['banks_id'] == null) {
                    
                    $this->Flash->warning(__('Desculpe, ocorreu um erro e o registro não foi salvo. Banco não informado'));
                    return $this->redirect($this->referer());
                    
                }//if ($this->request->data['banks_id'] == null)
                
            }//if ($this->request->data['radio_bc'] == 'banco')
            elseif ($this->request->data['radio_bc'] == 'caixa') {
                
                unset($moviment->banks_id);
                unset($moviment->cheque);
                unset($moviment->nominal);
                unset($moviment->emissaoch);
                
                if ($this->request->data['boxes_id'] == null) {
                    
                    $this->Flash->warning(__('Desculpe, ocorreu um erro e o registro não foi salvo. Caixa não informado'));
                    return $this->redirect($this->referer());
                    
                }//if ($this->request->data['boxes_id'] == null)
                
            }//elseif ($this->request->data['radio_bc'] == 'caixa')
            
            /******************************************************************/
            
            //Define como nulo os campos de cheque
            if (empty($this->request->data['cheque']) || $this->request->data['cheque'] == '') {
                
                unset($moviment->cheque);
                unset($moviment->nominal);
                unset($moviment->emissaoch);
                
            }//if (empty($this->request->data['cheque']) || $this->request->data['cheque'] == '')
            
            /******************************************************************/
            
            //VERIFICA DUPLICIDADE DE CHEQUE
            if (isset($moviment->cheque) && !empty($moviment->cheque)) {
                
                $this->MovimentChecksFunctions->validaCheque($moviment->cheque, $this->request->Session()->read('sessionParameterControl'));
                
            }//if (isset($moviment->cheque) && !empty($moviment->cheque))
            
            /******************************************************************/
            
            //VERIFICA SE O TÍTULO POSSUI VÍNCULO DE CARTÃO E REALIZA O CRÉDITO DO PAGAMENTO
            if (!empty($moviment->cards_id)) {
                
                $this->MovimentCardsFunctions->lowCard($moviment);
                
            }//if (!empty($moviment->cards_id))
            
            /******************************************************************/
            
            //VERIFICA SE O TÍTULO POSSUI VÍNCULO DE PLANEAMENTO
            if (!empty($moviment->plannings_id)) {
                
                $this->GeneralBalance->balancePlanning($moviment);
                
            }//if (!empty($moviment->plannings_id))
            
            /******************************************************************/
            
            //VERIFICA SE É BAIXA PARCIAL
            if ($this->request->data['parcial'] == 'P') {
                
                if ($moviment->valor > $moviment->valorbaixa) {
                    
                    //CRIA NOVO REGISTRO COM A BAIXA NA TABELA DE MOVIMENTO
                    $this->MovimentsFunctions->addPartial($moviment);
                    
                    /**********************************************************/

                    //DEFINE VALORES DAS VARÍAVEIS PARA NÃO BAIXAR O TÍTULO ATUAL
                    $moviment->dtbaixa        = null;
                    $moviment->valorbaixa     = null;
                    $moviment->cheque         = null;
                    $moviment->nominal        = null;
                    $moviment->emissaoch      = null;
                    $moviment->banks_id       = null;
                    $moviment->boxes_id       = null;
                    $moviment->event_types_id = null;
                    $moviment->userbaixa      = null;
                    $moviment->status         = 'P'; // Define como parcialmente aberto
                    
                }//if ($moviment->valor != $moviment->valorbaixa)
                
            //if ($moviment['parcial'] == 'P')
            } else {
                
                $moviment->status     = 'B'; // Define como documento baixado
                $moviment->userbaixa  = $this->Auth->user('name');
                
                /**************************************************************/
                
                // TÍTULOS PODEM SER VINCULADOS (UM BOLETO PARA VÁRIOS TÍTULOS) OU PARCIAL (PAGAMENTOS PARCIAIS)
                $this->MovimentsFunctions->lowVinculados($moviment, $this->request->Session()->read('sessionParameterControl'));
                
            }//if ($this->request->data['parcial'] == 'P')
            
            /******************************************************************/
            
            if ($this->Moviments->save($moviment)) {
                
                if ($this->request->data['parcial'] != 'P') {
                    
                    //Não contábil: Não movimenta o saldo do banco/caixa e pode ser filtrado nos relatórios.
                    if ($moviment->contabil == 'S') {
                        
                        // ATUALIZAÇÃO DOS SALDOS
                        $this->GeneralBalance->balance($moviment);
                        
                    }//if ($moviment->contabil == 'S')
                    
                    /**********************************************************/
                    
                    // REGISTRA MOVIMENTOS BANCÁRIOS E CAIXAS
                    $this->MovimentsFunctions->bankBoxCheck($moviment);
                    
                }//if ($this->request->data['parcial'] != 'P')
                
                $this->Flash->success(__('Registro baixado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Moviments->save($moviment))

            /**********************************************************************/
    
            //Alerta de erro
            $message = 'MovimentsController->low';
            $this->Error->registerError($moviment, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $conditions = ['MovimentMergeds.moviments_id LIKE' => $id, 'MovimentMergeds.parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('movimentMergeds', $this->MovimentMergeds->find('all', ['conditions' => $conditions]));
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('providers', $this->Moviments->Providers->find('list')->where($conditions)->order(['Providers.title']));
        $this->set('customers', $this->Moviments->Customers->find('list')->where($conditions)->order(['Customers.title']));
        $banks = $this->Moviments->Banks->find('list')->where(['Banks.parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'Banks.tipoconta !=' => 'A'])->order(['Banks.title']);
        $banks = $banks->select(['id', 'title' => $banks->func()->concat(['Banks.title' => 'identifier', 
                                                                          ' - (',
                                                                          'Banks.agencia' => 'identifier', 
                                                                          ' / ',
                                                                          'Banks.conta' => 'identifier', 
                                                                          ') '
                                                                         ])
                                ]);
        $this->set('banks', $banks);
        $this->set('boxes', $this->Moviments->Boxes->find('list')->where($conditions)->order(['Boxes.title']));
        $this->set('eventTypes', $this->Moviments->EventTypes->find('list')->where($conditions)->order(['EventTypes.title']));
        $this->set('documentTypes', $this->Moviments->DocumentTypes->find('list')->where($conditions)->order(['title']));
        
        if (!empty($moviment->data)) {
            $moviment->data = date("d/m/Y", strtotime($moviment->data));
        }
        if (!empty($moviment->vencimento)) {
            $moviment->vencimento = date("d/m/Y", strtotime($moviment->vencimento));
            $moviment->dtbaixa    = $moviment->vencimento;
        }
        if (!empty($moviment->emissaoch)) {
            $moviment->emissaoch = date("d/m/Y", strtotime($moviment->emissaoch));
        }
        
        $this->set(compact('moviment'));
    }
    
    public function lowSimple($id)
    {
        //Consulta de títulos vinculados
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/

        $moviment = $this->Moviments->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->contain(['Parameters', 'Banks', 'Boxes', 'Cards', 
                                               'Plannings', 'MovimentCards'
                                              ])
                                    ->first();
        
        /**********************************************************************/
        
        //Consulta título vinculados pela ID (MOVIMENTS_ID)
        /* Listas os movimentos que possuem este ID como vinculador */
        $movimentMergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                           'Moviments.id', 'Moviments.ordem', 'Moviments.valorbaixa', 'Moviments.status', 
                                                           'Moviment_Mergeds.id', 'Moviment_Mergeds.ordem', 'Moviment_Mergeds.valorbaixa', 'Moviment_Mergeds.status'
                                                          ])
                                                 ->where(['MovimentMergeds.moviments_id'  => $moviment->id])
                                                 ->join(['Moviments' => ['table'      => 'Moviments',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'Moviments.id = MovimentMergeds.moviments_id'
                                                                         ],
                                                         'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'Moviment_Mergeds.id = MovimentMergeds.moviments_merged'
                                                                              ]
                                                        ]);
        
        /**********************************************************************/
        
        $valorpago = 0;
        foreach($movimentMergeds as $value):
            
            if ($value->Moviment_Mergeds['status'] == 'O' || $value->Moviment_Mergeds['status'] == 'B') {
                
                //Incrementa com valores pagos em faturas anteriores
                $valorpago += $value->Moviment_Mergeds['valorbaixa'];
                
            }//if ($value->Moviment_Mergeds['status'] == 'O' || $value->Moviment_Mergeds['status'] == 'B')
            
        endforeach;
        
        /**********************************************************************/
        
        //ACRESCENTA A VARIÁVEL NO REQUEST PARA CONTABILIZAÇÃO DOS VALORES NA VIEW 18/05/2016
        $moviment->valorpago = $valorpago;
        
        /**********************************************************************/
        
        //Não baixa documento baixado, nem cancelado
        if ($moviment->status == 'O' || $moviment->status == 'V' ||
           $moviment->status == 'B' || $moviment->status == 'C') { 
            $this->Flash->warning(__('Documento baixado/cancelado, ação não permitida'));
            return $this->redirect($this->referer());
        } //if ($moviment->status == 'O' || $moviment->status == 'V' || $moviment->status == 'B' || $moviment->status == 'C')
        
        /**********************************************************************/
        
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
            
            //Cria Entidade
            $moviment = $this->Moviments->patchEntity($moviment, $this->request->getData());
            
            /******************************************************************/
            
            //Retira máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $moviment->valorbaixa = (float) str_replace($source, $replace, $this->request->data['valorbaixa']);
                    
            /******************************************************************/
            
            //Controle de preenchimento de Banco/Caixa
            if ($this->request->data['radio_bc'] == 'banco') {
                
                unset($moviment->boxes_id);
                
                if ($this->request->data['banks_id'] == null) {
                    
                    $this->Flash->warning(__('Desculpe, ocorreu um erro e o registro não foi salvo. Banco não informado'));
                    return $this->redirect($this->referer());
                    
                }//if ($this->request->data['banks_id'] == null)
                
            }//if ($this->request->data['radio_bc'] == 'banco')
            elseif ($this->request->data['radio_bc'] == 'caixa') {
                
                unset($moviment->banks_id);
                unset($moviment->cheque);
                unset($moviment->nominal);
                unset($moviment->emissaoch);
                
                if ($this->request->data['boxes_id'] == null) {
                    
                    $this->Flash->warning(__('Desculpe, ocorreu um erro e o registro não foi salvo. Caixa não informado'));
                    return $this->redirect($this->referer());
                    
                }//if ($this->request->data['boxes_id'] == null)
                
            }//elseif ($this->request->data['radio_bc'] == 'caixa')
            
            /******************************************************************/
            
            //VERIFICA SE O TÍTULO POSSUI VÍNCULO DE CARTÃO E REALIZA O CRÉDITO DO PAGAMENTO
            if (!empty($moviment->cards_id)) {
                
                $this->MovimentCardsFunctions->lowCard($moviment);
                
            }//if (!empty($moviment->cards_id))
            
            /******************************************************************/
            
            //VERIFICA SE O TÍTULO POSSUI VÍNCULO DE PLANEAMENTO
            if (!empty($moviment->plannings_id)) {
                
                $this->GeneralBalance->balancePlanning($moviment);
                
            }//if (!empty($moviment->plannings_id))
            
            /******************************************************************/
            
            //VERIFICA SE É BAIXA PARCIAL
            if ($this->request->data['parcial'] == 'P') {
                
                if ($moviment->valor > $moviment->valorbaixa) {
                    
                    //CRIA NOVO REGISTRO COM A BAIXA NA TABELA DE MOVIMENTO
                    $this->MovimentsFunctions->addPartial($moviment);
                    
                    /**********************************************************/

                    //DEFINE VALORES DAS VARÍAVEIS PARA NÃO BAIXAR O TÍTULO ATUAL
                    $moviment->dtbaixa        = null;
                    $moviment->valorbaixa     = null;
                    $moviment->cheque         = null;
                    $moviment->nominal        = null;
                    $moviment->emissaoch      = null;
                    $moviment->banks_id       = null;
                    $moviment->boxes_id       = null;
                    $moviment->event_types_id = null;
                    $moviment->userbaixa      = null;
                    $moviment->status         = 'P'; // Define como parcialmente aberto
                    
                }//if ($moviment->valor != $moviment->valorbaixa)
                
            //if ($moviment['parcial'] == 'P')
            } else {
                
                $moviment->status     = 'B'; // Define como documento baixado
                $moviment->userbaixa  = $this->Auth->user('name');
                
                /**************************************************************/
                
                // TÍTULOS PODEM SER VINCULADOS (UM BOLETO PARA VÁRIOS TÍTULOS) OU PARCIAL (PAGAMENTOS PARCIAIS)
                $this->MovimentsFunctions->lowVinculados($moviment, $this->request->Session()->read('sessionParameterControl'));
                
            }//if ($this->request->data['parcial'] == 'P')
            
            /******************************************************************/
            
            if ($this->Moviments->save($moviment)) {
                
                if ($this->request->data['parcial'] != 'P') {
                    
                    //Não contábil: Não movimenta o saldo do banco/caixa e pode ser filtrado nos relatórios.
                    if ($moviment->contabil == 'S') {
                        
                        // ATUALIZAÇÃO DOS SALDOS
                        $this->GeneralBalance->balance($moviment);
                        
                    }//if ($moviment->contabil == 'S')
                    
                    /**********************************************************/
                    
                    // REGISTRA MOVIMENTOS BANCÁRIOS E CAIXAS
                    $this->MovimentsFunctions->bankBoxCheck($moviment);
                    
                }//if ($this->request->data['parcial'] != 'P')
                
                $this->Flash->success(__('Registro baixado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Moviments->save($moviment))

            /**********************************************************************/
    
            //Alerta de erro
            $message = 'MovimentsController->lowSimple';
            $this->Error->registerError($moviment, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))

        /**********************************************************************/
        
        $conditions = ['MovimentMergeds.moviments_id LIKE' => $id, 'MovimentMergeds.parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('movimentMergeds', $this->MovimentMergeds->find('all', ['conditions' => $conditions]));

        /**********************************************************************/
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $banks = $this->Moviments->Banks->find('list')->where(['Banks.parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'Banks.tipoconta !=' => 'A'])->order(['Banks.title']);
        $banks = $banks->select(['id', 'title' => $banks->func()->concat(['Banks.title' => 'identifier', 
                                                                          ' - (',
                                                                          'Banks.agencia' => 'identifier', 
                                                                          ' / ',
                                                                          'Banks.conta' => 'identifier', 
                                                                          ') '
                                                                         ])
                                ]);
        $this->set('banks', $banks);

        /**********************************************************************/

        $this->set('boxes', $this->Moviments->Boxes->find('list')->where($conditions)->order(['Boxes.title']));

        /**********************************************************************/
        
        if (!empty($moviment->data)) {
            $moviment->data = date("d/m/Y", strtotime($moviment->data));
        }
        if (!empty($moviment->vencimento)) {
            $moviment->vencimento = date("d/m/Y", strtotime($moviment->vencimento));
            $moviment->dtbaixa    = $moviment->vencimento;
        }

        /**********************************************************************/
        
        $this->set(compact('moviment'));
    }
    
    public function reopen($id)
    {
        $moviment = $this->Moviments->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $this->request->data['username'] = $this->Auth->user('name');
            $this->request->data['status']   = 'A';
            
            /******************************************************************/
            
            $moviment = $this->Moviments->patchEntity($moviment, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->Moviments->save($moviment)) {
                
                $this->Flash->success(__('Registro reativado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Moviments->save($moviment))

            /**********************************************************************/
    
            //Alerta de erro
            $message = 'MovimentsController->reopen';
            $this->Error->registerError($moviment, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is(['patch', 'post', 'put']))
    }
    
    public function cancel($id)
    {
        //Acessa a tabela MovimentMerged
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('cancel', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('cancel', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))

        /**********************************************************************/
        
        $this->request->allowMethod('post');
        
        /**********************************************************************/
        
        //CONSULTA TODO O CADASTRO
        $moviment = $this->Moviments->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->first();
        
        //O REGISTRO NÃO PERTENCE AO PERFIL ATUAL
        if (empty($moviment)) {
            $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
            return $this->redirect($this->referer());
        }//if (empty($moviment))
        
        /**********************************************************************/
        
        //Consulta título de vínculo pelo ID (MOVIMENTS_MERGED)
        /* Identifica os dados do vinculador, através do ID do movimento */
        $vinculador = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                            ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                      'Moviments.id', 'Moviments.ordem', 'Moviments.valorbaixa', 'Moviments.status', 
                                                      'Moviment_Mergeds.id', 'Moviment_Mergeds.ordem', 'Moviment_Mergeds.valorbaixa', 'Moviment_Mergeds.status'
                                                     ])
                                            ->where(['MovimentMergeds.moviments_merged' => $moviment->id])
                                            ->join(['Moviments' => ['table'      => 'Moviments',
                                                                    'type'       => 'LEFT',
                                                                    'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                   ],
                                                    'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                          'type'       => 'LEFT',
                                                                          'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                         ]
                                                   ])
                                            ->first();
        
        /**********************************************************************/
        
        if (!empty($vinculador)) {
            
            //ID DO MOVIMENTO VINCULADOR
            $moviments_id = $vinculador->Moviments['id'];
            
            // STATUS = O (BAIXA PARCIAL)
            if ($moviment->status == 'O') {
                
                // AO CANCELAR A BAIXA PARCIAL, O MESMO SERÁ EXCLUÍDO, LOGO APÓS O CANCELAMENTO.
                $bparcial = true;
                
                /**************************************************************/
                
                //Consulta título vinculados pela ID (MOVIMENTS_ID)
                /* Listas os outros movimentos que possuem o mesmo vinculador */
                $outros_vinculados = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                           ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                                     'Moviments.id', 'Moviments.ordem', 'Moviments.valorbaixa', 'Moviments.status', 
                                                                     'Moviment_Mergeds.id', 'Moviment_Mergeds.ordem', 'Moviment_Mergeds.valorbaixa', 'Moviment_Mergeds.status'
                                                                    ])
                                                           ->where(['MovimentMergeds.moviments_id' => $moviments_id])
                                                           ->join(['Moviments' => ['table'      => 'Moviments',
                                                                                   'type'       => 'LEFT',
                                                                                   'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                                  ],
                                                                   'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                                         'type'       => 'LEFT',
                                                                                         'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                                        ]
                                                                  ]);
                
                /**************************************************************/
                
                $qtd_outros_vinculados = count($outros_vinculados->toArray());

                /**************************************************************/
                
                //VERIFICA O STATUS DO REGISTRO
                $moviments_vinculador = $this->Moviments->findByIdAndParametersId($moviments_id, $this->request->Session()->read('sessionParameterControl'))
                                                        ->select(['Moviments.id', 'Moviments.parameters_id', 'Moviments.status']);
                
                /**************************************************************/
                
                foreach ($moviments_vinculador as $moviment_vinculador):
                    
                    // SE TENTAR CANCELAR UM TÍTULO VINCULADO A UM REGISTRO BAIXADO, NÃO SERÁ PERMITIDO.
                    if ($moviment_vinculador->status == 'B') {
                        
                        $this->Flash->error(__('Registro NÃO cancelado. O vínculo principal está baixado'));
                        return $this->redirect($this->referer());
                        
                    }//if ($moviment_vinculador->status == 'B')
                    
                    /**********************************************************/
                    
                    // SE O TÍTULO VINCULADO FOR O ÚLTIMO, O STATUS DO VÍNCULO PRINCIPAL SERÁ MUDADO PARA ABERTO.
                    if ($qtd_outros_vinculados == 1) {

                        //Define o status aberto para o título principal
                        $moviment_vinculador->status = 'A';
                        
                        if (!$this->Moviments->save($moviment_vinculador)) {

                            //Alerta de erro
                            $message = 'MovimentsController->cancel';
                            $this->Error->registerError($moviment_vinculador, $message, true);

                        }//if (!$this->Moviments->save($moviment_vinculador))
                        
                    }//if ($qtd_outros_vinculados == 1)
                    
                endforeach;
                
                /**************************************************************/
                
            }//if ($moviment->status == 'O') 
                    
        }//if (!empty($vinculador))
        
        /**********************************************************************/

        //Consulta título vinculados pela ID
        /* Listas os movimentos vinculados a este ID */
        $vinculados = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                            ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                      'Moviments.id', 'Moviments.ordem', 'Moviments.valorbaixa', 'Moviments.status', 
                                                      'Moviment_Mergeds.id', 'Moviment_Mergeds.ordem', 'Moviment_Mergeds.valorbaixa', 'Moviment_Mergeds.status'
                                                     ])
                                            ->where(['MovimentMergeds.moviments_id' => $moviment->id])
                                            ->join(['Moviments' => ['table'      => 'Moviments',
                                                                    'type'       => 'LEFT',
                                                                    'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                   ],
                                                    'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                          'type'       => 'LEFT',
                                                                          'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                         ]
                                                   ]);
        
        /**********************************************************************/
        
        if (!empty($vinculados->toArray())) {
            
            // SE HOUVER TÍTULOS VINCULADOS, ESTE VOLTARÁ A SER PARCIAL
            foreach($vinculados as $value):
                
                if ($value->Moviment_Mergeds['status'] == 'O') {
                    
                    $moviment->status = 'P';
                    
                } elseif ($value->Moviment_Mergeds['status'] == 'V') {
                    
                    $moviment->status = 'G';
                    
                }//elseif ($value->Moviment_Mergeds['status'] == 'V')
                
            endforeach;
            
        } else {
            
            // SE NÃO HOUVEREM MAIS VÍNCULOS, O MESMO SERÁ CANCELADO
            $moviment->status = 'C';
            
        }//else if (!empty($vinculados->toArray()))

        /**********************************************************************/
        
        //Não contábil: Não movimenta o saldo do banco/caixa e pode ser filtrado nos relatórios.
        if ($moviment->contabil == 'S') {
            $this->GeneralBalance->balance($moviment, true); //ATUALIZA OS SALDOS
        }//if ($moviment->contabil == 'S')

        /**********************************************************************/
        
        //EXCLUI MOVIMENTO DE BANCOS E CAIXAS
        $this->MovimentsFunctions->cancelDependency($moviment, $this->request->Session()->read('sessionParameterControl'));
        
        /**********************************************************************/
        
        //VERIFICA SE O TÍTULO POSSUI O FORNECEDOR CARTÃO E REALIZA O CRÉDITO DO PAGAMENTO
        if (!empty($moviment->cards_id)) {
            $this->MovimentCardsFunctions->lowCard($moviment, true);
        }//if (!empty($moviment->cards_id))
        
        /**********************************************************************/
        
        //VERIFICA SE O TÍTULO POSSUI VÍNCULO DE PLANEJAMENTO
        if (!empty($moviment->plannings_id)) {
            $this->GeneralBalance->balancePlanning($moviment, true);
        }//if (!empty($moviment->plannings_id))

        /**********************************************************************/
        
        //SE FOR CARTÃO O STATUS RETORNARÁ PARA ABERTO
        if (!empty($moviment->cards_id)) {
            
            //Aberto
            $moviment->status = 'A';
            
        }//if (!empty($moviment->cards_id))
        
        /**********************************************************************/
        
        // TÍTULOS PODEM SER VINCULADOS (UM BOLETO PARA VÁRIOS TÍTULOS) OU PARCIAL (PAGAMENTOS PARCIAIS)
        $this->MovimentsFunctions->lowVinculados($moviment, $this->request->Session()->read('sessionParameterControl'), true); // CANCELA MOVIMENTOS VINCULADOS
        
        /**********************************************************************/
        
        $moviment->username       = $this->Auth->user('name');
        $moviment->dtbaixa        = null;
        $moviment->valorbaixa     = null;
        $moviment->banks_id       = null;
        $moviment->boxes_id       = null;
        $moviment->event_types_id = null;
        $moviment->cheque         = null;
        $moviment->nominal        = null;
        $moviment->emissaoch      = null;
        
        /**********************************************************************/
        
        if ($this->Moviments->save($moviment)) {
            
            //CASO SEJA BAIXA PARCIAL, APÓS CANCELAR, EXCLUIR.
            if (isset($bparcial)) {
                
                //Exclui registros da tabela de vínculo
                $this->MovimentsFunctions->deleteMerged($id, $this->request->Session()->read('sessionParameterControl'));
                
                /**************************************************************/
                
                //Exclui os movimentos recorrentes
                $this->MovimentRecurrentsFunctions->deleteMovimentRecurrents($id, $this->request->Session()->read('sessionParameterControl'));
                
                /**************************************************************/
                
                //Exclui os movimentos de cartões
                $this->MovimentsFunctions->deleteMovimentCards($id, $this->request->Session()->read('sessionParameterControl'));
                
                /**************************************************************/
                
                //Exclui o registro
                $this->Moviments->deleteAll(['Moviments.id' => $id, 'Moviments.parameters_id' => $this->request->Session()->read('sessionParameterControl')]);
                
            }//if (isset($bparcial))

            /******************************************************************/
    
            //Alerta de erro
            $message = 'MovimentsController->cancel';
            $this->Error->registerError($moviment, $message, true);
            
            /******************************************************************/
        
            $this->Flash->success(__('Registro cancelado com sucesso'));
            return $this->redirect($this->referer());
            
        }//if ($this->Moviments->save($moviment))
        
        $this->Flash->error(__('Registro NÃO cancelado, tente novamente'));
        return $this->redirect($this->referer());
    }

    public function add()
    {
        $this->Cards = TableRegistry::get('Cards');
        
        /*********************************************************************/
        
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
            $this->request->data['status']   = 'A';
            $this->request->data['coins_id'] = '1'; //Campo utilizado na versão 1.0 do sistema
            
            /******************************************************************/
            
            //Preenche a data de vencimento
            if (!$this->request->data['vencimento']) {
                $this->request->data['vencimento'] = $this->request->data['data'];
            }
            
            /******************************************************************/
            
            //Guarda variáveis
            $documento = $this->request->data['documento'];
            $document_types_id = $this->request->data['document_types_id'];
            $customers_id = $this->request->data['customers_id'];
            $providers_id = $this->request->data['providers_id'];
            
            /******************************************************************/
            
            //Controle de preenchimento de Cliente/Fornecedor
            if ($this->request->data['creditodebito'] == 'C') {
                
                unset($this->request->data['providers_id']);

                if ($customers_id == null) {
                    $this->Flash->warning(__('Desculpe, ocorreu um erro e o registro não foi salvo. Fornecedor não informado'));
                    return $this->redirect($this->referer());
                }//if ($customers_id == null)
                
            } elseif ($this->request->data['creditodebito'] == 'D') {
                
                unset($this->request->data['customers_id']);
                
                if ($providers_id == null) {
                    $this->Flash->warning(__('Desculpe, ocorreu um erro e o registro não foi salvo. Cliente não informado'));
                    return $this->redirect($this->referer());
                }//if ($providers_id == null)
                
            }//elseif ($this->request->data['creditodebito'] == 'D')
            
            /******************************************************************/
            
            //Retirar máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['valor'] = str_replace($source, $replace, $this->request->data['valor']);
            
            /******************************************************************/
            
            //VERIFICA DUPLICIDADE DE DOCUMENTO
            $this->MovimentsFunctions->validaDocumento($providers_id, $customers_id, $documento, $document_types_id, $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            //DEFINE O VALOR DA ORDEM
            $ordem = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->select(['MAX' => 'MAX(Moviments.ordem)'])
                                     ->first();
            $ordem = $ordem->MAX;
            
            /******************************************************************/
            
            //CONTAS RECORRENTES
            if ($this->request->data['dd'] == 'R') {
                
                //CRIA UM NOVO CADASTRO
                $moviment = $this->Moviments->newEntity($this->request->getData());
                
                /**************************************************************/
                
                //DEFINE O VALOR DA ORDEM
                $moviment->ordem = $ordem + 1;
                
                /**************************************************************/
                
                //SALVA O NOVO REGISTRO
                if ($this->Moviments->save($moviment)) {
                    
                    //REGISTRA MOVIMENTOS RECORRENTES
                    $movimentRecurrent = $this->MovimentRecurrentsFunctions->addMovimentRecurrents($moviment->id, $this->request->Session()->read('sessionParameterControl')); 
                    
                    /**********************************************************/
                    
                    if (!empty($movimentRecurrent)) {
                        $this->Flash->success(__('Registro gravado com sucesso'));
                        return $this->redirect($this->referer());
                    }
                
                    /**********************************************************/
                    
                    if ($moviment->dtbaixa) {
                    
                        //EFETUA O PAGAMENTO CASO PREENCHIDO 
                        $this->lowSimple($moviment->id);
                    
                    }//if ($moviment->dtbaixa)

                    /**********************************************************/
                    
                    $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
                    return $this->redirect($this->referer());
                    
                } else {

                    //Alerta de erro
                    $message = 'MovimentsController->add, Recorrente';
                    $this->Error->registerError($moviment, $message, true);

                }//if ($this->Moviments->save($moviment))
                
            } else { //CONTAS NÃO RECORRENTES
                
                //Entradas parceladas
                $parcela       = 1;
                $parcelas      = $this->request->data['parcelas'];
                $historico     = $this->request->data['historico'];
                $documento     = $this->request->data['documento'];
                $vencimento    = $this->request->data['vencimento'];
                $ordem_parcela = $ordem; //Número de ordem crescente nas parcelas
                
                while ($parcela <= $parcelas) {
                    
                    //CRIA UM NOVO CADASTRO
                    $moviment = $this->Moviments->newEntity($this->request->getData());
                    
                    /**********************************************************/
                    
                    $moviment->vencimento    = $vencimento; //RECUPERA O VENCIMENTO
                    $moviment->ordem         = $ordem_parcela += 1; //DEFINE O VALOR DA ORDEM
                    $moviment->coins_id      = '1'; //Campo utilizado na versão 1.0 do sistema
                    $moviment->parameters_id = $this->request->Session()->read('sessionParameterControl');
                    
                    /**********************************************************/
                    
                    if ($parcelas > 1) {
                        //Modifica o HISTÓRICO e DOCUMENTO adicionando o número de parcelas
                        $moviment->historico = $historico . ' (' . $parcela . '/' . $parcelas . ')';
                        $moviment->documento = $documento . ' (' . $parcela . '/' . $parcelas . ')';
                    }
                    
                    /**********************************************************/
                    
                    if (!$this->Moviments->save($moviment)) {
                
                        //Alerta de erro
                        $message = 'MovimentsController->add, Não Recorrente';
                        $this->Error->registerError($moviment, $message, true);

                        /**********************************************************************/

                        $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                        return $this->redirect($this->referer());

                    }//if (!$this->Moviments->save($moviment))
                    
                    /**********************************************************/
                    
                    if ($parcelas > 1) {
                            
                       if ($this->request->data['dd'] == '30') {
                           $vencimento = $moviment->vencimento->addMonth(1);
                       } elseif ($this->request->data['dd'] == '10') {
                           $vencimento = $moviment->vencimento->addDays(10);
                       } elseif ($this->request->data['dd'] == '15') {
                           $vencimento = $moviment->vencimento->addDays(15);
                       } elseif ($this->request->data['dd'] == 'bim') {
                           $vencimento = $moviment->vencimento->addMonth(2);
                       } elseif ($this->request->data['dd'] == 'tri') {
                           $vencimento = $moviment->vencimento->addMonth(3);
                       } elseif ($this->request->data['dd'] == 'sem') {
                           $vencimento = $moviment->vencimento->addMonth(6);
                       } elseif ($this->request->data['dd'] == 'anu') {
                           $vencimento = $moviment->vencimento->addYear(1);
                       }
                
                }//if ($parcelas > 1)
                    
                    $parcela += 1;
                    
                }//while($parcela <= $parcelas)
                
                /**************************************************************/
                
                if ($moviment->dtbaixa && $parcelas == 1) {
                    //EFETUA O PAGAMENTO CASO PREENCHIDO 
                    $this->low($moviment->id);
                }//if ($moviment->dtbaixa && $parcelas == 1)
                
                /**************************************************************/
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//else if ($this->request->data['dd'] == 'R')
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('providers', $this->Moviments->Providers->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]
        $this->set('customers', $this->Moviments->Customers->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]
        $this->set('documentTypes', $this->Moviments->DocumentTypes->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]
        $this->set('costs', $this->Moviments->Costs->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]
        $banks = $this->Moviments->Banks->find('list')->where(['Banks.parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'Banks.tipoconta !=' => 'A'])->order(['Banks.title']);
        $banks = $banks->select(['id', 'title' => $banks->func()->concat(['Banks.title' => 'identifier', 
                                                                          ' - (',
                                                                          'Banks.agencia' => 'identifier', 
                                                                          ' / ',
                                                                          'Banks.conta' => 'identifier', 
                                                                          ') '
                                                                         ])
                                ]);
        $this->set('banks', $banks);
        $this->set('boxes', $this->Moviments->Boxes->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]
        $this->set('eventTypes', $this->Moviments->EventTypes->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]
        $accountPlans = $this->Moviments->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
                                                      ->where($conditions)
                                                      ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
        $this->set('cards', $this->Cards->find('list')->where($conditions)->order(['title']));
    }

    public function addSimple()
    {
        $this->Cards = TableRegistry::get('Cards');
        
        /*********************************************************************/
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //VERSÃO SIMPLIFICADA
            $this->request->data['documento']          = null;
            $this->request->data['providers_id']       = null;
            $this->request->data['customers_id']       = null;
            $this->request->data['event_types_id']     = null;
            $this->request->data['document_types_id']  = null;
            $this->request->data['account_plans_id']   = null;
            $this->request->data['cheque']             = null;
            $this->request->data['emissaoch']          = null;
            $this->request->data['nominal']            = null;
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            $this->request->data['username'] = $this->Auth->user('name');
            $this->request->data['status']   = 'A';
            $this->request->data['coins_id'] = '1'; //Campo utilizado na versão 1.0 do sistema
            if (empty($this->request->data['contabil'])) { $this->request->data['contabil'] = 'S'; } //Versão gratuita não exibe o campo
            
            /******************************************************************/
            
            //Preenche a data de vencimento
            if (!$this->request->data['vencimento']) {
                $this->request->data['vencimento'] = $this->request->data['data'];
            }
            
            /******************************************************************/
            
            //Guarda variáveis
            $documento = $this->request->data['documento'];
            
            /******************************************************************/
            
            //Retirar máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['valor'] = str_replace($source, $replace, $this->request->data['valor']);
            
            /******************************************************************/
            
            //DEFINE O VALOR DA ORDEM
            $ordem = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->select(['MAX' => 'MAX(Moviments.ordem)'])
                                     ->first();
            $ordem = $ordem->MAX;
            
            /******************************************************************/
            
            //CONTAS RECORRENTES
            if ($this->request->data['dd'] == 'R') {
                
                //CRIA UM NOVO CADASTRO
                $moviment = $this->Moviments->newEntity($this->request->getData());
                
                /**************************************************************/
                
                //DEFINE O VALOR DA ORDEM
                $moviment->ordem = $ordem + 1;

                /**************************************************************/
                
                //SALVA O NOVO REGISTRO
                if ($this->Moviments->save($moviment)) {
                    
                    //REGISTRA MOVIMENTOS RECORRENTES
                    $movimentRecurrent = $this->MovimentRecurrentsFunctions->addMovimentRecurrents($moviment->id, $this->request->Session()->read('sessionParameterControl')); 
                
                    /**********************************************************/
                    
                    if (!empty($movimentRecurrent)) {
                        $this->Flash->success(__('Registro gravado com sucesso'));
                        return $this->redirect($this->referer());
                    }
                
                    /**********************************************************/
                    
                    if ($moviment->dtbaixa) {
                    
                        //EFETUA O PAGAMENTO CASO PREENCHIDO 
                        $this->lowSimple($moviment->id);
                    
                    }//if ($moviment->dtbaixa)

                    /**********************************************************/
                    
                    $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
                    return $this->redirect($this->referer());
                    
                } else {

                    //Alerta de erro
                    $message = 'MovimentsController->addSimple, Recorrente';
                    $this->Error->registerError($moviment, $message, true);

                }//if ($this->Moviments->save($moviment))
                
            } else { //CONTAS NÃO RECORRENTES
                
                //Entradas parceladas
                $parcela       = 1;
                $parcelas      = $this->request->data['parcelas'];
                $historico     = $this->request->data['historico'];
                $vencimento    = $this->request->data['vencimento'];
                $ordem_parcela = $ordem; //Número de ordem crescente nas parcelas
                
                while ($parcela <= $parcelas) {
                    
                    //CRIA UM NOVO CADASTRO
                    $moviment = $this->Moviments->newEntity($this->request->getData());
                    
                    /**********************************************************/
                    
                    $moviment->vencimento    = $vencimento; //RECUPERA O VENCIMENTO
                    $moviment->ordem         = $ordem_parcela += 1; //DEFINE O VALOR DA ORDEM
                    $moviment->coins_id      = '1'; //Campo utilizado na versão 1.0 do sistema
                    $moviment->parameters_id = $this->request->Session()->read('sessionParameterControl');
                    
                    /**********************************************************/
                    
                    if ($parcelas > 1) {
                        //Modifica o HISTÓRICO e DOCUMENTO adicionando o número de parcelas
                        $moviment->historico = $historico . ' (' . $parcela . '/' . $parcelas . ')';
                    }
                    
                    /**********************************************************/
                    
                    if (!$this->Moviments->save($moviment)) {

                        //Alerta de erro
                        $message = 'MovimentsController->addSimple, Não recorrente';
                        $this->Error->registerError($moviment, $message, true);

                        /******************************************************/
                        
                        $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                        return $this->redirect($this->referer());

                    }//if (!$this->Moviments->save($moviment))
                    
                    /**********************************************************/
                    
                    if ($parcelas > 1) {
                            
                       if ($this->request->data['dd'] == '30') {
                           $vencimento = $moviment->vencimento->addMonth(1);
                       } elseif ($this->request->data['dd'] == '10') {
                           $vencimento = $moviment->vencimento->addDays(10);
                       } elseif ($this->request->data['dd'] == '15') {
                           $vencimento = $moviment->vencimento->addDays(15);
                       } elseif ($this->request->data['dd'] == 'bim') {
                           $vencimento = $moviment->vencimento->addMonth(2);
                       } elseif ($this->request->data['dd'] == 'tri') {
                           $vencimento = $moviment->vencimento->addMonth(3);
                       } elseif ($this->request->data['dd'] == 'sem') {
                           $vencimento = $moviment->vencimento->addMonth(6);
                       } elseif ($this->request->data['dd'] == 'anu') {
                           $vencimento = $moviment->vencimento->addYear(1);
                       }
                
                    }//if ($parcelas > 1)
                    
                    $parcela += 1;
                    
                }//while($parcela <= $parcelas)
                
                /**************************************************************/
                
                if ($moviment->dtbaixa && $parcelas == 1) {
                
                    //EFETUA O PAGAMENTO CASO PREENCHIDO 
                    $this->lowSimple($moviment->id);
                
                }//if ($moviment->dtbaixa && $parcelas == 1)
                
                /**************************************************************/
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//else if ($this->request->data['dd'] == 'R')
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('costs', $this->Moviments->Costs->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]
        $banks = $this->Moviments->Banks->find('list')->where(['Banks.parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'Banks.tipoconta !=' => 'A'])->order(['Banks.title']);
        $banks = $banks->select(['id', 'title' => $banks->func()->concat(['Banks.title' => 'identifier', 
                                                                          ' - (',
                                                                          'Banks.agencia' => 'identifier', 
                                                                          ' / ',
                                                                          'Banks.conta' => 'identifier', 
                                                                          ') '
                                                                         ])
                                ]);
        $this->set('banks', $banks);
        $this->set('boxes', $this->Moviments->Boxes->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]
        $this->set('cards', $this->Cards->find('list')->where($conditions)->order(['title']));
    }
    
    public function group($id)
    {
        //Consulta de títulos vinculados
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        //Consulta o movimento pelo ID
        $moviment = $this->Moviments->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->contain(['DocumentTypes'])
                                    ->first();
        
        /**********************************************************************/
        
        //Consulta os títulos vinculados
        $valorpago = 0;
        $movimentMergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->where(['MovimentMergeds.moviments_id'  => $moviment->id]);
        
        $this->set('movimentMergeds', $movimentMergeds);
        
        foreach($movimentMergeds as $merged): 
            if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
            }
        endforeach;
        
        //ACRESCENTA A VARIÁVEL PARA CONTABILIZAÇÃO DOS VALORES 18/05/2016
        $moviment->valorpago = $valorpago;
        
        /**********************************************************************/
        
        //Verifica se o movimento está baixado
        if ($moviment->status == 'B') {
            $this->Flash->warning(__('Documento baixado/cancelado, ação não permitida'));   
            return $this->redirect($this->referer());
        }
        
        /**********************************************************************/
        
        //Consulta de títulos para vínculo (Tipo de documento: vinculapgto)
        if (isset($moviment->providers_id)) {
            
            $conditions = ['Moviments.providers_id' => $moviment->providers_id,
                           'Moviments.status IN'       => ['A', 'V']
                          ];
            
        } elseif (isset($moviment->customers_id)) {
            
            $conditions = ['Moviments.customers_id' => $moviment->customers_id,
                           'Moviments.status IN'       => ['A', 'V']
                          ];
            
        }
        
        $moviments = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->where($conditions)
                                     ->contain(['DocumentTypes'])
                                     ->order(['Moviments.id, Moviments.data']);
        
        $this->set('moviments', $moviments);
        
        /**********************************************************************/
        
        $conditions = ['MovimentMergeds.moviments_id'  => $id, 
                       'MovimentMergeds.parameters_id' => $this->request->Session()->read('sessionParameterControl')
                      ];
        
        $movimentMergeds = $this->MovimentMergeds->find('all')
                                                 ->where($conditions);
        
        $this->set('movimentMergeds', $movimentMergeds);
        
        /**********************************************************************/
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }
            
            /******************************************************************/
            
            $moviment = $this->Moviments->patchEntity($moviment, $this->request->getData());
            
            /******************************************************************/
            
            $moviment->username = $this->Auth->user('name');
            
            /* SE UTILIZAR O OBJETO, AO INVÉS DE COLOCÁ-LO NO REQUEST (COMO ACIMA), 
             * O REGISTRO DUPLICARÁ TODAS AS INFORMAÇÕES, CONFORME OBJETO PRINCIPAL. 08/12/2015 */
            
            if (isset($this->request->data['vinculapgto'])) {
                
                $this->MovimentsFunctions->vinculaPagamentos($moviment->vinculapgto, $moviment->id, $this->request->Session()->read('sessionParameterControl'));
                //vinculaPagamentos($vinculapgtos, $moviments_id, $parameters_id)
                
                $moviment->status = 'G';
                
            } else {
                
                //Desvincula todos os vinculados e limpa tabela de vínculo
                $this->MovimentsFunctions->desvinculaPagamentos($moviment->id, $this->request->Session()->read('sessionParameterControl'));
                //desvinculaPagamentos($moviments_id, $parameters_id)
                
                $moviment->status = 'A';
                
            }//else if (isset($this->request->data['vinculapgto']))
            
            /******************************************************************/
            
            //Consulta vinculados e atualiza o valor da fatura agrupadora
            $moviment->valor = $this->MovimentsFunctions->vinculaConsulta($moviment->id, $this->request->Session()->read('sessionParameterControl'));
            //vinculaConsulta($moviments_id, $parameters_id)
            
            /******************************************************************/
            
            if ($this->Moviments->save($moviment)) {

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Moviments->save($moviment))
        
            /******************************************************************/

            //Alerta de erro
            $message = 'MovimentsController->group';
            $this->Error->registerError($moviment, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('providers', $this->Moviments->Providers->find('list')->where($conditions)->order(['Providers.title']));
        $this->set('customers', $this->Moviments->Customers->find('list')->where($conditions)->order(['Customers.title']));
        $this->set('documentTypes', $this->Moviments->DocumentTypes->find('list')->where($conditions)->order(['DocumentTypes.title']));
        $this->set('costs', $this->Moviments->Costs->find('list')->where($conditions)->order(['Costs.title']));
        $this->set('banks', $this->Moviments->Banks->find('list')->where($conditions)->order(['Banks.title']));
        $this->set('boxes', $this->Moviments->Boxes->find('list')->where($conditions)->order(['Boxes.title']));
        $this->set('eventTypes', $this->Moviments->EventTypes->find('list')->where($conditions)->order(['EventTypes.title']));
        $accountPlans = $this->Moviments->AccountPlans->find('list', ['keyField' => 'id', 'valueField' => 'dropdown_accounts'])
                                                      ->where($conditions)
                                                      ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
        
        /**********************************************************************/
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($moviment->data)) {
            $moviment->data = date("d/m/Y", strtotime($moviment->data));
        }
        if (!empty($moviment->vencimento)) {
            $moviment->vencimento = date("d/m/Y", strtotime($moviment->vencimento));
        }
        if (!empty($moviment->emissaoch)) {
            $moviment->emissaoch = date("d/m/Y", strtotime($moviment->emissaoch));
        }
        
        $this->set('moviment', $moviment);
    }
    
    public function editBaixado($id)
    {
        $moviment = $this->Moviments->get($id, ['contain' => ['DocumentTypes', 'EventTypes', 'AccountPlans', 'Costs', 'Providers', 'Customers']]);
        
        /**********************************************************************/
        
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $this->request->data['username'] = $this->Auth->user('name');
        
            /******************************************************************/
            
            if (!$this->request->data['vencimento']) {
                $this->request->data['vencimento'] = $this->request->data['data'];
            }//if (!$this->request->data['vencimento'])
        
            /******************************************************************/
            
            //CAMPOS QUE NÃO PERMITEM ALTERAÇÃO
            $this->request->data['data']          = $moviment->data;
            $this->request->data['valor']         = $moviment->valor;
            $this->request->data['contabil']      = $moviment->contabil;
            $this->request->data['creditodebito'] = $moviment->creditodebito;
            $this->request->data['dtbaixa']       = $moviment->dtbaixa;
            $this->request->data['valorbaixa']    = $moviment->valorbaixa;
            $this->request->data['status']        = $moviment->status;
        
            /******************************************************************/
            
            $moviment = $this->Moviments->patchEntity($moviment, $this->request->getData());
        
            /******************************************************************/
            
            if ($this->Moviments->save($moviment)) {
                
                //Atualiza os movimentos de banco, caixa e cheque
                $this->MovimentsFunctions->atualizaMovimentos($moviment);
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Moviments->save($moviment))
        
            /******************************************************************/

            //Alerta de erro
            $message = 'MovimentsController->editBaixado';
            $this->Error->registerError($moviment, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('providers', $this->Moviments->Providers->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]);
        $this->set('customers', $this->Moviments->Customers->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]);
        $this->set('documentTypes', $this->Moviments->DocumentTypes->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]);
        $this->set('costs', $this->Moviments->Costs->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]);
        $this->set('banks', $this->Moviments->Banks->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]);
        $this->set('boxes', $this->Moviments->Boxes->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]);
        $this->set('eventTypes', $this->Moviments->EventTypes->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]);
        $accountPlans = $this->Moviments->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
                                                      ->where($conditions)
                                                      ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
        
        /**********************************************************************/
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($moviment->data)) {
            $moviment->data = date("d/m/Y", strtotime($moviment->data));
        }
        if (!empty($moviment->dtbaixa)) {
            $moviment->dtbaixa = date("d/m/Y", strtotime($moviment->dtbaixa));
        }
        if (!empty($moviment->vencimento)) {
            $moviment->vencimento = date("d/m/Y", strtotime($moviment->vencimento));
        }
        if (!empty($moviment->emissaoch)) {
            $moviment->emissaoch = date("d/m/Y", strtotime($moviment->emissaoch));
        }
        
        $this->set('moviment', $moviment);
    }
    
    public function editBaixadoSimple($id)
    {
        $moviment = $this->Moviments->get($id, ['contain' => ['Costs']]);
        
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
            
            $this->request->data['username'] = $this->Auth->user('name');
        
            /******************************************************************/
            
            if (!$this->request->data['vencimento']) {
                $this->request->data['vencimento'] = $this->request->data['data'];
            }
        
            /******************************************************************/
            
            //CAMPOS QUE NÃO PERMITEM ALTERAÇÃO
            $this->request->data['data']          = $moviment->data;
            $this->request->data['valor']         = $moviment->valor;
            $this->request->data['contabil']      = $moviment->contabil;
            $this->request->data['creditodebito'] = $moviment->creditodebito;
            $this->request->data['dtbaixa']       = $moviment->dtbaixa;
            $this->request->data['valorbaixa']    = $moviment->valorbaixa;
            $this->request->data['status']        = $moviment->status;
        
            /******************************************************************/
            
            $moviment = $this->Moviments->patchEntity($moviment, $this->request->getData());
        
            /******************************************************************/
            
            if ($this->Moviments->save($moviment)) {
                
                //Atualiza os movimentos de banco, caixa e cheque
                $this->MovimentsFunctions->atualizaMovimentos($moviment);
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Moviments->save($moviment))
        
            /******************************************************************/

            //Alerta de erro
            $message = 'MovimentsController->editBaixadoSimple';
            $this->Error->registerError($moviment, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('providers', $this->Moviments->Providers->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]);
        $this->set('customers', $this->Moviments->Customers->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]);
        $this->set('documentTypes', $this->Moviments->DocumentTypes->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]);
        $this->set('costs', $this->Moviments->Costs->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]);
        $this->set('banks', $this->Moviments->Banks->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]);
        $this->set('boxes', $this->Moviments->Boxes->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]);
        $this->set('eventTypes', $this->Moviments->EventTypes->find('list')->where($conditions)->order(['title'])); // , ['limit' => 200]);
        $accountPlans = $this->Moviments->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
                                                      ->where($conditions)
                                                      ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
        
        /**********************************************************************/
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($moviment->data)) {
            $moviment->data = date("d/m/Y", strtotime($moviment->data));
        }
        if (!empty($moviment->dtbaixa)) {
            $moviment->dtbaixa = date("d/m/Y", strtotime($moviment->dtbaixa));
        }
        if (!empty($moviment->vencimento)) {
            $moviment->vencimento = date("d/m/Y", strtotime($moviment->vencimento));
        }
        if (!empty($moviment->emissaoch)) {
            $moviment->emissaoch = date("d/m/Y", strtotime($moviment->emissaoch));
        }
        
        $this->set('moviment', $moviment);
    }

    public function edit($id)
    {
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        //CONSULTA REGISTRO
        $moviment = $this->Moviments->get($id, ['contain' => ['DocumentTypes', 'EventTypes', 'AccountPlans', 'Costs', 'Providers', 'Customers']]);
        
        /**********************************************************************/
        
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        //Consulta de títulos vinculados
        $valorpago = 0;
        
        /**********************************************************************/
        
        $conditions = ['MovimentMergeds.moviments_id'  => $moviment->id,
                       'MovimentMergeds.parameters_id' => $this->request->Session()->read('sessionParameterControl')
                      ];
        
        $mergeds = $this->MovimentMergeds->find('all')
                                         ->where($conditions);
        foreach($mergeds as $merged): 
            if ($merged->status == 'O' || $merged->status == 'B') {
                $valorpago += $merged->valorbaixa;
            }
        endforeach;
        
        /**********************************************************************/
        
        //ACRESCENTA A VARIÁVEL PARA CONTABILIZAÇÃO DOS VALORES 18/05/2016
        $moviment->valorpago = $valorpago;
        
        /**********************************************************************/
        
        if ($moviment->status == 'B') {
            $this->Flash->warning('Documento baixado, ação não permitida');   
            return $this->redirect($this->referer());
        }
        
        /**********************************************************************/
        
        //Consulta de títulos vinculados
        $movimentMergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->where(['MovimentMergeds.moviments_id' => $id]);
        
        $this->set(compact('movimentMergeds'));
        
        /**********************************************************************/
        
        //Consulta de títulos para vínculo (Tipo de documento: vinculapgto)
        if (isset($moviment->providers_id)) {
            $conditions = ['Moviments.providers_id'  => $moviment->providers_id,
                           'Moviments.status'        => ['A', 'V'], 
                          ];
        } elseif (isset($moviment->customers_id)) {
            $conditions = ['Moviments.customers_id'  => $moviment->customers_id,
                           'Moviments.status'        => ['A', 'V'], 
                          ];
        }
        
        /**********************************************************************/
        
        $moviments = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->where($conditions)
                                     ->order(['Moviments.id, Moviments.data']);
        
        $this->set(compact('moviments'));
        
        /**********************************************************************/
                                
        if ($moviment->status == 'C') {
            $this->request->data['status']         = 'A';
            $this->request->data['dtbaixa']        = null;
            $this->request->data['valorbaixa']     = null;
            $this->request->data['cheque']         = null;
            $this->request->data['nominal']        = null;
            $this->request->data['emissaoch']      = null;
            $this->request->data['userbaixa']      = null;
            $this->request->data['boxes_id']       = null;
            $this->request->data['banks_id']       = null;
            $this->request->data['event_types_id'] = null;
        }
        
        /**********************************************************************/
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $this->request->data['username'] = $this->Auth->user('name');
        
            /******************************************************************/
            
            //NÃO É PERMITIDO EDITAR VALOR DO TÍTULO PARCIAL 18/05/2016
            if ($this->request->data['status'] != 'P') {
                $source  = ['.', ','];
                $replace = ['', '.'];
                $this->request->data['valor'] = str_replace($source, $replace, $this->request->data['valor']);
            }//if ($this->request->data['status'] != 'P')
        
            /******************************************************************/
            
            //Controle de preenchimento de Cliente/Fornecedor
            if ($this->request->data['creditodebito'] == 'C') {
                
                $this->request->data['providers_id'] = null;
                
                if ($this->request->data['customers_id'] == null) {
                    $this->Flash->warning('Registro NÃO gravado, cliente não informado');
                    return $this->redirect($this->referer());
                }//if ($this->request->data['customers_id'] == null)
                
            } elseif ($this->request->data['creditodebito'] == 'D') {
                
                $this->request->data['customers_id'] = null;
                
                if ($this->request->data['providers_id'] == null) {
                    $this->Flash->warning('Registro NÃO gravado, fornecedor não informado');
                    return $this->redirect($this->referer());
                }//if ($this->request->data['providers_id'] == null)
                
            }//elseif ($this->request->data['creditodebito'] == 'D')
        
            /******************************************************************/
            
            $moviment = $this->Moviments->patchEntity($moviment, $this->request->getData());
        
            /******************************************************************/
            
            if ($this->Moviments->save($moviment)) {

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Moviments->save($moviment))
        
            /******************************************************************/

            //Alerta de erro
            $message = 'MovimentsController->edit';
            $this->Error->registerError($moviment, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        //CONSULTA LANÇAMENTOS VINCULADOS
        $movimentMergeds = $this->MovimentMergeds->find('all')
                                                 ->where(['MovimentMergeds.moviments_id'  => $id,
                                                          'MovimentMergeds.parameters_id' => $this->request->Session()->read('sessionParameterControl')
                                                         ]);
        
        //$this->set('movimentMergeds', $movimentMergeds->toArray());
        $this->set(compact('movimentMergeds'));
        
        /**********************************************************************/
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('providers', $this->Moviments->Providers->find('list')->where($conditions)->order(['Providers.title']));
        $this->set('customers', $this->Moviments->Customers->find('list')->where($conditions)->order(['Customers.title']));
        $this->set('documentTypes', $this->Moviments->DocumentTypes->find('list')->where($conditions)->order(['DocumentTypes.title']));
        $this->set('costs', $this->Moviments->Costs->find('list')->where($conditions)->order(['Costs.title']));
        $this->set('banks', $this->Moviments->Banks->find('list')->where($conditions)->order(['Banks.title']));
        $this->set('boxes', $this->Moviments->Boxes->find('list')->where($conditions)->order(['Boxes.title']));
        $this->set('eventTypes', $this->Moviments->EventTypes->find('list')->where($conditions)->order(['EventTypes.title']));
        $accountPlans = $this->Moviments->AccountPlans->find('list', ['keyField' => 'id', 'valueField' => 'dropdown_accounts'])
                                                          ->where($conditions)
                                                          ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
        
        /**********************************************************************/
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($moviment->data)) {
            $moviment->data = date("d/m/Y", strtotime($moviment->data));
        }
        if (!empty($moviment->vencimento)) {
            $moviment->vencimento = date("d/m/Y", strtotime($moviment->vencimento));
        }
        if (!empty($moviment->emissaoch)) {
            $moviment->emissaoch = date("d/m/Y", strtotime($moviment->emissaoch));
        }
        
        /**********************************************************************/
        
        $this->set(compact('moviment'));
    }

    public function editSimple($id)
    {
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        //CONSULTA REGISTRO
        $moviment = $this->Moviments->get($id, ['contain' => ['Costs']]);
        
        /**********************************************************************/
        
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        //Consulta de títulos vinculados
        $valorpago = 0;
        
        /**********************************************************************/
        
        $conditions = ['MovimentMergeds.moviments_id'  => $moviment->id,
                       'MovimentMergeds.parameters_id' => $this->request->Session()->read('sessionParameterControl')
                      ];
        
        $mergeds = $this->MovimentMergeds->find('all')
                                         ->where($conditions);
        foreach($mergeds as $merged): 
            if ($merged->status == 'O' || $merged->status == 'B') {
                $valorpago += $merged->valorbaixa;
            }
        endforeach;
        
        /**********************************************************************/
        
        //ACRESCENTA A VARIÁVEL PARA CONTABILIZAÇÃO DOS VALORES 18/05/2016
        $moviment->valorpago = $valorpago;
        
        /**********************************************************************/
        
        if ($moviment->status == 'B') {
            $this->Flash->warning('Documento baixado, ação não permitida');   
            return $this->redirect($this->referer());
        }
        
        /**********************************************************************/
        
        //Consulta de títulos vinculados
        $movimentMergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->where(['MovimentMergeds.moviments_id' => $id]);
        
        $this->set(compact('movimentMergeds'));
        
        /**********************************************************************/
        
        $moviments = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->where($conditions)
                                     ->order(['Moviments.id, Moviments.data']);
        
        $this->set(compact('moviments'));
        
        /**********************************************************************/
                                
        if ($moviment->status == 'C') {
            $this->request->data['status']         = 'A';
            $this->request->data['dtbaixa']        = null;
            $this->request->data['valorbaixa']     = null;
            $this->request->data['cheque']         = null;
            $this->request->data['nominal']        = null;
            $this->request->data['emissaoch']      = null;
            $this->request->data['userbaixa']      = null;
            $this->request->data['boxes_id']       = null;
            $this->request->data['banks_id']       = null;
            $this->request->data['event_types_id'] = null;
        }//if ($moviment->status == 'C')
        
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
            
            $this->request->data['username'] = $this->Auth->user('name');
        
            /******************************************************************/
            
            //NÃO É PERMITIDO EDITAR VALOR DO TÍTULO PARCIAL 18/05/2016
            if ($this->request->data['status'] != 'P') {
                $source  = ['.', ','];
                $replace = ['', '.'];
                $this->request->data['valor'] = str_replace($source, $replace, $this->request->data['valor']);
            }//if ($this->request->data['status'] != 'P')
        
            /******************************************************************/
            
            $moviment = $this->Moviments->patchEntity($moviment, $this->request->getData());
        
            /******************************************************************/
            
            if ($this->Moviments->save($moviment)) {

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Moviments->save($moviment))
        
            /******************************************************************/

            //Alerta de erro
            $message = 'MovimentsController->editSimple';
            $this->Error->registerError($moviment, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is(['patch', 'post', 'put']))
        
        //CONSULTA LANÇAMENTOS VINCULADOS
        $movimentMergeds = $this->MovimentMergeds->find('all')
                                                 ->where(['MovimentMergeds.moviments_id'  => $id,
                                                          'MovimentMergeds.parameters_id' => $this->request->Session()->read('sessionParameterControl')
                                                         ]);
        
        //$this->set('movimentMergeds', $movimentMergeds->toArray());
        $this->set(compact('movimentMergeds'));
        
        /**********************************************************************/
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('banks', $this->Moviments->Banks->find('list')->where($conditions)->order(['Banks.title']));
        $this->set('boxes', $this->Moviments->Boxes->find('list')->where($conditions)->order(['Boxes.title']));
        
        /**********************************************************************/
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($moviment->data)) {
            $moviment->data = date("d/m/Y", strtotime($moviment->data));
        }
        if (!empty($moviment->vencimento)) {
            $moviment->vencimento = date("d/m/Y", strtotime($moviment->vencimento));
        }
        
        /**********************************************************************/
        
        $this->set(compact('moviment'));
    }

    public function delete($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('delete', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('delete', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        //CONSULTA REGISTRO COMPLETO PARA REGISTRO DE LOG
        $moviment = $this->Moviments->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->first();
        
        /**********************************************************************/
        
        if (!empty($moviment)) {

            $this->request->allowMethod(['post', 'delete']);
        
            /**********************************************************************/
            
            //Exclui registros da tabela de vínculo
            $this->MovimentsFunctions->deleteMerged($id, $this->request->Session()->read('sessionParameterControl'));
            
            /**********************************************************************/
            
            $this->MovimentRecurrentsFunctions->deleteMovimentRecurrents($id, $this->request->Session()->read('sessionParameterControl'));
            
            /**********************************************************************/
            
            $this->MovimentsFunctions->deleteMovimentCards($id, $this->request->Session()->read('sessionParameterControl'));
            
            /**********************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($moviment, 'delete', 'Moviments');
            
            /**********************************************************************/
            
            if ($this->Moviments->delete($moviment)) {
                
                $this->Flash->success(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Moviments->delete($moviment))
            
        }//if (empty($moviment))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'MovimentsController->delete';
        $this->Error->registerError($moviment, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'Moviments';
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
    
    public function reportForm() // Adicionar período
    {
        $this->Providers       = TableRegistry::get('Providers');
        $this->Customers       = TableRegistry::get('Customers');
        $this->AccountPlans    = TableRegistry::get('AccountPlans');
        $this->DocumentTypes   = TableRegistry::get('DocumentTypes');
        $this->EventTypes      = TableRegistry::get('EventTypes');
        $this->Costs           = TableRegistry::get('Costs');
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        $this->Parameters      = TableRegistry::get('Parameters');
        $this->AccountPlans    = TableRegistry::get('AccountPlans');
                
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
            
            $table = 'Moviments';
            
            /******************************************************************/
            
            //CONTROLE DE RECEITA/DESPESA/TODOS
            if ($this->request->data['creditodebito'] == 'C') { ($this->request->data['providers_id'] = ''); }
            elseif ($this->request->data['creditodebito'] == 'D') { ($this->request->data['customers_id'] = ''); }
            elseif ($this->request->data['creditodebito'] == 'A') { ($this->request->data['providers_id'] = ''); 
                                                                   ($this->request->data['customers_id'] = ''); 
                                                                 }
            
            /******************************************************************/
            
            // MONTAGEM DO SQL
            $conditions[] = $table.'.parameters_id = '.$this->request->Session()->read('sessionParameterControl');
            
            /******************************************************************/
            
            if (isset($this->request->data['dtemissao'])) {
                $date_find = 'data';
                //$conditions[] = $table.'.data BETWEEN ? AND ?' => [$dtinicial, $dtfinal]];
            } elseif ($this->request->data['Situação'] == 'baixado') {
                $date_find = 'dtbaixa';
                //$conditions[] = $table.'.dtbaixa BETWEEN ? AND ?' => [$dtinicial, $dtfinal]];
            } else {
                $date_find = 'vencimento';
                //$conditions[] = $table.'.vencimento BETWEEN ? AND ?' => [$dtinicial, $dtfinal]];
            }
            if ($this->request->data['historico']) {
                $conditions[] = $table.'.historico LIKE '."%".$this->request->data['historico']."%";
            }
            if ($this->request->data['documento']) {
                $conditions[] = $table.'.documento LIKE '.'%'.$this->request->data['documento'].'%';
            }
            if ($this->request->data['providers_id']) {
                $conditions[] = $table.'.providers_id LIKE '.$this->request->data['providers_id'];
                
                $provider = $this->Providers->findByIdAndParametersId($this->request->data['providers_id'], $this->request->Session()->read('sessionParameterControl'))
                                            ->select(['Providers.title'])
                                            ->first();
                $this->set('provider', $provider);
            }
            if ($this->request->data['customers_id']) {
                $conditions[] = $table.'.customers_id LIKE '.$this->request->data['customers_id'];
                
                $customer = $this->Customers->findByIdAndParametersId($this->request->data['customers_id'], $this->request->Session()->read('sessionParameterControl'))
                                             ->select(['Customers.title'])
                                             ->first();
                $this->set('customer', $customer);
            }
            if ($this->request->data['account_plans_id']) {
                $conditions[] = $table.'.account_plans_id LIKE '.$this->request->data['account_plans_id'];
                
                $accountPlan = $this->AccountPlans->findByIdAndParametersId($this->request->data['account_plans_id'], $this->request->Session()->read('sessionParameterControl'))
                                                   ->select(['AccountPlans.title'])
                                                   ->first();
                $this->set('accountPlan', $accountPlan);
            }
            if ($this->request->data['document_types_id']) {
                $conditions[] = $table.'.document_types_id LIKE '.$this->request->data['document_types_id'];
                
                $documentType = $this->DocumentTypes->findByIdAndParametersId($this->request->data['document_types_id'], $this->request->Session()->read('sessionParameterControl'))
                                                    ->select(['DocumentTypes.title'])
                                                    ->first();
                $this->set('documentType', $documentType);
            }
            if ($this->request->data['event_types_id']) {
                $conditions[] = $table.'.event_types_id = '.$this->request->data['event_types_id'];
                
                $eventType = $this->EventTypes->findByIdAndParametersId($this->request->data['event_types_id'], $this->request->Session()->read('sessionParameterControl'))
                                              ->select(['EventTypes.title'])
                                              ->first();
                $this->set('eventType', $eventType);
            }
            if ($this->request->data['costs_id']) {
                $conditions[] = $table.'.costs_id = '.$this->request->data['costs_id'];
                
                $cost = $this->Costs->findByIdAndParametersId($this->request->data['costs_id'], $this->request->Session()->read('sessionParameterControl'))
                                    ->select(['Costs.title'])
                                    ->first();
                $this->set('cost', $cost);
            }
            if ($this->request->data['contabil']) {
                $conditions[] = $table.'.contabil = "'.$this->request->data['contabil'].'"';
            }
            if ($this->request->data['Ordem']) {
                $order = 'AccountPlans.classification, Moviments.ordem, Moviments.'.$this->request->data['Ordem'].', Moviments.dtbaixa';
                
                if ($this->request->data['Tipo'] == 'fluxo') { //Fluxo de pagamento deverá ser ordenado por vencimento
                    if ($this->request->data['Situação'] == 'baixado') {
                        $order = 'Moviments.dtbaixa, '.$this->request->data['Ordem'];
                    } else {
                        $order = 'Moviments.vencimento, '.$this->request->data['Ordem'];
                    }
                } else {
                    if ($this->request->data['Situação'] == 'baixado') { //BAIXADO
                        if ($this->request->data['Tipo'] == 'planodecontas') {
                            $order = 'AccountPlans.classification, Moviments.dtbaixa, Moviments.'.$this->request->data['Ordem'];
                        } else {
                            $order = 'Moviments.dtbaixa, Moviments.'.$this->request->data['Ordem'];
                        }
                    } else {
                        if ($this->request->data['Tipo'] == 'planodecontas') {
                            $order = 'AccountPlans.classification, Moviments.vencimento, Moviments.'.$this->request->data['Ordem'];
                        } else {
                            //Ajuste realizado em 29/04/2016
                            $order = 'Moviments.'.$this->request->data['Ordem'];
                        }
                    }
                }
            }
            
            /******************************************************************/
            
            $fields = ['Moviments.id',
                       'Moviments.parameters_id',
                       'Moviments.ordem',
                       'Moviments.banks_id',
                       'Moviments.boxes_id',
                       'Moviments.cards_id',
                       'Moviments.costs_id',
                       'Moviments.event_types_id',
                       'Moviments.providers_id',
                       'Moviments.customers_id',
                       'Moviments.document_types_id',
                       'Moviments.account_plans_id',
                       'Moviments.data',
                       'Moviments.vencimento',
                       'Moviments.dtbaixa',
                       'Moviments.historico',
                       'Moviments.valor',
                       'Moviments.valorbaixa',
                       'Moviments.documento',
                       'Moviments.cheque',
                       'Moviments.nominal',
                       'Moviments.emissaoch',
                       'Moviments.creditodebito',
                       'Moviments.contabil',
                       'Moviments.status',
                       'Banks.title',
                       'Boxes.title',
                       'Cards.title',
                       'Costs.title',
                       'EventTypes.title',
                       'Providers.title',
                       'Customers.title',
                       'DocumentTypes.title',
                       'AccountPlans.id',
                       'AccountPlans.title',
                       'AccountPlans.classification',
                       'AccountPlans.parameters_id',
                       'Parameters.id'
                      ];
            
            $moviments = $this->Moviments->find('all')
                                         ->select($fields)
                                         ->where(function ($exp, $q) use($dtinicial, $dtfinal, $date_find) {
                                                  return $exp->between('Moviments.'.$date_find, $dtinicial, $dtfinal);
                                                 })
                                         ->where($conditions)
                                         ->contain(['Banks', 'Boxes', 'Cards', 'Costs', 'EventTypes', 'Providers', 
                                                    'Customers', 'DocumentTypes', 'AccountPlans', 'Parameters'
                                                   ])
                                         ->order($order);
            $this->set('moviments', $moviments);
            
            /******************************************************************/
            
            //Consulta de títulos vinculados
            $conditions = ['Moviments.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                           'MovimentMergeds.parameters_id' => $this->request->Session()->read('sessionParameterControl')
                          ];

            if ($date_find === 'data') {
                $conditions[] = '(Moviments.data BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'") OR (Moviment_Mergeds.data BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'")';
            } elseif ($date_find === 'dtbaixa') {
                $conditions[] = '(Moviments.dtbaixa BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'") OR (Moviment_Mergeds.dtbaixa BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'")';
            } elseif ($date_find === 'vencimento') {
                $conditions[] = '(Moviments.vencimento BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'") OR (Moviment_Mergeds.vencimento BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'")';
            }

            $fields = ['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                       'Moviments.id', 'Moviments.parameters_id', 'Moviments.ordem', 'Moviments.banks_id', 'Moviments.boxes_id',
                       'Moviments.cards_id', 'Moviments.plannings_id', 'Moviments.costs_id', 'Moviments.event_types_id',
                       'Moviments.document_types_id', 'Moviments.account_plans_id', 'Moviments.providers_id', 'Moviments.customers_id', 
                       'Moviments.documento', 'Moviments.historico', 'Moviments.creditodebito', 'Moviments.data', 'Moviments.vencimento', 
                       'Moviments.dtbaixa', 'Moviments.valor', 'Moviments.valorbaixa', 'Moviments.contabil', 'Moviments.status',
                       'Moviment_Mergeds.id', 'Moviment_Mergeds.parameters_id', 'Moviment_Mergeds.ordem', 'Moviment_Mergeds.banks_id',
                       'Moviment_Mergeds.boxes_id', 'Moviment_Mergeds.cards_id', 'Moviment_Mergeds.plannings_id',
                       'Moviment_Mergeds.costs_id', 'Moviment_Mergeds.event_types_id', 'Moviment_Mergeds.document_types_id', 
                       'Moviment_Mergeds.account_plans_id', 'Moviment_Mergeds.providers_id', 'Moviment_Mergeds.customers_id',
                       'Moviment_Mergeds.documento', 'Moviment_Mergeds.historico', 'Moviment_Mergeds.creditodebito',
                       'Moviment_Mergeds.data', 'Moviment_Mergeds.vencimento', 'Moviment_Mergeds.dtbaixa',
                       'Moviment_Mergeds.valor', 'Moviment_Mergeds.valorbaixa', 'Moviment_Mergeds.contabil', 'Moviment_Mergeds.status',
                       //'Parameter.id', 'Parameter.razao', 'Parameter.cpfcnpj', 'Parameter.tipo'
                      ];

            $movimentMergeds = $this->MovimentMergeds->find('all')
                                                     ->select($fields)
                                                     ->join(['Moviments' => ['table'      => 'Moviments',
                                                                             'type'       => 'LEFT',
                                                                             'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                            ],
                                                             'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                                    'type'       => 'LEFT',
                                                                                    'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                                   ]
                                                            ])
                                                     ->where($conditions);

            $this->set('movimentMergeds', $movimentMergeds);
            
            /******************************************************************/
            
            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());
            
            /******************************************************************/
            
            $this->set('plans', $this->AccountPlans->find('all')
                                                   ->select(['AccountPlans.id', 'AccountPlans.title', 'AccountPlans.order', 'AccountPlans.parameters_id'])
                                                   ->where(['AccountPlans.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                                   ->order(['AccountPlans.classification'])
                      );
            
            /******************************************************************/
            
            $tipo          = $this->request->data['Tipo'];
            $creditodebito = $this->request->data['creditodebito'];
            $situacao      = $this->request->data['Situação'];
            $detalhamento  = $this->request->data['Detalhamento'];
            
            /******************************************************************/
            
            //Evitar página de erro
            $this->render('reports/sem_relatorio');
            
            /******************************************************************/
            
            //PLANO DE CONTAS
            if ($tipo == 'planodecontas' && $creditodebito == 'D') { //DÉBITOS
                //BAIXADOS
                if ($situacao == 'baixado' && $detalhamento == 'analitico') {
                    $this->render('reports/planodecontas_despesa_consolidada_analitico'); //OK
                } elseif ($situacao == 'baixado' && $detalhamento == 'sintetico') {
                    $this->render('reports/planodecontas_despesa_consolidada_sintetico'); //OK
                }
                //ABERTOS
                elseif ($situacao == 'aberto' && $detalhamento == 'analitico') {
                    $this->render('reports/planodecontas_despesa_aberta_analitico'); //OK
                } elseif ($situacao == 'aberto' && $detalhamento == 'sintetico') {
                    $this->render('reports/planodecontas_despesa_aberta_sintetico'); //OK
                } 
                //TODOS
                elseif ($situacao == 'todos' && $detalhamento == 'analitico') {
                    $this->render('reports/planodecontas_despesa_analitico');
                } elseif ($situacao == 'todos' && $detalhamento == 'sintetico') {
                    $this->render('reports/planodecontas_despesa_sintetico');
                } 
            } elseif ($tipo == 'planodecontas' && $creditodebito == 'C') { //CRÉDITOS
                //BAIXADOS
                if ($situacao == 'baixado' && $detalhamento == 'analitico') {
                    $this->render('reports/planodecontas_receita_consolidada_analitico'); //OK
                } elseif ($situacao == 'baixado' && $detalhamento == 'sintetico') {
                    $this->render('reports/planodecontas_receita_consolidada_sintetico'); //OK
                }
                //ABERTOS
                elseif ($situacao == 'aberto' && $detalhamento == 'analitico') {
                    $this->render('reports/planodecontas_receita_aberta_analitico'); //OK
                } elseif ($situacao == 'aberto' && $detalhamento == 'sintetico') {
                    $this->render('reports/planodecontas_receita_aberta_sintetico'); //OK
                }
                //TODOS
                elseif ($situacao == 'todos' && $detalhamento == 'analitico') {
                    $this->render('reports/planodecontas_receita_analitico');
                } elseif ($situacao == 'todos' && $detalhamento == 'sintetico') {
                    $this->render('reports/planodecontas_receita_sintetico');
                } 
            }  elseif ($tipo == 'planodecontas' && $creditodebito == 'A') { //DÉBITOS E CRÉDITOS
                //BAIXADOS
                if ($situacao == 'baixado' && $detalhamento == 'analitico') {
                    $this->render('reports/planodecontas_consolidada_analitico'); //EM DESENVOLVIMENTO
                } elseif ($situacao == 'baixado' && $detalhamento == 'sintetico') {
                    $this->render('reports/planodecontas_consolidada_sintetico'); //OK
                }
                //ABERTOS
                elseif ($situacao == 'aberto' && $detalhamento == 'analitico') {
                    $this->render('reports/planodecontas_aberta_analitico'); //OK
                } elseif ($situacao == 'aberto' && $detalhamento == 'sintetico') {
                    $this->render('reports/planodecontas_aberta_sintetico'); //OK
                }
                //TODOS
                elseif ($situacao == 'todos' && $detalhamento == 'analitico') {
                    $this->render('reports/planodecontas_analitico'); //OK
                } elseif ($situacao == 'todos' && $detalhamento == 'sintetico') {
                    $this->render('reports/planodecontas_sintetico');//OK
                } 
            }
            
            //FLUXO
            if ($tipo == 'fluxo' && $creditodebito == 'D') { //DÉBITOS
                //BAIXADOS
                if ($situacao == 'baixado' && $detalhamento == 'analitico') {
                    $this->render('reports/fluxo_despesa_consolidada_analitico'); //OK
                } elseif ($situacao == 'baixado' && $detalhamento == 'sintetico') {
                    $this->render('reports/fluxo_despesa_consolidada_sintetico'); //OK
                }
                //ABERTOS
                elseif ($situacao == 'aberto' && $detalhamento == 'analitico') {
                    $this->render('reports/fluxo_despesa_aberta_analitico'); //OK
                } elseif ($situacao == 'aberto' && $detalhamento == 'sintetico') {
                    $this->render('reports/fluxo_despesa_aberta_sintetico'); //OK
                } 
                //TODOS
                elseif ($situacao == 'todos' && $detalhamento == 'analitico') {
                    $this->render('reports/fluxo_despesa_analitico');
                } elseif ($situacao == 'todos' && $detalhamento == 'sintetico') {
                    $this->render('reports/fluxo_despesa_sintetico');
                } 
            } elseif ($tipo == 'fluxo' && $creditodebito == 'C') { //CRÉDITOS
                //BAIXADOS
                if ($situacao == 'baixado' && $detalhamento == 'analitico') {
                    $this->render('reports/fluxo_receita_consolidada_analitico'); //OK
                } elseif ($situacao == 'baixado' && $detalhamento == 'sintetico') {
                    $this->render('reports/fluxo_receita_consolidada_sintetico'); //OK
                }
                //ABERTOS
                elseif ($situacao == 'aberto' && $detalhamento == 'analitico') {
                    $this->render('reports/fluxo_receita_aberta_analitico'); //OK
                } elseif ($situacao == 'aberto' && $detalhamento == 'sintetico') {
                    $this->render('reports/fluxo_receita_aberta_sintetico'); //OK
                }
                //TODOS
                elseif ($situacao == 'todos' && $detalhamento == 'analitico') {
                    $this->render('reports/fluxo_receita_analitico');
                } elseif ($situacao == 'todos' && $detalhamento == 'sintetico') {
                    $this->render('reports/fluxo_receita_sintetico');
                }
            } elseif ($tipo == 'fluxo' && $creditodebito == 'A') { //DÉBITOS E CRÉDITOS
                //BAIXADOS
                if ($situacao == 'baixado' && $detalhamento == 'analitico') {
                    $this->render('reports/fluxo_consolidada_analitico'); //OK
                } elseif ($situacao == 'baixado' && $detalhamento == 'sintetico') {
                    $this->render('reports/fluxo_consolidada_sintetico'); //OK
                }
                //ABERTOS
                elseif ($situacao == 'aberto' && $detalhamento == 'analitico') {
                    $this->render('reports/fluxo_aberta_analitico'); //OK
                } elseif ($situacao == 'aberto' && $detalhamento == 'sintetico') {
                    $this->render('reports/fluxo_aberta_sintetico'); //OK
                }
                //TODOS
                elseif ($situacao == 'todos' && $detalhamento == 'analitico') {
                    $this->render('reports/fluxo_analitico'); //OK
                } elseif ($situacao == 'todos' && $detalhamento == 'sintetico') {
                    $this->render('reports/fluxo_sintetico'); //OK
                } 
            }
            
            //DEFAULT
            if ($tipo == 'default' && $creditodebito == 'D') { //DÉBITOS
                //BAIXADOS
                if ($situacao == 'baixado' && $detalhamento == 'analitico') {
                    $this->render('reports/default_despesa_consolidada_analitico'); //OK
                } elseif ($situacao == 'baixado' && $detalhamento == 'sintetico') {
                    $this->render('reports/default_despesa_consolidada_sintetico'); //OK
                }
                //ABERTOS
                elseif ($situacao == 'aberto' && $detalhamento == 'analitico') {
                    $this->render('reports/default_despesa_aberta_analitico'); //OK
                } elseif ($situacao == 'aberto' && $detalhamento == 'sintetico') {
                    $this->render('reports/default_despesa_aberta_sintetico'); //OK
                } 
                //TODOS
                elseif ($situacao == 'todos' && $detalhamento == 'analitico') {
                    $this->render('reports/default_despesa_analitico');
                } elseif ($situacao == 'todos' && $detalhamento == 'sintetico') {
                    $this->render('reports/default_despesa_sintetico');
                } 
            } elseif ($tipo == 'default' && $creditodebito == 'C') { //CRÉDITOS
                //BAIXADOS
                if ($situacao == 'baixado' && $detalhamento == 'analitico') {
                    $this->render('reports/default_receita_consolidada_analitico'); //OK
                } elseif ($situacao == 'baixado' && $detalhamento == 'sintetico') {
                    $this->render('reports/default_receita_consolidada_sintetico'); //OK
                }
                //ABERTOS
                elseif ($situacao == 'aberto' && $detalhamento == 'analitico') {
                    $this->render('reports/default_receita_aberta_analitico'); //OK
                } elseif ($situacao == 'aberto' && $detalhamento == 'sintetico') {
                    $this->render('reports/default_receita_aberta_sintetico'); //OK
                }
                //TODOS
                elseif ($situacao == 'todos' && $detalhamento == 'analitico') {
                    $this->render('reports/default_receita_analitico');
                } elseif ($situacao == 'todos' && $detalhamento == 'sintetico') {
                    $this->render('reports/default_receita_sintetico');
                }
            } elseif ($tipo == 'default' && $creditodebito == 'A') { //DÉBITOS E CRÉDITOS
                //BAIXADOS
                if ($situacao == 'baixado' && $detalhamento == 'analitico') {
                    $this->render('reports/default_consolidada_analitico'); //OK
                } elseif ($situacao == 'baixado' && $detalhamento == 'sintetico') {
                    $this->render('reports/default_consolidada_sintetico'); //OK
                }
                //ABERTOS
                elseif ($situacao == 'aberto' && $detalhamento == 'analitico') {
                    $this->render('reports/default_aberta_analitico'); //OK
                } elseif ($situacao == 'aberto' && $detalhamento == 'sintetico') {
                    $this->render('reports/default_aberta_sintetico'); //OK
                }
                //TODOS
                elseif ($situacao == 'todos' && $detalhamento == 'analitico') {
                    $this->render('reports/default_analitico'); //OK
                } elseif ($situacao == 'todos' && $detalhamento == 'sintetico') {
                    $this->render('reports/default_sintetico'); //OK
                } 
            }
        }
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('providers', $this->Moviments->Providers->find('list')->where($conditions)->order(['Providers.title']));
        $this->set('customers', $this->Moviments->Customers->find('list')->where($conditions)->order(['Customers.title']));
        $this->set('documentTypes', $this->Moviments->DocumentTypes->find('list')->where($conditions)->order(['DocumentTypes.title']));
        $this->set('costs', $this->Moviments->Costs->find('list')->where($conditions)->order(['Costs.title']));
        $this->set('banks', $this->Moviments->Banks->find('list')->where($conditions)->order(['Banks.title']));
        $this->set('boxes', $this->Moviments->Boxes->find('list')->where($conditions)->order(['Boxes.title']));
        $this->set('cards', $this->Moviments->Cards->find('list')->where($conditions)->order(['Cards.title']));
        $this->set('eventTypes', $this->Moviments->EventTypes->find('list')->where($conditions)->order(['EventTypes.title']));
        $accountPlans = $this->Moviments->AccountPlans->find('list', ['keyField' => 'id', 'valueField' => 'dropdown_accounts'])
                                                          ->where($conditions)
                                                          ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
    }
    
    public function reportRp()
    {
        $this->Banks           = TableRegistry::get('Banks');
        $this->Parameters      = TableRegistry::get('Parameters');
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            if (empty($this->request->data['rp'])) {
                $this->Flash->warning(__('Desculpe, ocorreu um erro e o registro não foi salvo. Os registros não foram selecionados'));
                return $this->redirect($this->referer());
            }//if (empty($this->request->data['rp']))

            /******************************************************************/
            
            $moviments = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->where(['Moviments.ordem IN' => $this->request->data['rp']])
                                         ->contain(['Costs']);
            $this->set('moviments', $moviments);

            /******************************************************************/
            
            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $parameter = $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))
                                          ->first();
            $this->set('parameter', $parameter);
            
            /******************************************************************/
            
            $Bank = $this->Banks->findByIdAndParametersId($this->request->data['banks_id'], $this->request->Session()->read('sessionParameterControl'))
                                 ->first();
            $this->set('Bank', $Bank);

            /******************************************************************/

            $parameter = $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))
                                          ->first();
            $this->set('parameter', $parameter);

            /******************************************************************/

            $rp = ['data'    => $this->request->data['data'],
                   'descrp'  => $this->request->data['descrp'],
                   'cheque'  => $this->request->data['cheque'],
                   'nominal' => $this->request->data['nominal']
                  ];

            $this->set('rp', $rp);

            /******************************************************************/
            
            if (!empty($this->request->data['cost'])) {
                $this->render('reports/relacao_pagamentos_centro_de_custos');
            } else {
                $this->render('reports/relacao_pagamentos');
            }//if (!empty($this->request->data['cost']))
            
        }//if ($this->request->is(['patch', 'post', 'put']))

        /**********************************************************************/
        
        /* DÉBITOS */
        $conditions = ['Moviments.status IN ("A", "P", "G")',
                       'Moviments.creditodebito LIKE' => 'D',
                       'Moviments.parameters_id'      => $this->request->Session()->read('sessionParameterControl')
                      ];
        $order = 'Moviments.vencimento ASC';
        
        $debitos = $this->Moviments->find('all')
                                   ->where($conditions)
                                   ->order($order);

        $this->set('debitos', $debitos);

        /**********************************************************************/
        
        /* MOVIMENTOS VINCULADOS */
        $conditions = ['MovimentMergeds.parameters_id' => $this->request->Session()->read('sessionParameterControl')];

        $movimentMergeds = $this->MovimentMergeds->find('all')
                                                 ->where($conditions)
                                                 ->order($order);

        $this->set('movimentMergeds', $movimentMergeds);

        /**********************************************************************/

        $conditions = ['Banks.parameters_id' => $this->request->Session()->read('sessionParameterControl')];

        $banks = $this->Banks->find('list')
                             ->where($conditions)
                             ->order(['Banks.title']);
        
        $this->set('banks', $banks);
    }
    
    public function cashFlow()
    {
        $this->AccountPlans    = TableRegistry::get('AccountPlans');
        $this->Parameters      = TableRegistry::get('Parameters');
        $this->Customers       = TableRegistry::get('Customers');
        $this->Providers       = TableRegistry::get('Providers');
        $this->EventTypes      = TableRegistry::get('EventTypes');
        $this->DocumentTypes   = TableRegistry::get('DocumentTypes');
        $this->Costs           = TableRegistry::get('Costs');
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
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
            
            $tables = [0 => 'Moviments',
                       1 => 'MovimentBanks',
                       2 => 'MovimentBoxes'
                      ];
            
            /******************************************************************/
            
            //CONTROLE DE PREENCHIMENTO DO CLIENTE E FORNECEDOR
            if ($this->request->data['creditodebito'] == 'C') {
                $this->request->data['providers_id'] = null;
            } elseif ($this->request->data['creditodebito'] == 'D') {
                $this->request->data['customers_id'] = null;
            } else {
                $this->request->data['providers_id'] = null;
                $this->request->data['customers_id'] = null;
            }
            
            /******************************************************************/
            
            $conditions_merged[] = 'Moviments.parameters_id = ' . $this->request->Session()->read('sessionParameterControl');
            $conditions_merged[] = 'Moviment_Mergeds.parameters_id = ' . $this->request->Session()->read('sessionParameterControl');
            
            //CONSULTA MOVIMENTOS
            foreach($tables as $table):
                
                // MONTAGEM DO SQL
                $conditions = [$table . '.parameters_id = ' . $this->request->Session()->read('sessionParameterControl')];
                
                /**************************************************************/
                
                //MOVIMENTOS EM ABERTO CONSULTADOS POR DATA DE VENCIMENTO
                if ($table == 'Moviments') {
                    
                    if (isset($this->request->data['dtemissao'])) {
                        $conditions[] = $table . '.data BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"';
                    } else {
                        $conditions[] = $table . '.vencimento BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"';
                    }//if (isset($this->request->data['dtemissao']))
                    
                }//if ($table == 'Moviments')
                
                //MOVIMENTOS DE BANCOS CONSULTADOS POR DATA DE PAGAMENTO
                elseif ($table == 'MovimentBanks') {
                    
                    if (isset($this->request->data['dtemissao'])) {
                        $conditions[] = $table . '.data BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"';
                    } else {
                        $conditions[] = $table . '.dtbaixa BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"';
                    }//if (isset($this->request->data['dtemissao']))
                    
                }//elseif ($table == 'MovimentBanks')
                
                //MOVIMENTOS DE CAIXAS CONSULTADOS POR DATA DE PAGAMENTO
                elseif ($table == 'MovimentBoxes') {
                    
                    if (isset($this->request->data['dtemissao'])) {
                        $conditions[] = $table . '.data BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"';
                    } else {
                        $conditions[] = $table . '.dtbaixa BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"';
                    }//if (isset($this->request->data['dtemissao']))
                    
                }//elseif ($table == 'MovimentBoxes')
                
                /**************************************************************/
                
                if ($this->request->data['account_plans_id']) {
                    
                    //Conditions dos planos de contas
                    $conditions[] = $table . '.account_plans_id IN (' . implode(", ", $this->request->data['account_plans_id']) . ')';
                    
                    //Conditions dos movimentos vinculados (parciais)
                    $conditions_merged[] = 'Moviments.account_plans_id IN (' . implode(", ", $this->request->data['account_plans_id']) . ')';
                    $conditions_merged[] = 'Moviment_Mergeds.account_plans_id IN (' . implode(", ", $this->request->data['account_plans_id']) . ')';
                    
                    //Consulta os títulos dos planos de contas
                    $accountPlans = $this->AccountPlans->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                       ->select(['AccountPlans.title'])
                                                       ->where(['AccountPlans.id IN ' => $this->request->data['account_plans_id']]);

                    $this->set('accountPlans', $accountPlans);
                    
                }//if ($this->request->data['account_plans_id'])
                
                if ($this->request->data['customers_id']) {
                    
                    //Conditions dos clientes
                    $conditions[]  = $table . '.customers_id = '.$this->request->data['customers_id'];
                    
                    //Conditions dos movimentos vinculados (parciais)
                    $conditions_merged[] = 'Moviments.customers_id = ' . $this->request->data['customers_id'];
                    $conditions_merged[] = 'Moviment_Mergeds.customers_id = ' . $this->request->data['customers_id'];
                    
                    //Consulta os títulos dos clientes
                    $customer = $this->Customers->findByIdAndParametersId($this->request->data['customers_id'], $this->request->Session()->read('sessionParameterControl'))
                                                ->select(['Customers.title'])
                                                ->first();
                    $this->set('customer', $customer);
                    
                }//if ($this->request->data['customers_id'])
                
                if ($this->request->data['providers_id']) {
                    
                    //Conditions dos fornecedores
                    $conditions[] = $table . '.providers_id = '.$this->request->data['providers_id'];
                    
                    //Conditions dos movimentos vinculados (parciais)
                    $conditions_merged[] = 'Moviments.providers_id = ' . $this->request->data['providers_id'];
                    $conditions_merged[] = 'Moviment_Mergeds.providers_id = ' . $this->request->data['providers_id'];
                    
                    //Consulta os títulos dos fornecedores
                    $provider = $this->Providers->findByIdAndParametersId($this->request->data['providers_id'], $this->request->Session()->read('sessionParameterControl'))
                                                ->select(['Providers.title'])
                                                ->first();
                    $this->set('provider', $provider);
                    
                }//if ($this->request->data['providers_id'])
                
                if ($this->request->data['event_types_id']) {
                    
                    //Conditions dos tipos de eventos
                    $conditions[] = $table . '.event_types_id = '.$this->request->data['event_types_id'];
                    
                    //Conditions dos movimentos vinculados (parciais)
                    $conditions_merged[] = 'Moviments.event_types_id = ' . $this->request->data['event_types_id'];
                    $conditions_merged[] = 'Moviment_Mergeds.event_types_id = ' . $this->request->data['event_types_id'];
                    
                    //Consulta os títulos dos tipos de eventos
                    $eventType = $this->EventTypes->findByIdAndParametersId($this->request->data['event_types_id'], $this->request->Session()->read('sessionParameterControl'))
                                                  ->select(['EventTypes.title'])
                                                  ->first();
                    $this->set('eventType', $eventType);
                    
                }//if ($this->request->data['event_types_id'])
                
                if ($this->request->data['document_types_id']) {
                    
                    //Conditions dos tipos de documentos
                    $conditions[] = $table . '.document_types_id = '.$this->request->data['document_types_id'];
                    
                    //Conditions dos movimentos vinculados (parciais)
                    $conditions_merged[] = 'Moviments.document_types_id = ' . $this->request->data['document_types_id'];
                    $conditions_merged[] = 'Moviment_Mergeds.document_types_id = ' . $this->request->data['document_types_id'];
                    
                    //Consulta os títulos dos tipos de documentos
                    $documentType = $this->DocumentTypes->findByIdAndParametersId($this->request->data['document_types_id'], $this->request->Session()->read('sessionParameterControl'))
                                                        ->select(['DocumentTypes.title'])
                                                        ->first();
                    $this->set('documentType', $documentType);
                    
                }//if ($this->request->data['document_types_id'])
                
                if ($this->request->data['costs_id']) {

                    //Separa a lista de centros de cutos
                    foreach($this->request->data['costs_id'] as $value):
                        $list_costs[] = $value;
                    endforeach;
                    
                    //Conditions dos centros de custos
                    $conditions[] = $table . '.costs_id IN (' . implode(', ', $list_costs) . ')';
                    
                    //Conditions dos movimentos vinculados (parciais)
                    $conditions_merged[] = 'Moviments.costs_id IN (' . implode(', ', $list_costs) . ')';
                    $conditions_merged[] = 'Moviment_Mergeds.costs_id IN (' . implode(', ', $list_costs) . ')';
                    
                    //Consulta os títulos dos centros de custos
                    $costs = $this->Costs->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->select(['Costs.id', 'Costs.title'])
                                         ->where(['Costs.id IN (' . implode(', ', $list_costs) . ')']);
                    $this->set('costs', $costs);
                    
                }//if ($this->request->data['costs_id'])
                
                if (!empty($this->request->data['contabil'])) {
                    
                    //Conditions dos documentos contábeis
                    $conditions[] = $table . '.contabil = "'.$this->request->data['contabil'].'"';
                    
                    //Conditions dos movimentos vinculados (parciais)
                    $conditions_merged[] = 'Moviments.contabil = "' . $this->request->data['contabil'] . '"';
                    $conditions_merged[] = 'Moviment_Mergeds.contabil = "' . $this->request->data['contabil'] . '"';
                    
                }//if (!empty($this->request->data['contabil']))
                
                /**************************************************************/
                
                //CHAMA FUNÇÃO PARA CONSULTAS
                $request_banks = $this->request->data['banks_id'];
                $request_boxes = $this->request->data['boxes_id'];
                $ordenacao     = $this->request->data['Ordem'];
                
                /**************************************************************/
                
                if ($this->request->data['Situação'] == 'todos') {
                    
                    if ($table == 'Moviments') {
                        
                        $cashFlowMoviment = $this->MovimentsFunctions->cashFlowMoviment($conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                        
                        foreach($cashFlowMoviment as $index => $value):
                            $this->set($index, $value);
                        endforeach;
                        
                    }//if ($table == 'Moviments')
                    
                    if ($request_banks && $request_boxes) {
                        
                        if ($table == 'MovimentBanks') { 
                            
                            $cashFlowBank = $this->MovimentsFunctions->cashFlowBank($request_banks, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                            
                            foreach($cashFlowBank as $index => $value):
                                $this->set($index, $value);
                            endforeach;
                            
                        } elseif ($table == 'MovimentBoxes') { 
                            
                            $cashFlowBox = $this->MovimentsFunctions->cashFlowBox($request_boxes, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                            
                            foreach($cashFlowBox as $index => $value):
                                $this->set($index, $value);
                            endforeach;
                            
                        }
                        
                    } elseif ($request_banks) {
                        
                        if ($table == 'MovimentBanks') { 
                            
                            $cashFlowBank = $this->MovimentsFunctions->cashFlowBank($request_banks, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                            
                            foreach($cashFlowBank as $index => $value):
                                $this->set($index, $value);
                            endforeach;
                        }
                        
                    } elseif ($request_boxes) {
                        
                        if ($table == 'MovimentBoxes') { 
                            
                            $cashFlowBox = $this->MovimentsFunctions->cashFlowBox($request_boxes, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                            
                            foreach($cashFlowBox as $index => $value):
                                $this->set($index, $value);
                            endforeach;
                            
                        }
                        
                    }
                    
                } elseif ($this->request->data['Situação'] == 'aberto') {
                    
                    if ($table == 'Moviments') {   
                        
                        $cashFlowMoviment = $this->MovimentsFunctions->cashFlowMoviment($conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                        
                        foreach($cashFlowMoviment as $index => $value):
                            $this->set($index, $value);
                        endforeach;
                        
                    }
                    
                } elseif ($this->request->data['Situação'] == 'baixado') {
                    
                    if (!empty($request_boxes) && !empty($request_banks)) {
                        
                        if ($table == 'MovimentBanks') { 
                            
                            $cashFlowBank = $this->MovimentsFunctions->cashFlowBank($request_banks, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                            
                            foreach($cashFlowBank as $index => $value):
                                $this->set($index, $value);
                            endforeach;
                            
                        } elseif ($table == 'MovimentBoxes') { 
                            
                            $cashFlowBox = $this->MovimentsFunctions->cashFlowBox($request_boxes, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                            
                            foreach($cashFlowBox as $index => $value):
                                $this->set($index, $value);
                            endforeach;
                            
                        }
                        
                    } elseif (!empty($request_boxes)) {
                        
                        if ($table == 'MovimentBoxes') { 
                            
                            $cashFlowBox = $this->MovimentsFunctions->cashFlowBox($request_boxes, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                            
                            foreach($cashFlowBox as $index => $value):
                                $this->set($index, $value);
                            endforeach;
                            
                        }
                        
                    } elseif (!empty($request_banks)) {
                        
                        if ($table == 'MovimentBanks') { 
                            
                            $cashFlowBank = $this->MovimentsFunctions->cashFlowBank($request_banks, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                            
                            foreach($cashFlowBank as $index => $value):
                                $this->set($index, $value);
                            endforeach;
                            
                        }
                        
                    }
                    
                }
                
            endforeach;
            
            /******************************************************************/
            
            if (!empty($request_banks)) { 
                //Conditions dos movimentos vinculados (parciais)
                $conditions_merged[] = 'Moviments.banks_id IN (' . implode(',', $request_banks) . ')';
                $conditions_merged[] = 'Moviment_Mergeds.banks_id IN (' . implode(',', $request_banks) . ')';
            }
            if (!empty($request_boxes)) { 
                //Conditions dos movimentos vinculados (parciais)
                $conditions_merged[] = 'Moviments.boxes_id IN (' . implode(',', $request_boxes) . ')';
                $conditions_merged[] = 'Moviment_Mergeds.boxes_id IN (' . implode(',', $request_boxes) . ')';
            }
            
            /******************************************************************/
            
            //Conditions para movimentos vinculados (parciais)
            if (isset($this->request->data['dtemissao'])) {
                $conditions_merged[] = 'Moviments.data BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'" '
                                        . 'OR Moviment_Mergeds.data BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"';
            } else {
                $conditions_merged[] = 'Moviments.vencimento BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'" '
                                        . 'OR Moviments.dtbaixa BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'" '
                                        . 'OR Moviment_Mergeds.vencimento BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'" '
                                        . 'OR Moviment_Mergeds.dtbaixa BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"';
            }//if (isset($this->request->data['dtemissao']))

            /******************************************************************/
            /*EM DESENVOLVIMENTO 08/03/2018*/
            $movimentMergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                     ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                               'Moviments.id', 'Moviments.data', 'Moviments.vencimento', 'Moviments.dtbaixa', 'Moviments.ordem', 'Moviments.valorbaixa', 
                                                               'Moviments.id', 'Moviments.parameters_id', 'Moviments.ordem', 'Moviments.data', 'Moviments.vencimento', 'Moviments.dtbaixa',
                                                               'Moviments.valor', 'Moviments.valorbaixa', 'Moviments.account_plans_id', 'Moviments.customers_id', 'Moviments.providers_id',
                                                               'Moviments.event_types_id', 'Moviments.document_types_id', 'Moviments.costs_id', 'Moviments.contabil', 'Moviments.status',
                                                               'Moviments.boxes_id', 'Moviments.banks_id', 
                                                               'Moviment_Mergeds.id', 'Moviment_Mergeds.parameters_id', 'Moviment_Mergeds.ordem', 'Moviment_Mergeds.data', 'Moviment_Mergeds.vencimento',
                                                               'Moviment_Mergeds.dtbaixa', 'Moviment_Mergeds.valor', 'Moviment_Mergeds.valorbaixa', 'Moviment_Mergeds.account_plans_id',
                                                               'Moviment_Mergeds.customers_id', 'Moviment_Mergeds.providers_id', 'Moviment_Mergeds.event_types_id', 'Moviment_Mergeds.document_types_id',
                                                               'Moviment_Mergeds.costs_id', 'Moviment_Mergeds.contabil', 'Moviment_Mergeds.status', 'Moviment_Mergeds.boxes_id', 'Moviment_Mergeds.banks_id', 
                                                               'MovimentBanks.id', 'MovimentBanks.ordem', 'MovimentBanks.parameters_id', 'MovimentBanks.banks_id', 'MovimentBanks.moviments_id', 
                                                               'MovimentBoxes.id', 'MovimentBoxes.ordem', 'MovimentBoxes.parameters_id', 'MovimentBoxes.boxes_id', 'MovimentBoxes.moviments_id',
                                                               'MovimentBank_Merged.id', 'MovimentBank_Merged.ordem', 'MovimentBank_Merged.parameters_id', 'MovimentBank_Merged.banks_id', 'MovimentBank_Merged.moviments_id', 'MovimentBank_Merged.valorbaixa', 
                                                               'MovimentBox_Merged.id', 'MovimentBox_Merged.ordem', 'MovimentBox_Merged.parameters_id', 'MovimentBox_Merged.boxes_id', 'MovimentBox_Merged.moviments_id', 'MovimentBox_Merged.valorbaixa'
                                                              ])
                                                     ->where($conditions_merged)
                                                     ->join(['Moviments' => ['table'      => 'Moviments',
                                                                             'type'       => 'LEFT',
                                                                             'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                            ],
                                                             'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                                   'type'       => 'LEFT',
                                                                                   'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                                  ],
                                                             'MovimentBanks' => ['table'      => 'Moviment_Banks',
                                                                                 'type'       => 'LEFT',
                                                                                 'conditions' => 'MovimentBanks.moviments_id = Moviments.id '
                                                                                                  . 'AND MovimentBanks.banks_id = Moviments.banks_id'
                                                                                ],
                                                             'MovimentBoxes' => ['table'      => 'Moviment_Boxes',
                                                                                 'type'       => 'LEFT',
                                                                                 'conditions' => 'MovimentBoxes.moviments_id = Moviments.id '
                                                                                                  . 'AND MovimentBoxes.boxes_id = Moviments.boxes_id'
                                                                                ],
                                                             'MovimentBank_Merged' => ['table'      => 'Moviment_Banks',
                                                                                       'type'       => 'LEFT',
                                                                                       'conditions' => 'MovimentBank_Merged.moviments_id = Moviment_Mergeds.id '
                                                                                                        . 'AND MovimentBank_Merged.banks_id = Moviment_Mergeds.banks_id'
                                                                                      ],
                                                             'MovimentBox_Merged' => ['table'      => 'Moviment_Boxes',
                                                                                      'type'       => 'LEFT',
                                                                                      'conditions' => 'MovimentBox_Merged.moviments_id = Moviment_Mergeds.id '
                                                                                                       . 'AND MovimentBox_Merged.boxes_id = Moviment_Mergeds.boxes_id'
                                                                                     ]
                                                            ]);
            //debug($conditions_merged);
            //debug($movimentMergeds->sql());
            //debug($movimentMergeds->toArray());
            
            $this->set('movimentMergeds', $movimentMergeds);
            
            /******************************************************************/
            
            //CONSULTA SALDO ANTERIOR
            $cashFlowBalance = $this->MovimentsFunctions->cashFlowBalance($dtinicial, $request_banks, $request_boxes, $this->request->Session()->read('sessionParameterControl'));
            
            $this->set('balance', $cashFlowBalance);
            
            /******************************************************************/
            
            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());
            
            /******************************************************************/
            
            //Evitar página de erro
            $this->render('reports/sem_relatorio');
            
            /******************************************************************/
            
            //PLANO DE CONTAS -> UTLIZADO NO RELATÓRIO SINTÉTICO POR PLANOS DE CONTAS
            $accountPlans = $this->AccountPlans->find('all')
                                               ->select(['AccountPlans.id', 'AccountPlans.title', 'AccountPlans.classification', 'AccountPlans.parameters_id'])
                                               ->where(['AccountPlans.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                               ->order(['AccountPlans.classification']);
            
            $this->set('plans', $accountPlans);
            
            /******************************************************************/

            //CLIENTES -> UTILIZADO NO RELATÓRIO SINTÉTICO POR CLIENTES/FORNECEDORES
            $customers = $this->Customers->find('all')
                                         ->select(['Customers.id', 'Customers.parameters_id', 'Customers.cpfcnpj', 'Customers.title', 'Customers.status'])
                                         ->where(['Customers.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                  'Customers.status'        => 'A'
                                                 ])
                                         ->order(['Customers.title']);
            
            $this->set('customers', $customers);
            
            /******************************************************************/

            //FORNECEDORES -> UTILIZADO NO RELATÓRIO SINTÉTICO POR CLIENTES/FORNECEDORES
            $providers = $this->Providers->find('all')
                                         ->select(['Providers.id', 'Providers.parameters_id', 'Providers.cpfcnpj', 'Providers.title', 'Providers.status'])
                                         ->where(['Providers.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                  'Providers.status'        => 'A'
                                                 ])
                                         ->order(['Providers.title']);
            
            $this->set('providers', $providers);
            
            /******************************************************************/
            
            if ($this->request->data['Detalhamento'] == 'analitico_cashflow') {
                $this->render('/Moviments/reports/cash_flow_analitico');
            } elseif ($this->request->data['Detalhamento'] == 'analitico_simples') {
                $this->render('/Moviments/reports/cash_flow_analitico_simples');
            } elseif ($this->request->data['Detalhamento'] == 'analitico_clieforn') {
                $this->render('/Moviments/reports/cash_flow_clieforn_analitico');
            } elseif ($this->request->data['Detalhamento'] == 'sintetico') {
                $this->render('/Moviments/reports/cash_flow_sintetico');
            } elseif ($this->request->data['Detalhamento'] == 'contas') {
                $this->render('/Moviments/reports/cash_flow_contas_sintetico');
            } elseif ($this->request->data['Detalhamento'] == 'sintetico_clieforn') {
                $this->render('/Moviments/reports/cash_flow_clieforn_sintetico');
            }
            
        }
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('providers', $this->Moviments->Providers->find('list')->where($conditions)->order(['Providers.title']));
        $this->set('customers', $this->Moviments->Customers->find('list')->where($conditions)->order(['Customers.title']));
        $this->set('documentTypes', $this->Moviments->DocumentTypes->find('list')->where($conditions)->order(['DocumentTypes.title']));
        $this->set('costs', $this->Moviments->Costs->find('list')->where($conditions)->order(['Costs.title']));
        $this->set('banks', $this->Moviments->Banks->find('list')->where($conditions)->order(['Banks.title']));
        $this->set('boxes', $this->Moviments->Boxes->find('list')->where($conditions)->order(['Boxes.title']));
        $this->set('cards', $this->Moviments->Cards->find('list')->where($conditions)->order(['Cards.title']));
        $this->set('eventTypes', $this->Moviments->EventTypes->find('list')->where($conditions)->order(['EventTypes.title']));
        $accountPlans = $this->Moviments->AccountPlans->find('list', ['keyField' => 'id', 'valueField' => 'dropdown_accounts'])
                                                          ->where($conditions)
                                                          ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
    }
    
    public function cashFlowSimple()
    {
        $this->Parameters      = TableRegistry::get('Parameters');
        $this->Costs           = TableRegistry::get('Costs');
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
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
            
            //CHAMA FUNÇÃO PARA CONSULTAS
            $request_banks = $this->request->data['banks_id'];
            $request_boxes = $this->request->data['boxes_id'];
            $ordenacao     = $this->request->data['Ordem'];
            $periodo       = [];

            /******************************************************************/
            
            $tables = [0 => 'Moviments',
                       1 => 'MovimentBanks',
                       2 => 'MovimentBoxes'
                      ];
            
            /******************************************************************/
            
            $conditions_merged = ['Moviments.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                  'Moviment_Mergeds.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                 ];
            
            //CONSULTA MOVIMENTOS
            foreach($tables as $table):
                
                // MONTAGEM DO SQL
                $conditions = [$table . '.parameters_id = '.$this->request->Session()->read('sessionParameterControl')];
                
                /**************************************************************/
                
                //MOVIMENTOS EM ABERTO CONSULTADOS POR DATA DE VENCIMENTO
                if ($table == 'Moviments') {
                    
                    if (isset($this->request->data['dtemissao'])) {
                        $conditions[] = $table . '.data BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"';
                    } else {
                        $conditions[] = $table . '.vencimento BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"';
                    }//if (isset($this->request->data['dtemissao']))
                    
                }//if ($table == 'Moviments')
                
                //MOVIMENTOS DE BANCOS CONSULTADOS POR DATA DE PAGAMENTO
                elseif ($table == 'MovimentBanks') {
                    
                    if (isset($this->request->data['dtemissao'])) {
                        $conditions[] = $table . '.data BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"';
                    } else {
                        $conditions[] = $table . '.dtbaixa BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"';
                    }//if (isset($this->request->data['dtemissao']))
                    
                }//elseif ($table == 'MovimentBanks')
                
                //MOVIMENTOS DE CAIXAS CONSULTADOS POR DATA DE PAGAMENTO
                elseif ($table == 'MovimentBoxes') {
                    
                    if (isset($this->request->data['dtemissao'])) {
                        $conditions[] = $table . '.data BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"';
                    } else {
                        $conditions[] = $table . '.dtbaixa BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"';
                    }//if (isset($this->request->data['dtemissao']))
                    
                }//elseif ($table == 'MovimentBoxes')
                
                /**************************************************************/
                
                if ($this->request->data['costs_id']) {

                    //Separa a lista de centros de cutos
                    foreach($this->request->data['costs_id'] as $value):
                        $list_costs[] = $value;
                    endforeach;
                    
                    //Conditions dos centros de custos
                    $conditions[] = $table . '.costs_id IN (' . implode(', ', $list_costs) . ')';
                    
                    //Conditions dos movimentos vinculados (parciais)
                    $conditions_merged[] = 'Moviments.costs_id IN (' . implode(', ', $list_costs) . ')';
                    $conditions_merged[] = 'Moviment_Mergeds.costs_id IN (' . implode(', ', $list_costs) . ')';
                    
                    //Consulta os títulos dos centros de custos
                    $costs = $this->Costs->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->select(['Costs.id', 'Costs.title'])
                                         ->where(['Costs.id IN (' . implode(', ', $list_costs) . ')']);
                    $this->set('costs', $costs);
                    
                }//if ($this->request->data['costs_id'])
                
                if (!empty($this->request->data['contabil'])) {
                    
                    //Conditions dos documentos contábeis
                    $conditions[] = $table . '.contabil = "'.$this->request->data['contabil'].'"';
                    
                    //Conditions dos movimentos vinculados (parciais)
                    $conditions_merged[] = ['Moviments.contabil' => $this->request->data['contabil'],
                                            'Moviment_Mergeds.contabil' => $this->request->data['contabil']
                                           ];
                    
                }//if (!empty($this->request->data['contabil']))
                
                /**************************************************************/
                
                if ($this->request->data['Situação'] == 'todos') {
                    
                    if ($table == 'Moviments') {
                        
                        $cashFlowMoviment = $this->MovimentsFunctions->cashFlowMoviment($conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                        
                        foreach($cashFlowMoviment as $index => $value):
                            $this->set($index, $value);
                            
                            //Incrementa o período para exibição
                            if (is_object($value)) { 
                                foreach($value as $val):
                                    if ($ordenacao == 'data') {
                                        $periodo[] = $val->data;
                                    } elseif ($ordenacao == 'vencimento') {
                                        $periodo[] = $val->vencimento;
                                    } elseif ($ordenacao == 'dtbaixa') {
                                        $periodo[] = $val->vencimento;
                                        //$periodo[] = $val->dtbaixa;
                                    }
                                endforeach;
                            }//if (is_object($value))

                        endforeach;
                        
                    }//if ($table == 'Moviments')
                    
                    if ($request_banks && $request_boxes) {
                        
                        if ($table == 'MovimentBanks') { 
                            
                            $cashFlowBank = $this->MovimentsFunctions->cashFlowBank($request_banks, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                            
                            foreach($cashFlowBank as $index => $value):
                                $this->set($index, $value);

                                //Incrementa o período para exibição
                                if (is_object($value)) {
                                    foreach($value as $val):
                                        if ($ordenacao == 'data') {
                                            $periodo[] = $val->data;
                                        } elseif ($ordenacao == 'vencimento') {
                                            $periodo[] = $val->vencimento;
                                        } elseif ($ordenacao == 'dtbaixa') {
                                            $periodo[] = $val->dtbaixa;
                                        }
                                    endforeach;
                                }//if (is_object($value))

                            endforeach;
                            
                        } elseif ($table == 'MovimentBoxes') { 
                            
                            $cashFlowBox = $this->MovimentsFunctions->cashFlowBox($request_boxes, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                            
                            foreach($cashFlowBox as $index => $value):
                                $this->set($index, $value);

                                //Incrementa o período para exibição
                                if (is_object($value)) {
                                    foreach($value as $val):
                                        if ($ordenacao == 'data') {
                                            $periodo[] = $val->data;
                                        } elseif ($ordenacao == 'vencimento') {
                                            $periodo[] = $val->vencimento;
                                        } elseif ($ordenacao == 'dtbaixa') {
                                            $periodo[] = $val->dtbaixa;
                                        }
                                    endforeach;
                                }//if (is_object($value))

                            endforeach;
                            
                        }//elseif ($table == 'MovimentBoxes')
                        
                    } elseif ($request_banks) {
                        
                        if ($table == 'MovimentBanks') { 
                            
                            $cashFlowBank = $this->MovimentsFunctions->cashFlowBank($request_banks, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 

                            foreach($cashFlowBank as $index => $value):
                                $this->set($index, $value);

                                //Incrementa o período para exibição
                                if (is_object($value)) {
                                    foreach($value as $val):
                                        if ($ordenacao == 'data') {
                                            $periodo[] = $val->data;
                                        } elseif ($ordenacao == 'vencimento') {
                                            $periodo[] = $val->vencimento;
                                        } elseif ($ordenacao == 'dtbaixa') {
                                            $periodo[] = $val->dtbaixa;
                                        }
                                    endforeach;
                                }//if (is_object($value))
                                
                            endforeach;
                        }//if ($table == 'MovimentBanks')
                        
                    } elseif ($request_boxes) {
                        
                        if ($table == 'MovimentBoxes') { 
                            
                            $cashFlowBox = $this->MovimentsFunctions->cashFlowBox($request_boxes, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                            
                            foreach($cashFlowBox as $index => $value):
                                $this->set($index, $value);

                                //Incrementa o período para exibição
                                if (is_object($value)) {
                                    foreach($value as $val):
                                        if ($ordenacao == 'data') {
                                            $periodo[] = $val->data;
                                        } elseif ($ordenacao == 'vencimento') {
                                            $periodo[] = $val->vencimento;
                                        } elseif ($ordenacao == 'dtbaixa') {
                                            $periodo[] = $val->dtbaixa;
                                        }
                                    endforeach;
                                }//if (is_object($value))

                            endforeach;
                            
                        }//if ($table == 'MovimentBoxes')
                        
                    }//elseif ($request_boxes)
                    
                } elseif ($this->request->data['Situação'] == 'aberto') {
                    
                    if ($table == 'Moviments') {   
                        
                        $cashFlowMoviment = $this->MovimentsFunctions->cashFlowMoviment($conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                        
                        foreach($cashFlowMoviment as $index => $value):
                            $this->set($index, $value);

                            //Incrementa o período para exibição
                            if (is_object($value)) {
                                foreach($value as $val):
                                    if ($ordenacao == 'data') {
                                        $periodo[] = $val->data;
                                    } elseif ($ordenacao == 'vencimento') {
                                        $periodo[] = $val->vencimento;
                                    } elseif ($ordenacao == 'dtbaixa') {
                                        $periodo[] = $val->dtbaixa;
                                    }
                                endforeach;
                            }//if (is_object($value))

                        endforeach;
                        
                    }//if ($table == 'Moviments')
                    
                } elseif ($this->request->data['Situação'] == 'baixado') {
                    
                    if (!empty($request_boxes) && !empty($request_banks)) {
                        
                        if ($table == 'MovimentBanks') { 
                            
                            $cashFlowBank = $this->MovimentsFunctions->cashFlowBank($request_banks, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                            
                            foreach($cashFlowBank as $index => $value):
                                $this->set($index, $value);

                                //Incrementa o período para exibição
                                if (is_object($value)) {
                                    foreach($value as $val):
                                        if ($ordenacao == 'data') {
                                            $periodo[] = $val->data;
                                        } elseif ($ordenacao == 'vencimento') {
                                            $periodo[] = $val->vencimento;
                                        } elseif ($ordenacao == 'dtbaixa') {
                                            $periodo[] = $val->dtbaixa;
                                        }
                                    endforeach;
                                }//if (is_object($value))
                                
                            endforeach;
                            
                        } elseif ($table == 'MovimentBoxes') { 
                            
                            $cashFlowBox = $this->MovimentsFunctions->cashFlowBox($request_boxes, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                            
                            foreach($cashFlowBox as $index => $value):
                                $this->set($index, $value);

                                //Incrementa o período para exibição
                                if (is_object($value)) {
                                    foreach($value as $val):
                                        if ($ordenacao == 'data') {
                                            $periodo[] = $val->data;
                                        } elseif ($ordenacao == 'vencimento') {
                                            $periodo[] = $val->vencimento;
                                        } elseif ($ordenacao == 'dtbaixa') {
                                            $periodo[] = $val->dtbaixa;
                                        }
                                    endforeach;
                                }//if (is_object($value))
                                
                            endforeach;
                            
                        }//elseif ($table == 'MovimentBoxes')
                        
                    } elseif (!empty($request_boxes)) {
                        
                        if ($table == 'MovimentBoxes') { 
                            
                            $cashFlowBox = $this->MovimentsFunctions->cashFlowBox($request_boxes, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                            
                            foreach($cashFlowBox as $index => $value):
                                $this->set($index, $value);

                                //Incrementa o período para exibição
                                if (is_object($value)) {
                                    foreach($value as $val):
                                        if ($ordenacao == 'data') {
                                            $periodo[] = $val->data;
                                        } elseif ($ordenacao == 'vencimento') {
                                            $periodo[] = $val->vencimento;
                                        } elseif ($ordenacao == 'dtbaixa') {
                                            $periodo[] = $val->dtbaixa;
                                        }
                                    endforeach;
                                }//if (is_object($value))
                                
                            endforeach;
                            
                        }//if ($table == 'MovimentBoxes')
                        
                    } elseif (!empty($request_banks)) {
                        
                        if ($table == 'MovimentBanks') { 
                            
                            $cashFlowBank = $this->MovimentsFunctions->cashFlowBank($request_banks, $conditions, $ordenacao, $this->request->Session()->read('sessionParameterControl')); 
                            
                            foreach($cashFlowBank as $index => $value):
                                $this->set($index, $value);

                                //Incrementa o período para exibição
                                if (is_object($value)) {
                                    foreach($value as $val):
                                        if ($ordenacao == 'data') {
                                            $periodo[] = $val->data;
                                        } elseif ($ordenacao == 'vencimento') {
                                            $periodo[] = $val->vencimento;
                                        } elseif ($ordenacao == 'dtbaixa') {
                                            $periodo[] = $val->dtbaixa;
                                        }
                                    endforeach;
                                }//if (is_object($value))

                            endforeach;
                            
                        }//if ($table == 'MovimentBanks')
                        
                    }//elseif (!empty($request_banks))
                    
                }//elseif ($this->request->data['Situação'] == 'baixado')
                
            endforeach;
            
            /******************************************************************/
            
            //Período de datas encontradas nas consultas acima
            if (!empty($periodo)) {

                //modifica o formato da data
                foreach($periodo as $per):
                    if (!empty($per)) $perdata[] = $per->i18nFormat('YYY-MM-dd');
                endforeach;
                $periodo = $perdata;

                $periodo = array_unique($periodo); //elimina duplicados
                array_multisort($periodo, SORT_ASC, SORT_STRING); //ordena

                $this->set('periodo', $periodo);

            }//if (!empty($periodo))

            /******************************************************************/
            
            if (!empty($request_banks)) { 
                //Conditions dos movimentos vinculados (parciais)
                $conditions_merged[] = ['Moviments.banks_id IN' => $request_banks,
                                        'Moviment_Mergeds.banks_id IN' => $request_banks
                                       ];
            }
            if (!empty($request_boxes)) { 
                //Conditions dos movimentos vinculados (parciais)
                $conditions_merged[] = ['Moviments.boxes_id IN' => $request_boxes,
                                        'Moviment_Mergeds.boxes_id IN' => $request_boxes
                                       ];
            }
            
            /******************************************************************/
            
            //Conditions para movimentos vinculados (parciais)
            if (isset($this->request->data['dtemissao'])) {
                $conditions_merged[] = ['Moviments.data BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'" '
                                        . 'OR Moviment_Mergeds.data BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"'
                                       ];
            } else {
                $conditions_merged[] = ['Moviments.vencimento BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'" '
                                        . 'OR Moviments.dtbaixa BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'" '
                                        . 'OR Moviment_Mergeds.vencimento BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'" '
                                        . 'OR Moviment_Mergeds.dtbaixa BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'"'
                                       ];
            }//if (isset($this->request->data['dtemissao']))

            /******************************************************************/
            /*EM DESENVOLVIMENTO 08/03/2018*/
            $movimentMergeds = $this->MovimentMergeds->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                     ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                               'Moviments.id', 'Moviments.data', 'Moviments.vencimento', 'Moviments.dtbaixa', 'Moviments.ordem', 'Moviments.valorbaixa', 
                                                               'Moviments.id', 'Moviments.parameters_id', 'Moviments.ordem', 'Moviments.data', 'Moviments.vencimento', 'Moviments.dtbaixa',
                                                               'Moviments.valor', 'Moviments.valorbaixa', 'Moviments.costs_id', 'Moviments.contabil', 'Moviments.status',
                                                               'Moviments.boxes_id', 'Moviments.banks_id', 
                                                               'Moviment_Mergeds.id', 'Moviment_Mergeds.parameters_id', 'Moviment_Mergeds.ordem', 'Moviment_Mergeds.data', 'Moviment_Mergeds.vencimento',
                                                               'Moviment_Mergeds.dtbaixa', 'Moviment_Mergeds.valor', 'Moviment_Mergeds.valorbaixa', 'Moviment_Mergeds.account_plans_id',
                                                               'Moviment_Mergeds.costs_id', 'Moviment_Mergeds.contabil', 'Moviment_Mergeds.status', 'Moviment_Mergeds.boxes_id', 'Moviment_Mergeds.banks_id', 
                                                               'MovimentBanks.id', 'MovimentBanks.ordem', 'MovimentBanks.parameters_id', 'MovimentBanks.banks_id', 'MovimentBanks.moviments_id', 
                                                               'MovimentBoxes.id', 'MovimentBoxes.ordem', 'MovimentBoxes.parameters_id', 'MovimentBoxes.boxes_id', 'MovimentBoxes.moviments_id',
                                                               'MovimentBank_Merged.id', 'MovimentBank_Merged.ordem', 'MovimentBank_Merged.parameters_id', 'MovimentBank_Merged.banks_id', 'MovimentBank_Merged.moviments_id', 'MovimentBank_Merged.valorbaixa', 
                                                               'MovimentBox_Merged.id', 'MovimentBox_Merged.ordem', 'MovimentBox_Merged.parameters_id', 'MovimentBox_Merged.boxes_id', 'MovimentBox_Merged.moviments_id', 'MovimentBox_Merged.valorbaixa'
                                                              ])
                                                     ->where($conditions_merged)
                                                     ->join(['Moviments' => ['table'      => 'Moviments',
                                                                             'type'       => 'LEFT',
                                                                             'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                            ],
                                                             'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                                   'type'       => 'LEFT',
                                                                                   'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                                  ],
                                                             'MovimentBanks' => ['table'      => 'Moviment_Banks',
                                                                                 'type'       => 'LEFT',
                                                                                 'conditions' => 'MovimentBanks.moviments_id = Moviments.id '
                                                                                                  . 'AND MovimentBanks.banks_id = Moviments.banks_id'
                                                                                ],
                                                             'MovimentBoxes' => ['table'      => 'Moviment_Boxes',
                                                                                 'type'       => 'LEFT',
                                                                                 'conditions' => 'MovimentBoxes.moviments_id = Moviments.id '
                                                                                                  . 'AND MovimentBoxes.boxes_id = Moviments.boxes_id'
                                                                                ],
                                                             'MovimentBank_Merged' => ['table'      => 'Moviment_Banks',
                                                                                       'type'       => 'LEFT',
                                                                                       'conditions' => 'MovimentBank_Merged.moviments_id = Moviment_Mergeds.id '
                                                                                                        . 'AND MovimentBank_Merged.banks_id = Moviment_Mergeds.banks_id'
                                                                                      ],
                                                             'MovimentBox_Merged' => ['table'      => 'Moviment_Boxes',
                                                                                      'type'       => 'LEFT',
                                                                                      'conditions' => 'MovimentBox_Merged.moviments_id = Moviment_Mergeds.id '
                                                                                                       . 'AND MovimentBox_Merged.boxes_id = Moviment_Mergeds.boxes_id'
                                                                                     ]
                                                            ]);
            //debug($conditions_merged);
            //debug($movimentMergeds->sql());
            //debug($movimentMergeds->toArray());
            
            $this->set('movimentMergeds', $movimentMergeds);
            
            /******************************************************************/
            
            //CONSULTA SALDO ANTERIOR
            $cashFlowBalance = $this->MovimentsFunctions->cashFlowBalance($dtinicial, $request_banks, $request_boxes, $this->request->Session()->read('sessionParameterControl'));
            
            $this->set('balance', $cashFlowBalance);
            
            /******************************************************************/
            
            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());
            
            /******************************************************************/
            
            //Evitar página de erro
            $this->render('reports/sem_relatorio');
            
            /******************************************************************/
            
            //CATEGORIAS
            $costs = $this->Costs->find('all')
                                 ->select(['Costs.id', 'Costs.title', 'Costs.parameters_id'])
                                 ->where(['Costs.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                 ->order(['Costs.title']);
            
            $this->set('costs', $costs);
            
            /******************************************************************/
            
            if ($this->request->data['Detalhamento'] == 'analitico_cashflow') {
                $this->render('/Moviments/reports/simple/cash_flow_analitico');
            } elseif ($this->request->data['Detalhamento'] == 'analitico_simples') {
                $this->render('/Moviments/reports/simple/cash_flow_analitico_simples');
            } elseif ($this->request->data['Detalhamento'] == 'sintetico') {
                $this->render('/Moviments/reports/simple/cash_flow_sintetico');
            } elseif ($this->request->data['Detalhamento'] == 'categorias') {
                $this->render('/Moviments/reports/simple/cash_flow_categorias_sintetico');
            }
            
        }
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $this->set('costs', $this->Moviments->Costs->find('list')->where($conditions)->order(['Costs.title']));
        $this->set('banks', $this->Moviments->Banks->find('list')->where($conditions)->order(['Banks.title']));
        $this->set('boxes', $this->Moviments->Boxes->find('list')->where($conditions)->order(['Boxes.title']));
        $this->set('cards', $this->Moviments->Cards->find('list')->where($conditions)->order(['Cards.title']));
    }
}