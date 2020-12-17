<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand_model extends Model
{
  public function brand(){
    return $this->belongsTo('App\Brand');
  }

  public function product(){
    return $this->hasMany('App\Product');
  }
}
