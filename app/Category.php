<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function scategory(){
      return $this->hasMany('App\Scategory')->select('id','name','slug','url','category_id','view_count');
    }
    public function product(){
      return $this->hasMany('App\Product');
    }
}
