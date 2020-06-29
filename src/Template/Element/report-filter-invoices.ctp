<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/report-filter-invoices.ctp */
?>

    <h4><span class="text-bold"><?= __('FILTROS') ?></span></h4>
    <?php
		
        if ($this->request->data['dtinicial'] && $this->request->data['dtfinal']) {
        	echo '<span class="text-bold">Período: </span>'.$this->request->data['dtinicial'] . ' à ' . $this->request->data['dtfinal'].'<br />';
        }

        /******************************************************************/

        if (!empty($this->request->data['providers_id'])) {
                
            foreach ($providers as $provider):
                $list_of_providers[] = $provider->title;
            endforeach;

            echo '<span class="text-bold">Fornecedores: </span>' . implode(", ", $list_of_providers) . '<br />';
            
        }//if (!empty($this->request->data['providers_id']))

        /******************************************************************/

        if (!empty($this->request->data['customers_id'])) {
                
            foreach ($customers as $customer):
                $list_of_customers[] = $customer->title;
            endforeach;
            
            echo '<span class="text-bold">Clientes: </span>' . implode(", ", $list_of_customers) . '<br />';
            
        }//if (!empty($this->request->data['customers_id']))

        /******************************************************************/

        if (!empty($this->request->data['status'])) {

            switch ($this->request->data['status']) {
                case 'P':
                    $status = 'Em Entrega';
                    break;
                case 'C':
                    $status = 'Cancelado';
                    break;
                case 'F':
                    $status = 'Finalizado';
                    break;
            }
            
            echo '<span class="text-bold">Status: </span>' . $status . '<br />';

        }//if (!empty($this->request->data['status']))

        /******************************************************************/

        if (isset($this->request->data['Ordem'])) {

            switch($this->request->data['Ordem']):
                case 'nf':          $ordem = 'Número da Nota Fiscal'; break;
                case 'dtemissaonf': $ordem = 'Data de Emissão da NF'; break;
                case 'type':        $ordem = 'Tipo de Faturamento'; break;
                case 'status':      $ordem = 'Status'; break;
            endswitch;

            echo '<span class="text-bold">Ordem: </span>'.$ordem.'<br />';
        }
    ?>