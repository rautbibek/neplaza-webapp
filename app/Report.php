<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $appends=['created'];
    public function getCreatedAttribute(){
        return $this->created_at->diffForHumans();
    }
}
