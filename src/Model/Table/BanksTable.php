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

class BanksTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('banks');
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
            ->notEmpty('banco');
        $validator
            ->notEmpty('agencia');
        $validator
            ->notEmpty('conta');
        $validator
            ->allowEmpty('tipoconta');
        $validator
            ->notEmpty('numbanco');
        $validator
            ->notEmpty('emitecheque');
        $validator
            ->allowEmpty('username');
        $validator
            ->notEmpty('status');

        return $validator;
    }
    
    public function validationNovo($validator) 
    {
        $validator
            ->add('title', 'verify', ['rule' => 
                function ($data, $provider) {
                    
                    if (strlen($provider['data']['title']) == 0){
                        return 'Precisa informar o nome do banco';
                    }
                    
                    return true;
                }
            ]);
        
        $validator
            ->add('title', 'unique', ['rule' => 
                function ($data, $provider) {
                    
                    $this->session = new Session();
                    $parameters_id = $this->session->read('sessionParameterControl');
                    
                    $whereId = [];
                    
                    if (!empty($provider['data']['id'])) {
                        $whereId[] = 'Banks.id != ' . $provider['data']['id'];
                    }
                    
                    $item = $this->find()
                            ->select(['Banks.id'])
                            ->where(array_merge(['Banks.title' => $data,
                                                 'Banks.parameters_id' => $parameters_id
                                                ], $whereId));
                    
                    
                    if (!$item->count()) {
                        return true;
                    }
                    
                    return 'Banco ja cadastrado';
                    
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