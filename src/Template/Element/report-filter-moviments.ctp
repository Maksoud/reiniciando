<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/report-filter-moviments.ctp */
?>

    <span class="text-bold"><?= __('FILTROS') ?></span><br />
    <?php
        if ($this->request->data['dtinicial'] && $this->request->data['dtfinal']) {
	        if (isset($this->request->data['dtemissao'])) {
	            $desc = 'Data de Emissão: ';
	        } elseif ($this->request->data['Situação'] == 'baixado') {
	            $desc = 'Data de Pagamento: ';
	        } else {
	            $desc = 'Data de Vencimento: ';
	        }
	        
	        echo $desc.$this->request->data['dtinicial'].' até '.$this->request->data['dtfinal'].'<br />';
        }
        if ($this->request->data['historico'] != null) {
            echo 'Histórico: '.$this->request->data['historico'].'<br />';
        }
        if (!empty($this->request->data['customers_id'])) {
            echo 'Cliente: '.$customer['title'].'<br />';
        }
        if (!empty($this->request->data['providers_id'])) {
            echo 'Fornecedor: '.$provider['title'].'<br />';
        }
        if (!empty($this->request->data['account_plans_id'])) {
            echo 'Plano de Contas: '.$accountPlan['title'].'<br />';
        }
        if (!empty($this->request->data['document_types_id'])) {
            echo 'Tipo de Documento: '.$documentType['title'].'<br />';
        }
        if (!empty($this->request->data['event_types_id'])) {
            echo 'Tipo de Evento: '.$eventType['title'].'<br />';
        }
        if (!empty($this->request->data['costs_id'])) {
            echo 'Centro de Custos: '.$cost['title'].'<br />';
        }
        if ($this->request->data['contabil'] == 'S') {
            echo 'Contábil: Sim <br />';
        } elseif ($this->request->data['contabil'] == 'N') {
            echo 'Contábil: Não <br />';
        } else {
            echo 'Contábil: Todos <br />';
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