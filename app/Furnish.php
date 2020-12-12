<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Furnish extends Model
{

  public function scategory(){
    return $this->belongsTo('App\Scategory');
  }

  public function product(){
    return $this->hasMany('App\Product');
  }
}
