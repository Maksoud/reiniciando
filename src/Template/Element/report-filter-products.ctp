<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/report-filter-products.ctp */
?>

    <h4><span class="text-bold"><?= __('FILTROS') ?></span></h4>
    <?php
		
        if ($this->request->data['dtinicial'] && $this->request->data['dtfinal']) {
        	echo '<span class="text-bold">Período: </span>'.$this->request->data['dtinicial'] . ' à ' . $this->request->data['dtfinal'].'<br />';
        }

        if (!empty($this->request->data['product_types_id'])) {
                
            foreach ($types as $type):
                $list_of_types[] = $type->title;
            endforeach;

            echo '<span class="text-bold">Tipos de Produtos: </span>' . implode(", ", $list_of_types) . '<br />';

        } else {
            
            echo '<span class="text-bold">Todos os tipos de produtos. </span> <br />';
            
        }//else if (!empty($this->request->data['product_types_id']))

        if (!empty($this->request->data['product_groups_id'])) {
                
            foreach ($groups as $group):
                $list_of_groups[] = $group->title;
            endforeach;

            echo '<span class="text-bold">Grupos de Produtos: </span>' . implode(", ", $list_of_groups) . '<br />';

        } else {
            
            echo '<span class="text-bold">Todos os grupos de produtos. </span> <br />';

        }//else if (!empty($this->request->data['product_groups_id']))

        if (isset($this->request->data['Ordem'])) {

            switch($this->request->data['Ordem']):
                case 'title':   $ordem = 'Título'; break;
                case 'code':    $ordem = 'Código Interno'; break;
                case 'ean':     $ordem = 'EAN'; break;
                case 'ncm':     $ordem = 'NCM'; break;
            endswitch;

            echo '<span class="text-bold">Ordem: </span>'.$ordem.'<br />';
        }
    ?>