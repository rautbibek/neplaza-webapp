<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Featured extends Model
{
    protected $fillable=['expire_date','product_id'];
    protected $appends=['remaining_days','remaining_minute'];
    public function product(){
        return $this->belongsTo('App\Product');
    }

    
    public function getRemainingDaysAttribute(){
        return Carbon::now()->diffInDays($this->expire_date, false);
    }

    public function getRemainingMinuteAttribute(){
        return Carbon::now()->diffInMinutes($this->expire_date, false);
        
    }

    public static function boot(){
        parent::boot();
        static::saved(function($featured){
            DB::table('products')
            ->where('id', $featured->product_id)
            ->update(['premium' => 1]);
        });
       static::deleted(function($featured){
            DB::table('products')
             ->where('id', $featured->product_id)
             ->update(['premium' => 0]);
            
        });
    }
}