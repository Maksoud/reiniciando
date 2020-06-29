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

class SellItemsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('sell_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Sells', [
            'foreignKey' => 'sells_id',
            'propertyName' => 'Sells'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'propertyName' => 'Products'
        ]);
        $this->belongsTo('Parameters', [
            'foreignKey' => 'parameters_id',
            'propertyName' => 'Parameters',
            'joinType' => 'INNER'
        ]);
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('sells_id');
        $validator
            ->notEmpty('products_id');

        return $validator;
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        $rules->add($rules->existsIn(['sells_id'], 'Sells'));
        $rules->add($rules->existsIn(['products_id'], 'Products'));

        return $rules;
    }
}