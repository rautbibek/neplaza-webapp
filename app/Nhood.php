<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nhood extends Model
{
    public function city(){
      return $this->belongsTo('App\City');
    }

    public function product(){
      return $this->hasMany('App\Product');
    }

    public function user(){
      return $this->hasMany('App\User');
    }

}
