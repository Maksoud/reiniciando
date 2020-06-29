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

class StockBalancesFunctionsComponent extends Component
{
    public function __construct()
    {
        $this->Error = new ErrorComponent();

        $this->StockBalances = TableRegistry::get('StockBalances');
        $this->Products      = TableRegistry::get('Products');
    }

    private function _calcCost($product_id, $parameters_id)
    {
        $stockBalances = $this->StockBalances->find('all')
                                             ->where(['StockBalances.products_id'   => $product_id,
                                                      'StockBalances.parameters_id' => $parameters_id
                                                     ]);

        foreach ($stockBalances as $stockBalance):

            //Calcula o valor de custo do produto
            $stockBalance->vlcost;

        endforeach;

        //Retorna o custo do produto informado
        return 0.00;
    }

    /**
     * UTILIZADO PARA CRIAR UM NOVO REGISTRO NA TABELA DE SALDOS
     */
    public function addBalance($date, $item, $parameters_id)
    {

        //Cria novo registro
        $stock = $this->StockBalances->newEntity();

        //Verifica se foi informada a data
        if (!$date) { $date = date('Y-m-d'); }

        //Define valores
        $stock->parameters_id = $parameters_id;
        $stock->date          = $date;
        $stock->products_id   = $item['products_id'];
        $stock->quantity      = $item['quantity'];
        $stock->unity         = $item['unity'];

        //Identifica o valor de custo do produto
        $stock->vlcost        = $this->_calcCost($item['products_id'], $parameters_id);

        //Grava registro
        if (!$this->StockBalances->save($stock)) {

            //Alerta de erro
            $message = 'StockBalancesFunctions->addBalance';
            $this->Error->registerError($stock, $message, true);

        }//if (!$this->StockBalances->save($stock))

    }

    /**
     * UTILIZADO PARA ATUALIZAR O SALDO DE UM PRODUTO EM UMA DATA ESPECÍFICA
     */
    public function updateBalance($stockBalances_id, $date, $item, $parameters_id)
    {
        $stock = $this->StockBalances->findByIdAndParametersId($stockBalances_id, $parameters_id)
                                     ->first();

        //Define valores
        $stock->parameters_id = $parameters_id;
        $stock->date          = $date;
        $stock->products_id   = $item['products_id'];
        $stock->quantity      = $item['quantity']; //Atualiza o saldo atual, o valor recebido deve ser contabilizado
        $stock->unity         = $item['unity'];

        //Identifica o valor de custo do produto
        $stock->vlcost        = $this->_calcCost($item['products_id'], $parameters_id);

        //Grava registro
        if (!$this->StockBalances->save($stock)) {

            //Alerta de erro
            $message = 'StockBalancesFunctions->updateBalance';
            $this->Error->registerError($stock, $message, true);

        }//if (!$this->StockBalances->save($stock))

    }
    
    /**
     * UTILIZADO PARA EXCLUIR SALDOS DE BANCOS, CAIXAS E PLANEJAMENTOS
     */
    public function deleteBalance($products_id, $parameters_id)
    {
        //ATENÇÃO: ANTES DE EXECUTAR ESSA FUNÇÃO ANALISE SE HÁ MOVIMENTOS REGISTRADOS
        $conditions = ['StockBalances.products_id'   => $products_id,
                       'StockBalances.parameters_id' => $parameters_id
                      ];
        
        $this->StockBalances->deleteAll($conditions, false);
    }

    /** 
     * FUNÇÃO PRINCIPAL QUE EXECUTA TODA A VERIFICAÇÃO DE SALDOS
     * ANTERIORES E REPLICA O SALDO PARA DATAS POSTERIORES
     */
    public function balance($date, $products_list, $parameters_id, $cancel = false)
    {
        /*
            Id
            parameters_id
            Created
            Modified
            products_id
            Date
            Quantity
            Unity
            Vlcost
         */

        /******************************************************************/

        foreach ($products_list as $item):

            //CONSULTA O SALDO ANTERIOR OU ATUAL
            $saldoAnterior = $this->StockBalances->findByParametersId($parameters_id)
                                                 ->select(['StockBalances.id', 'StockBalances.date', 
                                                           'StockBalances.quantity', 'StockBalances.unity'
                                                          ])
                                                 ->where(['StockBalances.products_id' => $item['products_id'],
                                                          'StockBalances.unity'       => $item['unity'],
                                                          'StockBalances.date <= '    => $date
                                                         ])
                                                 ->order(['StockBalances.date' => 'desc'])
                                                 ->first();

            /**************************************************************/

            //VERIFICA SE HÁ SALDO ANTERIOR OU ATUAL
            if (!empty($saldoAnterior->quantity)) {

                //Inicializa o array de itens
                $item_list = [];

                //VERIFICA SE HÁ SALDO NA DATA
                if ($saldoAnterior->date == $date) {

                    //Atualiza a quantidade
                    !$cancel ? $item_list['quantity'] = $saldoAnterior->quantity + $item['quantity'] : 
                               $item_list['quantity'] = $saldoAnterior->quantity + ($item['quantity'] *-1);
                    $item_list['products_id'] = $item['products_id'];
                    $item_list['unity']       = $item['unity'];

                    //Atualiza registro atual
                    $this->updateBalance($saldoAnterior->id, $saldoAnterior->date, $item_list, $parameters_id);

                } else { //SE NÃO HOUVER SALDO NA DATA

                    //Atualiza a quantidade
                    $item_list['products_id'] = $item['products_id'];
                    $item_list['quantity']    = $saldoAnterior->quantity + $item['quantity'];
                    $item_list['unity']       = $item['unity'];

                    //Cria um novo registro
                    $this->addBalance($date, $item_list, $parameters_id);

                }//else if ($saldoAnterior->date == $date)
                
            } else { //SE NÃO HOUVER SALDO ANTERIOR OU ATUAL
                
                //Cria um novo registro
                $this->addBalance($date, $item, $parameters_id);

            }//else if (!empty($saldoAnterior->value))

            /**************************************************************/
            /**************************************************************/

            //MOVIMENTAR SALDOS POSTERIORES
            $saldoPosteriores = $this->StockBalances->findByParametersId($parameters_id)
                                                ->select(['StockBalances.id', 'StockBalances.date', 
                                                          'StockBalances.quantity', 'StockBalances.unity'
                                                         ])
                                                ->where(['StockBalances.products_id' => $item['products_id'],
                                                         'StockBalances.unity'       => $item['unity'],
                                                         'StockBalances.date > '     => $date
                                                        ])
                                                ->order(['StockBalances.date' => 'desc']);

            /**************************************************************/

            //VERIFICA SE HÁ SALDO POSTERIORES
            if (!empty($saldoPosteriores->toArray())) {

                foreach ($saldoPosteriores as $saldoPosterior):

                    //Inicializa o array de itens
                    $item_list = [];

                    //Atualiza a quantidade
                    !$cancel ? $item_list['quantity'] = $saldoPosterior->quantity + $item['quantity'] : 
                               $item_list['quantity'] = $saldoPosterior->quantity + ($item['quantity'] *-1);
                    $item_list['products_id'] = $item['products_id'];
                    $item_list['unity']       = $item['unity'];

                    //Atualiza registro atual
                    $this->updateBalance($saldoPosterior->id, $saldoPosterior->date, $item_list, $parameters_id);

                endforeach;
                
            } else { //SE NÃO HOUVER SALDO POSTERIORES

                //Do nothing

            }//else if (!empty($saldoPosteriores->toArray()))

        endforeach;

    }

}