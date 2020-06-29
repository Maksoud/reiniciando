<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

class InvoicesPurchasesSellsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->setTable('invoices_purchases_sells');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Parameters', [
            'foreignKey' => 'parameters_id',
            'propertyName' => 'Parameters',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Invoices', [
            'foreignKey' => 'invoices_id',
            'propertyName' => 'Invoices',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Purchases', [
            'foreignKey' => 'purchases_id',
            'propertyName' => 'Purchases',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Sells', [
            'foreignKey' => 'sells_id',
            'propertyName' => 'Sells',
            'joinType' => 'INNER'
        ]);
    }
    
    public function validationDefault(Validator $validator)
    {
        return $validator;
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        $rules->add($rules->existsIn(['invoices_id'], 'Invoices'));
        $rules->add($rules->existsIn(['purchases_id'], 'Purchases'));
        $rules->add($rules->existsIn(['sells_id'], 'Sells'));
        
        return $rules;
    }
}
