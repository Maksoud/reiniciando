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

class MovimentRecurrentsFunctionsComponent extends Component 
{   
    public function __construct()
    {
        $this->Error = new ErrorComponent();

        $this->MovimentRecurrents = TableRegistry::get('MovimentRecurrents');
        $this->Moviments          = TableRegistry::get('Moviments');
        $this->MovimentCards      = TableRegistry::get('MovimentCards');
        $this->Cards              = TableRegistry::get('Cards');
        $this->Customers          = TableRegistry::get('Customers');
        $this->Providers          = TableRegistry::get('Providers');
        
        $this->MovimentCardsFunctions = new MovimentCardsFunctionsComponent();
        $this->SystemFunctions        = new SystemFunctionsComponent();
    }
    
    public function makeMovimentRecurrents($recurrents, $parameters_id = null)
    {
        /* Função incialmente localizada em MovimentRecurrentsController
         * utilizada na função recurrent() do CronController
         */
        $recurrents_regis = [];
        
        /**********************************************************************/
        
        if (empty($parameters_id)) {
            $parameters_id = $this->request->Session()->read('sessionParameterControl');
        }//if (empty($parameters_id))
        
        /**********************************************************************/
        
        $data = date('Y-m-d');
        
        /**********************************************************************/
        
        //RESPOSTA DE EXECUÇÃO
        foreach ($recurrents as $recurrent):
            
            //Executa o script abaixo, somente se houverem Movimentos na consulta
            if (!empty($recurrent->moviments_id)) {

                //Consulta o movimento para duplicação
                $moviments = $this->Moviments->findByIdAndParametersId($recurrent->moviments_id, $parameters_id);

                foreach ($moviments as $moviment):

                    if ($moviment->vencimento < $data) {

                        //CRIA UM NOVO REGISTRO
                        $new_moviment = $this->Moviments->newEntity();

                        /**********************************************************/

                        //DEFINE O VALOR DA ORDEM
                        $ordem = $this->Moviments->findByParametersId($parameters_id)
                                                 ->select(['MAX' => 'MAX(Moviments.ordem)'])
                                                 ->first();
                        $ordem = $ordem->MAX;

                        /**********************************************************/

                        //Ajusta variáveis
                        $vencimento = date("Y-m-d", strtotime("+1 month", strtotime($moviment->vencimento)));
                        $valor      = $moviment->valor;

                        if (!empty($moviment->valorbaixa)) { 

                            $valor = $moviment->valorbaixa;

                        }//if (!empty($moviment->valorbaixa))

                        /**********************************************************/

                        //Alimenta campos do novo lançamento
                        $new_moviment->ordem             = $ordem + 1;
                        $new_moviment->costs_id          = $moviment->costs_id;
                        $new_moviment->event_types_id    = $moviment->event_types_id;
                        $new_moviment->document_types_id = $moviment->document_types_id;
                        $new_moviment->account_plans_id  = $moviment->account_plans_id;           
                        $new_moviment->customers_id      = $moviment->customers_id;
                        $new_moviment->providers_id      = $moviment->providers_id;
                        $new_moviment->creditodebito     = $moviment->creditodebito;
                        $new_moviment->data              = $data;
                        $new_moviment->vencimento        = $vencimento;
                        $new_moviment->valor             = $valor;
                        $new_moviment->documento         = $moviment->documento;
                        $new_moviment->historico         = $moviment->historico;
                        $new_moviment->contabil          = $moviment->contabil;
                        $new_moviment->obs               = $moviment->obs;//possivelmente não será replicado, analisar usabilidade
                        $new_moviment->status            = 'A';
                        $new_moviment->username          = $moviment->username;
                        $new_moviment->parameters_id     = $parameters_id;

                        if (!$this->Moviments->save($new_moviment)) {

                            //Alerta de erro
                            $message = 'MovimentRecurrentsFunctionsComponent->makeMovimentRecurrents, Moviments';
                            $this->Error->registerError($new_moviment, $message, true);

                        }//if (!$this->Moviments->save($new_moviment))

                        /**********************************************************/

                        //E ATUALIZA A TABELA MOVIMENT RECURRENT.
                        $recurrent->moviments_id = $new_moviment->id;

                        if (!$this->MovimentRecurrents->save($recurrent)) {

                            //Alerta de erro
                            $message = 'MovimentRecurrentsFunctionsComponent->makeMovimentRecurrents, MovimentRecurrents';
                            $this->Error->registerError($recurrent, $message, true);

                        }//if (!$this->MovimentRecurrents->save($recurrent))

                        /**********************************************************/
                        //Complemento do cadastro de clientes
                        if (!empty($new_moviment->customers_id)) {

                            $new_moviment->Customers = $this->Customers->find('all')
                                                                       ->select(['Customers.id', 'Customers.title'])
                                                                       ->where(['Customers.id' => $new_moviment->customers_id])
                                                                       ->first();

                        }//if (!empty($new_moviment->customers_id))

                        /**********************************************************/
                        //Complemento do cadastro de fornecedores
                        if (!empty($new_moviment->providers_id)) {

                            $new_moviment->Providers = $this->Providers->find('all')
                                                                       ->select(['Providers.id', 'Providers.title'])
                                                                       ->where(['Providers.id' => $new_moviment->providers_id])
                                                                       ->first();

                        }//if (!empty($new_moviment->providers_id))

                        /**********************************************************/

                        //RESPOSTA DE EXECUÇÃO
                        $recurrents_regis[] = $new_moviment;

                    }//if ($moviment->vencimento < $data)

                endforeach;

            }//if (!empty($recurrent->moviments_id))
            
        endforeach;
        
        //RESPOSTA DE EXECUÇÃO
        return $recurrents_regis;
    }
    
    public function makeCardRecurrents($recurrents, $parameters_id = null)
    {
        $recurrents_regis = [];
        
        /**********************************************************************/

        if (empty($parameters_id)) {
            $parameters_id = $this->request->Session()->read('sessionParameterControl');
        }//if (empty($parameters_id))
        
        /**********************************************************************/
        
        //RESPOSTA DE EXECUÇÃO
        foreach($recurrents as $recurrent):

            //Execulta o script apenas se houver movimentos de cartões
            if (!empty($recurrent->moviment_cards_id)) {

                $moviments = $this->MovimentCards->find('all')
                                                 ->where(['MovimentCards.parameters_id' => $parameters_id,
                                                          'MovimentCards.id '           => $recurrent->moviment_cards_id
                                                         ]);

                foreach($moviments as $moviment):

                    $venc = explode('-', $moviment->vencimento);
                    $dt   = explode('-', date('Y-m-d'));
                    $venc = $venc[0].$venc[1];
                    $dt   = $dt[0].$dt[1];

                    if ($venc < $dt) { //VENCIMENTOS DE CARTÕES SÃO FIXOS, POR ISSO É NECESSÁRIO ANALISAR A INFORMAÇÃO PELO MÊS

                        //CRIA UM NOVO REGISTRO
                        $new_moviment_cards = $this->MovimentCards->newEntity();

                        /**********************************************************/

                        //DEFINE O VALOR DA ORDEM
                        $ordem = $this->MovimentCards->findByParametersId($parameters_id)
                                                     ->select(['MAX' => 'MAX(MovimentCards.ordem)'])
                                                     ->first();
                        $ordem = $ordem->MAX;

                        /**********************************************************/

                        //Consulta cartão
                        $card = $this->Cards->find('all')
                                            ->where(['Cards.parameters_id' => $parameters_id,
                                                     'Cards.id'            => $moviment->cards_id
                                                    ])
                                            ->first();

                        /**********************************************************/

                        //Ajusta variáveis
                        $vencimento = date("Y-m-d", strtotime("+1 month", strtotime($moviment->vencimento)));
                        $valor      = $moviment->valor;

                        if (!empty($moviment->valorbaixa)) {

                            $valor = $moviment->valorbaixa;

                        }//if (!empty($moviment->valorbaixa))

                        /**********************************************************/

                        $new_moviment_cards->ordem            = $ordem + 1;
                        $new_moviment_cards->cards_id         = $moviment->cards_id;
                        //$new_moviment_cards->customers_id     = $card->customers_id;
                        $new_moviment_cards->providers_id     = $card->providers_id;
                        $new_moviment_cards->cards_id         = $moviment->cards_id;
                        $new_moviment_cards->account_plans_id = $moviment->account_plans_id;
                        $new_moviment_cards->costs_id         = $moviment->costs_id;
                        $new_moviment_cards->vencimento       = $vencimento;
                        $new_moviment_cards->documento        = $moviment->documento;
                        $new_moviment_cards->title            = $moviment->title;
                        $new_moviment_cards->creditodebito    = $moviment->creditodebito;
                        $new_moviment_cards->valor            = $valor;
                        $new_moviment_cards->data             = date('Y-m-d');
                        $new_moviment_cards->contabil         = $moviment->contabil;
                        $new_moviment_cards->status           = 'A';
                        $new_moviment_cards->username         = $moviment->username;
                        $new_moviment_cards->obs              = $moviment->obs;
                        $new_moviment_cards->parameters_id    = $parameters_id;

                        if (!$this->MovimentCards->save($new_moviment_cards)) {

                            //Alerta de erro
                            $message = 'MovimentRecurrentsFunctionsComponent->makeCardRecurrents, MovimentCards';
                            $this->Error->registerError($new_moviment_cards, $message, true);
                            
                        }//if (!$this->MovimentCards->save($new_moviment_cards))

                        /**********************************************************/

                        $movimentCards = $this->MovimentCards->findByIdAndParametersId($new_moviment_cards->id, $parameters_id)
                                                             ->first();

                        /**********************************************************/

                        //REGISTRA OS SALDOS - Deduz do limite de crédito (DATA PARA CÁLCULO SERÁ O VENCIMENTO)
                        $this->MovimentCardsFunctions->balanceCard($movimentCards, null); //Modificado 01/03/2018

                        /**********************************************************/

                        //REGISTRA A CONTA A PAGAR NO CPR
                        $this->MovimentCardsFunctions->moviments_moviment_cards($movimentCards);

                        /**********************************************************/

                        //E ATUALIZA A TABELA MOVIMENT RECURRENT.
                        $recurrent->moviment_cards_id = $new_moviment_cards->id;

                        if (!$this->MovimentRecurrents->save($recurrent)) {

                            //Alerta de erro
                            $message = 'MovimentRecurrentsFunctionsComponent->makeCardRecurrents, MovimentRecurrents';
                            $this->Error->registerError($recurrent, $message, true);

                        }//if (!$this->MovimentRecurrents->save($recurrent))

                        /**********************************************************/
                        //Complemento do cadastro de clientes (Desenvolver recebimentos por cartões 06/08/2018)
                        if (!empty($new_moviment_cards->customers_id)) {

                            $new_moviment_cards->Customers = $this->Customers->find('all')
                                                                             ->select(['Customers.id', 'Customers.title'])
                                                                             ->where(['Customers.id' => $new_moviment_cards->customers_id])
                                                                             ->first();

                        }//if (!empty($new_moviment_cards->customers_id))

                        /**********************************************************/
                        //Complemento do cadastro de fornecedores
                        if (!empty($new_moviment_cards->providers_id)) {

                            $new_moviment_cards->Providers = $provider = $this->Providers->find('all')
                                                                                         ->select(['Providers.id', 'Providers.title'])
                                                                                         ->where(['Providers.id' => $new_moviment_cards->providers_id])
                                                                                         ->first();

                        }//if (!empty($new_moviment_cards->providers_id))

                        /**********************************************************/

                        //RESPOSTA DE EXECUÇÃO
                        $recurrents_regis[] = $new_moviment_cards;

                    }//if ($venc < $dt)

                endforeach;

            }//if (!empty($moviment_cards_id))
            
        endforeach;
        
        //RESPOSTA DE EXECUÇÃO
        return $recurrents_regis;
    }
    
    public function addMovimentRecurrents($id, $parameters_id)
    {
        //Registra na tabela de movimentos recorrentes o id (moviments_id) do lançamento CPR
        $movimentRecurrent = $this->MovimentRecurrents->newEntity();
        
        $movimentRecurrent->moviments_id  = $id;
        $movimentRecurrent->parameters_id = $parameters_id;
        
        return $this->MovimentRecurrents->save($movimentRecurrent);
    }
    
    public function addMovimentCardRecurrents($id, $parameters_id)
    {
        //Registra na tabela de movimentos recorrentes o id (moviment_cards_id) do lançamento de cartão
        $movimentRecurrent = $this->MovimentRecurrents->newEntity();
        
        $movimentRecurrent->moviment_cards_id  = $id;
        $movimentRecurrent->parameters_id      = $parameters_id;
        
        return $this->MovimentRecurrents->save($movimentRecurrent);
    }
    
    public function deleteMovimentRecurrents($id, $parameters_id)
    {
        $conditions = ['MovimentRecurrents.parameters_id' => $parameters_id,
                       'MovimentRecurrents.moviments_id'  => $id
                      ];
        
        return $this->MovimentRecurrents->deleteAll($conditions);
    }
    
}