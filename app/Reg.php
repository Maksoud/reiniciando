<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reg extends Model
{
    protected $table = 'regs';
    
    public function parameter()
    {
	    return $this->hasOne('App\Parameter', 'parameters_id', 'id');
    }
    
    public function user()
    {
	    return $this->belongsTo('App\User', 'users_id', 'id');
    }
}
