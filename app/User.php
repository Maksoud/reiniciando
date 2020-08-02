<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $table = 'users';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'language', 'last_parameter'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function parameters()
    {
	    return $this->belongsToMany('App\Parameter', 'users_parameters', 'users_id', 'parameters_id');
    }
    
    public function roles()
    {
	    return $this->belongsToMany('App\Role', 'users_parameters', 'users_id', 'roles_id');
    }
    
    public function regs()
    {
	    return $this->hasMany('App\Reg', 'users_id', 'id');
    }
}
