<?php

/**
 * Renée Maksoud C. Rodrigues
 * All rights reserved - 2017
 */

class DataPtBrBehavior extends ModelBehavior 
{
    public function replace(Model $Model, $resultados)
    {
        //em cada resultado do array
        foreach($resultados as $key => $value):
            
            //verifico se ele é um array
            if (is_array($value)) {
                
                //se for eu executo a função novamente
                $res[$key] = $Model->replace($value);
                
            //se não
            } else {
                
                //pego as colunas do model atual com o tipo de cada uma no banco
                $colunas = $Model->getColumnTypes();
                
                //em cada coluna
                foreach($colunas as $coluna => $tipo) {
                    
                    //verifico se é do tipo datetime e removo se não for
                    if ($tipo != 'datetime')
                        unset($colunas[$coluna]);
                    
                }
                
                //se o campo atual ainda existir no array colunas então ele é do tipo datetime
                if (array_key_exists($key,$colunas)) {
                    
                    //em cada coluna
                    foreach($colunas as $coluna => $tipo) {
                        
                        //adiciono ao array final o resultado da função organiza
                        $res[$coluna] = $this->organiza($value);
                        
                    }
                    
                //se não
                } else{
                    
                    //apenas adiciono o valor ao array final
                    $res[$key]=$value;
                    
                }
                
            }
            
        endforeach;
        
        //retorno o valor
        if (isset($res))return $res;
        
    }//replace(Model $Model, $resultados)
    
    public function organiza($datahora, $options = ['data' => true, 'hora' => true]) 
    {
        //inicia a variável de retorno vazia
        $res = '';
        
        //separa a data e a hora
        $array = explode(' ', $datahora);
        
        //armazena a data
        $data = array_shift($array);
        
        //armazena a hora
        $hora = array_pop($array);
        
        //extrai as variáveis options
        extract($options, EXTR_PREFIX_SAME, "se");
        
        //se data enviado no options for true (verdadeiro)
        if (($se_data)) {
            
            //separa o dia mes e ano
            $data = explode('-', $data);
            
            //Seta o mes
            switch ($data[1]) {
                case '00': $mes = "none"; break;
                case '01': $mes = "Janeiro"; break;
                case '02': $mes = "Fevereiro"; break;
                case '03': $mes = "Março"; break;
                case '04': $mes = "Abril"; break;
                case '05': $mes = "Maio"; break;
                case '06': $mes = "Junho"; break;
                case '07': $mes = "Julho"; break;
                case '08': $mes = "Agosto"; break;
                case '09': $mes = "Setembro"; break;
                case '10': $mes = "Outubro"; break;
                case '11': $mes = "Novembro"; break;
                case '12': $mes = "Dezembro"; break;
            };
            
            //Pega o valor numérico referente ao dia da semana
            $dia = date('w', strtotime($datahora));
            
            //Define o dia da semana
            switch ($dia) {
                case 0: $semana = 'Domingo'; break;
                case 1: $semana = 'Segunda-feira'; break;
                case 2: $semana = 'Terça-feira'; break;
                case 3: $semana = 'Quarta-feira'; break;
                case 4: $semana = 'Quinta-feira'; break;
                case 5: $semana = 'Sexta-feira'; break;
                case 6: $semana = 'Sábado'; break;
            };

            //Monta a saída da data corretamente segundo padrão: Terça-feira, 21 de Maio de 2013,
            $res .= $semana.', '.$data[2].' de '.$mes.' de '.$data[0];

            //se hora enviado no options for true (verdadeiro), adiciono uma virgula e espaço para separar
            if (($se_hora)) {
                $res .= ', ';
            }

            //se hora enviado no options for true (verdadeiro)
            if (($se_hora)) {
                
                //Pegamos os valores separados da hora
                $hora = explode(':', $hora);
                
                //Organizamos a hora:
                $res .= ' '.$hora[0].'h:'.$hora[1].'m';
                
            }
            
            //Retornamos a string no formato: Terça-feira, 21 de Maio de 2013, 11h:21m
            return $res;
            
        }//if (($se_data)
        
    }//organiza($datahora, $options = ['data' => true, 'hora' => true])
    
    public function afterFind(Model $Model, $resultados, $primary)
    {
        $resultados = $this->replace($Model, $resultados); 
        return $resultados; 
    }
    
}