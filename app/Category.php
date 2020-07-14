<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function scategory(){
      return $this->hasMany('App\Scategory');
    }
    public function product(){
      return $this->hasMany('App\Product')->where('sold',false)
                  ->where('deleted',false);;
    }
}
