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

class MovimentMergedsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->setTable('moviment_mergeds');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('Parameters', [
            'foreignKey' => 'parameters_id',
            'propertyName' => 'Parameters',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Moviments', [
            'foreignKey' => 'moviments_id',
            'propertyName' => 'Moviments',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Moviment_Mergeds', [
            'foreignKey' => 'moviments_merged',
            'propertyName' => 'Moviment_Mergeds',
            'joinType' => 'INNER'
        ]);
    }
    
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['parameters_id'], 'Parameters'));
        //$rules->add($rules->existsIn(['moviments_id'], 'Moviments'));
        
        return $rules;
    }
}