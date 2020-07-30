<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $appends=['created'];
    public function getCreatedAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function product(){
        return $this->belongsTo('App\Product')->select('id','title','created_at');
    }

    public function user(){
        return $this->belongsTo('App\User')->select('id','name','created_at');
    }
}
