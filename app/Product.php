<?php

namespace App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $appends=['created_date','product_price','product_max_price','ad_title','is_favorite','product_cover'];

    public function product_image(){
      return $this->hasMany('App\Product_image')->select('id','image','product_id');
    }

    public function category(){
      return $this->belongsTo('App\Category')->select('id','name','slug');
    }

    public function scategory(){
      return $this->belongsTo('App\Scategory')->select('id','name','slug');
    }

    public function favorite_to_users(){
      return $this->belongsToMany('App\User')->withTimestamps();
    }

    public function getIsFavoriteAttribute(){
      return $this->favorite_to_users()->where('user_id',Auth::id())->count() >0;
    }

    public function city(){
      return $this->belongsTo('App\City')->select('id','name','slug');
    }

    public function nhood(){
      return $this->belongsTo('App\Nhood')->select('id','name','slug');
    }

    public function type(){
      return $this->belongsTo('App\Type');
    }

    public function user(){
      return $this->belongsTo('App\User')->select('id','name');
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

    public function getCreatedDateAttribute(){
      return $this->created_at->diffForHumans();
    }

    public function getProductPriceAttribute(){
      return number_format($this->price);
    }

    public function getProductMaxPriceAttribute(){
      $max_p = number_format($this->maxprice);
      if($max_p == 0){
        return "";
      }else{
        return ' - '.$max_p;
      }
    }

    public function getAdTitleAttribute(){
      return ucwords($this->title);
    }

    public function getProductCoverAttribute(){
      $count = $this->product_image->count();
      if($count>0){
        return asset('storage/thumb/'.$this->product_image[0]->image);
      }else{
        return asset('storage/noimage.png');
      }
    }

}
