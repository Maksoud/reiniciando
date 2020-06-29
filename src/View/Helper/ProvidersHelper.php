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

class ProvidersHelper extends HtmlHelper 
{
    public function initialize(array $config) {
        //
    }
    
    public function status($status) {
        $string = "";
        
        if ($status == 'A') {
            $prefix = '<span class="label label-primary">';
            $sufix  = '</span>';
            $string = $prefix.__('Ativo').$sufix;
        } elseif ($status == 'I') {
            $prefix = '<span class="label label-danger">';
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
    
    public function tipo($tipo) {
        $string = "";
        
        if ($tipo == 'J') {
            $prefix = '<span class="label label-default">';
            $sufix  = '</span>';
            $string = $prefix.__('Pessoa Jurídica').$sufix;
        } elseif ($tipo == 'F') {
            $prefix = '<span class="label label-default">';
            $sufix  = '</span>';
            $string = $prefix.__('Pessoa Física').$sufix;
        } else {
            $string = '-';
        }
        
        return $string;
    }
    
}

?>