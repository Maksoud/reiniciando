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

class InventoryItemsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('inventory_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Inventories', [
            'foreignKey' => 'inventories_id',
            'propertyName' => 'Inventories'
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
            ->notEmpty('inventories_id');
        $validator
            ->notEmpty('products_id');

        return $validator;
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        $rules->add($rules->existsIn(['inventories_id'], 'Inventories'));
        $rules->add($rules->existsIn(['products_id'], 'Products'));

        return $rules;
    }
}