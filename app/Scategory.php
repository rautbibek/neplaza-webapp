<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scategory extends Model
{
    public function category(){
      return $this->belongsTo('App\Category');
    }

    public function brand(){
      return $this->hasMany('App\Brand');
    }

    public function product(){
      return $this->hasMany('App\Product')
                  ->latest()
                  ->where('sold',false)
                  ->where('deleted',false);
    }

    public function type(){
      return $this->hasMany('App\Type');
    }

    public function status(){
      return $this->hasMany('App\Status');
    }

    public function filter(){
      return $this->hasMany('App\Filter');
    }

    public function filter_1(){
      return $this->hasMany('App\Filter_1');
    }

    public function filter_2(){
      return $this->hasMany('App\Filter_2');
    }

    public function filter_3(){
      return $this->hasMany('App\Filter_3');
    }
}
