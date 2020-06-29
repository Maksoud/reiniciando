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

class GeneralBalanceComponent extends Component 
{
    private $valorbaixa  = null;
    
    public function __construct()
    {
        $this->Error = new ErrorComponent();
        $this->Balances = TableRegistry::get('Balances');
    }
    
    /**
     * UTILIZADO PARA CRIAR UM NOVO REGISTRO NA TABELA DE SALDOS
     */
    public function addBalance($table_id, $reg_id, $value = null, $parameters_id, $data = null)
    {
        
        if (empty($value)) {
	        
            //CONSULTA SALDO ANTERIOR - Atualizado em 07/07/2018
            if (empty($data)) {
	            $conditions = ['Balances.' . $table_id => $reg_id,
	                           'Balances.date <'       => date('Y-m-d')
	                          ];
            } else {
	            $conditions = ['Balances.' . $table_id => $reg_id,
	                           'Balances.date <'       => $data
	                          ];
            }

            $saldoAnterior = $this->Balances->findByParametersId($parameters_id)
                                            ->select(['Balances.id', 'Balances.date', 'Balances.value'])
                                            ->where($conditions)
                                            ->order(['Balances.date' => 'desc'])
                                            ->first();
            
            //DEFINE VALOR DO SALDO ATUAL
            if (!empty($saldoAnterior->value)) {
                
                $value = $saldoAnterior->value;
                
            } else {
                
                $value = '0.00';
                
            }
            
        }//if (empty($value))
        
        /******************************************************************/
        
        //TRATAMENTO PARA CARTÕES E PLANEJAMENTOS
        if ($table_id == 'cards_id' || $table_id == 'plannings_id') { //07/07/2017
            
            //EXCLUI REGISTROS ANTERIORES (CARTÃO POSSUI LIMITE E NÃO SALDO!) 15/12/2017
            $conditions = ['Balances.parameters_id' => $parameters_id,
                           'Balances.' . $table_id  => $reg_id,
                           'Balances.date <'        => date('Y-m-d')
                          ];
            
            $this->Balances->deleteAll($conditions);
            
        }//if ($table_id == 'cards_id' || $table_id == 'plannings_id')
        
        /******************************************************************/
        
        //CRIA-SE UM NOVO REGISTRO NA DATA INFORMADA COM O SALDO ANTERIOR, SE HOUVER
        $balance = $this->Balances->newEntity();
        
        switch($table_id):
            case 'banks_id':
                $balance->banks_id = $reg_id;
                break;
            case 'boxes_id':
                $balance->boxes_id = $reg_id;
                break;
            case 'cards_id':
                $balance->cards_id = $reg_id;
                break;
            case 'plannings_id':
                $balance->plannings_id = $reg_id;
                break;
        endswitch;
        
        $balance->value         = $value;
        $balance->parameters_id = $parameters_id;
        
        //Identifica qual é a data que será implementado o novo saldo 07/07/2018
        if (empty($data)) {
	        $balance->date      = date("Y-m-d");
        } else {
	        $balance->date      = $data;
        }
        
        /**********************************************************************/
        
        if ($this->Balances->save($balance)) {

            return $balance;

        }//if ($this->Balances->save($balance))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'GeneralBalanceComponent->addBalance';
        $this->Error->registerError($balance, $message, true);

        return null;
    }
    
    /**
     * UTILIZADO PARA EXCLUIR SALDOS DE BANCOS, CAIXAS E PLANEJAMENTOS
     */
    public function deleteBalance($table_id, $field_id, $parameters_id)
    {
        //ATENÇÃO: ANTES DE EXECUTAR ESSA FUNÇÃO ANALISE SE HÁ MOVIMENTOS REGISTRADOS
        $conditions = ['Balances.' . $table_id  => $field_id,
                       'Balances.parameters_id' => $parameters_id
                      ];
        
        $this->Balances->deleteAll($conditions, false);
    }
    
    /** 
     * FUNÇÃO PRINCIPAL QUE EXECUTA TODA A VERIFICAÇÃO DE SALDOS
     * ANTERIORES E REPLICA O SALDO PARA DATAS POSTERIORES
     */
    public function balance($object, $cancel = null)
    {
        //Identifica a tabela de origem
        $this->Model = $object->source();
        
        /**********************************************************************/

        //Define campos para cadastro
        if ($this->Model == 'Moviments') {
            
            if (!empty($object->boxes_id)) {
                $table_id = 'boxes_id';
            } elseif (!empty($object->banks_id)) {
                $table_id = 'banks_id';
            }
            
            $this->Model_times = 1;
            
        } elseif ($this->Model == 'MovimentBoxes') {
            
            $table_id    = 'boxes_id';
            $this->Model_times = 1;
            
        } elseif ($this->Model == 'MovimentBanks') {
            
            $table_id    = 'banks_id';
            $this->Model_times = 1;
            
        } elseif ($this->Model == 'Transfers') {
            
            $bo = $object->banks_id;
            $bd = $object->banks_dest;
            $co = $object->boxes_id;
            $cd = $object->boxes_dest;

            if ($bo && $bd) {
                $table_orig = 'banks_id';
                $table_dest = 'banks_id';
            } elseif ($co && $cd) {
                $table_orig = 'boxes_id';
                $table_dest = 'boxes_id';
            } elseif ($bo && $cd) {
                $table_orig = 'banks_id';
                $table_dest = 'boxes_id';
            } elseif ($co && $bd) {
                $table_orig = 'boxes_id';
                $table_dest = 'banks_id';
            }
            
            //TABELA DE ORIGEM E DESTINO
            $this->Model_times = 2;
            
        } elseif ($this->Model == 'MovimentCards') {
            
            $table_id    = 'cards_id';
            $this->Model_times = 1;
            
        }//elseif ($this->Model == 'MovimentCards')
        
        /**********************************************************************/
        
        //Organização da Data 
        /*Modificado data para dtbaixa devido a inconsistências em 19/10/2016*/
        if (!empty($object->dtbaixa)) {
            
            $this->data = $object->dtbaixa;
            
        } else {
            
            //Movimentos não possuem dtbaixa no formulário
            $this->data = $object->data;
            
        }//else if (!empty($object->dtbaixa))
        
        /**********************************************************************/
        
        //NECESSÁRIO PARA TRANSFERÊNCIAS
        for ($count = 1; $count <= $this->Model_times; $count++) {
            
            //UTILZIADO EM recordBalance NAS TRANSFERÊNCIAS 07/04/2017
            $destination = null;
            
            if ($this->Model == 'Transfers' && $count == 1) {       //BANCO/CAIXA DE ORIGEM
                
                $this->valorbaixa = $object->valor*-1;
                $table_id   	  = $table_orig;
                
            } elseif ($this->Model == 'Transfers' && $count == 2) { //BANCO/CAIXA DE DESTINO
                
                $this->valorbaixa = $object->valor; 
                $table_id   	  = $table_dest;
                $destination      = true;
                
            } elseif ($this->Model != 'Transfers') { 
                
                //Ajusta valor em caso de crédito/débito
                if ($object->creditodebito == 'C') {
                    
                    if ($object->valorbaixa >= 0) { 
                        $this->valorbaixa = $object->valorbaixa; 
                    } else { 
                        $this->valorbaixa = $object->valor; 
                    }
                    
                } elseif ($object->creditodebito == 'D') {
                    
                    if ($object->valorbaixa >= 0) { 
                        $this->valorbaixa = $object->valorbaixa*-1; 
                    } else { 
                        $this->valorbaixa = $object->valor*-1; 
                    }
                    
                }//elseif ($object->creditodebito == 'D')
                
            }//elseif ($this->Model != 'Transfers')
            
            /******************************************************************/
            
            //Ajusta valor em caso de cancelamento
            if ($cancel) {
                if ($this->valorbaixa != 0) $this->valorbaixa = $this->valorbaixa*-1;
            }//if ($cancel)
            
            /******************************************************************/
            
            //Define o Reg_ID 15/12/2017
            if (!empty($table_id)) {
                
                switch($table_id):
                    case 'banks_id':
                        if (!$destination) { $reg_id = $object->banks_id; }
                        else {               $reg_id = $object->banks_dest; }
                        break;
                    case 'boxes_id':
                        if (!$destination) { $reg_id = $object->boxes_id; }
                        else {               $reg_id = $object->boxes_dest; }
                        break;
                    case 'cards_id':
                        $reg_id = $object->cards_id;
                        break;
                    case 'plannings_id':
                        $reg_id = $object->plannings_id;
                        break;
                endswitch;
                
            }//if (!empty($table_id))
            
            /******************************************************************/
            
            //CONTROLE DAS CONDIÇÕES DE BUSCA
            if ($this->Model != 'MovimentCards') {
                $conditions = ['Balances.' . $table_id => $reg_id,
                               'Balances.date'         => $this->data
                              ];
            } else {
                //MOVIMENTO DE CARTÃO NÃO POSSUI SALDO. POSSUI LIMITE DE CRÉDITO, ATUALIZADO SEMPRE PARA ÚLTIMO DIA DO LOGIN NO SISTEMA.
                $conditions = ['Balances.' . $table_id => $reg_id];
            }
            
            //BUSCA REGISTROS NA TABELA BALANCE
            $balance = $this->Balances->findByParametersId($object->parameters_id)
                                      ->where($conditions)
                                      ->first();
            
            /******************************************************************/
            
            //Se não existir registros na tabela Balances, cria-se um novo registro 
            if (empty($balance)) {
                //CRIA-SE UM NOVO REGISTRO NA DATA INFORMADA COM SALDO ANTERIOR 
                //$balance = $this->recordBalance($this->data, $object, $destination);// ATUALIZADO EM 18/12/2017
                $balance = $this->addBalance($table_id, $reg_id, null, $object->parameters_id, $this->data); //Adicionada a data em 07/07/2018
                
            }//if (empty($balance))
            
            /******************************************************************/
            /******************************************************************/
            
            //ATUALIZA O REGISTRO 07/07/2017
            if (!empty($balance)) {
                
                //Incrementa o valor
                $balance->value += $this->valorbaixa;
                
                //Salva novo valor
                if (!$this->Balances->save($balance)) {

                    //Alerta de erro
                    $message = 'GeneralBalanceComponent->balance, Balances';
                    $this->Error->registerError($balance, $message, true);

                }//if (!$this->Balances->save($balance))

            }//if (!empty($balance))
            
            /******************************************************************/
            /******************************************************************/
            
            if ($this->Model != 'MovimentCards') {
                
                //LOCALIZA REGISTROS POSTERIORES
                $conditions = ['Balances.' . $table_id  => $reg_id,
                               'Balances.date >'        => $this->data
                              ];
                
                $post_days = $this->Balances->findByParametersId($object->parameters_id)
                                            ->select(['Balances.id', 'Balances.value'])
                                            ->where($conditions);

                if (!empty($post_days->toArray())) {
                    
                    foreach ($post_days as $day):
                         
                        //Incrementa                         
                        $day->value += $this->valorbaixa;
                         
                        //SALVA REGISTRO
                        if (!$this->Balances->save($day)) {

                            //Alerta de erro
                            $message = 'GeneralBalanceComponent->balance, $post_days';
                            $this->Error->registerError($day, $message, true);

                        }//if (!$this->Balances->save($day))
                         
                    endforeach;
                     
                }//if (!empty($post_days->toArray()))
                
            } else {
                
                //MOVIMENTO DE CARTÃO NÃO POSSUI SALDO. POSSUI LIMITE DE CRÉDITO, ATUALIZADO SEMPRE PARA ÚLTIMO DIA DO LOGIN NO SISTEMA.
                $conditions = ['Balances.cards_id' => $reg_id,
                               'Balances.date <'   => date('Y-m-d')
                              ];
                
                $anteriores = $this->Balances->findByParametersId($object->parameters_id)
                                             ->select(['Balances.id', 'Balances.cards_id', 'Balances.value'])
                                             ->where($conditions);
                
                if (!empty($anteriores->toArray())) {
                    
                    foreach ($anteriores as $anterior):
                        
                        $conditions = ['Balances.parameters_id' => $object->parameters_id,
                                       'Balances.cards_id'      => $anterior->cards_id,
                                       'Balances.id'            => $anterior->id
                                      ];
                        
                        if (!$this->Balances->deleteAll($conditions)) {
                            //Alerta de erro
                            $message = 'GeneralBalanceComponent->balance, exclusão de movimentos de cartões: '.$conditions;
                            $this->Error->registerError(null, $message, true);
                        }
                        
                    endforeach;
                    
                }//if (!empty($anteriores->toArray()))
                
            }//else if ($this->Model != 'MovimentCards')
            
        }//for ($count = 1; $count <= $this->Model_times; $count++)
        
    }
    
    /**
     * UTILIZADO NA INICIALIZAÇÃO DO SISTEMA, CRIAR OS SALDOS DO DIA
     * POSSIBILITANDO A IDENTIFICAÇÃO NO DASHBOARD
     */
    public function updateBalance($parameters_id)
    {
        $tables = [0 => 'Banks',
                   1 => 'Boxes',
                   2 => 'Cards',
                   3 => 'Plannings'
                  ];
        
        foreach($tables as $table):
            
            $this->Model = TableRegistry::get($table);
            
            $conditions = [$table . '.parameters_id' => $parameters_id,
                           $table . '.status'        => 'A'
                          ];
            
            $dataTable = $this->Model->find('all')
                                     ->where($conditions);
            
            foreach ($dataTable as $object):
                //$this->recordBalance(date("Y-m-d"), $record, null); 18/12/2017
                
                //Define campos para cadastro
                if ($table == 'Banks') {
                    
                    $table_id = 'banks_id';
                    $reg_id   = $object->id;
                    
                } elseif ($table == 'Boxes') {
                    
                    $table_id = 'boxes_id';
                    $reg_id   = $object->id;
                    
                } elseif ($table == 'Cards') {

                    $table_id = 'cards_id';
                    $reg_id   = $object->id;

                } elseif ($table == 'Plannings') {

                    $table_id = 'plannings_id';
                    $reg_id   = $object->id;

                }
                
                /**************************************************************/
                
                //CONSULTA SE HÁ MOVIMENTOS PARA A TABELA INFORMADA
                $conditions = ['Balances.' . $table_id  => $reg_id,
                               'Balances.date'          => date("Y-m-d")
                              ];
                
                $balance = $this->Balances->findByParametersId($object->parameters_id)
                                          ->select(['Balances.id', 'Balances.value'])
                                          ->where($conditions)
                                          ->first();
                
                /**************************************************************/
                
                //SE NÃO HOUVER MOVIMENTOS...
                if (empty($balance)) {
                    
                    //CONSULTA SALDO ANTERIOR
                    $conditions = ['Balances.' . $table_id  => $reg_id,
                                   'Balances.date <'        => date("Y-m-d")
                                  ];
                    
                    $saldoAnterior = $this->Balances->findByParametersId($object->parameters_id)
                                                    ->select(['Balances.id', 'Balances.date', 'Balances.value'])
                                                    ->where($conditions)
                                                    ->order(['Balances.date' => 'desc'])
                                                    ->first();
                    
                    //DEFINE VALOR DO SALDO ATUAL
                    if (!empty($saldoAnterior->value)) {
                        $value = $saldoAnterior->value;
                    } else {
                        $value = '0.00';
                    }
                    
                    /**********************************************************/
                    
                    //TRATAMENTO PARA CARTÕES E PLANEJAMENTOS
                    if ($table_id == 'cards_id' || $table_id == 'plannings_id') { //07/07/2017
                        
                        //EXCLUI REGISTROS ANTERIORES (CARTÃO POSSUI LIMITE E NÃO SALDO!) 15/12/2017
                        $conditions = ['Balances.parameters_id' => $object->parameters_id,
                                       'Balances.' . $table_id  => $reg_id,
                                       'Balances.date <'        => date('Y-m-d')
                                      ];
                        
                        $this->Balances->deleteAll($conditions);
                        
                    }
                    
                    /**********************************************************/
                    
                    //CRIA-SE UM NOVO REGISTRO NA DATA INFORMADA COM O SALDO ANTERIOR, SE HOUVER
                    $balance = $this->Balances->newEntity();

                    switch($table_id):
                        case 'banks_id':
                            $balance->banks_id = $reg_id;
                            break;
                        case 'boxes_id':
                            $balance->boxes_id = $reg_id;
                            break;
                        case 'cards_id':
                            $balance->cards_id = $reg_id;
                            break;
                        case 'plannings_id':
                            $balance->plannings_id = $reg_id;
                            break;
                    endswitch;

                    $balance->value         = $value;
                    $balance->date          = date("Y-m-d");
                    $balance->parameters_id = $object->parameters_id;

                    if (!$this->Balances->save($balance)) {

                        //Alerta de erro
                        $message = 'GeneralBalanceComponent->updateBalance';
                        $this->Error->registerError($balance, $message, true);

                    }//if (!$this->Balances->save($balance))

                }//if (empty($balance))
                
            endforeach;//foreach ($dataTable as $object)
            
        endforeach;//foreach($tables as $table)
    }

    /** 
     * UTILIZADO PARA DEFINIR O SALDO DE FORMA MANDATÓRIA, 
     * USADO NA ATUALIZAÇÃO DO MOVIMENTO DE BANCO, CAIXA E 
     * TRANSFERÊNCIAS. 
     */
    public function setBalance($object, $new_diff_value, $new_creditodebito)
	{
        $this->Balances  = TableRegistry::get('Balances');
        
        /**********************************************************************/

        //Identifica se é banco ou caixa
        if (!empty($object->banks_id)) {
            $where[] = 'Balances.banks_id = '.$object->banks_id;
            $where[] = 'Balances.date     = "'.$object->dtbaixa.'"';
        } elseif (!empty($object->boxes_id)) {
            $where[] = 'Balances.boxes_id = '.$object->boxes_id;
            $where[] = 'Balances.date     = "'.$object->dtbaixa.'"';
        } elseif (!empty($object->cards_id)) {
            $where[] = 'Balances.cards_id = '.$object->cards_id;
            $where[] = 'Balances.date     = "'.date('Y-m-d').'"';
        }
        
        $balance = $this->Balances->findByParametersId($object->parameters_id)
                                  ->select(['Balances.id', 'Balances.value', 'Balances.date',
                                            'Balances.boxes_id', 'Balances.banks_id'
                                           ])
                                  ->where($where)
                                  ->first();

        /**********************************************************************/

        //VERIFICA SE O TIPO DE PAGAMENTO É DIFERENTE (CRÉDITO/DÉBITO)
        if ($object->creditodebito != $new_creditodebito) {

            if ($object->creditodebito == 'C' && $new_creditodebito == 'D') {

                //CASO O MOVIMENTO DEIXE DE SER CRÉDITO PARA SER DÉBITO, SOME A DIFERENÇA AO VALOR ANTIGO E DECRESÇA AO SALDO
                $balance->value += ((($object->valor * 2) + $new_diff_value)*-1);
                $change_creditodebito = 'CD';

            } elseif ($object->creditodebito == 'D' && $new_creditodebito == 'C') {

                //CASO O MOVIMENTO DEIXE DE SER CRÉDITO PARA SER CRÉDITO, SOME A DIFERENÇA AO VALOR ANTIGO E ACRESÇA AO SALDO
                $balance->value += (($object->valor * 2) + $new_diff_value);
                $change_creditodebito = 'DC';

            }//if ($object->creditodebito == 'C' && $new_creditodebito == 'D')

        } else { 

            //MESMO TIPO DE PAGAMENTO (CRÉDITO/DÉBITO)
            if ($object->creditodebito == 'C') {

                //SE O REGISTRO CONTINUAR SENDO CRÉDITO, APENAS SOME O VALOR DA DIFERENÇA AO SALDO
                $balance->value += $new_diff_value;
                $change_creditodebito = 'CC';

            } elseif ($object->creditodebito == 'D') {

                //SE O REGISTRO CONTINUAR SENDO DÉBITO, APENAS SUBTRAIA O VALOR DA DIFERENÇA AO SALDO
                $balance->value += $new_diff_value*-1;
                $change_creditodebito = 'DD';

            }//if ($object->creditodebito == 'C')

        }//if ($object->creditodebito != $new_creditodebito)
        
        /**********************************************************************/
        
        //SALVA ALTERAÇÕES
        if (!$this->Balances->save($balance)) {

            //Alerta de erro
            $message = 'GeneralBalanceComponent->setBalance';
            $this->Error->registerError($balance, $message, true);

        }//if (!$this->Balances->save($balance))
        
        /**********************************************************************/

        //TRATAMENTO PARA CARTÕES E PLANEJAMENTOS
        if (!empty($object->cards_id) || !empty($object->plannings_id)) { //07/07/2017

            //Identifica o table_id e reg_id
            if (!empty($object->cards_id)) {

                $table_id = 'cards_id';
                $reg_id   = $object->cards_id;

            } elseif (!empty($object->plannings_id)) {

                $table_id = 'plannings_id';
                $reg_id   = $object->plannings_id;

            }
                
            //EXCLUI REGISTROS ANTERIORES (CARTÃO POSSUI LIMITE E NÃO SALDO!) 17/07/2018
            $conditions = ['Balances.parameters_id' => $object->parameters_id,
                           'Balances.' . $table_id  => $reg_id,
                           'Balances.date <'        => date('Y-m-d')
                          ];
            
            $this->Balances->deleteAll($conditions);
            
        } else {

            //LOCALIZA REGISTROS POSTERIORES
            $post_days = $this->Balances->findByParametersId($object->parameters_id)
                                        ->select(['Balances.id', 'Balances.value'])
                                        ->where($where)
                                        ->where(['Balances.date >' => $object->dtbaixa]);

            if (!empty($post_days->toArray())) {

                foreach ($post_days as $day):

                    if ($change_creditodebito == 'CC') {
            
                        //SE O REGISTRO CONTINUAR SENDO CRÉDITO, APENAS SOME O VALOR DA DIFERENÇA AO SALDO
                        $day->value += $new_diff_value;
            
                    } elseif ($change_creditodebito == 'DD') {

                        //SE O REGISTRO CONTINUAR SENDO DÉBITO, APENAS SUBTRAIA O VALOR DA DIFERENÇA AO SALDO
                        $day->value += $new_diff_value*-1;
            
                    } elseif ($change_creditodebito == 'CD') {
            
                        //CASO O MOVIMENTO DEIXE DE SER CRÉDITO PARA SER DÉBITO, SOME A DIFERENÇA AO VALOR ANTIGO E DECRESÇA AO SALDO
                        $day->value += ((($object->valor * 2) + $new_diff_value)*-1);
            
                    } elseif ($change_creditodebito == 'DC') {
            
                        //CASO O MOVIMENTO DEIXE DE SER CRÉDITO PARA SER CRÉDITO, SOME A DIFERENÇA AO VALOR ANTIGO E ACRESÇA AO SALDO
                        $day->value += (($object->valor * 2) + $new_diff_value);
            
                    }//elseif ($change_creditodebito

                    //SALVA REGISTRO
                    if (!$this->Balances->save($day)) {

                        //Alerta de erro
                        $message = 'GeneralBalanceComponent->setBalance, $post_days';
                        $this->Error->registerError($day, $message, true);
                        
                    }//if (!$this->Balances->save($day))

                endforeach;

            }//if (!empty($post_days->toArray()))

        }//if (!empty($object->cards_id) || !empty($object->plannings_id))

    }

    /**
     * UTILIZADO APENAS PARA CONTROLAR OS DADOS DOS PLANEJAMENTOS
     */
    public function balancePlanning($moviment, $cancel = null)
    {
        $this->Plannings = TableRegistry::get('Plannings');
        $this->Balances  = TableRegistry::get('Balances');
        
        /**********************************************************************/
        
        //Define o valor a ser creditado/debitado
        $valor = $moviment->valorbaixa;
        
        //Ajusta valor em caso de cancelamento
        if ($cancel) {
            $valor = $valor*-1;
        }
        /**********************************************************************/
        
        //BUSCA REGISTROS NA TABELA BALANCE
        $balances = $this->Balances->findByParametersId($moviment->parameters_id)
                                   ->select(['Balances.id', 'Balances.value'])
                                   ->where(['Balances.plannings_id' => $moviment->plannings_id]);
        
        //SEMPRE HAVERÁ DADOS NESSA CONSULTA, ASSIM QUE CADASTRADO UM CARTÃO ELE CRIA UM REGISTRO NA TABELA DE SALDOS
        foreach($balances as $balance):
            
            //ATUALIZA O REGISTRO
            $balance->value += $valor;
            
            //SALVA ALTERAÇÕES
            if (!$this->Balances->save($balance)) {

                //Alerta de erro
                $message = 'GeneralBalanceComponent->balancePlanning, Balances';
                $this->Error->registerError($balance, $message, true);

            }//if (!$this->Balances->save($balance))
            
        endforeach;
        
        /**********************************************************************/
        
        //EXCLUI REGISTROS ANTERIORES (PLANEJAMENTO NÃO POSSUI SALDOS ANTERIORES!)
        $conditions = ['Balances.parameters_id' => $moviment->parameters_id,
                       'Balances.plannings_id'  => $moviment->plannings_id,
                       'Balances.date <'        => date('Y-m-d')
                      ];
        
        $this->Balances->deleteAll($conditions);
        
        /**********************************************************************/
        
        //VERIFICA SE A META FOI ATINGIDA
        $plannings = $this->Plannings->findByIdAndParametersId($moviment->plannings_id, $moviment->parameters_id)
                                     ->select(['Plannings.id', 'Plannings.valor', 
                                               'Plannings.parcelas', 'Plannings.status'
                                              ]);
        
        foreach($plannings as $planning):
            
            $total_planning = $planning->valor * $planning->parcelas;
            
            if ($total_planning == $balance->value + $valor) {
                //Finalizado
                $planning->status = 'F';
            } else {
                //Aberto
                $planning->status = 'A';
            }
            
            //SALVA ALTERAÇÕES
            if (!$this->Plannings->save($planning)) {

                //Alerta de erro
                $message = 'GeneralBalanceComponent->balancePlanning, Plannings';
                $this->Error->registerError($planning, $message, true);

            }//if (!$this->Plannings->save($planning))
            
        endforeach;
        
    }
}