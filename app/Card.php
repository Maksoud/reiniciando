<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';
    
    public function parameter()
    {
	    return $this->hasOne('App\Parameter', 'parameters_id', 'id');
    }
    
    public function movements()
    {
	    return $this->belongsTo('App\Movement', 'cards_id', 'id');
    }
    
    public function movementCards()
    {
	    return $this->belongsTo('App\MovementCard', 'cards_id', 'id');
    }
    
    public function balances()
    {
	    return $this->belongsTo('App\Balance', 'cards_id', 'id');
    }
}
