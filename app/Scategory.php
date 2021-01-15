<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scategory extends Model
{
    
    public function category(){
      return $this->belongsTo('App\Category');
    }

    public function brand(){
      return $this->hasMany('App\Brand')->orderBy('id','asc')->orderBy('name','asc');
    }

    public function product(){
      return $this->hasMany('App\Product')
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
      return $this->hasMany('App\Filter')->orderBy('id','asc');
    }

    public function filter_1(){
      return $this->hasMany('App\Filter_1')->orderBy('name','asc');
    }

    public function filter_2(){
      return $this->hasMany('App\Filter_2')->orderBy('name','asc');
    }

    public function filter_3(){
      return $this->hasMany('App\Filter_3')->orderBy('name','asc');
    }
}
