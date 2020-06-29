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

class StockBalancesTable extends Table
{
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if (isset($data['date']) && strstr($data['date'], '/')) {
            $data['date'] = Date::createFromFormat('d/m/Y', $data['date']);
        }
    }
    
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('stock_balances');
        $this->setDisplayField('quantity');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->notEmpty('quantity');
        $validator
            ->notEmpty('unity');
        $validator
            ->allowEmpty('vlcost');

        return $validator;
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        $rules->add($rules->existsIn(['products_id'], 'Products'));

        return $rules;
    }
    
    public function beforeSave($event, $entity, $options) 
    {
        //Anter se salvar, vai verificar se a data vem em pt-br, caso seja, fará a conversão
        if (strlen($entity->date) == 10 && strstr($entity->date, '/')) {
            $entity->date = Date::createFromFormat('d/m/Y', $entity->date);
        }
    }
}