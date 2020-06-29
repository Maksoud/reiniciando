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

class CardsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('cards');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Parameters', [
            'foreignKey' => 'parameters_id',
            'propertyName' => 'Parameters',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Providers', [
            'foreignKey' => 'providers_id',
            'propertyName' => 'Providers',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Costs', [
            'foreignKey' => 'costs_id',
            'propertyName' => 'Costs'
        ]);
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('vencimento')
            ->notEmpty('vencimento');
        $validator
            ->notEmpty('title');
        $validator
            ->notEmpty('bandeira');
        $validator
            ->integer('melhor_dia')
            ->notEmpty('melhor_dia');
        $validator
            ->decimal('limite')
            ->allowEmpty('limite');
        $validator
            ->notEmpty('username');
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
                        return 'Precisa informar o nome do cartao';
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
                        $whereId[] = 'Cards.id != ' . $provider['data']['id'];
                    }
                    
                    $item = $this->find()
                            ->select(['Cards.id'])
                            ->where(array_merge(['Cards.title' => $data,
                                                 'Cards.parameters_id' => $parameters_id
                                                ], $whereId));
                    
                    
                    if (!$item->count()) {
                        return true;
                    }
                    
                    return 'Cartao ja cadastrado';
                    
                }
            ]);

        return $validator;
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        //$rules->add($rules->existsIn(['providers_id'], 'Providers'));
        //$rules->add($rules->existsIn(['costs_id'], 'Costs'));

        return $rules;
    }
}
