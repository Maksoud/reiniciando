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

class CostsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('costs');
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
            ->notEmpty('title');
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
                        return 'Precisa informar o centro de custos';
                    }
                    
                    return true;
                }
            ]);
        
        $validator
            ->add('title', 'unique', ['rule' => 
                function ($data, $provider) {
                    
                    $whereId = [];
                    
                    if (!empty($provider['data']['id'])) {
                        $whereId[] = 'Costs.id != ' . $provider['data']['id'];
                    }
                    
                    $item = $this->find()
                            ->select(['Costs.id'])
                            ->where(array_merge(['Costs.title' => $data,
                                                 'Costs.parameters_id' => $provider['data']['parameters_id']
                                                ], $whereId));
                    
                    
                    if (!$item->count()) {
                        return true;
                    }
                    
                    return 'Centro de custos ja cadastrado';
                    
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
