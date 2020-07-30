<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $table = 'movements';
    
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
    
    public function bank()
    {
	    return $this->hasOne('App\Bank', 'banks_id', 'id');
    }
    
    public function box()
    {
	    return $this->hasOne('App\Box', 'boxes_id', 'id');
    }
    
    public function card()
    {
	    return $this->hasOne('App\Card', 'cards_id', 'id');
    }
    
    public function provider()
    {
	    return $this->hasOne('App\Provider', 'providers_id', 'id');
    }
    
    public function customer()
    {
	    return $this->hasOne('App\Customer', 'customers_id', 'id');
    }
    
    public function planning()
    {
	    return $this->hasOne('App\Planning', 'plannings_id', 'id');
    }
    
    public function movementChecks()
    {
	    return $this->belongsTo('App\MovementCheck', 'movements_id', 'id');
    }
    
    public function movementBanks()
    {
	    return $this->belongsTo('App\MovementBank', 'movements_id', 'id');
    }
    
    public function movementBoxes()
    {
	    return $this->belongsTo('App\MovementBox', 'movements_id', 'id');
    }
    
    public function movementCards()
    {
	    return $this->belongsTo('App\MovementCard', 'movements_id', 'id');
    }
}
