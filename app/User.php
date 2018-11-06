<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function clienti_visibili()
    {
        return $this->belongsToMany('App\Cliente', 'tblClienteVisibileCommerciale', 'user_id', 'cliente_id');
    }


    public function clienti_associati()
    {
        return $this->belongsToMany('App\Cliente', 'tblClienteAssociatoCommerciale', 'user_id', 'cliente_id');
    }




}
