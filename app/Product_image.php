<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Product_image extends Model
{
  protected $appends  = ['thumb_image','full_image'];
  protected $fillable = ['image'];

  public function product(){
    return $this->belongsTo('App\Product')->select('id','product_id','image');
  }

  public function getThumbImageAttribute(){
    return asset('storage/thumb/'.$this->image);
  }

  public function getFullImageAttribute(){
    return asset('storage/product/'.$this->image);
  }
  public static function boot(){
      parent::boot();

     static::deleting(function($product_image){

       if(Storage::disk('public')->exists('product/'.'/'.$product_image->image)){
           Storage::disk('public')->delete('product/'.$product_image->image);
       }
       if(Storage::disk('public')->exists('thumb/'.'/'.$product_image->image)){
           Storage::disk('public')->delete('thumb/'.'/'.$product_image->image);
       }
      });
  }

}
