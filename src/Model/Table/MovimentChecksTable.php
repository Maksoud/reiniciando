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

class MovimentChecksTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->setTable('moviment_checks');
        $this->setDisplayField('historico');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');
        
        $this->belongsTo('Parameters', [
            'foreignKey' => 'parameters_id',
            'propertyName' => 'Parameters'
        ]);
        $this->belongsTo('Banks', [
            'foreignKey' => 'banks_id',
            'propertyName' => 'Banks'
        ]);
        $this->belongsTo('Boxes', [
            'foreignKey' => 'boxes_id',
            'propertyName' => 'Boxes'
        ]);
        $this->belongsTo('Costs', [
            'foreignKey' => 'costs_id',
            'propertyName' => 'Costs'
        ]);
        $this->belongsTo('EventTypes', [
            'foreignKey' => 'event_types_id',
            'propertyName' => 'EventTypes'
        ]);
        $this->belongsTo('Providers', [
            'foreignKey' => 'providers_id',
            'propertyName' => 'Providers'
        ]);
        $this->belongsTo('AccountPlans', [
            'foreignKey' => 'account_plans_id',
            'propertyName' => 'AccountPlans'
        ]);
        $this->belongsTo('Moviments', [
            'foreignKey' => 'moviments_id',
            'conditions' => ['Moviments.id = MovimentChecks.moviments_id'],
            'propertyName' => 'Moviments'
        ]);
        $this->belongsTo('Transfers', [
            'foreignKey' => 'transfers_id',
            'conditions' => ['Transfers.id = MovimentChecks.transfers_id'],
            'propertyName' => 'Transfers'
        ]);
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('ordem')
            ->notEmpty('ordem');
        $validator
            ->notEmpty('cheque');
        $validator
            ->allowEmpty('nominal');
        $validator
            ->notEmpty('data');
        $validator
            ->decimal('valor')
            ->notEmpty('valor');
        $validator
            ->allowEmpty('documento');
        $validator
            ->notEmpty('historico');
        $validator
            ->notEmpty('contabil');
        $validator
            ->allowEmpty('status');
        $validator
            ->allowEmpty('username');
        $validator
            ->allowEmpty('obs');
        
        return $validator;
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['account_plans_id'], 'AccountPlans'));
        $rules->add($rules->existsIn(['banks_id'], 'Banks'));
        $rules->add($rules->existsIn(['boxes_id'], 'Boxes'));
        $rules->add($rules->existsIn(['costs_id'], 'Costs'));
        $rules->add($rules->existsIn(['event_types_id'], 'EventTypes'));
        //$rules->add($rules->existsIn(['moviments_id'], 'Moviments')); Apresentando erro na baixa
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        $rules->add($rules->existsIn(['providers_id'], 'Providers'));
        //$rules->add($rules->existsIn(['transfers_id'], 'Transfers'));
        
        return $rules;
    }
    
    public function beforeSave($event, $entity, $options) 
    {
        //Anter se salvar, vai verificar se a data vem em pt-br, caso seja, fara a conversão
        if (strlen($entity->data) == 10 && strstr($entity->data, '/')) {      
            $entity->data = Time::createFromFormat('d/m/Y', $entity->data);   
        } 
    }
}
