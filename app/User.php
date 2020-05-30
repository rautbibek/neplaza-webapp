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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
       return $this->belongsTo('App\Role');
    }

    public function city(){
       return $this->belongsTo('App\City');
    }

    public function Nhood(){
       return $this->belongsTo('App\Nhood');
    }

    public function product(){
       return $this->hasMany('App\Product')->latest()->where('sold',false)->where('deleted',false);
    }

    public function comment(){
       return $this->hasMany('App\Comment');
    }
    public function favourit_products(){
      return $this->belongsToMany('App\Product')
            ->withTimestamps()->where('sold',false)->where('deleted',false);
    }
}
