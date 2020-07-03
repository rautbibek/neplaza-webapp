<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_image extends Model
{
  
  protected $fillable = ['image'];

  public function product(){
    return $this->belongsTo('App\Product')->select('id','image');
  }


}
