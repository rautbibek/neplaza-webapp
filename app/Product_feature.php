<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_feature extends Model
{
    public function features(){
      return $this->belongsTo('App\Feature','feature_id');
    }
}
