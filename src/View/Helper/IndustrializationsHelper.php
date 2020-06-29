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

class IndustrializationsHelper extends HtmlHelper 
{
    public function initialize(array $config) {
        //
    }
    
    public function status($status) {
        // P - pending, C - cancelled, F - finalized
        $string = "";
        
        if ($status == 'P') {
            $prefix = '<span class="label label-success">';
            $sufix  = '</span>';
            $string = $prefix.__('Em Processo').$sufix;
        } elseif ($status == 'C') {
            $prefix = '<span class="label label-danger">';
            $sufix  = '</span>';
            $string = $prefix.__('Cancelado').$sufix;
        } elseif ($status == 'F') {
            $prefix = '<span class="label label-default">';
            $sufix  = '</span>';
            $string = $prefix.__('Finalizado').$sufix;
        } else {
            $string = '-';
        }
        
        return $string;
    }
    
}

?>