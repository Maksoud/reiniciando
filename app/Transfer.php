<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = 'transfers';
    
    public function parameter()
    {
	    return $this->hasOne('App\Parameter', 'parameters_id', 'id');
    }
    
    public function accountPlan()
    {
	    return $this->hasOne('App\AccountPlan', 'account_plans_id', 'id');
    }
    
    public function accountPlanDest()
    {
	    return $this->hasOne('App\AccountPlan', 'account_plans_dest', 'id');
    }
    
    public function cost()
    {
	    return $this->hasOne('App\Cost', 'costs_id', 'id');
    }
    
    public function costDest()
    {
	    return $this->hasOne('App\Cost', 'costs_dest', 'id');
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
    
    public function bankDest()
    {
	    return $this->hasOne('App\Bank', 'banks_dest', 'id');
    }
    
    public function box()
    {
	    return $this->hasOne('App\Box', 'boxes_id', 'id');
    }
    
    public function boxDest()
    {
	    return $this->hasOne('App\Box', 'boxes_dest', 'id');
    }
    
    public function movementChecks()
    {
	    return $this->belongsTo('App\MovementCheck', 'transfers_id', 'id');
    }
    
    public function movementBanks()
    {
	    return $this->belongsTo('App\MovementBank', 'transfers_id', 'id');
    }
    
    public function movementBoxes()
    {
	    return $this->belongsTo('App\MovementBox', 'transfers_id', 'id');
    }
}
