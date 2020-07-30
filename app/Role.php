<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    
    public function users()
    {
	    return $this->belongsToMany('App\User', 'users_parameters', 'roles_id', 'users_id');
    }
}
