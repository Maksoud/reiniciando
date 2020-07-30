<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovementBox extends Model
{
    protected $table = 'movement_boxes';
    
    public function parameter()
    {
	    return $this->hasOne('App\Parameter', 'parameters_id', 'id');
    }
    
    public function accountPlan()
    {
	    return $this->hasOne('App\AccountPlan', 'account_plans_id', 'id');
    }
    
    public function cost()
    {
	    return $this->hasOne('App\Cost', 'costs_id', 'id');
    }
    
    public function documentType()
    {
	    return $this->hasOne('App\DocumentType', 'document_types_id', 'id');
    }
    
    public function eventType()
    {
	    return $this->hasOne('App\EventType', 'event_types_id', 'id');
    }
    
    public function box()
    {
	    return $this->hasOne('App\Box', 'boxes_id', 'id');
    }
    
    public function provider()
    {
	    return $this->hasOne('App\Provider', 'providers_id', 'id');
    }
    
    public function customer()
    {
	    return $this->hasOne('App\Customer', 'customers_id', 'id');
    }
    
    public function transfer()
    {
	    return $this->hasOne('App\Transfer', 'transfers_id', 'id');
    }
    
    public function movement()
    {
	    return $this->hasOne('App\Movement', 'movements_id', 'id');
    }
    
    public function movementCheck()
    {
	    return $this->hasOne('App\MovementCheck', 'movement_checks_id', 'id');
    }
}
