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

class PurchasesPurchaseRequestsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->setTable('purchase_purchases_requests');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Parameters', [
            'foreignKey' => 'parameters_id',
            'propertyName' => 'Parameters',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PurchaseRequests', [
            'foreignKey' => 'purchase_requests_id',
            'propertyName' => 'PurchaseRequests',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Purchases', [
            'foreignKey' => 'purchases_id',
            'propertyName' => 'Purchases',
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
        $rules->add($rules->existsIn(['purchase_requests_id'], 'PurchaseRequests'));
        $rules->add($rules->existsIn(['purchases_id'], 'Purchases'));
        
        return $rules;
    }
}
