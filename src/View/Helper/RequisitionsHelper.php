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

class RequisitionsHelper extends HtmlHelper 
{
    public function initialize(array $config) {
        //
    }
    
    public function type($type) {
        // I - in, O - out
        $string = "";
        
        if ($type == 'I') {
            $prefix = '<span class="label label-success">';
            $sufix  = '</span>';
            $string = $prefix.__('Entrada').$sufix;
        } elseif ($type == 'O') {
            $prefix = '<span class="label label-danger">';
            $sufix  = '</span>';
            $string = $prefix.__('Saída').$sufix;
        } else {
            $string = '-';
        }
        
        return $string;
    }
    
    public function status($status) {
        // F - finalized, C - cancelled
        $string = "";
        
        if ($status == 'F') {
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
    
}

?>