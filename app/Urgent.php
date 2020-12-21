<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
class Urgent extends Model
{
    protected $fillable =['product_id','expire_date'];
    protected $appends=['remaining_days'];

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function getRemainingDaysAttribute(){
        return Carbon::now()->diffInDays($this->expire_date, false);
    }



    public static function boot(){
        parent::boot();
        static::saved(function($urgent){
            DB::table('products')
            ->where('id', $urgent->product_id)
            ->update(['emergency_sell' => 1]);
        });
       static::deleted(function($urgent){
            DB::table('products')
            ->where('id', $urgent->product_id)
            ->update(['emergency_sell' => 0]);
        });
    }
}
