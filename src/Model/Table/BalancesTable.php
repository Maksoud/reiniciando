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

class BalancesTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('balances');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Parameters', [
            'foreignKey' => 'parameters_id',
            'propertyName' => 'Parameters',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Banks', [
            'foreignKey' => 'banks_id',
            'propertyName' => 'Banks'
        ]);
        $this->belongsTo('Boxes', [
            'foreignKey' => 'boxes_id',
            'propertyName' => 'Boxes'
        ]);
        $this->belongsTo('Cards', [
            'foreignKey' => 'cards_id',
            'propertyName' => 'Cards'
        ]);
        $this->belongsTo('Plannings', [
            'foreignKey' => 'plannings_id',
            'propertyName' => 'Plannings'
        ]);
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        $rules->add($rules->existsIn(['banks_id'], 'Banks'));
        $rules->add($rules->existsIn(['boxes_id'], 'Boxes'));
        $rules->add($rules->existsIn(['cards_id'], 'Cards'));
        $rules->add($rules->existsIn(['plannings_id'], 'Plannings'));

        return $rules;
    }
    
    public function beforeSave($event, $entity, $options) 
    {
        //Anter se salvar, vai verificar se a data vem em pt-br, caso seja, fará a conversão
        if (strlen($entity->data) == 10 && strstr($entity->data, '/')) {      
            $entity->data = Time::createFromFormat('d/m/Y', $entity->data);   
        }
    }
}
