<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
  public function scategory(){
    return $this->belongsTo('App\Scategory');
  }

  public function brand_model(){
    return $this->hasMany('App\Brand_model');
  }

  public function product(){
    return $this->hasMany('App\Product');
  }
}
