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
use Cake\I18n\Number;
use Cake\Log\Log;

Number::config('pt_BR', \NumberFormatter::CURRENCY, [
    'pattern'   => '#.##,##0',
    'places'    => 2,
    'zero'      => __('0,00'),
    'decimals'  => ',',
    'thousands' => '.',
    'negative'  => '-'
    ]);

class RegisterMovimentsComponent extends Component 
{
    public function __construct()
    {
        $this->Error = new ErrorComponent();

        $this->Moviments              = TableRegistry::get('Moviments');
        $this->MovimentsMovimentCards = TableRegistry::get('MovimentsMovimentCards');
        $this->MovimentBoxes          = TableRegistry::get('MovimentBoxes');
        $this->MovimentBanks          = TableRegistry::get('MovimentBanks');
        $this->MovimentChecks         = TableRegistry::get('MovimentChecks');
        $this->DocumentTypes          = TableRegistry::get('DocumentTypes');
        $this->Costs                  = TableRegistry::get('Costs');
        $this->Cards                  = TableRegistry::get('Cards');
        
        $this->SystemFunctions        = new SystemFunctionsComponent();
    }
    
    public function moviment_add($object, $parcelas = 1, $dd = '30')
    {
        //Identifica a tabela de origem
        $this->Model = $object->source();
        
        /**********************************************************************/
        
        if ($this->Model == 'MovimentCards') {
            
            //Consulta os dados do cartão
            $card = $this->Cards->findByParametersId($object->parameters_id)
                                ->where(['Cards.id' => $object->cards_id])
                                ->first();
            
            /******************************************************************/
            
            //Consulta tipo de documento (Fatura)
            $documentType = $this->DocumentTypes->findByParametersId($object->parameters_id)
                                                ->where(['DocumentTypes.title LIKE' => 'FATURA',
                                                         'DocumentTypes.status IN' => ['A', 'T']
                                                        ])
                                                ->first();

            if (!empty($documentType)) {
                $pre_save['document_types_id'] = $documentType->id;
            }
            
            /******************************************************************/
            
            //Consulta Centro de custos / categoria
            $costs = $this->Costs->findByParametersId($object->parameters_id)
                                 ->where(['OR' => ['Costs.title LIKE' => 'CARD',
                                                   'Costs.title LIKE' => 'CARDS',
                                                   'Costs.title LIKE' => 'CARTÃO',
                                                   'Costs.title LIKE' => 'CARTÕES'
                                                  ],
                                          'Costs.status IN' => ['A', 'T']
                                         ])
                                 ->first();

            if (!empty($costs)) {
                $pre_save['costs_id'] = $costs->id;
            }

            /******************************************************************/
            
            //Consulta o mês por extenso
            $data_venc         = explode('-', $object->vencimento);
            $mes_extenso       = $this->SystemFunctions->mesPorExtenso($data_venc[1]);
            $mes_extenso_abrev = $this->SystemFunctions->mesAbreviado($data_venc[1]);
            
            /******************************************************************/
            
            $pre_save = ['moviments_cards_id' => $object->id,
                         'cards_id'           => $object->cards_id
                        ];
            
        } elseif ($this->Model == 'Plannings') {
            
            //Consulta tipo de documento (Fatura)
            $documentType = $this->DocumentTypes->findByParametersId($object->parameters_id)
                                                ->where(['DocumentTypes.title LIKE' => '%DEPÓSITO%',
                                                         'DocumentTypes.status IN' => ['A', 'T']
                                                        ])
                                                ->first();

            if (!empty($documentType)) {
                $pre_save['document_types_id'] = $documentType->id;
            }
            
            /******************************************************************/
            
            $pre_save = ['plannings_id'      => $object->id,
                         'creditodebito'     => 'D'
                        ];
            
        }
        
        /**********************************************************************/
        
        //DEFINE O VALOR DA ORDEM
        $ordem = $this->Moviments->findByParametersId($object->parameters_id)
                                 ->select(['MAX' => 'max(Moviments.ordem)'])
                                 ->first();
        $ordem = $ordem->MAX;
        
        /**********************************************************************/
        
        //DEFINE A QUANTIDADE DE PARCELAS
        $parcela          = 1;
        $object->parcelas = 1;
        
        if (empty($object->vencimento)) {
            $object->vencimento = $object->data;
            $vencimento         = $object->data;
        }//if (empty($object->vencimento))
        
        if (empty($vencimento)) {
            $vencimento = $object->vencimento;
        }//if (empty($vencimento))
        
        $return = null;
        
        /**********************************************************************/
        
        while ($parcela <= $parcelas) {
            
            //CRIA UM NOVO CADASTRO
            $moviment = $this->Moviments->newEntity($pre_save);
            
            //DEFINE O VALOR DA ORDEM
            $ordem += 1;
            
            if ($this->Model == 'MovimentCards') {
                
                $historico = 'Fatura do cartão ' . $card->title . ' com vencimento em ' . $mes_extenso . '/' . $data_venc[0];
                $documento = $card->title . '-' . $mes_extenso_abrev . '/' . $data_venc[0];
                
        	} elseif ($this->Model == 'Plannings') {
                
                $historico = 'Planejamento: ' . $object->title . ' (' . $parcela . '/' . $parcelas . ')';
                $documento = $object->documento . ' (' . $parcela . '/' . $parcelas . ')';
                
            }
            
            $moviment->ordem            = $ordem;
            $moviment->documento        = $documento;
            $moviment->creditodebito    = $object->creditodebito;
            $moviment->providers_id     = $object->providers_id;
            $moviment->customers_id     = $object->customers_id;
            $moviment->account_plans_id = $object->account_plans_id;
            //$moviment->costs_id         = $object->costs_id; Está buscando um registro Cartões 08/07/18
            $moviment->historico        = $historico;
            $moviment->vencimento       = $vencimento;
            $moviment->data             = $object->data;
            $moviment->valor            = $object->valor;
            $moviment->contabil         = $object->contabil; //'S',
            $moviment->obs              = 'Fatura gerada automaticamente. ' . $object->obs;
            $moviment->status           = $object->status; //'A',
            $moviment->parameters_id    = $object->parameters_id;
            
            if (@$_SESSION['Auth']['User']['name']) { 
                $moviment->username = $_SESSION['Auth']['User']['name'];
            } else {
                $moviment->username = 'SISTEMA'; //FUNÇÃO ORIGINADA DE CRON->CRON => RECURRENT => MovimentRecurrentsFunctions->makeCardRecurrents => RegisterMoviments->moviment_add 10/09/2018
            }

            //$moviments = $this->Moviments->patchEntity($moviment, $save);
            
            if ($this->Moviments->save($moviment)) {
            
                //Atribui ID para retornar valor da função
                $return = $moviment->id;
            
            } else {
            
                //Alerta de erro
                $message = 'RegisterMovimentsComponent->moviment_add';
                $this->Error->registerError($moviment, $message, true);
            
            }//else if ($this->Moviments->save($moviment))
            
            if ($parcelas > 1) {
                
                //Adiciona periodicidade das parcelas
                if ($dd == '30') {
                    $vencimento = $vencimento->addMonth(1);
                } elseif ($dd == '10') {
                    $vencimento = $vencimento->addDays(10);
                } elseif ($dd == '15') {
                    $vencimento = $vencimento->addDays(15);
                } elseif ($dd == 'bim') {
                    $vencimento = $vencimento->addMonth(2);
                } elseif ($dd == 'tri') {
                    $vencimento = $vencimento->addMonth(3);
                } elseif ($dd == 'sem') {
                    $vencimento = $vencimento->addMonth(6);
                } elseif ($dd == 'anu') {
                    $vencimento = $vencimento->addYear(1);
                }
                
            }//if ($parcelas > 1)
            
            //INCREMENTA O NÚMERO DA PARCELA
            $parcela += 1;
            
        }//while ($parcela <= $parcelas)
        
        //ID DO MOVIMENTO CRIADO {Não retorna Array pois não é tratado por nenhuma função que o chama.}
        return $return; 
    }
    
    public function moviment_update($moviments_id, $valor_titulo, $object)
    {
        //Os movimentos de cartões são agrupados pelo número de Ordem
        $moviments = $this->Moviments->findByParametersId($object->parameters_id)
                                     ->where(['Moviments.id' => $moviments_id]);
        
        /**********************************************************************/
        
        foreach($moviments as $moviment):
            
            if (($moviment->valor + $valor_titulo) == '0') {
                
                //MOVIMENTOS COM VALOR ZERO SERÃO EXCLUÍDOS AUTOMATICAMENTE
                $conditions = ['Moviments.parameters_id' => $object->parameters_id,
                               'Moviments.id'            => $moviments_id
                              ];
                
                $this->Moviments->deleteAll($conditions);
                
                /**************************************************************/
                
                $conditions = ['MovimentsMovimentCards.parameters_id' => $object->parameters_id,
                               'MovimentsMovimentCards.cards_id'      => $object->cards_id,
                               'MovimentsMovimentCards.vencimento'    => $object->vencimento
                              ];
                
                $this->MovimentsMovimentCards->deleteAll($conditions);
                
            } else {
                
                //Incrementa o valor
                $moviment->valor += $valor_titulo;
                
                $moviment->providers_id     = $object->providers_id;
                $moviment->customers_id     = $object->customers_id;
                $moviment->account_plans_id = $object->account_plans_id;
                //$moviment->costs_id         = $object->costs_id; Não atualizar o centro de custos / categoria
                
                if (!$this->Moviments->save($moviment)) {

                    //Alerta de erro
                    $message = 'RegisterMovimentsComponent->moviment_update';
                    $this->Error->registerError($moviment, $message, true);

                }//if (!$this->Moviments->save($moviment))
                
                //implementado em 28/07/2017
                return $moviment->id; 
            }
            
        endforeach;
    }
    
    public function movimentCheck($object, $id_vinculado = null, $destination = null)
    {
        $this->Model = $object->source();
        
        /**********************************************************************/
        
        if (!empty($id_vinculado)) {
            $moviments_id = $id_vinculado;
        } else {
            $moviments_id = $object->id;
        }//if (!empty($id_vinculado))
        
        /**********************************************************************/
        
        if ($this->Model == 'Moviments') {
            
            $pre_save = ['moviments_id'  => $moviments_id,
                         'banks_id'      => $object->banks_id, //Banco de Origem
                         'caixaforn'     => 'F',
                        ];
            
        } elseif ($this->Model == 'Transfers') {
            
            if (!empty($object->boxes_dest)) {
                $caixaforn = 'C';
            } else {
                $caixaforn = 'F';
            }//if (!empty($object->boxes_dest))
            
            $pre_save = ['transfers_id' => $moviments_id,
                         'caixaforn'    => $caixaforn,
                        ];
            
        }//elseif ($this->Model == 'Transfers')
        
        /**********************************************************************/
        
        //DEFINE O VALOR DA ORDEM
        $ordem = $this->MovimentChecks->findByParametersId($object->parameters_id)
                                      ->select(['MAX' => 'max(MovimentChecks.ordem)'])
                                      ->first();
        $ordem = $ordem->MAX;
        
        /**********************************************************************/
        
        //PREENCHE COMO NULO, CASO NÃO ESTEJA PREENCHIDO
        if (!isset($object->providers_id)) { $object->providers_id = null; }
        
        /**********************************************************************/

        if ($destination == 'source') {

            //Caixas não emitem cheques
            $movimentCheck->banks_id          = $object->banks_id;
            $movimentCheck->costs_id          = $object->costs_id;
            $movimentCheck->account_plans_id  = $object->account_plans_id;

        } elseif ($destination == 'destination' && !empty($object->banks_dest)) {

            $movimentCheck->banks_id          = $object->banks_dest;
            $movimentCheck->costs_id          = $object->costs_dest;
            $movimentCheck->account_plans_id  = $object->account_plans_dest;

        } elseif ($destination == 'destination' && !empty($object->boxes_dest)) {

            $movimentCheck->boxes_id          = $object->boxes_dest;
            $movimentCheck->costs_id          = $object->costs_dest;
            $movimentCheck->account_plans_id  = $object->account_plans_dest;

        } elseif ($destination == 'destination' && empty($object->banks_dest) && empty($object->boxes_dest)) {

            //ADAPTAÇÃO PLANO SIMPLES (POSSUI APENAS 1 CATEGORIA) 03/08/2018
            if (!empty($object->banks_id)) {

                $movimentCheck->banks_id      = $object->banks_id;
                $movimentCheck->costs_id      = $object->costs_id;

            } elseif (!empty($object->boxes_id)) {

                $movimentCheck->boxes_id      = $object->boxes_id;
                $movimentCheck->costs_id      = $object->costs_id;

            }//elseif (!empty($object->boxes_id))

        }//elseif ($destination == 'destination' && empty($object->banks_dest) && empty($object->boxes_dest))

        /**********************************************************************/

        //Cria novo registro na tabela
        $movimentCheck = $this->MovimentChecks->newEntity($pre_save);
        
        $movimentCheck->ordem            = $ordem + 1;
        //$movimentCheck->account_plans_id = $object->account_plans_id;
        $movimentCheck->event_types_id   = $object->event_types_id;
        $movimentCheck->providers_id     = $object->providers_id;
        //$movimentCheck->costs_id         = $object->costs_id;
        $movimentCheck->cheque           = $object->cheque;
        $movimentCheck->nominal          = $object->nominal;
        $movimentCheck->data             = $object->emissaoch;
        $movimentCheck->valor            = $object->valorbaixa;//Ajustado 'valorbaixa' em 08/03/2018
        $movimentCheck->documento        = $object->documento;
        $movimentCheck->historico        = $object->historico;
        $movimentCheck->contabil         = $object->contabil;
        $movimentCheck->obs              = $object->obs;
        $movimentCheck->status           = 'B'; //Movimento de cheque sempre deverá possuir o status Baixado 09/03/2018
        $movimentCheck->username         = $_SESSION['Auth']['User']['name'];
        $movimentCheck->parameters_id    = $object->parameters_id;
        
        /**********************************************************************/
        
        if (!$this->MovimentChecks->save($movimentCheck)) {

            //Alerta de erro
            $message = 'RegisterMovimentsComponent->movimentCheck';
            $this->Error->registerError($movimentCheck, $message, true);

        }//if (!$this->MovimentChecks->save($movimentCheck))
        
        /**********************************************************************/

        return $movimentCheck->id;
    }
    
    public function movimentBank($object, $id_vinculado = null, $destination = null)
    {
        //Identifica a tabela de origem
        $this->Model = $object->source();
        
        /**********************************************************************/
        
        if (!empty($id_vinculado)) {
            $moviments_id = $id_vinculado;
        } else {
            //$moviments_id = $object->ordem;
            $moviments_id = $object->id;
        }
        
        /**********************************************************************/
        
        if ($this->Model == 'Moviments') {
            $pre_save = ['moviments_id'       => $moviments_id,
                         'account_plans_id'   => $object->account_plans_id,
                         'vencimento'         => $object->vencimento,
                         'data'               => $object->data,
                         'valor'              => $object->valor,
                         'dtbaixa'            => $object->dtbaixa,
                         'valorbaixa'         => $object->valorbaixa,
                         'historico'          => $object->historico
                        ];
        } elseif ($this->Model == 'MovimentChecks') {
            $pre_save = ['moviment_checks_id' => $moviments_id,
                         'vencimento'         => $object->data,
                         'dtbaixa'            => $object->data,
                         'data'               => $object->data,
                         'valor'              => $object->valor,
                         'valorbaixa'         => $object->valor,
                         'historico'          => $object->historico . ' - Ch: ' . $object->cheque,
                         'account_plans_id'   => $object->account_plans_id,
                         'userbaixa'          => $_SESSION['Auth']['User']['name']
                        ];
        } elseif ($this->Model == 'Transfers') {
            $pre_save = ['transfers_id'       => $moviments_id,
                         'vencimento'         => $object->data,
                         'data'               => $object->data,
                         'valor'              => $object->valor,
                         'dtbaixa'            => $object->data,
                         'valorbaixa'         => $object->valor,
                         'historico'          => $object->historico,
                         'userbaixa'          => $_SESSION['Auth']['User']['name']
                        ];
        }
        
        /**********************************************************************/
        
        //DEFINE O VALOR DA ORDEM
        $ordem = $this->MovimentBanks->findByParametersId($object->parameters_id)
                                     ->select(['MAX' => 'max(MovimentBanks.ordem)'])
                                     ->first();
        $ordem = $ordem->MAX;
        
        /**********************************************************************/
        
        //TRATAMENTO ESPECIAL PARA CHEQUE
        if ($object->cheque) {
            
            $object->historico = $object->historico . ' CH: ' . $object->cheque; //.' NOMINAL: ' . $requestData->nominal
            
        }//if ($object->cheque)
        
        if (!empty($object->cheque)) {

            //Função de criação de cheques foi utilizada em 03/08/2018
            $object->moviment_checks_id = $this->movimentCheck($object, $id_vinculado, $destination);
            
        } else {
            
            $object->moviment_checks_id = null;
            
        }// else if (!empty($object->cheque))
        
        /**********************************************************************/
        
        //PREENCHE COMO NULO, CASO NÃO ESTEJA PREENCHIDO
        if (!isset($object->customers_id)) { $object->customers_id = null; }
        if (!isset($object->providers_id)) { $object->providers_id = null; }
        
        /**********************************************************************/
        
        $object->data;
        $object->valor;
        
        /**********************************************************************/
        
        //Cria novo registro na tabela
        $movimentBank = $this->MovimentBanks->newEntity($pre_save);
        
        /**********************************************************************/
        
        //USADO NA TRANSFERÊNCIA, DEFINE ORIGEM E DESTINO
        if ($destination == 'source') {
            $object->creditodebito = 'D';
        } elseif ($destination == 'destination') {
            $object->creditodebito = 'C';
        } elseif (!$destination) {
            $destination = 'source';
        }
        
        /**********************************************************************/
        
        if ($destination == 'source' && !empty($object->banks_id)) {

            $movimentBank->banks_id          = $object->banks_id;
            $movimentBank->costs_id          = $object->costs_id;
            $movimentBank->account_plans_id  = $object->account_plans_id;

        } elseif ($destination == 'destination' && !empty($object->banks_dest)) {

            $movimentBank->banks_id          = $object->banks_dest;
            $movimentBank->costs_id          = $object->costs_dest;
            $movimentBank->account_plans_id  = $object->account_plans_dest;

        } elseif ($destination == 'destination' && empty($object->banks_dest)) {

            //ADAPTAÇÃO PLANO SIMPLES (POSSUI APENAS 1 CATEGORIA) 03/08/2018
            if (!empty($object->banks_id)) {

                $movimentBank->banks_id      = $object->banks_id;
                $movimentBank->costs_id      = $object->costs_id;

            }//if (!empty($object->banks_id))

        }//elseif ($destination == 'destination' && empty($object->banks_dest))
        
        /**********************************************************************/
        
        $movimentBank->ordem              = $ordem + 1;
        $movimentBank->moviment_checks_id = $object->moviment_checks_id;
        if (!empty($object->document_types_id)) { $movimentBank->document_types_id  = $object->document_types_id; }
        if (!empty($object->event_types_id))  { $movimentBank->event_types_id     = $object->event_types_id; }
        $movimentBank->customers_id       = $object->customers_id;
        $movimentBank->providers_id       = $object->providers_id;
        $movimentBank->data               = $object->data;
        $movimentBank->valor              = $object->valor;
        $movimentBank->creditodebito      = $object->creditodebito;
        $movimentBank->documento          = $object->documento;
        $movimentBank->contabil           = $object->contabil;
        $movimentBank->obs                = $object->obs;
        $movimentBank->status             = 'B'; //Movimento de banco/caixa sempre deverá possuir o status Baixado 09/03/2018
        $movimentBank->username           = $_SESSION['Auth']['User']['name'];
        $movimentBank->parameters_id      = $object->parameters_id;
        
        /**********************************************************************/
        
        if (!$this->MovimentBanks->save($movimentBank)) {

            //Alerta de erro
            $message = 'RegisterMovimentsComponent->movimentBank';
            $this->Error->registerError($movimentBank, $message, true);

        }//if (!$this->MovimentBanks->save($movimentBank))
        
    }
    
    public function movimentBox($object, $id_vinculado = null, $destination = null)
    {
        //Identifica a tabela de origem
        $this->Model = $object->source();
        
        /**********************************************************************/
        
        if (!empty($id_vinculado)) {
            $moviments_id = $id_vinculado;
        } else {
            $moviments_id = $object->id;
        }
        
        /**********************************************************************/
        
        if ($this->Model == 'Moviments') {
            $pre_save = ['moviments_id'       => $moviments_id,
                         'account_plans_id'   => $object->account_plans_id,
                         'vencimento'         => $object->vencimento,
                         'data'               => $object->data,
                         'valor'              => $object->valor,
                         'dtbaixa'            => $object->dtbaixa,
                         'valorbaixa'         => $object->valorbaixa,
                         'historico'          => $object->historico
                        ];
        } elseif ($this->Model == 'MovimentChecks') {
            $pre_save = ['moviment_checks_id' => $moviments_id,
                         'vencimento'         => $object->data,
                         'dtbaixa'            => $object->data,
                         'data'               => $object->data,
                         'valor'              => $object->valor,
                         'valorbaixa'         => $object->valor,
                         'historico'          => $object->historico . ' - Ch: ' . $object->cheque,
                         'account_plans_id'   => $object->account_plans_id,
                         'userbaixa'          => $_SESSION['Auth']['User']['name']
                        ];
        } elseif ($this->Model == 'Transfers') {
            $pre_save = ['transfers_id'       => $moviments_id,
                         'vencimento'         => $object->data,
                         'dtbaixa'            => $object->data,
                         'data'               => $object->data,
                         'valor'              => $object->valor,
                         'valorbaixa'         => $object->valor,
                         'historico'          => $object->historico,
                         'userbaixa'          => $_SESSION['Auth']['User']['name']
                        ];
        }
        
        /**********************************************************************/
        
        //DEFINE O VALOR DA ORDEM
        $ordem = $this->MovimentBoxes->findByParametersId($object->parameters_id)
                                     ->select(['MAX' => 'max(MovimentBoxes.ordem)'])
                                     ->first();
        $ordem = $ordem->MAX;
        
        /**********************************************************************/
        
        //PREENCHE COMO NULO, CASO NÃO ESTEJA PREENCHIDO
        if (!isset($object->customers_id)) { $object->customers_id = null; }
        if (!isset($object->providers_id)) { $object->providers_id = null; }
        
        /**********************************************************************/
        
        //Cria novo registro na tabela
        $movimentBox = $this->MovimentBoxes->newEntity($pre_save);
        
        /**********************************************************************/
        
        if ($destination == 'source') {
            $object->creditodebito = 'D';
        } elseif ($destination == 'destination') {
            $object->creditodebito = 'C';
        } elseif (!$destination) {
            $destination = 'source';
        }
        
        /**********************************************************************/
        
        if ($destination == 'source' && !empty($object->boxes_id)) {

            $movimentBox->boxes_id          = $object->boxes_id;
            $movimentBox->costs_id          = $object->costs_id;
            $movimentBox->account_plans_id  = $object->account_plans_id;

        } elseif ($destination == 'destination' && !empty($object->boxes_dest)) {

            $movimentBox->boxes_id          = $object->boxes_dest;
            $movimentBox->costs_id          = $object->costs_dest;
            $movimentBox->account_plans_id  = $object->account_plans_dest;

        } elseif ($destination == 'destination' && empty($object->boxes_dest)) {

            //ADAPTAÇÃO PLANO SIMPLES (POSSUI APENAS 1 CATEGORIA) 03/08/2018
            if (!empty($object->boxes_id)) {

                $movimentBox->boxes_id      = $object->boxes_id;
                $movimentBox->costs_id      = $object->costs_id;

            }//if (!empty($object->boxes_id))

        }//elseif ($destination == 'destination' && empty($object->boxes_dest))
        
        /**********************************************************************/
        
        $movimentBox->ordem             = $ordem + 1;
        if (!empty($object->document_types_id)) { $movimentBox->document_types_id = $object->document_types_id; }
        if (!empty($object->event_types_id)) { $movimentBox->event_types_id    = $object->event_types_id; }
        $movimentBox->customers_id      = $object->customers_id;
        $movimentBox->providers_id      = $object->providers_id;
        $movimentBox->creditodebito     = $object->creditodebito;
        $movimentBox->documento         = $object->documento;
        $movimentBox->contabil          = $object->contabil;
        $movimentBox->obs               = $object->obs;
        $movimentBox->status            = 'B'; //Movimento de banco/caixa sempre deverá possuir o status Baixado 09/03/2018
        $movimentBox->username          = $_SESSION['Auth']['User']['name'];
        $movimentBox->parameters_id     = $object->parameters_id;
        
        /**********************************************************************/
        
        //Método saveMany devido a repetição de salvamento nas transferências.
        if (!$this->MovimentBoxes->save($movimentBox)) {

            //Alerta de erro
            $message = 'RegisterMovimentsComponent->movimentBox';
            $this->Error->registerError($movimentBox, $message, true);

        }//if (!$this->MovimentBoxes->save($movimentBox))
        
    }
    
    public function deleteMovimentCheck($object)
    {
        $this->Model = $object->source();
        
        /**********************************************************************/
        
        if ($this->Model == 'Moviments') {
            $table_id = 'moviments_id';
        } elseif ($this->Model == 'Transfers') {
            $table_id = 'transfers_id';
        }
        
        /**********************************************************************/
        
        $conditions = ['MovimentChecks.' . $table_id  => $object->id, //Consulta pelo número de ordem?
                       'MovimentChecks.parameters_id' => $object->parameters_id
                      ];
        
        return $this->MovimentChecks->deleteAll($conditions, false);
    }
    
    public function deleteMovimentBank($object)
    {
        $this->Model = $object->source();
        
        /**********************************************************************/
        
        if ($this->Model == 'Moviments') {
            $table_id = 'moviments_id';
        } elseif ($this->Model == 'Transfers') {
            $table_id = 'transfers_id';
        }
        
        /**********************************************************************/
        
        $conditions = ['MovimentBanks.' . $table_id  => $object->id, //Consulta pelo número de ordem?
                       'MovimentBanks.parameters_id' => $object->parameters_id
                      ];
        
        return $this->MovimentBanks->deleteAll($conditions, false);
    }
    
    public function deleteMovimentBox($object)
    {
        $this->Model = $object->source();
        
        /**********************************************************************/
        
        if ($this->Model == 'Moviments') {
            $table_id = 'moviments_id';
        } elseif ($this->Model == 'Transfers') {
            $table_id = 'transfers_id';
        }
        
        /**********************************************************************/
        
        $conditions = ['MovimentBoxes.' . $table_id  => $object->id, //Consulta pelo número de ordem?
                       'MovimentBoxes.parameters_id' => $object->parameters_id
                      ];
        
        return $this->MovimentBoxes->deleteAll($conditions, false);
    }
    
    public function deleteMoviments($table_id, $field_id, $parameters_id)
    {
        $conditions = ['Moviments.' . $table_id  => $field_id,
                       'Moviments.parameters_id' => $parameters_id
                      ];
        
        $this->Moviments->deleteAll($conditions, false);
    }
    
}