<?php

namespace App;

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

}
