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

class TransfersHelper extends HtmlHelper 
{
    public function initialize(array $config) {
        //
    }
    
    public function status($status) {
        $string = "";
        
        if ($status == 'A') {
            $prefix = '<span class="label label-success">';
            $sufix  = '</span>';
            $string = $prefix.__('Aberto').$sufix;
        } elseif ($status == 'B') {
            $prefix = '<span class="label label-default">';
            $sufix  = '</span>';
            $string = $prefix.__('Baixado').$sufix;
        } elseif ($status == 'C') {
            $prefix = '<span class="label label-danger">';
            $sufix  = '</span>';
            $string = $prefix.__('Cancelado').$sufix;
        } elseif ($status == 'P') {
            $prefix = '<span class="label label-warning">';
            $sufix  = '</span>';
            $string = $prefix.__('Programado').$sufix;
        } else {
            $string = '-';
        }
        
        return $string;
    }
    
}

?>