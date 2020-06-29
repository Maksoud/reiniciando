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

class MovimentCardsTable extends Table
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
        
        $this->setTable('moviment_cards');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');
        
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
            'propertyName' => 'Cards',
            'joinType' => 'INNER'
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
        $this->belongsTo('Moviments', [
            'foreignKey' => 'moviments_id',
            'conditions' => ['Moviments.id = MovimentCards.moviments_id'],
            'propertyName' => 'Moviments'
        ]);
        $this->belongsTo('Parameters', [
            'foreignKey' => 'parameters_id',
            'propertyName' => 'Parameters',
            'joinType' => 'INNER'
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
            ->notEmpty('data', 'Você precisa preencher uma data');
        $validator
            ->allowEmpty('vencimento');
        $validator
            ->decimal('valor')
            ->notEmpty('valor', 'Você precisa preencher um valor');
        $validator
            ->allowEmpty('documento');
        $validator
			->add('title', 'verify', ['rule' => 
                function ($data, $provider) {
                    
                    if (empty($provider['data']['title'])) {
                        if (empty($provider['data']['historico'])) {
                            return 'Você precisa preencher uma descrição';
                        }
                    } 
                    
                    return true;
                }
            ]);
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
        $rules->add($rules->existsIn(['cards_id'], 'Cards'));
        $rules->add($rules->existsIn(['costs_id'], 'Costs'));
        $rules->add($rules->existsIn(['document_types_id'], 'DocumentTypes'));
        $rules->add($rules->existsIn(['event_types_id'], 'EventTypes'));
        $rules->add($rules->existsIn(['customers_id'], 'Customers'));
        $rules->add($rules->existsIn(['providers_id'], 'Providers'));
        //$rules->add($rules->existsIn(['moviments_id'], 'Moviments')); //O registro pode ainda não existir na tabela Movimentos no momento da gravação deste registro. 17/05/2018
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        
        return $rules;
    }
    
    public function beforeSave($event, $entity, $options) 
    {
        //Anter se salvar, vai verificar se a data vem em pt-br, caso seja, fará a conversão
        if (strlen($entity->data) == 10 && strstr($entity->data, '/')) {      
            $entity->data = Time::createFromFormat('d/m/Y', $entity->data);   
        }
        if (strlen($entity->vencimento) == 10 && strstr($entity->vencimento, '/')) {      
            $entity->vencimento = Time::createFromFormat('d/m/Y', $entity->vencimento);   
        }
    }
}