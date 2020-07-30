<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    protected $table = 'costs';
    
    public function parameter()
    {
	    return $this->hasOne('App\Parameter', 'parameters_id', 'id');
    }
    
    public function plannings()
    {
	    return $this->belongsTo('App\Planning', 'costs_id', 'id');
    }
    
    public function transfers()
    {
	    return $this->belongsTo('App\Transfer', 'costs_id', 'id');
    }
    
    public function transfersDest()
    {
	    return $this->belongsTo('App\Transfer', 'costs_dest', 'id');
    }
    
    public function movements()
    {
	    return $this->belongsTo('App\Movement', 'costs_id', 'id');
    }
    
    public function movementChecks()
    {
	    return $this->belongsTo('App\MovementCheck', 'costs_id', 'id');
    }
    
    public function movementBanks()
    {
	    return $this->belongsTo('App\MovementBank', 'costs_id', 'id');
    }
    
    public function movementBoxes()
    {
	    return $this->belongsTo('App\MovementBox', 'costs_id', 'id');
    }
    
    public function movementCards()
    {
	    return $this->belongsTo('App\MovementCard', 'costs_id', 'id');
    }
}
