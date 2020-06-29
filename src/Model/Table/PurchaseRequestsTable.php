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

class PurchaseRequestsTable extends Table
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

        $this->setTable('purchase_requests');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Industrializations', [
            'foreignKey' => 'industrializations_id',
            'propertyName' => 'Industrializations'
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
            ->allowEmpty('industrializations_id');
        $validator
            ->notEmpty('status');

        return $validator;
    }
    
    public function validationNovo($validator) 
    {
        $validator
            ->add('applicant', 'verify', ['rule' => 
                function ($data, $provider) {
                    
                    if (strlen($provider['data']['applicant']) == 0){
                        return 'Precisa informar o nome do solicitante';
                    }
                    
                    return true;
                }
            ]);
        
        $validator
            ->add('code', 'unique', ['rule' => 
                function ($data, $provider) {
                    
                    $this->session = new Session();
                    $parameters_id = $this->session->read('sessionParameterControl');
                    
                    $whereId = [];
                    
                    if (!empty($provider['data']['id'])) {
                        $whereId[] = 'PurchaseRequests.id != ' . $provider['data']['id'];
                    }
                    
                    $item = $this->find()
                            ->select(['PurchaseRequests.id'])
                            ->where(array_merge(['PurchaseRequests.code' => $data,
                                                 'PurchaseRequests.parameters_id' => $parameters_id
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