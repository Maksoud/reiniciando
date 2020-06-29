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

class InventoriesTable extends Table
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

        $this->setTable('inventories');
        $this->setDisplayField('code');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
                        $whereId[] = 'Inventories.id != ' . $provider['data']['id'];
                    }
                    
                    $item = $this->find()
                            ->select(['Inventories.id'])
                            ->where(array_merge(['Inventories.code' => $data,
                                                 'Inventories.parameters_id' => $parameters_id
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

        return $rules;
    }
    
    public function beforeSave($event, $entity, $options) 
    {
        //Anter se salvar, vai verificar se a data vem em pt-br, caso seja, fara a conversão
        if (strlen($entity->date) == 10 && strstr($entity->date, '/')) {
            $entity->date = Date::createFromFormat('d/m/Y', $entity->date);
        }
    }
}