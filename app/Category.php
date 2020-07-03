<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function scategory(){
      return $this->hasMany('App\Scategory')->select('id','name','slug','category_id');
    }
    public function product(){
      return $this->hasMany('App\Product');
    }
}
