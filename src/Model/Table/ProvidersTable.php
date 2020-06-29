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

class ProvidersTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('providers');
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
            ->notEmpty('tipo');
        $validator
            ->notEmpty('title');
        $validator
            ->allowEmpty('fantasia');
        $validator
            ->allowEmpty('ie');
        $validator
            ->allowEmpty('endereco');
        $validator
            ->allowEmpty('bairro');
        $validator
            ->allowEmpty('cidade');
        $validator
            ->allowEmpty('estado');
        $validator
            ->allowEmpty('cep');
        $validator
            ->allowEmpty('telefone1');
        $validator
            ->allowEmpty('telefone2');
        $validator
            ->allowEmpty('telefone3');
        $validator
            ->allowEmpty('telefone4');
        $validator
            ->email('email')
            ->allowEmpty('email');
        $validator
            ->allowEmpty('banco');
        $validator
            ->allowEmpty('agencia');
        $validator
            ->allowEmpty('conta');
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
                    
                    if ($provider['data']['tipo'] == 'F') {
                        if (strlen($provider['data']['cpfcnpj']) != 14){
                            return 'Precisa informar o CPF no formato ex. 123.456.789-00';
                        }
                    } elseif ($provider['data']['tipo'] == 'J') {
                        if (strlen($provider['data']['cpfcnpj']) != 18) {
                            return 'Precisa informar o CNPJ no formato ex. 01.234.578/0001-00';
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
                        $whereId[] = 'Providers.id != ' . $provider['data']['id'];
                    }
                    
                    if ($provider['data']['tipo'] == 'J') {
                        $item = $this->find()
                                ->select(['Providers.id'])
                                ->where(array_merge(['Providers.cpfcnpj' => $data,
                                                     'Providers.tipo'    => $provider['data']['tipo'],
                                                     'Providers.parameters_id' => $parameters_id
                                                    ], $whereId));
                    } elseif ($provider['data']['tipo'] == 'F') {
                        $item = $this->find()
                                ->select(['Providers.id'])
                                ->where(array_merge(['Providers.cpfcnpj' => $data,
                                                     'Providers.tipo'    => $provider['data']['tipo'],
                                                     'Providers.parameters_id' => $parameters_id
                                                    ], $whereId));
                    }
                    
                    if (!$item->count()) {
                        return true;
                    }
                    
                    return 'CPF/CNPJ ja cadastrado';
                    
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
