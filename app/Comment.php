<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $appends = ['created'];
    protected $fillable = [
        'user_id',
        'product_id',
        'reply_id',
        'body'
    ];
    protected $with = ['user','replies'];
    public function user(){
      return $this->belongsTo('App\User')->select('id','name','image');
    }

    public function product(){
      return $this->belongsTo('App\Product');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class,'reply_id','id');
    }

    public function getCreatedAttribute(){
      return $this->created_at->diffForHumans();
    }
}
