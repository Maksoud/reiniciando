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

class ProductTypesHelper extends HtmlHelper 
{
    public function initialize(array $config) {
        //
    }
    
    public function calc_cost($calc_cost) {
        $string = "";
        
        if ($calc_cost == 'S') {
            $prefix = '<span class="label label-primary">';
            $sufix  = '</span>';
            $string = $prefix.__('Sim').$sufix;
        } elseif ($calc_cost == 'N') {
            $prefix = '<span class="label label-default">';
            $sufix  = '</span>';
            $string = $prefix.__('Não').$sufix;
        } else {
            $string = '-';
        }
        
        return $string;
    }
    
}

?>