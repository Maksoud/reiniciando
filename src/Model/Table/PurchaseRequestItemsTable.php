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
use Cake\Network\Session;
use Cake\I18n\Date;
use Cake\Event\Event;
use Cake\Validation\Validator;
use ArrayObject;

class PurchaseRequestItemsTable extends Table
{
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if (isset($data['deadline']) && strstr($data['deadline'], '/')) {
            $data['deadline'] = Date::createFromFormat('d/m/Y', $data['deadline']);
        }
    }

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('purchase_request_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('PurchaseRequests', [
            'foreignKey' => 'purchase_requests_id',
            'propertyName' => 'PurchaseRequests'
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
            ->notEmpty('purchase_requests_id');
        $validator
            ->notEmpty('products_id');
        $validator
            ->allowEmpty('deadline');

        return $validator;
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        $rules->add($rules->existsIn(['purchase_requests_id'], 'PurchaseRequests'));
        $rules->add($rules->existsIn(['products_id'], 'Products'));

        return $rules;
    }
    
    public function beforeSave($event, $entity, $options) 
    {
        //Anter se salvar, vai verificar se a data vem em pt-br, caso seja, fará a conversão
        if (strlen($entity->deadline) == 10 && strstr($entity->deadline, '/')) {
            $entity->deadline = Date::createFromFormat('d/m/Y', $entity->deadline);
        }
    }
}