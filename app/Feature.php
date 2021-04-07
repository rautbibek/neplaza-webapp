<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    public function scategory(){
      return $this->belognsTo('App\Scategory');
    }

    // public function fearure_product(){
    //   return $this->belongsToMany('App\Product','product_features')->withTimestamps();
    // }
}
