<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class MovimentsFunctionsComponent extends Component 
{
    public function __construct()
    {
        $this->Error = new ErrorComponent();

        $this->Moviments = TableRegistry::get('Moviments');
        $this->Balances  = TableRegistry::get('Balances');
        
        $this->RegisterMoviments = new RegisterMovimentsComponent();
        $this->GeneralBalance    = new GeneralBalanceComponent();
        $this->SystemFunctions   = new SystemFunctionsComponent();
    }
    
    public function validaDocumento($providers_id, $customers_id, $documento, $document_types_id, $parameters_id)
    {
        //Acessa a tabela DocumentType
        $this->DocumentTypes = TableRegistry::get('DocumentTypes');
        
        $documentType = $this->DocumentTypes->findByIdAndParametersId($document_types_id, $parameters_id)
                                          ->select(['duplicadoc'])
                                          ->first();

        if (!empty($documentType)) {
        
            if ($documentType->duplicadoc == 'N') {
                
                //Busca lançamentos com mesmo número de documento
                if (!empty($providers_id)) {
                    $conditions = ['Moviments.documento'    => $documento,
                                'Moviments.providers_id' => $providers_id, 
                                ];
                } elseif (!empty($customers_id)) {
                    $conditions = ['Moviments.documento'    => $documento,
                                'Moviments.customers_id' => $customers_id, 
                                ];
                }
                
                if (!empty($conditions)) {
                    $moviment = $this->Moviments->findByParametersId($parameters_id)
                                                ->select(['Moviments.ordem'])
                                                ->where($conditions)
                                                ->first();
                }
                
                if (!empty($moviment->ordem)) {
                    $this->Flash->warning(__('Registro nº de documento já cadastrado. Movimento ' . $moviment->ordem));
                    return $this->redirect($this->referer());
                }//if (!empty($moviment->ordem))
                
            }//if ($documentType->duplicadoc == 'N')

        }//if (!empty($documentType))

    }
        
    public function bankBoxCheck($object, $id_vinculado = null)
    {
        if (isset($object->banks_id)) {
            
            if (isset($object->cheque)) {
                
                $this->RegisterMoviments->movimentCheck($object, $id_vinculado);
                
            }//if (isset($object->cheque))
            
            $this->RegisterMoviments->movimentBank($object, $id_vinculado);
            
        } elseif (isset($object->boxes_id)) {
            
            $this->RegisterMoviments->movimentBox($object, $id_vinculado);
            
        }//elseif (isset($object->boxes_id))
    }
    
    public function addMovimentMerged($object_principal, $id_vinculado, $parameters_id) /* VERIFICAR A LÓGICA DESSA FUNÇÃO 18/12/2017 */
    {
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        //Consulta a existência desse vínculo
        $movimentMerged = $this->MovimentMergeds->findByParametersId($parameters_id)
                                                ->where(['MovimentMergeds.moviments_id'     => $object_principal->id,
                                                         'MovimentMergeds.moviments_merged' => $id_vinculado,
                                                         'MovimentMergeds.parameters_id'    => $parameters_id
                                                        ])
                                                ->first();
        
        if (empty($movimentMerged)) {
            
            //Cria novo vínculo, no caso de ainda não existir
            $merged = $this->MovimentMergeds->newEntity();
            
            $merged->moviments_id     = $object_principal->id;
            $merged->moviments_merged = $id_vinculado;
            $merged->parameters_id    = $parameters_id;
            
            //Retorna o objeto criado
            return $this->MovimentMergeds->save($merged);
            
        } //if (empty($movimentMerged))
        
        //Retorna o objeto encontrado
        return $movimentMerged;
    }
    
    public function addPartial($moviment)
    {
        //DEFINE O VALOR DA ORDEM
        $ordem = $this->Moviments->findByParametersId($moviment->parameters_id)
                                 ->select(['MAX' => 'MAX(Moviments.ordem)'])
                                 ->first();
        $ordem = $ordem->MAX;
        
        /**********************************************************************/
        
        //Cria novo registro na tabela
        $new_moviment = $this->Moviments->newEntity();
        
        $new_moviment->parameters_id     = $moviment->parameters_id;
        $new_moviment->ordem             = $ordem + 1;
        $new_moviment->banks_id          = $moviment->banks_id;
        $new_moviment->boxes_id          = $moviment->boxes_id;
        $new_moviment->cards_id          = $moviment->cards_id;
        $new_moviment->plannings_id      = $moviment->plannings_id;
        $new_moviment->costs_id          = $moviment->costs_id;
        $new_moviment->event_types_id    = $moviment->event_types_id;
        $new_moviment->providers_id      = $moviment->providers_id;
        $new_moviment->customers_id      = $moviment->customers_id;
        $new_moviment->document_types_id = $moviment->document_types_id;
        $new_moviment->account_plans_id  = $moviment->account_plans_id;
        $new_moviment->coins_id          = $moviment->coins_id;
        $new_moviment->documento         = $moviment->documento;
        $new_moviment->creditodebito     = $moviment->creditodebito;
        $new_moviment->data              = $moviment->data;
        $new_moviment->vencimento        = $moviment->vencimento;
        $new_moviment->dtbaixa           = $moviment->dtbaixa;
        $new_moviment->valor             = $moviment->valorbaixa;//Registro parcial no valor que está sendo pago
        $new_moviment->valorbaixa        = $moviment->valorbaixa;
        $new_moviment->historico         = $moviment->historico;
        $new_moviment->contabil          = $moviment->contabil;
        $new_moviment->status            = 'O'; //Baixa parcial
        $new_moviment->username          = $_SESSION['Auth']['User']['name']; //Nome do usuário do lançamento
        $new_moviment->userbaixa         = $_SESSION['Auth']['User']['name']; //Nome do usuário do lançamento
        $new_moviment->obs               = $moviment->obs;
        //$new_moviment->valorpago         = $moviment->valorpago;
        //$new_moviment->parcelas          = $moviment->parcelas;
        //$new_moviment->dd                = $moviment->dd;
        //$new_moviment->parcial           = $moviment->parcial;
        //$new_moviment->radio_bc          = $moviment->radio_bc;
        
        //SALVA REGISTRO
        if ($this->Moviments->save($new_moviment)) {
            
            //Não contábil: Não movimenta o saldo do banco/caixa e pode ser filtrado nos relatórios.
            if ($new_moviment->contabil == 'S') {
                $this->GeneralBalance->balance($new_moviment); // ATUALIZAÇÃO DOS SALDOS
            }
            
            /******************************************************************/
            
            // REGISTRA MOVIMENTOS BANCÁRIOS E CAIXAS
            $this->bankBoxCheck($new_moviment, $new_moviment->id);
            
            /******************************************************************/
            
            // ADICIONA A TABELA DE MOVIMENTOS VINCULADOS
            $this->addMovimentMerged($moviment, $new_moviment->id, $new_moviment->parameters_id);
            
            /******************************************************************/
            
            return true;
            
        }//if ($this->Moviments->save($new_moviment))
        
        //Alerta de erro
        $message = 'MovimentsFunctionsComponent->addPartial';
        $this->Error->registerError($new_moviment, $message, true);

        return false;
    }
    
    public function lowVinculados($object, $parameters_id, $cancel = null)
    {
        //Acessa a tabela MovimentMerged
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        //Consulta pagamentos vinculados pelo ID
        $movimentMergeds = $this->MovimentMergeds->findByParametersId($parameters_id)
                                                 ->select(['MovimentMergeds.id', 'MovimentMergeds.parameters_id', 'MovimentMergeds.moviments_id', 'MovimentMergeds.moviments_merged',
                                                           'Moviments.id', 'Moviment_Mergeds.id', 'Moviment_Mergeds.ordem', 'Moviment_Mergeds.valor', 'Moviment_Mergeds.valorbaixa', 
                                                           'Moviment_Mergeds.id', 'Moviment_Mergeds.data', 'Moviment_Mergeds.dtbaixa', 'Moviment_Mergeds.valor', 'Moviment_Mergeds.vencimento', 'Moviment_Mergeds.status',
                                                           'Moviment_Mergeds.documento', 'Moviment_Mergeds.historico'
                                                          ])
                                                 ->where(['MovimentMergeds.moviments_id' => $object->id])
                                                 ->join(['Moviments' => ['table'      => 'Moviments',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'MovimentMergeds.moviments_id = Moviments.id'
                                                                        ],
                                                         'Moviment_Mergeds' => ['table'      => 'Moviments',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'MovimentMergeds.moviments_merged = Moviment_Mergeds.id'
                                                                              ]
                                                        ]);
        
        //Se houver pagamentos vinculados, estes serão atualizados com as informações da baixa.
        if (!empty($movimentMergeds->toArray())) {
            
            foreach ($movimentMergeds as $merged):
                
                //Altera lançamento para aberto
                if (!$cancel) {
                    
                    if (!isset($merged->Moviment_Mergeds['dtbaixa'])) { 
                        
                        //OS PAGAMENTO VINCULADOS POSSUEM APENAS UM BOLETO
                        $pre_save = ['id'             => $merged->Moviment_Mergeds['id'],
                                     'dtbaixa'        => $object->dtbaixa,
                                     'valorbaixa'     => $merged->Moviment_Mergeds['valor'],
                                     'cheque'         => $object->cheque,
                                     'nominal'        => $object->nominal,
                                     'emissaoch'      => $object->emissaoch,
                                     'userbaixa'      => $object->userbaixa,
                                     'boxes_id'       => $object->boxes_id,
                                     'banks_id'       => $object->banks_id,
                                     'event_types_id' => $object->event_types_id,
                                     'obs'            => $object->obs 
                                    ];
                        
                    } else {
                        
                        //OS PAGAMENTOS VINCULADOS SÃO BAIXAS PARCIAIS, NÃO FAÇA NADA.
                        $pre_save = null;
                        
                    }//if (!isset($merged->Moviment_Mergeds['dtbaixa']))
                    
                } else {
                    
                    if ($merged->Moviment_Mergeds['status'] == 'V') { //REGISTROS AGRUPADOS
                        
                        $pre_save = ['id'             => $merged->Moviment_Mergeds['id'],
                                     'dtbaixa'        => '',
                                     'valorbaixa'     => '',
                                     'cheque'         => null,
                                     'nominal'        => '',
                                     'emissaoch'      => '',
                                     'userbaixa'      => '',
                                     'boxes_id'       => '',
                                     'banks_id'       => '',
                                     'event_types_id' => ''
                                    ];
                        
                    } elseif ($merged->Moviment_Mergeds['status'] == 'O') {
                        
                        //OS PAGAMENTOS VINCULADOS SÃO BAIXAS PARCIAIS, NÃO FAÇA NADA.
                        $pre_save = null;
                        
                    } //elseif ($merged->Moviment_Mergeds['status'] == 'O')
                    
                }//if (!$cancel)
                
                //Verifica se foi necessário algum tratamento nos dados do objeto
                if (!empty($pre_save)) {
                    
                    //Cria entidade
                    $moviment = $this->Moviments->patchEntity($object, $pre_save);
                    
                } else {
                    
                    $moviment = $object;
                    
                }//if (!empty($pre_save))
                
                //Salva registro
                if (!$this->Moviments->save($moviment)) { 

                    //Alerta de erro
                    $message = 'MovimentsFunctionsComponent->lowVinculados';
                    $this->Error->registerError($moviment, $message, true);

                }//if (!$this->Moviments->save($moviment))
                
            endforeach;
            
        }//if (!empty($movimentMergeds->toArray()))
        
    }
    
    public function vinculaConsulta($moviments_id, $parameters_id)
    {
        //Acessa a tabela MovimentMerged
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        //Consulta a tabela de vínculo
        $mergeds = $this->MovimentMergeds->findByParametersId($parameters_id)
                                         ->where(['MovimentMergeds.moviments_id' => $moviments_id]);
        $total = 0;
        
        foreach($mergeds as $merged):
            
            //Consulta os movimentos vinculados ao principal
            $moviments = $this->Moviments->findByIdAndParametersId($merged->moviments_merged, $parameters_id)
                                         ->select(['Moviments.id', 'Moviments.valor']);
            
            foreach($moviments as $moviment):
                
                //Soma o valor dos movimentos vinculados
                $total += $moviment->valor;
                
            endforeach;
            
        endforeach;
        
        /**********************************************************************/
        
        //RETORNA O VALOR TOTAL DOS MOVIMENTOS VINCULADOS
        return $total;
    }
    
    public function vinculaPagamentos($vinculapgtos, $moviments_id, $parameters_id)
    {
        //Acessa a tabela MovimentMerged
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        //Desvincula todos os vinculados e limpa tabela de vínculo
        $this->desvinculaPagamentos($moviments_id, $parameters_id);
        
        /**********************************************************************/
        
        //Lista os itens marcados para vínculo        
        foreach ($vinculapgtos as $vinculapgto):
            
            //Consulta lançamentos marcados para vínculo
            $moviments = $this->Moviments->findByIdAndParametersId($vinculapgto, $parameters_id)
                                         ->select(['Moviments.id', 'Moviments.ordem', 'Moviments.status']);
            
            //Vincula movimentos selecionados
            foreach($moviments as $moviment):
                
                //Modifica o status dos movimentos vinculados
                $moviment->status = 'V';
                
                if (!$this->Moviments->save($moviment)) {

                    //Alerta de erro
                    $message = 'MovimentsFunctionsComponent->vinculaPagamentos, Moviments';
                    $this->Error->registerError($moviment, $message, true);

                }//if (!$this->Moviments->save($moviment))
                
            endforeach;
            
            /******************************************************************/
            
            //CRIA NOVOS REGISTROS NA TABELA DE MOVIMENTOS VINCULADOS
            $movimentMerged = $this->MovimentMergeds->newEntity();
            
            //Armazena vínculo na tabela de vínculos
            $movimentMerged->moviments_id     = $moviments_id; //Movimento principal
            $movimentMerged->moviments_merged = $vinculapgto;  //Movimento vinculado
            $movimentMerged->parameters_id    = $parameters_id;//Perfil
            
            //SALVA REGISTROS
            if (!$this->MovimentMergeds->save($movimentMerged)) {

                //Alerta de erro
                $message = 'MovimentsFunctionsComponent->vinculaPagamentos, MovimentMergeds';
                $this->Error->registerError($movimentMerged, $message, true);

            }//if (!$this->MovimentMergeds->save($movimentMerged))
            
        endforeach;
    }
    
    public function desvinculaPagamentos($moviments_id, $parameters_id)
    {
        //Acessa a tabela MovimentMerged
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
        /**********************************************************************/
        
        //Consulta pagamentos vinculados pelo ID
        $movimentMergeds = $this->MovimentMergeds->findByParametersId($parameters_id)
                                                 ->where(['MovimentMergeds.moviments_id' => $moviments_id]);
        
        if (!empty($movimentMergeds->toArray())) {
            
            //Desvincula todos os vinculados
            foreach ($movimentMergeds as $movimentMerged):
                
                $moviments = $this->Moviments->findByIdAndParametersId($movimentMerged->moviments_merged, $parameters_id)
                                             ->select(['Moviments.id', 'Moviments.status']);
                
                foreach($moviments as $moviment):
                    
                    //Modifica o status dos movimentos vinculados ao registro
                    $moviment->status = 'A';
                    
                    if (!$this->Moviments->save($moviment)) {

                        //Alerta de erro
                        $message = 'MovimentsFunctionsComponent->desvinculaPagamentos';
                        $this->Error->registerError($moviment, $message, true);

                    }//if (!$this->Moviments->save($moviment))
                    
                endforeach;
                
            endforeach;
            
            /******************************************************************/
            
            //limpa tabela de vínculo
            $conditions = ['MovimentMergeds.moviments_id'  => $moviments_id,
                           'MovimentMergeds.parameters_id' => $parameters_id
                          ];
            
            $this->MovimentMergeds->deleteAll($conditions, false);
            
        }//if (!empty($movimentMergeds->toArray()))
            
    }
    
    public function atualizaMovimentos($object)
    {
        $this->Moviments      = TableRegistry::get('Moviments');
        $this->MovimentBanks  = TableRegistry::get('MovimentBanks');
        $this->MovimentBoxes  = TableRegistry::get('MovimentBoxes');
        $this->MovimentChecks = TableRegistry::get('MovimentChecks');
        
        /**********************************************************************/

        //Define as variáveis
        $join  = [];
        $where = [];

        //Identifica a tabela de origem
        $this->Model = $object->source();
        
        /**********************************************************************/
        
        //Define campos para consulta
        if ($this->Model == 'Moviments') {
            $table_id = 'moviments_id';
        } elseif ($this->Model == 'Transfers') {
            $table_id = 'transfers_id';
        } elseif ($this->Model == 'MovimentBanks') {
            $join      = ['MovimentBanks' => ['table'      => 'moviment_banks',
                                              'type'       => 'LEFT',
                                              'conditions' => 'Moviments.id = MovimentBanks.moviments_id'
                                             ],
                         ];
            $where[]   = 'MovimentBanks.id = '.$object->id;
            $where[]   = 'Moviments.parameters_id = '.$object->parameters_id;
        } elseif ($this->Model == 'MovimentBoxes') {
            $join      = ['MovimentBoxes' => ['table'      => 'moviment_boxes',
                                              'type'       => 'LEFT',
                                              'conditions' => 'Moviments.id = MovimentBoxes.moviments_id'
                                             ],
                         ];
            $where[]   = 'MovimentBoxes.id = '.$object->id;
            $where[]   = 'Moviments.parameters_id = '.$object->parameters_id;
        } elseif ($this->Model == 'MovimentChecks') {
            $join      = ['MovimentChecks' => ['table'      => 'moviment_checks',
                                               'type'       => 'LEFT',
                                               'conditions' => 'Moviments.id = MovimentChecks.moviments_id'
                                              ],
                         ];
            $where[]   = 'MovimentChecks.id = '.$object->id;
            $where[]   = 'Moviments.parameters_id = '.$object->parameters_id;
        }//elseif ($this->Model == 'MovimentChecks')
        
        /**********************************************************************/
        //Ao atualizar os lançamentos do CPR ou Transferências, atualize os movimentos de bancos, caixas e cheques
        if ($this->Model == 'Moviments' || $this->Model == 'Transfers') {

            $MovimentBanks = $this->MovimentBanks->find('all')
                                                 ->where(['MovimentBanks.' . $table_id  => $object->id,
                                                          'MovimentBanks.parameters_id' => $object->parameters_id
                                                         ]);
            
            if (!empty($MovimentBanks->toArray())) {
                
                foreach($MovimentBanks as $MovimentBank):
                    
                    if ($object->documento) {
                        $MovimentBank->documento         = $object->documento;
                    }
                    if ($object->vencimento) {
                        $MovimentBank->vencimento        = $object->vencimento;
                    }
                    if ($object->document_types_id) {
                        $MovimentBank->document_types_id = $object->document_types_id;
                    }
                    if ($object->event_types_id) {
                        $MovimentBank->event_types_id    = $object->event_types_id;
                    }
                    if ($object->account_plans_id) {
                        $MovimentBank->account_plans_id  = $object->account_plans_id;
                    }
                    if ($object->costs_id) {
                        $MovimentBank->costs_id          = $object->costs_id;
                    }
                    if ($object->providers_id) {
                        $MovimentBank->providers_id      = $object->providers_id;
                    }
                    if ($object->customers_id) {
                        $MovimentBank->customers_id      = $object->customers_id;
                    }
                    
                    $MovimentBank->historico             = $object->historico;
                    $MovimentBank->obs                   = $object->obs;
                    
                    if (!$this->MovimentBanks->save($MovimentBank)) {

                        //Alerta de erro
                        $message = 'MovimentsFunctionsComponent->atualizaMovimentos, MovimentBanks';
                        $this->Error->registerError($movimentBank, $message, true);

                    }//if (!$this->MovimentBanks->save($MovimentBank))
                    
                endforeach;
                
            }//if (!empty($MovimentBanks->toArray()))
            
            /******************************************************************/
            
            $MovimentBoxes = $this->MovimentBoxes->find('all')
                                                 ->where(['MovimentBoxes.' . $table_id  => $object->id,
                                                          'MovimentBoxes.parameters_id' => $object->parameters_id
                                                         ]);
            
            if (!empty($MovimentBoxes->toArray())) {
                
                foreach($MovimentBoxes as $MovimentBox):
                    
                    if ($object->documento) {
                        $MovimentBox->documento         = $object->documento;
                    }
                    if ($object->vencimento) {
                        $MovimentBox->vencimento        = $object->vencimento;
                    }
                    if ($object->document_types_id) {
                        $MovimentBox->document_types_id = $object->document_types_id;
                    }
                    if ($object->event_types_id) {
                        $MovimentBox->event_types_id    = $object->event_types_id;
                    }
                    if ($object->account_plans_id) {
                        $MovimentBox->account_plans_id  = $object->account_plans_id;
                    }
                    if ($object->costs_id) {
                        $MovimentBox->costs_id          = $object->costs_id;
                    }
                    if ($object->providers_id) {
                        $MovimentBox->providers_id      = $object->providers_id;
                    }
                    if ($object->customers_id) {
                        $MovimentBox->customers_id      = $object->customers_id;
                    }
                    
                    $MovimentBox->historico             = $object->historico;
                    $MovimentBox->obs                   = $object->obs;
                    
                    if (!$this->MovimentBoxes->save($MovimentBox)) {

                        //Alerta de erro
                        $message = 'MovimentsFunctionsComponent->atualizaMovimentos, MovimentBoxes';
                        $this->Error->registerError($movimentBox, $message, true);

                    }//if (!$this->MovimentBoxes->save($MovimentBox))
                    
                endforeach;
                
            }//if (!empty($MovimentBoxes->toArray()))
            
            /******************************************************************/
            
            $MovimentChecks = $this->MovimentChecks->find('all')
                                                   ->where(['MovimentChecks.' . $table_id  => $object->id,
                                                            'MovimentChecks.parameters_id' => $object->parameters_id
                                                           ]);
            
            if (!empty($MovimentChecks->toArray())) {
                
                foreach($MovimentChecks as $MovimentCheck):
                    
                    if ($object->documento) {
                        $MovimentCheck->documento         = $object->documento;
                    }
                    if ($object->event_types_id) {
                        $MovimentCheck->event_types_id    = $object->event_types_id;
                    }
                    if ($object->account_plans_id) {
                        $MovimentCheck->account_plans_id  = $object->account_plans_id;
                    }
                    if ($object->costs_id) {
                        $MovimentCheck->costs_id          = $object->costs_id;
                    }
                    if ($object->providers_id) {
                        $MovimentCheck->providers_id      = $object->providers_id;
                    }
                    
                    $MovimentCheck->historico             = $object->historico;
                    $MovimentCheck->obs                   = $object->obs;
                    
                    if (!$this->MovimentChecks->save($MovimentCheck)) {

                        //Alerta de erro
                        $message = 'MovimentsFunctionsComponent->atualizaMovimentos, MovimentCheck';
                        $this->Error->registerError($MovimentCheck, $message, true);

                    }//if (!$this->MovimentChecks->save($MovimentCheck))
                    
                endforeach;
                
            }//if (!empty($MovimentChecks->toArray()))

        }//if ($this->Model == 'Moviments' || $this->Model == 'Transfers')
        
        /**********************************************************************/
        //Ao atualizar os movimentos de bancos, caixas e cheques, atualize os lançamentos do CPR
        if ($this->Model != 'Transfers' && $this->Model != 'Moviments') {

            $Moviments = $this->Moviments->find('all')
                                         ->join($join)
                                         ->where($where);

            if (!empty($Moviments->toArray())) {

                foreach($Moviments as $Moviment):
                    
                    if ($object->documento) {
                        $Moviment->documento         = $object->documento;
                    }
                    if ($object->document_types_id) {
                        $Moviment->document_types_id = $object->document_types_id;
                    }
                    if ($object->event_types_id) {
                        $Moviment->event_types_id    = $object->event_types_id;
                    }
                    if ($object->account_plans_id) {
                        $Moviment->account_plans_id  = $object->account_plans_id;
                    }
                    if ($object->costs_id) {
                        $Moviment->costs_id          = $object->costs_id;
                    }
                    if ($object->providers_id) {
                        $Moviment->providers_id      = $object->providers_id;
                    }
                    if ($object->customers_id) {
                        $Moviment->customers_id      = $object->customers_id;
                    }
                    
                    $Moviment->historico             = $object->historico;
                    $Moviment->vencimento            = $object->vencimento;
                    $Moviment->obs                   = $object->obs;
                    
                    if (!$this->Moviments->save($Moviment)) {

                        //Alerta de erro
                        $message = 'MovimentsFunctionsComponent->atualizaMovimentos, Moviments';
                        $this->Error->registerError($Moviment, $message, true);
                        
                    }//if (!$this->Moviments->save($Moviment))
                    
                endforeach;

            }//if (!empty($Moviments->toArray()))

            //NÃO ALTERAR AS TRANSFERÊNCIAS, JÁ QUE SÃO DOIS REGISTROS VINCULADOS.

        }//if ($this->Model != 'Transfers' && $this->Model != 'Moviments')
        
    }
    
    public function consultaMovimentos($moviments_id, $parameters_id)
    {
        $this->MovimentBanks  = TableRegistry::get('MovimentBanks');
        $this->MovimentBoxes  = TableRegistry::get('MovimentBoxes');
        $this->MovimentChecks = TableRegistry::get('MovimentChecks');
        
        /**********************************************************************/
        
        $movimentos = [];
        
        /**********************************************************************/
        
        $MovimentBanks = $this->MovimentBanks->find('all')
                                             ->where(['MovimentBanks.moviments_id'  => $moviments_id,
                                                      'MovimentBanks.parameters_id' => $parameters_id
                                                     ]);
        
        if (!empty($MovimentBanks->toArray())) {
            
            $movimentos[] = $MovimentBanks;
            
        }//if (!empty($MovimentBanks->toArray()))
        
        /**********************************************************************/
        
        $MovimentBoxes = $this->MovimentBoxes->find('all')
                                             ->where(['MovimentBoxes.moviments_id'  => $moviments_id,
                                                      'MovimentBoxes.parameters_id' => $parameters_id
                                                     ]);
        
        if (!empty($MovimentBoxes->toArray())) {
            
            $movimentos[] = $MovimentBoxes;
            
        }//if (!empty($MovimentBoxes->toArray()))
        
        /**********************************************************************/
        
        $MovimentChecks = $this->MovimentChecks->find('all')
                                               ->where(['MovimentChecks.moviments_id'  => $moviments_id,
                                                        'MovimentChecks.parameters_id' => $parameters_id
                                                       ]);
        
        if (!empty($MovimentChecks->toArray())) {
            
            $movimentos[] = $MovimentChecks;
            
        }//if (!empty($MovimentChecks->toArray()))
        
        /**********************************************************************/
        
        return $movimentos;
    }
    
    public function consultaPlanejamentos($plannings_id, $parameters_id)
    {
        $pgto = null;
        
        $moviments = $this->Moviments->findByParametersId($parameters_id)
                                     ->where(['Moviments.plannings_id' => $plannings_id]);
        
        if (!empty($moviments)) {
            
            foreach($moviments as $moviment):
                
                if (!empty($moviment->dtbaixa)) { 
                    
                    if (!empty($pgto)) { $pgto .= ', '; }
                    $pgto .= str_pad($moviment->ordem, 6, '0', STR_PAD_LEFT);
                    
                }//if (!empty($moviment->dtbaixa))
                
            endforeach;
            
        }//if (!empty($moviments))
        
        return $pgto;
        
    }
    
    public function cancelDependency($requestData = null, $parameters_id = null)
    {
        //CANCELA MOVIMENTOS DE BANCO
        if (!empty($requestData['banks_id'])) {
            $this->RegisterMoviments->deleteMovimentBank($requestData, $parameters_id);
        }
        //CANCELA MOVIMENTOS DE CAIXA
        if (!empty($requestData['boxes_id'])) {
            $this->RegisterMoviments->deleteMovimentBox($requestData, $parameters_id);
        }
        //CANCELA CHEQUES
        if (!empty($requestData['cheque'])) {
            $this->RegisterMoviments->deleteMovimentCheck($requestData, $parameters_id);
        }
    }
    
    public function deleteMerged($id, $parameters_id)
    {
        //Acessa a tabela MovimentMerged
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        
        //Deleta pagamentos vinculados pelo ID
        $conditions = ['OR' => ['MovimentMergeds.moviments_id'     => $id,
                                'MovimentMergeds.moviments_merged' => $id],
                       'MovimentMergeds.parameters_id' => $parameters_id
                      ];
        
        return $this->MovimentMergeds->deleteAll($conditions, false);
    }
    
    public function deleteMovimentCards($id, $parameters_id)
    {
        //Acessa a tabela moviments_moviment_cards
        $this->MovimentsMovimentCards = TableRegistry::get('MovimentsMovimentCards');
        
        $conditions = ['MovimentsMovimentCards.parameters_id' => $parameters_id,
                       'MovimentsMovimentCards.moviments_id'  => $id
                      ];
        
        return $this->MovimentsMovimentCards->deleteAll($conditions);
    }
    
    public function cashFlowMoviment($conditions, $ordenacao, $parameters_id)
    {
        $this->MovimentMergeds    = TableRegistry::get('MovimentMergeds');
        $this->MovimentRecurrents = TableRegistry::get('MovimentRecurrents');
        
        /**********************************************************************/
        
        $fields = ['Moviments.id', 'Moviments.parameters_id', 'Moviments.ordem', 'Moviments.banks_id',
                   'Moviments.boxes_id', 'Moviments.cards_id', 'Moviments.costs_id', 'Moviments.event_types_id',
                   'Moviments.providers_id', 'Moviments.customers_id', 'Moviments.document_types_id', 
                   'Moviments.account_plans_id', 'Moviments.data', 'Moviments.vencimento', 'Moviments.dtbaixa',
                   'Moviments.historico', 'Moviments.valor', 'Moviments.valorbaixa', 'Moviments.documento',
                   'Moviments.cheque', 'Moviments.nominal', 'Moviments.emissaoch', 'Moviments.creditodebito',
                   'Moviments.contabil', 'Moviments.status',
                   'Banks.id', 'Banks.title',
                   'Boxes.id', 'Boxes.title',
                   'Cards.id', 'Cards.title',
                   'Costs.id', 'Costs.title',
                   'EventTypes.id', 'EventTypes.title',
                   'Providers.id', 'Providers.title',
                   'Customers.id', 'Customers.title',
                   'DocumentTypes.id', 'DocumentTypes.title',
                   'AccountPlans.id', 'AccountPlans.title', 'AccountPlans.classification', 'AccountPlans.parameters_id',
                   'Parameters.id', 'Parameters.razao'
                  ];
        
        /**********************************************************************/
        
        $moviments = $this->Moviments->find('all')
                                     ->select($fields)
                                     ->contain(['Banks', 'Boxes', 'Cards', 'Costs', 'EventTypes', 
                                                'Providers', 'Customers', 'DocumentTypes', 
                                                'AccountPlans', 'Parameters'
                                               ])
                                     ->where($conditions)
                                     ->order(['Moviments.'.$ordenacao]);
        
        /**********************************************************************/
        
        //$this->set('moviments', $moviments);
        
        /**********************************************************************/
        
        //CONSULTA RECORRENTE
        if (!empty($moviments->toArray())) {
            foreach($moviments as $moviment):
                $list_of_moviments[] = $moviment['id'];
            endforeach;
        }//if (!empty($moviments->toArray()))
        
        /**********************************************************************/
        
        //MOVIMENTOS RECORRENTES       
        $fields = ['Moviments.id', 'Moviments.parameters_id', 'Moviments.ordem', 'Moviments.banks_id', 
                   'Moviments.boxes_id', 'Moviments.cards_id', 'Moviments.costs_id', 'Moviments.event_types_id', 
                   'Moviments.providers_id', 'Moviments.customers_id', 'Moviments.document_types_id', 
                   'Moviments.account_plans_id', 'Moviments.data', 'Moviments.vencimento', 
                   'Moviments.dtbaixa', 'Moviments.historico', 'Moviments.valor', 'Moviments.valorbaixa', 
                   'Moviments.documento', 'Moviments.cheque', 'Moviments.nominal', 'Moviments.emissaoch', 
                   'Moviments.creditodebito', 'Moviments.contabil', 'Moviments.status', 
                   'Banks.id', 'Banks.title',
                   'Boxes.id', 'Boxes.title',
                   'Cards.id', 'Cards.title',
                   'Costs.id', 'Costs.title',
                   'EventTypes.id', 'EventTypes.title',
                   'Providers.id', 'Providers.title',
                   'Customers.id', 'Customers.title',
                   'DocumentTypes.id', 'DocumentTypes.title',
                   'AccountPlans.id', 'AccountPlans.title', 'AccountPlans.classification', 'AccountPlans.parameters_id', 
                   'Parameters.id', 'Parameters.razao'
                  ];
        
        $movimentRecurrents = $this->MovimentRecurrents->find('all')
                                                       ->select($fields)
                                                       ->where(['MovimentRecurrents.parameters_id'   => $parameters_id,
                                                                'MovimentRecurrents.moviments_id IN' => $list_of_moviments
                                                               ])
                                                       ->join(['Moviments' => ['table'      => 'Moviments',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'Moviments.id = MovimentRecurrents.moviments_id'
                                                                              ],
                                                               'MovimentsCards' => ['table'      => 'Moviments',
                                                                                    'type'       => 'LEFT',
                                                                                    'conditions' => 'MovimentsCards.id = MovimentRecurrents.moviment_cards_id'
                                                                                   ],
                                                               'Cards' => ['table'      => 'Cards',
                                                                           'type'       => 'LEFT',
                                                                           'conditions' => 'Cards.id = Moviments.cards_id'
                                                                          ],
                                                               'Banks' => ['table'      => 'Banks',
                                                                           'type'       => 'LEFT',
                                                                           'conditions' => 'Banks.id = Moviments.banks_id'
                                                                          ],
                                                               'Boxes' => ['table'      => 'Boxes',
                                                                           'type'       => 'LEFT',
                                                                           'conditions' => 'Boxes.id = Moviments.boxes_id'
                                                                          ],
                                                               'AccountPlans' => ['table'      => 'account_plans',
                                                                                  'type'       => 'LEFT',
                                                                                  'conditions' => 'AccountPlans.id = Moviments.account_plans_id'
                                                                                 ],
                                                               'Costs' => ['table'      => 'Costs',
                                                                           'type'       => 'LEFT',
                                                                           'conditions' => 'Costs.id = Moviments.costs_id'
                                                                          ],
                                                               'EventTypes' => ['table'      => 'event_types',
                                                                                'type'       => 'LEFT',
                                                                                'conditions' => 'EventTypes.id = Moviments.event_types_id'
                                                                               ],
                                                               'DocumentTypes' => ['table'      => 'document_types',
                                                                                   'type'       => 'LEFT',
                                                                                   'conditions' => 'DocumentTypes.id = Moviments.document_types_id'
                                                                                  ],
                                                               'Customers' => ['table'      => 'Customers',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'Customers.id = Moviments.customers_id'
                                                                              ],
                                                               'Providers' => ['table'      => 'Providers',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'Providers.id = Moviments.providers_id'
                                                                              ],
                                                               'Parameters' => ['table'      => 'Parameters',
                                                                                'type'       => 'LEFT',
                                                                                'conditions' => 'Parameters.id = Moviments.parameters_id'
                                                                               ]
                                                              ]);
        //$this->set('movimentRecurrents', $movimentRecurrents);
        
        /**********************************************************************/
            
        //MOVIMENTOS VINCULADOS
        //$this->set('movimentMergeds', $this->MovimentMergeds->findByParametersId($parameters_id));
        
        /**********************************************************************/
        
        $cashFlowMoviment = ['moviments'          => $moviments,
                             'movimentRecurrents' => $movimentRecurrents
                            ];
        
        return $cashFlowMoviment;
    }
    
    public function cashFlowBank($banks_id, $conditions, $ordenacao, $parameters_id)
    {
        $this->Banks         = TableRegistry::get('Banks');
        $this->MovimentBanks = TableRegistry::get('MovimentBanks');
        
        /**********************************************************************/
        
        $return = [];
        
        /**********************************************************************/
        
        $fields = ['MovimentBanks.id',
                   'MovimentBanks.ordem',
                   'MovimentBanks.parameters_id',
                   'MovimentBanks.banks_id',
                   'MovimentBanks.costs_id',
                   'MovimentBanks.event_types_id',
                   'MovimentBanks.moviment_checks_id',
                   'MovimentBanks.transfers_id',
                   'MovimentBanks.moviments_id',
                   'MovimentBanks.providers_id',
                   'MovimentBanks.customers_id',
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
                   'MovimentChecks.id', 'MovimentChecks.historico', 'MovimentChecks.ordem',
                   'Transfers.id', 'Transfers.historico', 'Transfers.ordem',
                   'Moviments.id', 'Moviments.historico', 'Moviments.ordem',
                   'Banks.id', 'Banks.title',
                   'Costs.id', 'Costs.title',
                   'EventTypes.id', 'EventTypes.title',
                   'Providers.id', 'Providers.title',
                   'Customers.id', 'Customers.title',
                   'DocumentTypes.id', 'DocumentTypes.title',
                   'AccountPlans.id', 'AccountPlans.title', 'AccountPlans.classification', 'AccountPlans.parameters_id', 
                   'Parameters.id', 'Parameters.razao'
                  ];
        
        /**********************************************************************/
        
        //SELEÇÃO DE MÚLTIPLOS BANCOS
        if (!empty($banks_id)) {
            
            foreach($banks_id as $value):
                $list_banks[] = $value;
            endforeach;
            
            $conditions[] = 'MovimentBanks.banks_id IN (' . implode(', ', $list_banks) . ')';
            
        }//if (!empty($banks_id))
        
        /**********************************************************************/
        
        $movimentBanks = $this->MovimentBanks->find('all')
                                             ->select($fields)
                                             ->where($conditions)
                                             ->join(['MovimentChecks' => ['table'      => 'moviment_checks',
                                                                          'type'       => 'LEFT',
                                                                          'conditions' => 'MovimentChecks.id = MovimentBanks.moviment_checks_id'
                                                                         ],
                                                     'Moviments' => ['table'      => 'Moviments',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'Moviments.id = MovimentBanks.moviments_id'
                                                                    ],
                                                     'Transfers' => ['table'      => 'Transfers',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'Transfers.id = MovimentBanks.transfers_id'
                                                                    ],
                                                     'Banks' => ['table'      => 'Banks',
                                                                 'type'       => 'LEFT',
                                                                 'conditions' => 'Banks.id = MovimentBanks.banks_id'
                                                                ],
                                                     'AccountPlans' => ['table'      => 'account_plans',
                                                                        'type'       => 'LEFT',
                                                                        'conditions' => 'AccountPlans.id = MovimentBanks.account_plans_id'
                                                                       ],
                                                     'Costs' => ['table'      => 'Costs',
                                                                 'type'       => 'LEFT',
                                                                 'conditions' => 'Costs.id = MovimentBanks.costs_id'
                                                                ],
                                                     'EventTypes' => ['table'      => 'event_types',
                                                                      'type'       => 'LEFT',
                                                                      'conditions' => 'EventTypes.id = MovimentBanks.event_types_id'
                                                                     ],
                                                     'DocumentTypes' => ['table'      => 'document_types',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'DocumentTypes.id = MovimentBanks.document_types_id'
                                                                        ],
                                                     'Customers' => ['table'      => 'Customers',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'Customers.id = MovimentBanks.customers_id'
                                                                    ],
                                                     'Providers' => ['table'      => 'Providers',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'Providers.id = MovimentBanks.providers_id'
                                                                    ],
                                                     'Parameters' => ['table'      => 'Parameters',
                                                                      'type'       => 'LEFT',
                                                                      'conditions' => 'Parameters.id = MovimentBanks.parameters_id'
                                                                     ]
                                                    ])
                                             ->order(['MovimentBanks.'.$ordenacao]);
                                             //->order(['MovimentBanks.dtbaixa']);

        /**********************************************************************/
        
        //$this->set('movimentBanks', $movimentBanks);
        
        /**********************************************************************/
        
        //IDENTIFICA OS NOMES DOS BANCOS
        $banks = $this->Banks->findByParametersId($parameters_id)
                             ->select(['Banks.id', 'Banks.title'])
                             ->where(['Banks.id IN' => $list_banks]);
        
        foreach($banks as $bank):
            $return[$bank->id] = $bank->title;
        endforeach;
        
        /**********************************************************************/
        
        //$this->set('banks', $return);
        $cashFlowBank = ['banks'         => $return,
                         'movimentBanks' => $movimentBanks
                        ];
        
        return $cashFlowBank;
    }
    
    public function cashFlowBox($boxes_id, $conditions, $ordenacao, $parameters_id)
    {
        $this->Boxes         = TableRegistry::get('Boxes');
        $this->MovimentBoxes = TableRegistry::get('MovimentBoxes');
        
        /**********************************************************************/
        
        $return = [];
        
        /**********************************************************************/
        
        $fields = ['MovimentBoxes.id',
                   'MovimentBoxes.ordem',
                   'MovimentBoxes.boxes_id',
                   'MovimentBoxes.costs_id',
                   'MovimentBoxes.event_types_id',
                   'MovimentBoxes.moviment_checks_id',
                   'MovimentBoxes.transfers_id',
                   'MovimentBoxes.moviments_id',
                   'MovimentBoxes.providers_id',
                   'MovimentBoxes.customers_id',
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
                   'MovimentChecks.id', 'MovimentChecks.historico', 'MovimentChecks.ordem',
                   'Transfers.id', 'Transfers.historico', 'Transfers.ordem',
                   'Moviments.id', 'Moviments.historico', 'Moviments.ordem',
                   'Boxes.id', 'Boxes.title',
                   'Costs.id', 'Costs.title',
                   'EventTypes.id', 'EventTypes.title',
                   'Providers.id', 'Providers.title',
                   'Customers.id', 'Customers.title',
                   'DocumentTypes.id', 'DocumentTypes.title',
                   'AccountPlans.id', 'AccountPlans.title', 'AccountPlans.classification', 'AccountPlans.parameters_id', 
                   'Parameters.id', 'Parameters.razao'
                  ];
        
        /**********************************************************************/
        
        //SELEÇÃO DE MÚLTIPLOS CAIXAS
        if (!empty($boxes_id)) {
            
            foreach($boxes_id as $value):
                $list_of_boxes[] = $value;
            endforeach;
            
            $conditions[] = 'MovimentBoxes.boxes_id IN (' . implode(', ', $list_of_boxes) . ')';
            
        }//if (!empty($boxes_id))
        
        $movimentBoxes = $this->MovimentBoxes->find('all')
                                             ->select($fields)
                                             ->where($conditions)
                                             ->join(['MovimentChecks' => ['table'      => 'moviment_checks',
                                                                          'type'       => 'LEFT',
                                                                          'conditions' => 'MovimentChecks.id = MovimentBoxes.moviment_checks_id'
                                                                         ],
                                                     'Moviments' => ['table'      => 'Moviments',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'Moviments.id = MovimentBoxes.moviments_id'
                                                                    ],
                                                     'Transfers' => ['table'      => 'Transfers',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'Transfers.id = MovimentBoxes.transfers_id'
                                                                    ],
                                                     'Boxes' => ['table'      => 'Boxes',
                                                                 'type'       => 'LEFT',
                                                                 'conditions' => 'Boxes.id = MovimentBoxes.boxes_id'
                                                                ],
                                                     'AccountPlans' => ['table'      => 'account_plans',
                                                                        'type'       => 'LEFT',
                                                                        'conditions' => 'AccountPlans.id = MovimentBoxes.account_plans_id'
                                                                       ],
                                                     'Costs' => ['table'      => 'Costs',
                                                                 'type'       => 'LEFT',
                                                                 'conditions' => 'Costs.id = MovimentBoxes.costs_id'
                                                                ],
                                                     'DocumentTypes' => ['table'      => 'document_types',
                                                                         'type'       => 'LEFT',
                                                                         'conditions' => 'DocumentTypes.id = MovimentBoxes.document_types_id'
                                                                        ],
                                                     'EventTypes' => ['table'      => 'event_types',
                                                                      'type'       => 'LEFT',
                                                                      'conditions' => 'EventTypes.id = MovimentBoxes.event_types_id'
                                                                     ],
                                                     'Customers' => ['table'      => 'Customers',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'Customers.id = MovimentBoxes.customers_id'
                                                                    ],
                                                     'Providers' => ['table'      => 'Providers',
                                                                     'type'       => 'LEFT',
                                                                     'conditions' => 'Providers.id = MovimentBoxes.providers_id'
                                                                    ],
                                                     'Parameters' => ['table'      => 'Parameters',
                                                                      'type'       => 'LEFT',
                                                                      'conditions' => 'Parameters.id = MovimentBoxes.parameters_id'
                                                                     ]
                                                    ])
                                             ->order(['MovimentBoxes.'.$ordenacao]);
                                             //->order(['MovimentBoxes.dtbaixa']);
        
        //$this->set('movimentBoxes', $movimentBoxes);
        
        /**********************************************************************/
        
        //IDENTIFICA OS NOMES DOS Caixas
        $boxes = $this->Boxes->findByParametersId($parameters_id)
                             ->select(['Boxes.id', 'Boxes.title'])
                             ->where(['Boxes.id IN' => $list_boxes]);
        
        foreach($boxes as $box):
            $return[$box->id] = $box->title;
        endforeach;
        
        //$this->set('boxes', $return);
        
        /**********************************************************************/
        
        $cashFlowBox = ['boxes'         => $return,
                        'movimentBoxes' => $movimentBoxes
                       ];
        
        return $cashFlowBox;
        
    }
    
    public function cashFlowBalance($dtinicial, $request_banks, $request_boxes, $parameters_id)
    {
        $this->Balances = TableRegistry::get('Balances');
        
        /**********************************************************************/
        
        //PREPARA LISTA DE BANCOS E CAIXAS PARA CONSULTA
        
        $list_banks = $list_boxes = null;
        
        if (!empty($request_banks)) {
            foreach($request_banks as $bank):
                $list_banks[] = $bank;
            endforeach;
        }//if (!empty($request_banks))
        
        if (!empty($request_boxes)) {
            foreach($request_boxes as $box):
                $list_boxes[] = $box;
            endforeach;
        }//if (!empty($request_boxes))
        
        /**********************************************************************/
        
        //PERÍODO PARA CONSULTA DE SALDO ANTERIOR
        $date = date('Y-m-d', strtotime($dtinicial . '-1 day'));
        
        /**********************************************************************/
        
        if (!empty($list_banks)) {
            
            $query = $this->Balances->find('all')
                                    ->select(['banks_id' => 'DISTINCT(Balances.banks_id)', 
                                              'Balances.date', 'Balances.value'
                                             ])
                                    ->where(['Balances.parameters_id' => $parameters_id, 
                                             'Balances.banks_id IS NOT NULL',
                                             'Balances.banks_id IN' => $list_banks
                                            ])
                                    ->andWhere(function ($exp, $q) use($date) {
                                                return $exp->between('Balances.date', '2000-01-01', $date);
                                              })
                                    ->order(['Balances.date ASC']);
                                    
            $banks[] = $query->last();
            	
        }//if (!empty($list_banks))
        
        /**********************************************************************/
        
        if (!empty($list_boxes)) {
            
            $query = $this->Balances->find('all')
                                    ->select(['boxes_id' => 'DISTINCT(Balances.boxes_id)', 
                                              'Balances.date', 'Balances.value'
                                             ])
                                    ->where(['Balances.parameters_id' => $parameters_id, 
                                             'Balances.boxes_id IS NOT NULL',
                                             'Balances.boxes_id IN' => $list_boxes
                                            ])
                                    ->andWhere(function ($exp, $q) use($date) {
                                                return $exp->between('Balances.date', '2000-01-01', $date);
                                              })
                                    ->order(['Balances.date ASC']);
                                    
            $boxes[] = $query->last();
            
        }//if (!empty($list_boxes))
        
        /**********************************************************************/
        
        if (!empty($banks) && !empty($boxes)) {
            $balance = array_merge($banks, $boxes);
        }
        elseif (!empty($banks)) { $balance = $banks; }
        elseif (!empty($boxes)) { $balance = $boxes; }
        else {
            
            if (!empty($list_banks)) {
                $balance[] = ['banks_id' => $list_banks,
                              'date'     => $date,
                              'value'    => '0.00'
                             ];
            }//if (!empty($list_banks))
            
            if (!empty($list_boxes)) {
                $balance[] = ['boxes_id' => $list_boxes,
                              'date'     => $date,
                              'value'    => '0.00'
                             ];
            }//if (!empty($list_boxes))
            
            if (empty($list_banks) && empty($list_boxes)) {
                $balance[] = NULL;
            }//if (empty($list_banks) && empty($list_boxes))
            
        }//if (!empty($banks) && !empty($boxes))
        
        /**********************************************************************/
        
        //$this->set('balance', $balance);
        
        return $balance;
    }
}