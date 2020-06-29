<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class MovimentChecksFunctionsComponent extends Component 
{
    public function __construct()
    {
        $this->MovimentChecks = TableRegistry::get('MovimentChecks');
    }
    
    public function validaCheque($cheque, $parameters_id)
    {
        //Busca lançamentos com mesmo número de cheque
        $check = $this->MovimentChecks->findByParametersId($parameters_id)
                                      ->where(['MovimentChecks.cheque' => $cheque])
                                      ->first();
        
        if (!empty($check)) {
            //Movimento de cheque existente na ordem $check->ordem
            return $check->ordem;
        }//if (!empty($check))

    }
    
}