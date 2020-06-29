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

class SellsTable extends Table
{
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if (isset($data['deadline']) && strstr($data['deadline'], '/')) {
            $data['deadline'] = Date::createFromFormat('d/m/Y', $data['deadline']);
        }
        if (isset($data['shipment']) && strstr($data['shipment'], '/')) {
            $data['shipment'] = Date::createFromFormat('d/m/Y', $data['shipment']);
        }
        if (isset($data['endingdate']) && strstr($data['endingdate'], '/')) {
            $data['endingdate'] = Date::createFromFormat('d/m/Y', $data['endingdate']);
        }
        if (isset($data['date']) && strstr($data['date'], '/')) {
            $data['date'] = Date::createFromFormat('d/m/Y', $data['date']);
        }
    }
    
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('sells');
        $this->setDisplayField('code');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'propertyName' => 'Customers'
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
            ->allowEmpty('username');
        $validator
            ->allowEmpty('endingdate');
        $validator
            ->notEmpty('status');

        return $validator;
    }
    
    public function validationNovo($validator) 
    {
        $validator
            ->add('code', 'unique', ['rule' => 
                function ($data, $provider) {
                    
                    $this->session = new Session();
                    $parameters_id = $this->session->read('sessionParameterControl');
                    
                    $whereId = [];
                    
                    if (!empty($provider['data']['id'])) {
                        $whereId[] = 'Sells.id != ' . $provider['data']['id'];
                    }
                    
                    $item = $this->find()
                            ->select(['Sells.id'])
                            ->where(array_merge(['Sells.code' => $data,
                                                 'Sells.parameters_id' => $parameters_id
                                                ], $whereId));
                    
                    
                    if (!$item->count()) {
                        return true;
                    }
                    
                    return 'Código ja cadastrado';
                    
                }
            ]);
        
        return $validator;
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        $rules->add($rules->existsIn(['customers_id'], 'Customers'));

        return $rules;
    }
    
    public function beforeSave($event, $entity, $options) 
    {
        //Anter se salvar, vai verificar se a data vem em pt-br, caso seja, fara a conversão
        if (strlen($entity->deadline) == 10 && strstr($entity->deadline, '/')) {
            $entity->deadline = Date::createFromFormat('d/m/Y', $entity->deadline);
        }
        if (strlen($entity->shipment) == 10 && strstr($entity->shipment, '/')) {
            $entity->shipment = Date::createFromFormat('d/m/Y', $entity->shipment);
        }
        if (strlen($entity->endingdate) == 10 && strstr($entity->endingdate, '/')) {
            $entity->endingdate = Date::createFromFormat('d/m/Y', $entity->endingdate);
        }
        if (strlen($entity->date) == 10 && strstr($entity->date, '/')) {
            $entity->date = Date::createFromFormat('d/m/Y', $entity->date);
        }
    }
}