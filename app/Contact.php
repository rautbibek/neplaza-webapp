<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $appends=[
        'created_date'];

    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }
}
