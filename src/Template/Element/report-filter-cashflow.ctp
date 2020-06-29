<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/report-filter-cashflow.ctp */
?>

    <h4><span class="text-bold"><?= __('FILTROS') ?></span></h4>
    <?php
		
        if ($this->request->data['dtinicial'] && $this->request->data['dtfinal']) {
        	echo '<span class="text-bold">Período: </span>'.$this->request->data['dtinicial'] . ' à ' . $this->request->data['dtfinal'].'<br />';
        }
        if (isset($this->request->data['dtemissao'])) {
            echo '<span class="text-bold">Registros filtrados pela data do lançamento </span>' . '<br />';
        } elseif ($this->request->data['Situação'] == 'baixado') {
            echo '<span class="text-bold">Registros filtrados pela data de Pagamento </span>' . '<br />';
        } elseif ($this->request->data['Situação'] == 'aberto') {
            echo '<span class="text-bold">Registros filtrados pela data de Vencimento </span>' . '<br />';
        } else {
            echo '<span class="text-bold">Registros filtrados pela data de pagamento para lançamentos baixados </span>' . '<br />';
            echo '<span class="text-bold">Registros filtrados pela data de vencimento para lançamentos em aberto </span>' . '<br />';
        }

        if ($this->request->data['creditodebito'] == 'C') {
            echo '<span class="text-bold">Somente Receitas </span>' . '<br />';
        } elseif ($this->request->data['creditodebito'] == 'D') {
            echo '<span class="text-bold">Somente Despesas </span>' . '<br />';
        } else {
            echo '<span class="text-bold">Receitas e Despesas </span>' . '<br />';
        }

        if (isset($banks)) {
            foreach($banks as $bank):
                $list_of_banksBoxes[] = $bank;
            endforeach;
        }//if (isset($banks))

        if (isset($boxes)) {
            foreach($boxes as $box):
                $list_of_banksBoxes[] = $box;
            endforeach;
        }//if (isset($boxes))

        if (!empty($list_of_banksBoxes)) {
            if (!empty($moviments)) { 
                echo '<span class="text-bold">Fonte: </span>' . implode(", ", $list_of_banksBoxes) . ', Contas a Pagar e Receber (Em Aberto)' . '<br />'; 
            } else { 
                echo '<span class="text-bold">Fonte: </span>' . implode(", ", $list_of_banksBoxes) . '<br />'; 
            }
        } elseif (!empty($moviments)) { 
            echo '<span class="text-bold">Fonte: </span>Contas a Pagar e Receber (Em Aberto)' . '<br />'; 
        } else { 
            echo '<span class="text-bold">Fonte: </span>Não Selecionado<br />'; 
            $moviments = $movimentBanks = $movimentBoxes = null; 
        }
        
        if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) {
            if (!empty($this->request->data['customers_id'])) {
                echo '<span class="text-bold">Cliente: </span>' . $customer->title . '<br />';
            }
            if (!empty($this->request->data['providers_id'])) {
                echo '<span class="text-bold">Fornecedor: </span>' . $provider->title . '<br />';
            }
            if (!empty($this->request->data['account_plans_id'])) {
                foreach ($accountPlans as $accountPlan):
                    $list_of_accountPlans[] = $accountPlan->title;
                endforeach;
                echo '<span class="text-bold">Plano de Contas: </span>' . implode(", ", $list_of_accountPlans) . '<br />';
            }
            if (!empty($this->request->data['document_types_id'])) {
                echo '<span class="text-bold">Tipo de Documento: </span>' . $documentType->title . '<br />';
            }
            if (!empty($this->request->data['event_types_id'])) {
                echo '<span class="text-bold">Tipo de Evento: </span>' . $eventType->title . '<br />';
            }

            if (!empty($this->request->data['costs_id'])) {
                foreach ($costs as $cost):
                    $list_of_costs[] = $cost->title;
                endforeach;
                echo '<span class="text-bold">Centro de Custos: </span>' . implode(", ", $list_of_costs) . '<br />';
            }//if (!empty($this->request->data['costs_id']))

        } elseif ($this->request->Session()->read('sessionPlan') == 1 || $this->request->Session()->read('sessionPlan') == 4) {

            if (!empty($this->request->data['costs_id'])) {
                foreach ($costs as $cost):
                    $list_of_costs[] = $cost->title;
                endforeach;
                echo '<span class="text-bold">Categorias: </span>' . implode(", ", $list_of_costs) . '<br />';
            }//if (!empty($this->request->data['costs_id']))

        }//elseif ($this->request->Session()->read('sessionPlan') == 1 || $this->request->Session()->read('sessionPlan') == 4))

        if ($this->request->data['contabil'] == 'S') {
            echo '<span class="text-bold">Contábil: </span>Sim <br />';
        } elseif ($this->request->data['contabil'] == 'N') {
            echo '<span class="text-bold">Contábil: </span>Não <br />';
        } else {
            echo '<span class="text-bold">Contábil: </span>Todos <br />';
        }

        if (isset($this->request->data['Ordem'])) {

            switch($this->request->data['Ordem']):
                case 'ordem':             $ordem = 'Ordem'; break;
                case 'data':              $ordem = 'Data do Lançamento'; break;
                case 'vencimento':        $ordem = 'Data do Vencimento'; break;
                case 'dtbaixa':           $ordem = 'Data do Pagamento'; break;
                case 'historico':         $ordem = 'Histórico'; break;
                case 'document_types_id': $ordem = 'Tipes de Documento'; break;
                case 'event_types_id':    $ordem = 'Tipos de Evento'; break;
                case 'status':            $ordem = 'Status'; break;
            endswitch;

            echo '<span class="text-bold">Ordem: </span>'.$ordem.'<br />';
        }
    ?>