<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $table = 'parameters';
    
    public function plan()
    {
	    return $this->hasOne('App\Plan', 'plans_id', 'id');
    }
    
    public function users()
    {
	    return $this->belongsToMany('App\User', 'users_parameters', 'parameters_id', 'users_id');
    }
    
    public function accountPlans()
    {
	    return $this->belongsTo('App\AccountPlan', 'parameters_id', 'id'); 
    }
    
    public function costs()
    {
	    return $this->belongsTo('App\Cost', 'parameters_id', 'id'); 
    }
    
    public function documentTypes()
    {
	    return $this->belongsTo('App\DocumentType', 'parameters_id', 'id'); 
    }
    
    public function eventTypes()
    {
	    return $this->belongsTo('App\EventType', 'parameters_id', 'id'); 
    }
    
    public function banks()
    {
	    return $this->belongsTo('App\Bank', 'parameters_id', 'id'); 
    }
    
    public function boxes()
    {
	    return $this->belongsTo('App\Box', 'parameters_id', 'id'); 
    }
    
    public function cards()
    {
	    return $this->belongsTo('App\Card', 'parameters_id', 'id'); 
    }
    
    public function customers()
    {
	    return $this->belongsTo('App\Customer', 'parameters_id', 'id'); 
    }
    
    public function providers()
    {
	    return $this->belongsTo('App\Provider', 'parameters_id', 'id'); 
    }
    
    public function plannings()
    {
	    return $this->belongsTo('App\Planning', 'parameters_id', 'id'); 
    }
    
    public function transfers()
    {
	    return $this->belongsTo('App\Transfer', 'parameters_id', 'id'); 
    }
    
    public function movements()
    {
	    return $this->belongsTo('App\Movement', 'parameters_id', 'id'); 
    }
    
    public function movementChecks()
    {
	    return $this->belongsTo('App\MovementChecks', 'parameters_id', 'id'); 
    }
    
    public function movementBanks()
    {
	    return $this->belongsTo('App\MovementBanks', 'parameters_id', 'id'); 
    }
    
    public function movementBoxes()
    {
	    return $this->belongsTo('App\MovementBoxes', 'parameters_id', 'id'); 
    }
    
    public function movementCards()
    {
	    return $this->belongsTo('App\MovementCards', 'parameters_id', 'id'); 
    }
    
    public function balances()
    {
	    return $this->belongsTo('App\Balance', 'parameters_id', 'id'); 
    }
    
    public function regs()
    {
	    return $this->belongsTo('App\Reg', 'parameters_id', 'id'); 
    }
}