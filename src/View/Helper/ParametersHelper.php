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

class ParametersHelper extends HtmlHelper 
{
    public function initialize(array $config) {
        //
    }
    
    public function status($dtvalidade) {
        $string = "";
        
        if ($dtvalidade > date('Y-m-d')) {
            $string = __('Ativo');
        } elseif ($dtvalidade == date('Y-m-d')) {
            $string = __('Dia de PGTO');
        } elseif ($dtvalidade < date('Y-m-d')) {
            $string = __('Vencido');
        } else {
            $string = '-';
        }
        
        return $string;
    }
    
    public function planos($planos) {
        $string = "";
        
        if (empty($planos)) {
            $string = __('Não Selecionado');
        } else {
            switch($planos) {
                case '1':
                    $string = __('Pessoal');
                    break;
                case '2':
                    $string = __('Simples');
                    break;
                case '3':
                    $string = __('Completo');
                    break;
                case '4':
                    $string = __('Limitado');
                    break;
                default:
                    $string = '-';
            }
        }
        
        return $string;
    }
    
}

?>