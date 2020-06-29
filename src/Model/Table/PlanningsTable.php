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
use Cake\I18n\Date;
use Cake\Event\Event;
use ArrayObject;

class PlanningsTable extends Table
{
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if (isset($data['data']) && strstr($data['data'], '/')) {
            $data['data'] = Date::createFromFormat('d/m/Y', $data['data']);
        }
        if (isset($data['vencimento']) && strstr($data['vencimento'], '/')) {
            $data['vencimento'] = Date::createFromFormat('d/m/Y', $data['vencimento']);
        }
    }

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('plannings');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Parameters', [
            'foreignKey' => 'parameters_id',
            'propertyName' => 'Parameters'
        ]);
        $this->belongsTo('AccountPlans', [
            'foreignKey' => 'account_plans_id',
            'propertyName' => 'AccountPlans'
        ]);
        $this->belongsTo('Providers', [
            'foreignKey' => 'providers_id',
            'propertyName' => 'Providers'
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'propertyName' => 'Customers'
        ]);
        $this->belongsTo('Costs', [
            'foreignKey' => 'costs_id',
            'propertyName' => 'Costs'
        ]);
        //$this->hasMany('Moviments', [
        //    'foreignKey' => 'plannings_id',
        //    'propertyName' => 'Moviments',
        //    'joinType' => 'LEFT'
        //]);
        $this->belongsTo('Moviments', [
            'foreignKey' => 'moviments_id',
            'conditions' => ['Moviments.plannings_id = Plannings.id'],
            'propertyName' => 'Moviments'
        ]);
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('data');
        $validator
            ->notEmpty('title');
        $validator
            ->decimal('valor')
            ->notEmpty('valor');
        $validator
            ->integer('parcelas')
            ->notEmpty('parcelas');
        $validator
            ->allowEmpty('obs');
        $validator
            ->allowEmpty('username');

        return $validator;
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['account_plans_id'], 'AccountPlans'));
        $rules->add($rules->existsIn(['costs_id'], 'Costs'));
        $rules->add($rules->existsIn(['customers_id'], 'Customers'));
        $rules->add($rules->existsIn(['providers_id'], 'Providers'));
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));

        return $rules;
    }
    
    public function beforeSave($event, $entity, $options) 
    {
        //Anter se salvar, vai verificar se a data vem em pt-br, caso seja, fará a conversão
        if (strlen($entity->data) == 10 && strstr($entity->data, '/')) {      
            $entity->data = Time::createFromFormat('d/m/Y', $entity->data);   
        }
        
        if (strlen($entity->vencimento) == 0) {
            $entity->vencimento = $entity->data;
        } elseif (strlen($entity->vencimento) == 10 && strstr($entity->vencimento, '/')) {      
            $entity->vencimento = Time::createFromFormat('d/m/Y', $entity->vencimento);
        }
    }
}