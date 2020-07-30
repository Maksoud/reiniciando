<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    protected $table = 'plannings';
    
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
    
    public function customer()
    {
	    return $this->hasOne('App\Customer', 'customers_id', 'id');
    }
    
    public function provider()
    {
	    return $this->hasOne('App\Provider', 'providers_id', 'id');
    }
    
    public function movements()
    {
	    return $this->belongsTo('App\Movement', 'plannings_id', 'id');
    }
    
    public function balances()
    {
	    return $this->belongsTo('App\Balance', 'plannings_id', 'id');
    }
}
