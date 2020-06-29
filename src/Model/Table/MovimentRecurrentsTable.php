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

class MovimentRecurrentsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->setTable('moviment_recurrents');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('Parameters', [
            'foreignKey' => 'parameters_id',
            'propertyName' => 'Parameters',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Moviments', [
            'foreignKey' => 'moviments_id',
            'propertyName' => 'Moviments'
        ]);
        $this->belongsTo('MovimentCards', [
            'foreignKey' => 'moviment_cards_id',
            'propertyName' => 'MovimentCards'
        ]);
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        //$rules->add($rules->existsIn(['moviments_id'], 'Moviments'));
        //$rules->add($rules->existsIn(['moviment_cards_id'], 'MovimentCards'));
        
        return $rules;
    }
}