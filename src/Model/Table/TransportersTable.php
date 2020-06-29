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
use Cake\Network\Session;

class TransportersTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('transporters');
        $this->setDisplayField('title');
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
            ->notEmpty('type');
        $validator
            ->notEmpty('title');
        $validator
            ->allowEmpty('companyname');
        $validator
            ->allowEmpty('contact');
        $validator
            ->allowEmpty('ie');
        $validator
            ->allowEmpty('address');
        $validator
            ->allowEmpty('neighborhood');
        $validator
            ->allowEmpty('city');
        $validator
            ->allowEmpty('state');
        $validator
            ->allowEmpty('cep');
        $validator
            ->allowEmpty('phone1');
        $validator
            ->allowEmpty('phone2');
        $validator
            ->allowEmpty('phone3');
        $validator
            ->allowEmpty('phone4');
        $validator
            ->email('email')
            ->allowEmpty('email');
        $validator
            ->allowEmpty('bank');
        $validator
            ->allowEmpty('agency');
        $validator
            ->allowEmpty('account');
        $validator
            ->allowEmpty('status');
        $validator
            ->allowEmpty('obs');
        $validator
            ->allowEmpty('username');

        return $validator;
    }
    
    public function validationNovo($validator) 
    {
        $validator
            ->add('cpfcnpj', 'verify', ['rule' => 
                function ($data, $provider) {
                    
                    if ($provider['data']['type'] == 'F') {
                        if (strlen($provider['data']['cpfcnpj']) != 14){
                            return __('Precisa informar o CPF no formato ex. 123.456.789-00');
                        }
                    } elseif ($provider['data']['type'] == 'J') {
                        if (strlen($provider['data']['cpfcnpj']) != 18) {
                            return __('Precisa informar o CNPJ no formato ex. 01.234.578/0001-00');
                        }
                    }
                    
                    return true;
                }
            ]);
        
        $validator
            ->add('cpfcnpj', 'unique', ['rule' => 
                function ($data, $provider) {
                    
                    $this->session = new Session();
                    $parameters_id = $this->session->read('sessionParameterControl');
                    
                    $whereId = [];
                    
                    if (!empty($provider['data']['id'])) {
                        $whereId[] = 'Transporters.id != ' . $provider['data']['id'];
                    }
                    
                    if ($provider['data']['type'] == 'J') {
                        $item = $this->find()
                                ->select(['Transporters.id'])
                                ->where(array_merge(['Transporters.cpfcnpj' => $data,
                                                     'Transporters.type'    => $provider['data']['type'],
                                                     'Transporters.parameters_id' => $parameters_id
                                                    ], $whereId));
                    } elseif ($provider['data']['type'] == 'F') {
                        $item = $this->find()
                                ->select(['Transporters.id'])
                                ->where(array_merge(['Transporters.cpfcnpj' => $data,
                                                     'Transporters.type'    => $provider['data']['type'],
                                                     'Transporters.parameters_id' => $parameters_id
                                                    ], $whereId));
                    }
                    
                    if (!$item->count()) {
                        return true;
                    }
                    
                    return __('CPF/CNPJ ja cadastrado');
                    
                }
            ]);
        
        return $validator;
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));

        return $rules;
    }
}