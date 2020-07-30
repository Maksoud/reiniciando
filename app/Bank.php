<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'banks';
    
    public function parameter()
    {
	    return $this->hasOne('App\Parameter', 'parameters_id', 'id');
    }
    
    public function transfers()
    {
	    return $this->belongsTo('App\Transfer', 'banks_id', 'id');
    }
    
    public function transfersDest()
    {
	    return $this->belongsTo('App\Transfer', 'banks_dest', 'id');
    }
    
    public function movements()
    {
	    return $this->belongsTo('App\Movement', 'banks_id', 'id');
    }
    
    public function movementChecks()
    {
	    return $this->belongsTo('App\MovementCheck', 'banks_id', 'id');
    }
    
    public function movementBanks()
    {
	    return $this->belongsTo('App\MovementBank', 'banks_id', 'id');
    }
    
    public function movementCards()
    {
	    return $this->belongsTo('App\MovementCard', 'banks_id', 'id');
    }
    
    public function balances()
    {
	    return $this->belongsTo('App\Balance', 'banks_id', 'id');
    }
}
