<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public function product_image(){
      return $this->hasMany('App\Product_image');
    }

    public function category(){
      return $this->belongsTo('App\Category');
    }

    public function scategory(){
      return $this->belongsTo('App\Scategory');
    }

    public function favourit_to_users(){
      return $this->belongsToMany('App\User')->withTimestamps();
    }


    public function city(){
      return $this->belongsTo('App\City');
    }

    public function nhood(){
      return $this->belongsTo('App\Nhood');
    }

    public function type(){
      return $this->belongsTo('App\Type');
    }

    public function user(){
      return $this->belongsTo('App\User');
    }

    public function status(){
      return $this->belongsTo('App\Status');
    }


    public function brand(){
      return $this->belongsTo('App\Brand');
    }

    public function brand_model(){
      return $this->belongsTo('App\Brand_model');
    }

    public function filter(){
      return $this->belongsTo('App\Filter');
    }

    public function filter_1(){
      return $this->belongsTo('App\Filter_1');
    }

    public function filter_2(){
      return $this->belongsTo('App\Filter_2');
    }

    public function filter_3(){
      return $this->belongsTo('App\Filter_3');
    }

    public function comment(){
      return $this->hasMany('App\Comment')->latest();
    }


}
