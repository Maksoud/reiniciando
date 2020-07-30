<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountPlan extends Model
{
    protected $table = 'account_plans';
    
    public function parameter()
    {
	    return $this->hasOne('App\Parameter', 'parameters_id', 'id');
    }
    
    public function group()
    {
	    return $this->hasOne('App\AccountPlan', 'plangroup', 'id');
    }
    
    public function plannings()
    {
	    return $this->belongsTo('App\Planning', 'account_plans_id', 'id');
    }
    
    public function transfers()
    {
	    return $this->belongsTo('App\Transfer', 'account_plans_id', 'id');
    }
    
    public function transfersDest()
    {
	    return $this->belongsTo('App\Transfer', 'account_plans_dest', 'id');
    }
    
    public function movements()
    {
	    return $this->belongsTo('App\Movement', 'account_plans_id', 'id');
    }
    
    public function movementChecks()
    {
	    return $this->belongsTo('App\MovementCheck', 'account_plans_id', 'id');
    }
    
    public function movementBanks()
    {
	    return $this->belongsTo('App\MovementBank', 'account_plans_id', 'id');
    }
    
    public function movementBoxes()
    {
	    return $this->belongsTo('App\MovementBox', 'account_plans_id', 'id');
    }
    
    public function movementCards()
    {
	    return $this->belongsTo('App\MovementCard', 'account_plans_id', 'id');
    }
}
