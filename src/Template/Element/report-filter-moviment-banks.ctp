<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/report-filter-moviment-banks.ctp */
?>

    <span class="text-bold"><?= __('FILTROS') ?></span><br />
    <?php
        if ($this->request->data['dtinicial'] && $this->request->data['dtfinal']) {
            if ($this->request->data['datapesq'] == 'lancamento') {
                    $desc = '<span class="text-bold">'.'Data do Lançamento: '.'</span>';
                } elseif ($this->request->data['datapesq'] == 'vencimento') {
                    $desc = '<span class="text-bold">'.'Data do Vencimento: '.'</span>';
                } elseif ($this->request->data['datapesq'] == 'consolidacao') {
                    $desc = '<span class="text-bold">'.'Data do Pagamento: '.'</span>';
                }
                echo $desc.$this->request->data['dtinicial'].' até '.$this->request->data['dtfinal'].'<br>';
        }

        if (isset($banks)) {

            foreach($banks as $bank):
                $list_of_banksBoxes[] = $bank;
            endforeach;

            echo '<span class="text-bold">Fonte: </span>' . implode(", ", $list_of_banksBoxes) . '<br />';

        }//if (isset($banks))

        if (!empty($this->request->data['creditodebito'])) {
            if ($this->request->data['creditodebito'] == 'C') { $receitadespesa = 'Receitas';}
            elseif ($this->request->data['creditodebito'] == 'D') { $receitadespesa = 'Despesas';}
            elseif ($this->request->data['creditodebito'] == 'A') { $receitadespesa = 'Todos';}
            echo '<span class="text-bold">'.'Receita/Despesa: '.'</span>' . $receitadespesa . '<br>';
        }
        if ($this->request->data['historico'] != null) {
            echo '<span class="text-bold">'.'Histórico: '.'</span>'.$this->request->data['historico'].'<br />';
        }
        if (!empty($this->request->data['account_plans_id'])) {
            echo '<span class="text-bold">'.'Plano de Contas: '.'</span>'.$accountPlan['title'].'<br />';
        }
        if (!empty($this->request->data['document_types_id'])) {
            echo '<span class="text-bold">'.'Tipo de Documento: '.'</span>'.$documentType['title'].'<br />';
        }
        if (!empty($this->request->data['event_types_id'])) {
            echo '<span class="text-bold">'.'Tipo de Evento: '.'</span>'.$eventType['title'].'<br />';
        }
        if (!empty($this->request->data['costs_id'])) {
            echo '<span class="text-bold">'.'Centro de Custos: '.'</span>'.$cost['title'].'<br />';
        }
        if (!empty($this->request->data['Receita/Despesa'])) {
            echo '<span class="text-bold">'.'Receita/Despesa: '.'</span>'.$this->request->data['Receita/Despesa'].'<br>';
        }
//        if ($this->request->data['Tipo de Conta'] == 'C') {
//            echo 'Tipo de Conta: Conta Corrente <br>';
//        } elseif ($this->request->data['Tipo de Conta'] == 'P') {
//            echo 'Tipo de Conta: Conta Poupança <br>';
//        } elseif ($this->request->data['Tipo de Conta'] == 'A') {
//            echo 'Tipo de Conta: Conta Aplicação <br>';
//        } elseif ($this->request->data['Tipo de Conta'] == 'S') {
//            echo 'Tipo de Conta: Conta Salário <br>';
//        }
        if ($this->request->data['contabil'] == 'S') {
            echo '<span class="text-bold">'.'Contábil: '.'</span>'.'Sim <br />';
        } elseif ($this->request->data['contabil'] == 'N') {
            echo '<span class="text-bold">'.'Contábil: '.'</span>'.'Não <br />';
        } else {
            echo '<span class="text-bold">'.'Contábil: '.'</span>'.'Todos <br />';
        }
        if (isset($this->request->data['Ordem'])) {

            switch($this->request->data['Ordem']):
                case 'ordem':             $ordem = 'Ordem'; break;
                case 'data':              $ordem = 'Data do Lançamento'; break;
                case 'vencimento':        $ordem = 'Data do Vencimento'; break;
                case 'dtbaixa':           $ordem = 'Data do Pagamento'; break;
                case 'historico':         $ordem = 'Histórico/Descrição'; break;
                case 'document_types_id': $ordem = 'Tipos de Documento'; break;
                case 'event_types_id':    $ordem = 'Tipos de Evento'; break;
                case 'status':            $ordem = 'Status'; break;
            endswitch;

            echo '<span class="text-bold">Ordem: </span>'.$ordem.'<br />';
        }
    ?>