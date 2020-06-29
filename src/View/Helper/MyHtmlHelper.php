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
use Cake\I18n\Time;
use Cake\I18n\Date;

class MyHtmlHelper extends HtmlHelper 
{
    public function initialize(array $config) 
    {
        // initialize
    }
    
    public function MesPorExtenso($mes)
    {
        if (!empty($mes)) {
            
            switch ($mes) {
                case 1:
                    return __('Janeiro');
                case 2:
                    return __('Fevereiro');
                case 3:
                    return __('Março');
                case 4:
                    return __('Abril');
                case 5:
                    return __('Maio');
                case 6:
                    return __('Junho');
                case 7:
                    return __('Julho');
                case 8:
                    return __('Agosto');
                case 9:
                    return __('Setembro');
                case 10:
                    return __('Outubro');
                case 11:
                    return __('Novembro');
                case 12:
                    return __('Dezembro');
            }
            
        }//if (!empty($mes))
        
    }
    
    public function MesAbreviado($mes)
    {
        if (!empty($mes)) {
            
            switch ($mes) {
                case 1:
                    return __('Jan');
                case 2:
                    return __('Fev');
                case 3:
                    return __('Mar');
                case 4:
                    return __('Abr');
                case 5:
                    return __('Mai');
                case 6:
                    return __('Jun');
                case 7:
                    return __('Jul');
                case 8:
                    return __('Ago');
                case 9:
                    return __('Set');
                case 10:
                    return __('Out');
                case 11:
                    return __('Nov');
                case 12:
                    return __('Dez');
            }
            
        }//if (!empty($mes))
        
    }
    
    public function MesNumeral($mes)
    {
        if (!empty($mes)) {
            
            $mes = strtolower($mes);

            if (strlen($mes) <= 3) {

                if ($mes == 'jan' || $mes == 'jan') { return '1'; }
                if ($mes == 'fev' || $mes == 'feb') { return '2'; }
                if ($mes == 'mar' || $mes == 'mar') { return '3'; }
                if ($mes == 'abr' || $mes == 'apr') { return '4'; }
                if ($mes == 'mai' || $mes == 'mai') { return '5'; }
                if ($mes == 'jun' || $mes == 'jun') { return '6'; }
                if ($mes == 'jul' || $mes == 'jul') { return '7'; }
                if ($mes == 'ago' || $mes == 'aug') { return '8'; }
                if ($mes == 'set' || $mes == 'sep') { return '9'; }
                if ($mes == 'out' || $mes == 'oct') { return '10'; }
                if ($mes == 'nov' || $mes == 'nov') { return '11'; }
                if ($mes == 'dez' || $mes == 'dec') { return '12'; }

            } else {

                if ($mes == 'janeiro'   || $mes == 'january') {   return '1'; }
                if ($mes == 'fevereiro' || $mes == 'february') {  return '2'; }
                if ($mes == 'março'     || $mes == 'march') {     return '3'; }
                if ($mes == 'abril'     || $mes == 'april') {     return '4'; }
                if ($mes == 'maio'      || $mes == 'may') {       return '5'; }
                if ($mes == 'junho'     || $mes == 'june') {      return '6'; }
                if ($mes == 'julho'     || $mes == 'july') {      return '7'; }
                if ($mes == 'agosto'    || $mes == 'august') {    return '8'; }
                if ($mes == 'setembro'  || $mes == 'september') { return '9'; }
                if ($mes == 'outubro'   || $mes == 'octuber') {   return '10'; }
                if ($mes == 'novembro'  || $mes == 'november') {  return '11'; }
                if ($mes == 'dezembro'  || $mes == 'december') {  return '12'; }

            }
            
        }//if (!empty($mes))
        
    }
    
    public function fullDate($date)
    {
        if (!empty($date)) {
            
            if (!$date = strtotime($date)) {
				
                //Cake\I18n\FrozenTime
                $date = new Time($string->format('Y-m-d'));
				
            } else {
				
                //Cake\I18n\FrozenDate
                $date = new Time($date);
				
            }
			
			if ($this->request->Session()->read('locale') == 'pt_BR') {
				return $date->i18nFormat("dd 'de' MMMM 'de' yyyy");
			} else {
				return $date->i18nFormat("MMMM, dd 'of' yyyy");
			}
            
        }//if (!empty($date))
        
    }
    
    public function tinyDate($date)
    {
        if (!empty($date)) {
            
            $string = $date;
			
            if (!$date = strtotime($date)) {
				
                //Cake\I18n\FrozenTime
                $date = new Time($string->format('Y-m-d'));
				
            } else {
				
                //Cake\I18n\FrozenDate
                $date = new Time($date);
				
            }
			
			if ($this->request->Session()->read('locale') == 'pt_BR') {
				
				if ($date->isToday()) {
					$string = "Hoje ";
				} elseif ($date->isYesterday()) {
					$string = "Ontem ";
				} else {
					$string = $date->i18nFormat("dd/MM/yyyy");
				}
				
			} else {
				
				if ($date->isToday()) {
					$string = "Today ";
				} elseif ($date->isYesterday()) {
					$string = "Yesterday ";
				} else {
					$string = $date->i18nFormat("yyyy-MM-dd");
				}
				return $date->i18nFormat("MMMM, dd 'of' yyyy");
				
			}
			
            return $string;
            
        }//if (!empty($date))
        
    }
    
    public function date($date)
    {
        
        if (!empty($date)) {
            
            $string = $date;
			
            if (strpos($string, '/') && strlen($string) == 14) { 
                $dt = explode('/', substr($string, 0, 8));
                $date = $dt[1].'/'.$dt[0].'/'.$dt[2];
            }
			
            if (!$date = strtotime($date)) {
				
                //Cake\I18n\FrozenTime
                $date = new Time($string->format('Y-m-d'));
				
            } else {
				
                //Cake\I18n\FrozenDate
                $date = new Time($date);
				
            }
			
			if ($this->request->Session()->read('locale') == 'pt_BR') {
				
				if ($date->isToday()) {
					$string = __("Hoje ");
				} elseif ($date->isYesterday()) {
					$string = __("Ontem ");
				} else {
					$string = $date->i18nFormat("dd 'de' ");
					$string .= ucwords($date->i18nFormat("MMMM"));
					$string .= $date->i18nFormat(" 'de' yyyy");
				}
				
			} else {
				
				if ($date->isToday()) {
					$string = __("Today ");
				} elseif ($date->isYesterday()) {
					$string = __("Yesterday ");
				} else {
					$string = ucwords($date->i18nFormat("MMMM, "));
					$string .= $date->i18nFormat("dd ");
					$string .= $date->i18nFormat(" 'of' yyyy");
				}
			}
			
            return $string;
            
        }//if (!empty($date))
        
    }
    
    public function time($datetime) 
    {
        
        if (!empty($datetime)) {
            
            $string = $datetime;
			
            if ($datetime) {
				
				if ($this->request->Session()->read('locale') == 'pt_BR') {
					
					if ($datetime->isToday()) {
						$string = "Hoje " . $datetime->i18nFormat("'às' HH'h'mm");
					} elseif ($datetime->isYesterday()) {
						$string = "Ontem " . $datetime->i18nFormat("'às' HH'h'mm");
					} else {

						if ($datetime->isThisYear()) {
							$string = $datetime->i18nFormat("dd 'de' ");
							$string .= ucwords($datetime->i18nFormat("MMMM"));
							$string .= $datetime->i18nFormat(" 'às' HH'h'mm");
						} else {
							$string = $datetime->i18nFormat("dd 'de' ");
							$string .= ucwords($datetime->i18nFormat("MMMM"));
							$string .= $datetime->i18nFormat(" 'de' yyyy 'às' HH'h'mm");
						}

					}
					
				} else {
					
					if ($datetime->isToday()) {
						$string = "Today " . $datetime->i18nFormat(" HH'h'mm");
					} elseif ($datetime->isYesterday()) {
						$string = "Yesterday " . $datetime->i18nFormat(" HH'h'mm");
					} else {

						if ($datetime->isThisYear()) {
							$string = $datetime->i18nFormat("dd 'de' ");
							$string .= ucwords($datetime->i18nFormat("MMMM"));
							$string .= $datetime->i18nFormat(" 'às' HH'h'mm");
						} else {
							$string = ucwords($datetime->i18nFormat("MMMM, "));
							$string .= $datetime->i18nFormat("dd ");
							$string .= $datetime->i18nFormat(" 'de' yyyy 'às' HH'h'mm");
						}

					}
					
				}
				
			}//if ($datetime)
			
            return $string;
            
        }//if (!empty($datetime))
        
    }

    public function imgThumb($src, $thumb = [],$tags = [])
    {
        if (!$src) {
            return false;
		}
		
        $tags_array = [];
        $thumb_array = [];
        
        if ($tags) {
            foreach ($tags as $chave => $value) {
                $tags_array[] = $chave.'="'.$value.'"';
            }
        }
        
        if ($thumb) {
            foreach ($thumb as $chave => $value) {
                $thumb_array[] = $chave.'='.$value;
            }
        }
        
        if ($src) {
            $thumb_array[] = "src=".$src;
        }
        
        $tag_img = '<img src="f.php?'.implode("&", $thumb_array).'" '.implode(" ", $tags_array).'/>';  
        
        return $tag_img;
    }
    
    public function convertDateUTCArrayToJson($array_date_utc)
    {
        $json_date_utc = [];
		
        foreach ($array_date_utc as $date_utc => $valores) {
            $json_date_utc[] = "[".$date_utc.",".array_sum($valores)."]";
        }    
        
        return implode(",", $json_date_utc);  
    }
    
}