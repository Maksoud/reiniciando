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

class TransfersFunctionsComponent extends Component 
{
    public function __construct()
    {
        $this->Transfers = TableRegistry::get('Transfers');
        
        $this->RegisterMoviments = new RegisterMovimentsComponent();
        $this->GeneralBalance    = new GeneralBalanceComponent();
    }
    
    public function deleteDependency($object)
    {
        //Atualiza os saldos
        $this->GeneralBalance->balance($object, true);
        
        //Exclui registros do banco
        $this->RegisterMoviments->deleteMovimentBank($object);
        
        //Exclui registros de cheques
        $this->RegisterMoviments->deleteMovimentCheck($object);
        
        //Exclui registros do caixa
        $this->RegisterMoviments->deleteMovimentBox($object);
    }
    
    public function transfer($object)
    {
        $this->RegisterMoviments = new RegisterMovimentsComponent();
        
        $bs = $object->banks_id;
        $bd = $object->banks_dest;
        $cs = $object->boxes_id;
        $cd = $object->boxes_dest;
        
        if ($bs && $bd) {
            $this->RegisterMoviments->movimentBank($object, null, 'source');
            $this->RegisterMoviments->movimentBank($object, null, 'destination');
        } elseif ($cs && $cd) {
            $this->RegisterMoviments->movimentBox($object, null, 'source');
            $this->RegisterMoviments->movimentBox($object, null, 'destination');
        } elseif ($bs && $cd) {
            $this->RegisterMoviments->movimentBank($object, null, 'source');
            $this->RegisterMoviments->movimentBox($object, null, 'destination');
        } elseif ($cs && $bd) {
            $this->RegisterMoviments->movimentBox($object, null, 'source');
            $this->RegisterMoviments->movimentBank($object, null, 'destination');               
        }
    }
    
}