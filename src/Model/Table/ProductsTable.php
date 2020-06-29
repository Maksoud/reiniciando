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

class ProductsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('products');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ProductGroups', [
            'foreignKey' => 'product_groups_id',
            'propertyName' => 'ProductGroups'
        ]);
        $this->belongsTo('ProductTypes', [
            'foreignKey' => 'product_types_id',
            'propertyName' => 'ProductTypes'
        ]);
        $this->belongsTo('Parameters', [
            'foreignKey' => 'parameters_id',
            'propertyName' => 'Parameters',
            'joinType' => 'INNER'
        ]);
        
        /*
        $this->belongsToMany('ProductTitles', [
            'foreignKey'       => 'id',
            'propertyName'     => 'ProductTitles',
            'joinTable'        => 'product_titles',
            'targetForeignKey' => 'products_id'
        ]);
        
        $this->belongsToMany('ProductTitles', [
            'foreignKey'       => 'id',
            'targetForeignKey' => 'products_id',
            //'joinTable'        => 'invoices_purchases_sells',
            'propertyName'     => 'ProductTitles'
        ]);
        */
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('username');

        return $validator;
    }
    
    public function validationNovo($validator) 
    {
        $validator
            ->add('title', 'verify', ['rule' => 
                function ($data, $provider) {
                    
                    if (strlen($provider['data']['title']) == 0){
                        return 'Precisa informar o nome do titulo do registro';
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
                        $whereId[] = 'Products.id != ' . $provider['data']['id'];
                    }
                    
                    $item = $this->find()
                            ->select(['Products.id'])
                            ->where(array_merge(['Products.title' => $data,
                                                 'Products.parameters_id' => $parameters_id
                                                ], $whereId));
                    
                    
                    if (!$item->count()) {
                        return true;
                    }
                    
                    return 'Titulo ja cadastrado';
                    
                }
            ]);
        
        return $validator;
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        $rules->add($rules->existsIn(['product_groups_id'], 'ProductGroups'));
        $rules->add($rules->existsIn(['product_types_id'], 'ProductTypes'));

        return $rules;
    }
}