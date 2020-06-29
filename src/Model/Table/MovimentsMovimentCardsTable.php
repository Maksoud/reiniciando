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
use Cake\I18n\Time;

class MovimentsMovimentCardsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->setTable('moviments_moviment_cards');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Parameters', [
            'foreignKey' => 'parameters_id',
            'propertyName' => 'Parameters',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cards', [
            'foreignKey' => 'cards_id',
            'propertyName' => 'Cards',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Moviments', [
            'foreignKey' => 'moviments_id',
            'propertyName' => 'Moviments',
            'joinType' => 'INNER'
        ]);
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('vencimento');
        
        return $validator;
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        $rules->add($rules->existsIn(['cards_id'], 'Cards'));
        //$rules->add($rules->existsIn(['moviments_id'], 'Moviments'));
        
        return $rules;
    }
    
    public function beforeSave($event, $entity, $options) 
    {
        //Anter se salvar, vai verificar se a data vem em pt-br, caso seja, fará a conversão
        if (strlen($entity->vencimento) == 10 && strstr($entity->vencimento, '/')) {      
            $entity->vencimento = Time::createFromFormat('d/m/Y', $entity->vencimento);   
        } 
    }
}
