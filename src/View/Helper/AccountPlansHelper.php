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

class AccountPlansHelper extends HtmlHelper 
{
    public function initialize(array $config) {
        //
    }
    
    public function status($status) {
        $string = "";
        
        if ($status == 'A') {
            $prefix = '<span class="label label-success">';
            $sufix  = '</span>';
            $string = $prefix.__('Ativo').$sufix;
        } elseif ($status == 'I') {
            $prefix = '<span class="label label-default">';
            $sufix  = '</span>';
            $string = $prefix.__('Inativo').$sufix;
        } elseif ($status == 'T') {
            $prefix = '<span class="label label-warning">';
            $sufix  = '</span>';
            $string = $prefix.__('Automático').$sufix;
        } else {
            $string = '-';
        }
        
        return $string;
    }
    
    public function receitadespesa($receitadespesa) {
        $string = "";
        
        if ($receitadespesa == 'R') {
            $prefix = '<span class="label label-primary">';
            $sufix  = '</span>';
            $string = $prefix.__('Receita').$sufix;
        } elseif ($receitadespesa == 'D') {
            $prefix = '<span class="label label-warning">';
            $sufix  = '</span>';
            $string = $prefix.__('Despesa').$sufix;
        } else {
            $string = '-';
        }
        
        return $string;
    }
    
}

?>