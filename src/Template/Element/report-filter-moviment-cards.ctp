<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/report-filter-moviment-cards.ctp */
?>

    <span class="text-bold"><?= __('FILTROS') ?></span><br />
    <?php
        echo '<span class="text-bold">Data de Vencimento: </span>'.$this->request->data['dtinicial'].
             ' até '.$this->request->data['dtfinal'].'<br />';
		
		$cartoes = null;

        if (isset($cards)) {

            foreach($cards as $card):
                $list_of_cards[] = $card;
            endforeach;

            echo '<span class="text-bold">Fonte: </span>' . implode(", ", $list_of_cards) . '<br />'; 

        }//if (isset($cards))
		
        if (isset($this->request->data['costs'])) {
            echo '<span class="text-bold">Centro de Custo: '.$this->request->data['costs'].'<br />';
        }
        if ($this->request->data['creditodebito'] == 'D') {
            echo '<span class="text-bold">Compras</span> <br />';
        } elseif ($this->request->data['creditodebito'] == 'C') {
            echo '<span class="text-bold">Estornos</span> <br />';
        } else {
            echo '<span class="text-bold">Compras e Estornos</span> <br />';
        }
        if (!empty($this->request->data['account_plans_id'])) {
            echo '<span class="text-bold">Plano de Contas: </span>'.$accountPlan['title'].'<br />';
        }
        if (!empty($this->request->data['costs_id'])) {
            echo '<span class="text-bold">Centro de Custos: </span>'.$cost['title'].'<br />';
        }
        if ($this->request->data['contabil'] == 'S') {
            echo '<span class="text-bold">Contábil:</span> Sim <br />';
        } elseif ($this->request->data['contabil'] == 'N') {
            echo '<span class="text-bold">Contábil:</span> Não <br />';
        } else {
            echo '<span class="text-bold">Contábil:</span> Todos <br />';
        }
        echo '<span class="text-bold">Ordem:</span> Vencimento <br />';
		if ($this->request->data['Situação'] == 'aberto') {
            echo '<span class="text-bold">Listando Somente Títulos em Aberto</span>';
        } elseif ($this->request->data['Situação'] == 'baixado') {
            echo '<span class="text-bold">Listando Somente Títulos Pagos</spanspan>';
        } else {
			echo '<span class="text-bold">Listando Títulos Pagos e Abertos</span>';
		}
    ?>