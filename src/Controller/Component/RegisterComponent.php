<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\I18n\Number;
use Cake\Log\Log;

Number::config('pt_BR', \NumberFormatter::CURRENCY, [
    'pattern'   => '#.##,##0',
    'places'    => 2,
    'zero'      => __('0,00'),
    'decimals'  => ',',
    'thousands' => '.',
    'negative'  => '-'
    ]);

class RegisterComponent extends Component 
{   
    /*
    05/04/2018 - Não desenvolvido o cadastro automático do plano de contas, devido a flexibilidade do usuário escolhar quais numerações (classifications) quer utilizar.
    */
    
    public function __construct()
    {
        $this->Error = new ErrorComponent();

        $this->Cards     = TableRegistry::get('Cards');
        $this->Costs     = TableRegistry::get('Costs');
        $this->Providers = TableRegistry::get('Providers');
        $this->Plannings = TableRegistry::get('Plannings');
    }
    
    public function addCustomer($title, $parameters_id)
    {
        //AINDA NÃO UTILIZADO 05/04/2018
        $customer = $this->Customers->newEntity();
        
        $customer->title         = $title;
        $customer->fantasia      = $title;
        $customer->obs           = 'Cadastro gerado automaticamente pelo sistema';
        $customer->tipo          = 'F'; //PESSOA FÍSICA
        $customer->status        = 'T'; //STATUS AUTOMÁTICO (CARTÃO), MAS PODE SER GERADO PELO PLANEJAMENTO
        $customer->username      = $_SESSION['Auth']['User']['name'];
        $customer->parameters_id = $parameters_id;
        
        if ($this->Customers->save($customer)) {
            return $customer->id;
        }//if ($this->Customers->save($customer))
        
        //Alerta de erro
        $message = 'RegisterComponent->addProvider, addCustomer';
        $this->Error->registerError($customer, $message, true);

        return false;
    }
    
    public function addProvider($title, $parameters_id)
    {
        //UTILIZADO SOMENTE NO CADASTRO DE CARTÕES E PLANEJAMENTOS
        $provider = $this->Providers->newEntity();
        
        $provider->title         = $title;
        $provider->fantasia      = $title;
        $provider->obs           = 'Cadastro gerado automaticamente pelo sistema';
        $provider->tipo          = 'F'; //PESSOA FÍSICA
        $provider->status        = 'T'; //STATUS AUTOMÁTICO (CARTÃO), MAS PODE SER GERADO PELO PLANEJAMENTO
        $provider->username      = $_SESSION['Auth']['User']['name'];
        $provider->parameters_id = $parameters_id;
        
        if ($this->Providers->save($provider)) {
            return $provider->id;
        }//if ($this->Providers->save($provider))
        
        //Alerta de erro
        $message = 'RegisterComponent->addProvider, Providers';
        $this->Error->registerError($provider, $message, true);

        return false;
    }
    
    public function addCost($title, $parameters_id)
    {
        //UTILIZADO SOMENTE NO CADASTRO DE CARTÕES E PLANEJAMENTOS
        $cost = $this->Costs->newEntity();
        
        $cost->title         = $title;
        $cost->username      = $_SESSION['Auth']['User']['name'];
        $cost->status        = 'T'; //STATUS AUTOMÁTICO (CARTÃO)
        $cost->parameters_id = $parameters_id;
        
        if ($this->Costs->save($cost)) {
            return $cost->id;
        }

        //Alerta de erro
        $message = 'RegisterComponent->addCost, Costs';
        $this->Error->registerError($cost, $message, true);

        return false;
    }
    
    public function editCustomer($object)
    {
        //AINDA NÃO UTILIZADO 05/04/2018
        $this->Model = $object->source();
        
        /**********************************************************************/
        
        //DEFINE CAMPOS PARA CADASTRO
        if ($this->Model == 'Cards') {
            
            $card      = $this->Cards->findByIdAndParametersId($object->id, $object->parameters_id)
                                     ->first();
            
            $field_id  = $card->customers_id;
            $title     = $object->title;
            
        } elseif ($this->Model == 'Plannings') {
            
            $planning  = $this->Plannings->findByIdAndParametersId($object->id, $object->parameters_id)
                                         ->first();
            
            $field_id  = $planning->customers_id;
            $title     = $object->title;
            
        }
        
        /**********************************************************************/
        
        $customer = $this->Customers->findByIdAndParametersId($field_id, $object->parameters_id)
                                    ->first();
        
        /**********************************************************************/
        
        if (!empty($customer)) {
            
            //ATUALIZA REGISTRO
            $customer->title    = $title;
            $customer->fantasia = $title;
            $customer->username = $_SESSION['Auth']['User']['name'];
            //Não modifica o status
            
            //SALVA ALTERAÇÕES
            if (!$this->Customers->save($customer)) {
                
                //Alerta de erro
                $message = 'RegisterComponent->editCustomer, Customers';
                $this->Error->registerError($customer, $message, true);

            }//if (!$this->Customers->save($customer))
            
        }//if (!empty($customer))
        
    }
    
    public function editProvider($object)
    {
        //UTILIZADO SOMENTE NO CADASTRO DE CARTÕES E PLANEJAMENTOS
        $this->Model = $object->source();
        
        /**********************************************************************/
        
        //DEFINE CAMPOS PARA CADASTRO
        if ($this->Model == 'Cards') {
            
            $card      = $this->Cards->findByIdAndParametersId($object->id, $object->parameters_id)
                                     ->first();
            
            $field_id  = $card->providers_id;
            $title     = $object->title;
            
        } elseif ($this->Model == 'Plannings') {
            
            $planning  = $this->Plannings->findByIdAndParametersId($object->id, $object->parameters_id)
                                         ->first();
            
            $field_id  = $planning->providers_id;
            $title     = $object->title;
            
        }
        
        /**********************************************************************/
        
        $provider = $this->Providers->findByIdAndParametersId($field_id, $object->parameters_id)
                                    ->first();
        
        /**********************************************************************/
        
        if (!empty($provider)) {
            
            //ATUALIZA REGISTRO
            $provider->title    = $title;
            $provider->fantasia = $title;
            $provider->username = $_SESSION['Auth']['User']['name'];
            //Não modifica o status
            
            //SALVA ALTERAÇÕES
            if (!$this->Providers->save($provider)) {
                
                //Alerta de erro
                $message = 'RegisterComponent->editProvider';
                $this->Error->registerError($provider, $message, true);

            }//if (!$this->Providers->save($provider))
            
        }//if (!empty($provider))
        
    }
    
    public function editCost($object)
    {
        //UTILIZADO SOMENTE NO CADASTRO DE CARTÕES E PLANEJAMENTOS
        $this->Model = $object->source();
        
        /**********************************************************************/
        
        //DEFINE CAMPOS PARA CADASTRO
        if ($this->Model == 'Cards') {
            
            $card      = $this->Cards->findByIdAndParametersId($object->id, $object->parameters_id)
                                     ->first();
            
            $field_id  = $card->costs_id;
            $title     = $object->title;
            
        } elseif ($this->Model == 'Plannings') {
            
            $planning  = $this->Plannings->findByIdAndParametersId($object->id, $object->parameters_id)
                                         ->first();
            
            $field_id  = $planning->providers_id;
            $title     = $object->title;
            
        }
        
        /**********************************************************************/
        
        $cost = $this->Costs->findByIdAndParametersId($field_id, $object->parameters_id)
                            ->first();
        
        /**********************************************************************/
        
        if (!empty($cost)) {
            
            //ATUALIZA REGISTRO
            $cost->title    = $title;
            $cost->username = $_SESSION['Auth']['User']['name'];
            //Não modifica o status
            
            //SALVA ALTERAÇÕES
            if (!$this->Costs->save($cost)) {

                //Alerta de erro
                $message = 'RegisterComponent->editCost';
                $this->Error->registerError($cost, $message, true);

            }//if (!$this->Costs->save($cost))
            
        }//if (!empty($cost))
        
    }
    
    public function deleteCustomer($id, $parameters_id)
    {
        //AINDA NÃO UTILIZADO 05/04/2018
        $conditions = ['Customers.id'            => $id,
                       'Customers.parameters_id' => $parameters_id
                      ];
        
        $this->Customers->deleteAll($conditions, false);
    }
    
    public function deleteProvider($id, $parameters_id)
    {
        //UTILIZADO SOMENTE NO CADASTRO DE CARTÕES E PLANEJAMENTOS
        $conditions = ['Providers.id'            => $id,
                       'Providers.parameters_id' => $parameters_id
                      ];
        
        $this->Providers->deleteAll($conditions, false);
    }
    
    public function deleteCost($id, $parameters_id)
    {
        //UTILIZADO SOMENTE NO CADASTRO DE CARTÕES E PLANEJAMENTOS
        $conditions = ['Costs.id'            => $id,
                       'Costs.parameters_id' => $parameters_id
                      ];
        
        $this->Costs->deleteAll($conditions, false);
    }
}    