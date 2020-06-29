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

class MovimentsTable extends Table
{
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if (isset($data['emissaoch']) && strstr($data['emissaoch'], '/')) {
            $data['emissaoch'] = Date::createFromFormat('d/m/Y', $data['emissaoch']);
        }
        if (isset($data['data']) && strstr($data['data'], '/')) {
            $data['data'] = Date::createFromFormat('d/m/Y', $data['data']);
        }
        if (isset($data['vencimento']) && strstr($data['vencimento'], '/')) {
            $data['vencimento'] = Date::createFromFormat('d/m/Y', $data['vencimento']);
        }
        if (isset($data['dtbaixa']) && strstr($data['dtbaixa'], '/')) {
            $data['dtbaixa'] = Date::createFromFormat('d/m/Y', $data['dtbaixa']);
        }
    }

    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->setTable('moviments');
        $this->setDisplayField('historico');
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
        $this->belongsTo('Costs', [
            'foreignKey' => 'costs_id',
            'propertyName' => 'Costs'
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'propertyName' => 'Customers'
        ]);
        $this->belongsTo('DocumentTypes', [
            'foreignKey' => 'document_types_id',
            'propertyName' => 'DocumentTypes'
        ]);
        $this->belongsTo('EventTypes', [
            'foreignKey' => 'event_types_id',
            'propertyName' => 'EventTypes'
        ]);
        $this->belongsToMany('MovimentCards', [
            'foreignKey'       => 'moviments_id',
            'targetForeignKey' => 'cards_id',
            'joinTable'        => 'moviments_moviment_cards',
            'propertyName'     => 'MovimentCards'
        ]);
        $this->belongsTo('Plannings', [
            'foreignKey' => 'plannings_id',
            'propertyName' => 'Plannings'
        ]);
        $this->belongsTo('Providers', [
            'foreignKey' => 'providers_id',
            'propertyName' => 'Providers'
        ]);
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('documento');
        $validator
            ->allowEmpty('cheque');
        $validator
            ->allowEmpty('nominal');
        $validator
            ->allowEmpty('emissaoch');
        $validator
            ->notEmpty('data');
        $validator
            ->allowEmpty('vencimento');
        $validator
            ->allowEmpty('dtbaixa');
        $validator
            ->decimal('valor')
            ->notEmpty('valor');
        $validator
            ->decimal('valorbaixa')
            ->allowEmpty('valorbaixa');
        $validator
            ->notEmpty('historico');
//        $validator
//            ->allowEmpty('contabil');
        $validator
            ->allowEmpty('status');
        $validator
            ->allowEmpty('username');
        $validator
            ->allowEmpty('userbaixa');
        $validator
            ->allowEmpty('obs');
        
        return $validator;
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        $rules->add($rules->existsIn(['banks_id'], 'Banks'));
        $rules->add($rules->existsIn(['boxes_id'], 'Boxes'));
        $rules->add($rules->existsIn(['cards_id'], 'Cards'));
        $rules->add($rules->existsIn(['plannings_id'], 'Plannings'));
        $rules->add($rules->existsIn(['costs_id'], 'Costs'));
        $rules->add($rules->existsIn(['event_types_id'], 'EventTypes'));
        $rules->add($rules->existsIn(['providers_id'], 'Providers'));
        $rules->add($rules->existsIn(['customers_id'], 'Customers'));
        $rules->add($rules->existsIn(['document_types_id'], 'DocumentTypes'));
        $rules->add($rules->existsIn(['account_plans_id'], 'AccountPlans'));
        
        return $rules;
    }
    
    public function beforeSave($event, $entity, $options) 
    {
        //Anter se salvar, vai verificar se a data vem em pt-br, caso seja, fará a conversão
        if (strlen($entity->emissaoch) == 10 && strstr($entity->emissaoch, '/')) {
            $entity->emissaoch = Time::createFromFormat('d/m/Y', $entity->emissaoch);
        }
        if (strlen($entity->data) == 10 && strstr($entity->data, '/')) {
            $entity->data = Time::createFromFormat('d/m/Y', $entity->data);
        }
        if (strlen($entity->vencimento) == 10 && strstr($entity->vencimento, '/')) {
            $entity->vencimento = Time::createFromFormat('d/m/Y', $entity->vencimento);
        }
        if (strlen($entity->dtbaixa) == 10 && strstr($entity->dtbaixa, '/')) {
            $entity->dtbaixa = Time::createFromFormat('d/m/Y', $entity->dtbaixa);
        }
    }
}