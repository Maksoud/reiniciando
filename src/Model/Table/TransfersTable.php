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

class TransfersTable extends Table
{
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if (isset($data['emissaoch']) && strstr($data['emissaoch'], '/')) {
            $data['emissaoch'] = Date::createFromFormat('d/m/Y', $data['emissaoch']);
        }
        if (isset($data['data']) && strstr($data['data'], '/')) {
            $data['data'] = Date::createFromFormat('d/m/Y', $data['data']);
        }
        if (isset($data['programacao']) && strstr($data['programacao'], '/')) {
            $data['programacao'] = Date::createFromFormat('d/m/Y', $data['programacao']);
        }
        if (isset($data['dtbaixa']) && strstr($data['dtbaixa'], '/')) {
            $data['dtbaixa'] = Date::createFromFormat('d/m/Y', $data['dtbaixa']);
        }
    }

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('transfers');
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
        $this->belongsTo('Banks_Dest', [
            'className'    => 'Banks',
            'foreignKey'   => 'banks_dest',
            'propertyName' => 'BanksDest'
        ]);
        $this->belongsTo('Boxes_Dest', [
            'className'    => 'Boxes',
            'foreignKey'   => 'boxes_dest',
            'propertyName' => 'BoxesDest'
        ]);
        $this->belongsTo('Costs', [
            'foreignKey' => 'costs_id',
            'propertyName' => 'Costs'
        ]);
        $this->belongsTo('Costs_Dest', [
            'className'    => 'Costs',
            'foreignKey'   => 'costs_dest',
            'propertyName' => 'CostsDest'
        ]);
        $this->belongsTo('AccountPlans', [
            'foreignKey' => 'account_plans_id',
            'propertyName' => 'AccountPlans'
        ]);
        $this->belongsTo('AccountPlans_Dest', [
            'className'    => 'AccountPlans',
            'foreignKey'   => 'account_plans_dest',
            'propertyName' => 'AccountPlansDest'
        ]);
        $this->belongsTo('DocumentTypes', [
            'foreignKey' => 'document_types_id',
            'propertyName' => 'DocumentTypes'
        ]);
        $this->belongsTo('EventTypes', [
            'foreignKey' => 'event_types_id',
            'propertyName' => 'EventTypes'
        ]);
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('ordem')
            ->notEmpty('ordem');
        $validator
            ->integer('banks_dest')
            ->allowEmpty('banks_dest');
        $validator
            ->integer('boxes_dest')
            ->allowEmpty('boxes_dest');
        $validator
            ->integer('costs_dest')
            ->allowEmpty('costs_dest');
        $validator
            ->integer('account_plans_dest')
            ->allowEmpty('account_plans_dest');
        $validator
            ->notEmpty('data');
        $validator
            ->allowEmpty('programacao');
        $validator
            ->allowEmpty('radio_origem');
        $validator
            ->allowEmpty('radio_destino');
        $validator
            ->decimal('valor')
            ->notEmpty('valor');
        $validator
            ->allowEmpty('documento');
        $validator
            ->notEmpty('historico');
        $validator
            ->allowEmpty('emissaoch');
        $validator
            ->allowEmpty('cheque');
        $validator
            ->allowEmpty('nominal');
        $validator
            ->notEmpty('contabil');
        $validator
            ->allowEmpty('status');
        $validator
            ->allowEmpty('obs');
        $validator
            ->allowEmpty('username');
        
        return $validator;
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        $rules->add($rules->existsIn(['banks_id'], 'Banks'));
        $rules->add($rules->existsIn(['boxes_id'], 'Boxes'));
        $rules->add($rules->existsIn(['costs_id'], 'Costs'));
        $rules->add($rules->existsIn(['account_plans_id'], 'AccountPlans'));
        $rules->add($rules->existsIn(['document_types_id'], 'DocumentTypes'));
        $rules->add($rules->existsIn(['event_types_id'], 'EventTypes'));
        
        return $rules;
    }
    
    public function beforeSave($event, $entity, $options) 
    {
        //Anter se salvar, vai verificar se a data vem em pt-br, caso seja, fará a conversão
        if (strlen($entity->data) == 10 && strstr($entity->data, '/')) {      
            $entity->data = Time::createFromFormat('d/m/Y', $entity->data);   
        } 
        if (strlen($entity->dtbaixa) == 10 && strstr($entity->dtbaixa, '/')) {      
            $entity->dtbaixa = Time::createFromFormat('d/m/Y', $entity->dtbaixa);   
        } 
        if (strlen($entity->programacao) == 10 && strstr($entity->programacao, '/')) {      
            $entity->programacao = Time::createFromFormat('d/m/Y', $entity->programacao);   
        } 
        if (strlen($entity->emissaoch) == 10 && strstr($entity->emissaoch, '/')) {      
            $entity->emissaoch = Time::createFromFormat('d/m/Y', $entity->emissaoch);   
        } 
    }
}