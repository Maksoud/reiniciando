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

class MovimentBanksTable extends Table
{
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
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
        
        $this->setTable('moviment_banks');
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
        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'propertyName' => 'Customers'
        ]);
        $this->belongsTo('Providers', [
            'foreignKey' => 'providers_id',
            'propertyName' => 'Providers'
        ]);
        $this->belongsTo('Costs', [
            'foreignKey' => 'costs_id',
            'propertyName' => 'Costs'
        ]);
        $this->belongsTo('DocumentTypes', [
            'foreignKey' => 'document_types_id',
            'propertyName' => 'DocumentTypes'
        ]);
        $this->belongsTo('EventTypes', [
            'foreignKey' => 'event_types_id',
            'propertyName' => 'EventTypes'
        ]);
        $this->belongsTo('MovimentChecks', [
            'foreignKey' => 'moviment_checks_id',
            'conditions' => ['MovimentChecks.id = MovimentBanks.moviment_checks_id'],
            'propertyName' => 'MovimentChecks'
        ]);
        $this->belongsTo('Moviments', [
            'foreignKey' => 'moviments_id',
            'conditions' => ['Moviments.id = MovimentBanks.moviments_id'],
            'propertyName' => 'Moviments'
        ]);
        $this->belongsTo('Transfers', [
            'foreignKey' => 'transfers_id',
            'conditions' => ['Transfers.id = MovimentBanks.transfers_id'],
            'propertyName' => 'Transfers'
        ]);
    }
    
    public function validationDefault(Validator $validator)
    {
//        $validator
//            ->integer('ordem')
//            ->notEmpty('ordem');
//        $validator
//            ->notEmpty('creditodebito');
        $validator
            ->notEmpty('data');
        $validator
            ->notEmpty('vencimento');
        $validator
            ->notEmpty('dtbaixa');
        $validator
            ->decimal('valor')
            ->notEmpty('valor', 'Você precisa preencher um valor');
        $validator
            ->decimal('valorbaixa')
            ->notEmpty('valorbaixa');
        $validator
            ->allowEmpty('documento');
        $validator
            ->notEmpty('historico');
//        $validator
//            ->notEmpty('contabil');
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
        $rules->add($rules->existsIn(['costs_id'], 'Costs'));
        $rules->add($rules->existsIn(['customers_id'], 'Customers'));
        $rules->add($rules->existsIn(['providers_id'], 'Providers'));
        $rules->add($rules->existsIn(['document_types_id'], 'DocumentTypes'));
        $rules->add($rules->existsIn(['event_types_id'], 'EventTypes'));
        //$rules->add($rules->existsIn(['moviments_id'], 'Moviments')); Apresentando erro na baixa
        //$rules->add($rules->existsIn(['moviment_checks_id'], 'MovimentChecks')); Apresentando erro na baixa
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        //$rules->add($rules->existsIn(['transfers_id'], 'Transfers'));
        
        return $rules;
    }
    
    public function beforeSave($event, $entity, $options) 
    {
        //Anter se salvar, vai verificar se a data vem em pt-br, caso seja, fara a conversão
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