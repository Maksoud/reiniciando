<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

namespace App\View\Helper;
use Cake\View\Helper\HtmlHelper;

class InvoicesHelper extends HtmlHelper 
{
    public function initialize(array $config) {
        //
    }
    
    public function status($status) {
        // P - delivering, C - cancelled, F - finalized
        $string = "";
        
        if ($status == 'P') {
            $prefix = '<span class="label label-success">';
            $sufix  = '</span>';
            $string = $prefix.__('Em Entrega').$sufix;
        } elseif ($status == 'F') {
            $prefix = '<span class="label label-default">';
            $sufix  = '</span>';
            $string = $prefix.__('Finalizado').$sufix;
        } elseif ($status == 'C') {
            $prefix = '<span class="label label-danger">';
            $sufix  = '</span>';
            $string = $prefix.__('Cancelado').$sufix;
        } else {
            $string = '-';
        }
        
        return $string;
    }

    public function freighttype($freighttype) {
        $string = "";

        if ($freighttype == 'C') {
            $prefix = '<span class="label label-primary">';
            $sufix  = '</span>';
            $string = $prefix.__('CIF').$sufix;
        } elseif ($freighttype == 'F') {
            $prefix = '<span class="label label-success">';
            $sufix  = '</span>';
            $string = $prefix.__('FOB').$sufix;
        } else {
            $string = '-';
        }
        
        return $string;
    }

    public function type($type) {
        // S - Sell, P - Purchase, DS - detached selling, DP - detached purchasing
        $string = "";

        if ($type == 'S') {
            $prefix = '<span class="label label-primary">';
            $sufix  = '</span>';
            $string = $prefix.__('Venda').$sufix;
        } elseif ($type == 'P') {
            $prefix = '<span class="label label-primary">';
            $sufix  = '</span>';
            $string = $prefix.__('Compra').$sufix;
        } elseif ($type == 'DS') {
            $prefix = '<span class="label label-primary">';
            $sufix  = '</span>';
            $string = $prefix.__('Saída Avulsa').$sufix;
        } elseif ($type == 'DP') {
            $prefix = '<span class="label label-primary">';
            $sufix  = '</span>';
            $string = $prefix.__('Entrada Avulsa').$sufix;
        } else {
            $string = '-';
        }
        
        return $string;
    }
    
}

?>