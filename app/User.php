<?php

namespace App;

use Laravel\Cashier\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Billable;
    use Notifiable;


    public function empresa(){
        return $this->belongsToMany('App\Empresa', 'empresa_user')
                    ->withPivot('user_id','cargo','estado');

    }

    public function points(){

     return $this->hasOne('App\PuntosComprados','usuario_id');

    }

    public function company()
    {
        return $this->hasOne('App\empresa_user','user_id');
    }




    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','model', 'birthdate', 'natinality','phone','address','profile'
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
}
