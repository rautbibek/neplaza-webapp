<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function nhood(){
      return $this->hasMany('App\Nhood');
    }

    public function product(){
      return $this->hasMany('App\Product');
    }

    public function user(){
      return $this->hasMany('App\User');
    }
}
