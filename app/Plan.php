<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';
    
    public function parameter()
    {
	    return $this->hasMany('App\Parameter', 'plans_id', 'id');
    }
}
