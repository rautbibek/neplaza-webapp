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
      'delivery',
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

    protected $hidden =[];

    protected $appends=['created_date','product_price','product_max_price','is_favorite','product_cover'];

    public function product_image(){
      return $this->hasMany('App\Product_image')->select('id','image','product_id');
    }



    public function image(){
      return $this->hasOne('App\Product_image')->select('id','image','product_id');
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

    public function f_all(){
      return $this->belongsToMany('App\Feature','product_features')->withTimestamps();
    }

    public function product_features(){
      return $this->belongsToMany('App\Feature','product_features')->withTimestamps();
    }


    public function all_product_feature(){
      return $this->hasMany('App\Product_feature');
    }

    public function getIsFavoriteAttribute(){
      return true;
    }



    public function city(){
      return $this->belongsTo('App\City')->select('id','name','slug','product_count');
    }

    public function nhood(){
      return $this->belongsTo('App\Nhood')->select('id','name','slug','product_count');
    }

    public function type(){
      return $this->belongsTo('App\Type');
    }

    public function user(){
      return $this->belongsTo('App\User')->select('id','name','phone','username','phone_verified','hide_contact','image','created_at');
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

    public function urgent(){
      return $this->hasOne('App\Urgent');
    }

    public function featured(){
        return $this->hasOne('App\Featured');
    }

    public function product_property(){
        return $this->hasOne('App\Product_property');
    }

    public function report(){
        return $this->hasMany('App\Report');
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



    public function getProductCoverAttribute(){

      if($this->image != null){
        return asset('storage/thumb/'.$this->image->image);
      }else{
        return asset('image/no-image.webp');
      }
    }

}
