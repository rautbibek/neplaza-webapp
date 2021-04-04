<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    public function setUsernameAttribute($value)
    {
       $username = str_slug($value);

       if(User::whereUsername($username)->exists())
       {
         $this->attributes['username'] = $username.'-'.uniqid();

       }else{
         $this->attributes['username'] = $username;
       }
       
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','phone', 'email', 'password','role_id','username',
    ];

    

    protected $guard = ['role_id'];

    protected $appends =['cover','register_date','contact_status','contact_number','valid_email','completion'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','role_id','phone','email','account_status','blck_by_admin','login_provider','provider_id'
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

    public function sent_message(){
       return $this->hasOne(Message::class,'to_id','id')->where('from_id',auth()->id())->latest();
    }

    public function received_message(){
      return $this->hasOne(Message::class,'from_id','id')->where('to_id',auth()->id())->latest();
    }

    public function city(){
       return $this->belongsTo('App\City')->select('id','name');
    }

    public function Nhood(){
       return $this->belongsTo('App\Nhood')->select('id','name');
    }

    public function product(){
       return $this->hasMany('App\Product')->latest();
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
               return asset('image/user.png');
            }
    }else{
      return asset('image/user.png');
   }
 }

 public function getValidEmailAttribute() {
     if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
         return $this->email;
      } else {
         return "";
      }
   }

   public function getCompletionAttribute(){
      if($this->password){
         return true;
      }else{
         return false;
      }
   }

   // slack notification
   public function routeNotificationForSlack($notification)
    {
        return 'https://hooks.slack.com/services/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';
    }
}
