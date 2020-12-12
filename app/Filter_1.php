<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filter_1 extends Model
{
  public function scategory(){
    return $this->belongsTo('App\Scategory');
  }

  public function product(){
    return $this->hasMany('App\Product');
  }
}
