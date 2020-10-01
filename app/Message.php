<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable=['to_id','from_id','text'];
    protected $guarded = [];
    protected $appends = ['message_at'];

    public function fromContact(){
        return $this->hasOne(User::class,'id','from_id');
    }

    // public function user(){
    //     return $this->belongsTo(User::class,'id','from_id','to_id');
    // }

    public function getmessageAtAttribute(){
        return $this->created_at->format('l, g:i A');
    }
}
