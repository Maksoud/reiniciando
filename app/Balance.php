<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'balances';
    
    public function parameter()
    {
	    return $this->hasOne('App\Parameter', 'parameters_id', 'id');
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
    
    public function planning()
    {
	    return $this->hasOne('App\Planning', 'plannings_id', 'id');
    }
}
