<?php

namespace App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
      'title',
      'description',
      'price',
      'status_id',
      'city_id',
      'nhood_id',
      'user_id',
      'address',
      'category_id',
      'scategory_id',
      'type_id',
      'brand_id',
      'brand_model',
      'filter_id',
      'maxprice',
      'filter_1_id',
      'filter_2_id',
      'filter_3_id',
      'property_1',
      'property_2',
      'property_3',
      'property_4',
      'join'
    ];
  

    protected $with=['product_image'];
    protected $appends=[
      'created_date','product_price','product_max_price','ad_title',
    'is_favorite','product_cover'];

    public function product_image(){
      return $this->hasMany('App\Product_image')->select('id','image','product_id');
    }

    public function category(){
      return $this->belongsTo('App\Category')->select('id','name','slug','url');
    }

    public function scategory(){
      return $this->belongsTo('App\Scategory')->select('id','name','slug','url');
    }

    public function favorite_to_users(){
      return $this->belongsToMany('App\User','product_user')->withTimestamps();
    }

    public function getIsFavoriteAttribute(){
      return true; 
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

    public function getCreatedDateAttribute(){
      return $this->created_at->diffForHumans();
    }

    public function getProductPriceAttribute(){
      return number_format($this->price);
    }

    public function getProductMaxPriceAttribute(){
      $max_p = number_format($this->maxprice);
      if($max_p == 0 || $max_p == null){
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
