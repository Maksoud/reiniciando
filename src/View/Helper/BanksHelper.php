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

class BanksHelper extends HtmlHelper 
{
    public function initialize(array $config) 
    {
        //
    }
    
    public function status($status) {
        $string = "";
        
        if ($status == 'A') {
            $prefix = '<span class="label label-primary">';
            $sufix  = '</span>';
            $string = $prefix.__('Ativo').$sufix;
        } elseif ($status == 'I') {
            $prefix = '<span class="label label-default">';
            $sufix  = '</span>';
            $string = $prefix.__('Inativo').$sufix;
        } else {
            $prefix = '<span class="label label-warning">';
            $sufix  = '</span>';
            $string = $prefix.__('Automático').$sufix;
        }
        
        return $string;
    }
    
    public function tipoconta($tipoconta) {
        $string = "";
        
        if ($tipoconta == 'C') {
            $string = __('Conta Corrente');
        } elseif ($tipoconta == 'P') {
            $string = __('Conta Poupança');
        } elseif ($tipoconta == 'A') {
            $string = __('Conta Aplicação');
        } elseif ($tipoconta == 'S') {
            $string = __('Conta Salário');
        } else {
            $string = '-';
        }
        
        return $string;
    }
    
}

?>