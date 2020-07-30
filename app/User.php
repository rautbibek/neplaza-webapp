<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id','username',
    ];

    protected $guard = ['role_id'];


   

    protected $appends =['cover','register_date','contact_status','contact_number','valid_email'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
       return $this->belongsTo('App\Role');
    }

    public function city(){
       return $this->belongsTo('App\City')->select('id','name');
    }

    public function Nhood(){
       return $this->belongsTo('App\Nhood')->select('id','name');
    }

    public function product(){
       return $this->hasMany('App\Product')->latest()->where('sold',false)->where('deleted',false);
    }

    public function report(){
       return $this->hasMany('App\Report');
    }

    public function getRegisterDateAttribute(){
      return date("d M Y", strtotime($this->created_at));
    }

    public function comment(){
       return $this->hasMany('App\Comment');
    }
    public function favourit_products(){
      return $this->belongsToMany('App\Product','product_user')
            ->withTimestamps()->where('sold',false)->where('deleted',false);
    }

    public function getContactStatusAttribute(){
      if($this->hide_contact){
         return 'Hidden for all';
      }
       return "Visible for all";
    }

    public function getContactNumberAttribute(){
      if($this->phone != '' || $this->phone != NULL){
         if(!$this->hide_contact){
            return $this->phone;
         }
         return '+977- xx-xxxx-xxxx';
         
      }
       return "N/A";
    }

    

    public function getCoverAttribute(){
      if($this->image != null && $this->image != ''){
         if (@is_array(getimagesize($this->image))) {
               return $this->image;
            }elseif(file_exists(public_path().'/storage/profile/'.$this->image)){
               return asset('storage/profile/'.$this->image);
            }else{
               return asset('storage/user.png');
            }
    }else{
      return asset('storage/user.png');
   }
 }

 public function getValidEmailAttribute() {
     if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
         return $this->email;
      } else {
         return "";
      }
   }
}
