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

class MovimentsHelper extends HtmlHelper 
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
        } elseif ($status == 'G') {
            $prefix = '<span class="label label-warning">';
            $sufix  = '</span>';
            $string = $prefix.__('Agrupado').$sufix;
        } elseif ($status == 'V') {
            $prefix = '<span class="label label-default">';
            $sufix  = '</span>';
            $string = $prefix.__('Vinculado').$sufix;
        } elseif ($status == 'O') {
            $prefix = '<span class="label label-default">';
            $sufix  = '</span>';
            $string = $prefix.__('B.Parcial').$sufix;
        } elseif ($status == 'P') {
            $prefix = '<span class="label label-warning">';
            $sufix  = '</span>';
            $string = $prefix.__('Parcial').$sufix;
        } else {
            $string = '-';
        }
        
        return $string;
    }
    
}

?>