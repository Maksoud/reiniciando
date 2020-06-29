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

class MovimentCardsFunctionsComponent extends Component 
{
    public $components = ['GeneralBalance', 'RegisterMoviments'];
    
    public function __construct()
    {
        $this->Error = new ErrorComponent();

        $this->Cards                  = TableRegistry::get('Cards');
        $this->Balances               = TableRegistry::get('Balances');
        $this->MovimentCards          = TableRegistry::get('MovimentCards');
        $this->MovimentsMovimentCards = TableRegistry::get('MovimentsMovimentCards');
        
        $this->GeneralBalance    = new GeneralBalanceComponent();
        $this->RegisterMoviments = new RegisterMovimentsComponent();
    }
    
    public function balanceCard($moviment, $cancel = null)
    {
        //Define o valor a ser creditado/debitado
        $valor = $moviment->valorbaixa;
        
        //Ajusta valor em caso de cancelamento
        if ($cancel) {
            $valor = $valor*-1;
        }//if ($cancel)
        
        /**********************************************************************/
        
        //BUSCA REGISTROS NA TABELA BALANCE
        $balances = $this->Balances->findByParametersId($moviment->parameters_id)
                                   ->select(['Balances.id', 'Balances.value'])
                                   ->where(['Balances.cards_id' => $moviment->cards_id]);
        
        //SEMPRE HAVERÁ DADOS NESSA CONSULTA, ASSIM QUE CADASTRADO UM CARTÃO ELE CRIA UM REGISTRO NA TABELA DE SALDOS
        foreach($balances as $balance):
            
            //ATUALIZA O REGISTRO
            $balance->value += $valor;
            
            //SALVA ALTERAÇÕES
            if (!$this->Balances->save($balance)) {

                //Alerta de erro
                $message = 'MovimentCardsFunctionsComponent->balanceCard';
                $this->Error->registerError($balance, $message, true);

            }//if (!$this->Balances->save($balance))
            
        endforeach;
        
        /**********************************************************************/
        
        //EXCLUI REGISTROS ANTERIORES (CARTÃO POSSUI LIMITE E NÃO SALDO!)
        $this->Balances->deleteAll(['Balances.parameters_id' => $moviment->parameters_id,
                                    'Balances.cards_id'      => $moviment->cards_id,
                                    'Balances.date <'        => date('Y-m-d')
                                   ]);
        
    }
    
    public function lowCard($moviment, $cancel = null)
    {
        //Acessa a tabela MovimentCard
        $this->MovimentCards = TableRegistry::get('MovimentCards');
            
        /******************************************************************/

        $movimentCards = $this->MovimentCards->findByParametersId($moviment->parameters_id)
                                             ->where(['MovimentCards.cards_id'   => $moviment->cards_id, 
                                                      'MovimentCards.vencimento' => $moviment->vencimento,
                                                     ]);
        
        /******************************************************************/

        if (!empty($movimentCards->toArray())) {
            
            foreach($movimentCards as $movimentCard):
                
                //Modifica o status do cadastro
                if ($cancel) {
                    $movimentCard->status     = 'A';
                    $movimentCard->valorbaixa = null;
                    $movimentCard->dtbaixa    = null;
                } else {
                    $movimentCard->status     = 'B';
                    $movimentCard->valorbaixa = $moviment->valorbaixa;
                    $movimentCard->dtbaixa    = $moviment->dtbaixa;
                }

                //GRAVA ALTERAÇÕES
                if (!$this->MovimentCards->save($movimentCard)) {

                    //Alerta de erro
                    $message = 'MovimentCardsFunctionsComponent->lowCard';
                    $this->Error->registerError($movimentCard, $message, true);

                }//if (!$this->MovimentCards->save($movimentCard))
                
            endforeach;

            /******************************************************************/
            
            //Registra crédito no limite do cartão
            $this->balanceCard($moviment, $cancel); //Se for um cancelamento, desfaz também o saldo
            
        }//if (!empty($movimentCards->toArray()))
        
    }
    
    public function cardAddLimit($id, $limite, $parameters_id)
    {
        $cards = $this->Cards->findByIdAndParametersId($id, $parameters_id)
                             ->select(['id', 'limite']);
        
        /**********************************************************************/
        
        foreach($cards as $card):
            
            if ($card->limite != $limite) {
                
                $balances = $this->Balances->findByParametersId($parameters_id)
                                           ->select(['id', 'date', 'value'])
                                           ->where(['Balances.cards_id' => $id])
                                           ->order(['Balances.date DESC']);
                
                /**************************************************************/
                
                //CALCULA O VALOR DA DIFERENÇA PARA CRIAR O NOVO SALDO
                $novo_saldo = $limite - $card->limite;
                
                /**************************************************************/
                
                foreach($balances as $balance):
                    
                    $balance->date  = date("Y-m-d");//ADICIONA A DATA ATUAL
                    $balance->value = $balance->value + $novo_saldo;
                    
                    if (!$this->Balances->save($balance)) {

                        //Alerta de erro
                        $message = 'MovimentCardsFunctionsComponent->cardAddLimit, Balances';
                        $this->Error->registerError($balance, $message, true);

                    }//if (!$this->Balances->save($balance))
                    
                endforeach;
                
            }//if ($card['limite'] != $limite)
            
        endforeach;
    }
    
    public function calculaVenc($cards_id, $dtLancamento, $parameters_id)
    {
        //CONSULTA DADOS DO CARTÃO
        $card = $this->Cards->findByIdAndParametersId($cards_id, $parameters_id)
                            ->first();
        
        /**********************************************************************/
        
        //DEFINE CAMPOS
        $dia_vencimento = $card->vencimento;
        $melhor_dia     = $card->melhor_dia;
        
        /**********************************************************************/
        
        //SE O MELHOR DIA DE COMPRA FOR NO MÊS ANTERIOR
        if ($melhor_dia < $dia_vencimento) {
            
            if ($dtLancamento->day < $melhor_dia) {
                
                $vencimento = $dtLancamento->year.'-'.$dtLancamento->month.'-'.$dia_vencimento;
                
            } elseif ($dtLancamento->day >= $melhor_dia) {
                
                $vencimento = $dtLancamento->year.'-'.$dtLancamento->month.'-'.$dia_vencimento;
                $vencimento = date("Y-m-d", strtotime("+1 month", strtotime($vencimento)));
                
            }
            
        } else { //SE O MELHOR DIA DE COMPRA FOR DENTRO DO MÊS DO VENCIMENTO
            
            if ($dtLancamento->day < $melhor_dia) {
                
                $vencimento = $dtLancamento->year.'-'.$dtLancamento->month.'-'.$dia_vencimento;
                $vencimento = date("Y-m-d", strtotime("+1 month", strtotime($vencimento)));
                
            } elseif ($dtLancamento->day >= $melhor_dia) {
                
                $vencimento = $dtLancamento->year.'-'.$dtLancamento->month.'-'.$dia_vencimento;
                $vencimento = date("Y-m-d", strtotime("+2 month", strtotime($vencimento)));
                
            }
            
        }
        
        return date("Y-m-d", strtotime($vencimento));
    }
    
    public function editaVenc($id, $direction, $parameters_id)
    {
        //CONSULTA REGISTRO COMPLETO
        $movimentCard = $this->MovimentCards->findByIdAndParametersId($id, $parameters_id)
                                            ->first();
        
        //REGISTRA OS SALDOS - Repõe ao limite de crédito
        $this->GeneralBalance->balance($movimentCard, true);
        
        /**********************************************************************/
        
        //CANCELA REGISTRO NO CPR
        $this->moviments_moviment_cards($movimentCard, true);
        
        /**********************************************************************/
        
        //CALCULA O VENCIMENTO
        if ($direction == 'backward') {
            $movimentCard->vencimento = date("Y-m-d", strtotime("-1 month", strtotime($movimentCard->vencimento)));
        } elseif ($direction == 'forward') {
            $movimentCard->vencimento = date("Y-m-d", strtotime("+1 month", strtotime($movimentCard->vencimento)));
        }//elseif ($direction == 'forward')
        
        /**********************************************************************/
        
        //REGISTRA OS SALDOS - Deduz do limite de crédito (DATA PARA CÁLCULO SERÁ O VENCIMENTO)
        $this->GeneralBalance->balance($movimentCard);
        
        /**********************************************************************/    

        //REGISTRA NO CPR
        $this->moviments_moviment_cards($movimentCard);
        
        /**********************************************************************/
        
        //SALVA REGISTROS
        if ($this->MovimentCards->save($movimentCard)) {
            
            return $movimentCard->id;
            
        } else {

            //Alerta de erro
            $message = 'MovimentCardsFunctionsComponent->editaVenc';
            $this->Error->registerError($movimentCard, $message, true);
            
            //CANCELA REGISTRO DE SALDOS - Repõe ao limite de crédito
            $this->GeneralBalance->balance($movimentCard, true);
            
            //CANCELA REGISTRO NO CPR
            $this->moviments_moviment_cards($movimentCard, true);
            
            return false;
            
        }//else if ($this->MovimentCards->save($movimentCard))
        
    }
    
    public function editValue($moviments_id, $new_diff_value, $creditodebito, $parameters_id)
    {
        /* ESTA FUNÇÃO ATUALIZA APENAS O MOVIMENTO (FATURA) 12/07/18 */
        $this->Moviments = TableRegistry::get('Moviments');
        
        /**********************************************************************/
        
        //CONSULTA REGISTRO COMPLETO
        $moviment = $this->Moviments->findByIdAndParametersId($moviments_id, $parameters_id)
                                    ->first();
        
        /**********************************************************************/
        
        //$this->GeneralBalance->balanceCard($moviment, $new_diff_value); Função substituída 12/07/2018
        
        /**********************************************************************/
        
        //ATUALIZA O REGISTRO
        $moviment->valor += $new_diff_value;
        
        /**********************************************************************/
        
        //SALVA ALTERAÇÕES
        if (!$this->Moviments->save($moviment)) {

            //Alerta de erro
            $message = 'MovimentCardsFunctionsComponent->editValue';
            $this->Error->registerError($moviment, $message, true);

        }//if (!$this->Moviments->save($moviment))
        
    }
    
    public function moviments_moviment_cards($object, $cancel = null)
    {
        /* 
            Utilizado a função para clonar o objeto, devido a uma atualização com o id, que víncula o movimento de 
            cartão ao CPR, realizada ao final da execução do script. 30/08/2018
         */
        $movimentCard = clone $object;
        
        /**********************************************************************/

        //COMPRA (D) OU ESTORNO (C)
        if ($movimentCard->creditodebito == 'C') {
            $movimentCard->valor = $movimentCard->valor*-1;
        }
        
        /**********************************************************************/
        
        $movimentsmc = $this->MovimentsMovimentCards->findByParametersId($movimentCard->parameters_id)
                                                    ->where(['MovimentsMovimentCards.cards_id'   => $movimentCard->cards_id,
                                                             'MovimentsMovimentCards.vencimento' => $movimentCard->vencimento
                                                            ])
                                                    ->first();
        
        /**********************************************************************/
        
        if (empty($movimentsmc)) {
            
            //CRIA NOVO MOVIMENTO COM A DATA DE VENCIMENTO
            $moviments_id = $this->RegisterMoviments->moviment_add($movimentCard);
            //public function moviment_add($movimentCard, $parcelas = 1, $dd = '30')
            
            /******************************************************************/
            
            //CRIA MOVIMENTO NA TABELA DE VÍNCULO
            $movimentsMovimentCards = $this->MovimentsMovimentCards->newEntity();
            
            $movimentsMovimentCards->moviments_id  = $moviments_id;
            $movimentsMovimentCards->cards_id      = $movimentCard->cards_id;
            $movimentsMovimentCards->vencimento    = $movimentCard->vencimento;
            $movimentsMovimentCards->parameters_id = $movimentCard->parameters_id;
            
            /******************************************************************/
                
            //SALVA REGISTRO
            if (!$this->MovimentsMovimentCards->save($movimentsMovimentCards)) {

                //Alerta de erro
                $message = 'MovimentCardsFunctionsComponent->moviments_moviment_cards';
                $this->Error->registerError($movimentsMovimentCards, $message, true);

            }//if (!$this->MovimentsMovimentCards->save($movimentsMovimentCards))

            /******************************************************************/

            //Atualiza o Movimento de cartão
            $object->moviments_id = $moviments_id;
            
        } else {
            
            if ($cancel) {
                $valor = $movimentCard->valor*-1;
            } else {
                $valor = $movimentCard->valor;
            }
            
            /******************************************************************/
            
            //ATUALIZA VALOR DO MOVIMENTO CPR REVISAR REVISAR REVISAR REVISAR REVISAR REVISAR REVISAR REVISAR REVISAR REVISAR REVISAR REVISAR REVISAR 
            $this->RegisterMoviments->moviment_update($movimentsmc->moviments_id, $valor, $movimentCard);
            //public function moviment_update($moviments_id, $valor_titulo, $movimentCard)
            
            /******************************************************************/

            //Atualiza o Movimento de cartão
            $object->moviments_id = $movimentsmc->moviments_id;
            
        }//else if (empty($movimentsmc))

        /**********************************************************************/
        
        //Salva no movimento de cartões o ID do movimento CPR
        if (!$this->MovimentCards->save($object)) {

            //Alerta de erro
            $message = 'MovimentCardsFunctionsComponent->moviments_moviment_cards, MovimentCards';
            $this->Error->registerError($object, $message, true);

        }//if (!$this->MovimentCards->save($object))

    }
    
}