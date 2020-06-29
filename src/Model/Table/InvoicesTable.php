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

class InvoicesTable extends Table
{
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if (isset($data['dtemissaonf']) && strstr($data['dtemissaonf'], '/')) {
            $data['dtemissaonf'] = Date::createFromFormat('d/m/Y', $data['dtemissaonf']);
        }
        if (isset($data['endingdate']) && strstr($data['endingdate'], '/')) {
            $data['endingdate'] = Date::createFromFormat('d/m/Y', $data['endingdate']);
        }
        if (isset($data['dtdelivery']) && strstr($data['dtdelivery'], '/')) {
            $data['dtdelivery'] = Date::createFromFormat('d/m/Y', $data['dtdelivery']);
        }
    }
    
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('invoices');
        $this->setDisplayField('nf');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Purchases', [
            'foreignKey'       => 'invoices_id',
            'targetForeignKey' => 'purchases_id',
            'joinTable'        => 'invoices_purchases_sells',
            'propertyName'     => 'Purchases'
        ]);
        $this->belongsToMany('Sells', [
            'foreignKey'       => 'invoices_id',
            'targetForeignKey' => 'sells_id',
            'joinTable'        => 'invoices_purchases_sells',
            'propertyName'     => 'Sells'
        ]);
        $this->belongsTo('Transporters', [
            'foreignKey' => 'transporters_id',
            'propertyName' => 'Transporters'
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
            ->allowEmpty('sells_id');
        $validator
            ->allowEmpty('purchases_id');
        $validator
            ->allowEmpty('transporters_id');
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
                        $whereId[] = 'Invoices.id != ' . $provider['data']['id'];
                    }
                    
                    $item = $this->find()
                            ->select(['Invoices.id'])
                            ->where(array_merge(['Invoices.nf' => $data,
                                                 'Invoices.parameters_id' => $parameters_id
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
        $rules->add($rules->existsIn(['transporters_id'], 'Transporters'));

        return $rules;
    }
    
    public function beforeSave($event, $entity, $options) 
    {
        //Anter se salvar, vai verificar se a data vem em pt-br, caso seja, fara a conversão
        if (strlen($entity->dtemissaonf) == 10 && strstr($entity->dtemissaonf, '/')) {
            $entity->dtemissaonf = Date::createFromFormat('d/m/Y', $entity->dtemissaonf);
        }
        if (strlen($entity->endingdate) == 10 && strstr($entity->endingdate, '/')) {
            $entity->endingdate = Date::createFromFormat('d/m/Y', $entity->endingdate);
        }
        if (strlen($entity->dtdelivery) == 10 && strstr($entity->dtdelivery, '/')) {
            $entity->dtdelivery = Date::createFromFormat('d/m/Y', $entity->dtdelivery);
        }
    }
}