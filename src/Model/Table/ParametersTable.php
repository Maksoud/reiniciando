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
use Cake\I18n\Date;
use Cake\Event\Event;
use ArrayObject;

class ParametersTable extends Table
{
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if (isset($data['fundacao']) && strstr($data['fundacao'], '/')) {
            $data['fundacao'] = Date::createFromFormat('d/m/Y', $data['fundacao']);
        }
        if (isset($data['dtvalidade']) && strstr($data['dtvalidade'], '/')) {
            $data['dtvalidade'] = Date::createFromFormat('d/m/Y', $data['dtvalidade']);
        }
    }

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('parameters');
        $this->setDisplayField('razao');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Plans', [
            'foreignKey' => 'plans_id',
            'propertyName' => 'Plans'
        ]);
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('razao');
        $validator
            ->allowEmpty('ie');
        $validator
            ->allowEmpty('cpfcnpj');
        $validator
            ->notEmpty('tipo');
        $validator
            ->notEmpty('email_cobranca');
        $validator
            ->allowEmpty('cidade');
        $validator
            ->allowEmpty('estado');
        $validator
            ->allowEmpty('cep');
        $validator
            ->allowEmpty('telefone');
        $validator
            ->allowEmpty('fundacao');
        $validator
            ->allowEmpty('logomarca');
        $validator
            ->allowEmpty('username');

        return $validator;
    }
    
    public function beforeSave($event, $entity, $options) 
    {
        //Anter se salvar, vai verificar se a data vem em pt-br, caso seja, fará a conversão
        if (strlen($entity->fundacao) == 10 && strstr($entity->fundacao, '/')) {      
            $entity->fundacao = Time::createFromFormat('d/m/Y', $entity->fundacao);   
        }
        if (strlen($entity->dtvalidade) == 10 && strstr($entity->dtvalidade, '/')) {      
            $entity->dtvalidade = Time::createFromFormat('d/m/Y', $entity->dtvalidade);   
        }
    }
}
