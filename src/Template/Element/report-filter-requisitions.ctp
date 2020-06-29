<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/report-filter-requisitions.ctp */
?>

    <h4><span class="text-bold"><?= __('FILTROS') ?></span></h4>
    <?php
		
        if ($this->request->data['dtinicial'] && $this->request->data['dtfinal']) {
        	echo '<span class="text-bold">Período: </span>'.$this->request->data['dtinicial'] . ' à ' . $this->request->data['dtfinal'].'<br />';
        }

        /******************************************************************/

        if (!empty($this->request->data['sells_id'])) {
                
            foreach ($sells as $sell):
                $list_of_sells[] = $sell->title;
            endforeach;

            echo '<span class="text-bold">Pedidos de Vendas: </span>' . implode(", ", $list_of_sells) . '<br />';
            
        }//if (!empty($this->request->data['sells_id']))

        /******************************************************************/

        if (!empty($this->request->data['customers_id'])) {
                
            foreach ($customers as $customer):
                $list_of_customers[] = $customer->title;
            endforeach;

            echo '<span class="text-bold">Clientes: </span>' . implode(", ", $list_of_customers) . '<br />';
            
        }//if (!empty($this->request->data['customers_id']))

        /******************************************************************/

        if (!empty($this->request->data['industrializations_id'])) {
                
            foreach ($industrializations as $industrialization):
                $list_of_industrializations[] = $industrialization->title;
            endforeach;

            echo '<span class="text-bold">Ordens de Fabricação: </span>' . implode(", ", $list_of_industrializations) . '<br />';

        }//if (!empty($this->request->data['industrializations_id']))

        /******************************************************************/

        if (!empty($this->request->data['status'])) {

            switch ($this->request->data['status']) {
                case 'F':
                    $status = 'Finalizado';
                    break;
                case 'C':
                    $status = 'Cancelado';
                    break;
            }//switch ($this->request->data['status'])
            
            echo '<span class="text-bold">Status: </span>' . $status . '<br />';

        }//if (!empty($this->request->data['status']))

        /******************************************************************/

        if (isset($this->request->data['Ordem'])) {

            switch($this->request->data['Ordem']):
                case 'code':      $ordem = 'Código do Registro'; break;
                case 'date':      $ordem = 'Data de Lançamento'; break;
                case 'applicant': $ordem = 'Solicitante'; break;
                case 'status':    $ordem = 'Status'; break;
            endswitch;

            echo '<span class="text-bold">Ordem: </span>'.$ordem.'<br />';
        }
    ?>