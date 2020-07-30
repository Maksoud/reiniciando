<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $table = 'boxes';
    
    public function parameter()
    {
	    return $this->hasOne('App\Parameter', 'parameters_id', 'id');
    }
    
    public function transfers()
    {
	    return $this->belongsTo('App\Transfer', 'boxes_id', 'id');
    }
    
    public function transfersDest()
    {
	    return $this->belongsTo('App\Transfer', 'boxes_dest', 'id');
    }
    
    public function movements()
    {
	    return $this->belongsTo('App\Movement', 'boxes_id', 'id');
    }
    
    public function movementChecks()
    {
	    return $this->belongsTo('App\MovementCheck', 'boxes_id', 'id');
    }
    
    public function movementCards()
    {
	    return $this->belongsTo('App\MovementCard', 'boxes_id', 'id');
    }
    
    public function balances()
    {
	    return $this->belongsTo('App\Balance', 'boxes_id', 'id');
    }
}
