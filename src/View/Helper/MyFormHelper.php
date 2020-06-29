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

use Cake\View\Helper\FormHelper;
use Cake\I18n\Time;
use Cake\I18n\Number;

class MyFormHelper extends FormHelper
{
    public function initialize(array $config)
    {
        //initialize
    }	
    
    public function select_ultimos_anos($campo, $options = [], $comeca = 2015) 
    {
        $meses = [];
        $dateTime = new Time();
        $dateTime->year($comeca);
        
        do 
        {
            $meses[$dateTime->year] = $dateTime->year;
            $dateTime->modify('+1 year');
        } while ($dateTime->year <= date('Y'));
        
        return $this->select($campo, $meses, $options);
    }

    public function select_dez_anos($campo, $options = [])
    {
        $meses = [];
        $dateTime = new Time();
        $inicio   = date('Y') - 5;
        $fim      = date('Y') + 5;
        $dateTime->year($inicio);

        do {
            $meses[$dateTime->year] = $dateTime->year;
            $dateTime->modify('+1 year');
        } while ($dateTime->year <= $fim);

        return $this->select($campo, $meses, $options);
    }

    public function select_meses($campo, $options = [])
    {
        $arr = [];
        $datetime = new Time();
        
        for ($i = 1; $i <= 12; $i++)
        {
            $month = ($i < 10) ? '0'.$i : $i;
            $arr["$month"] = ucwords($datetime->month($month)->i18nFormat('MMMM'));
        }
        
        return $this->select($campo, $arr, $options);
    }

    public function decimal($campo)
    {

        $precision = new Number();

        return $precision->precision($campo, 2);

    }
}