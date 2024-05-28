<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    
    protected $with = [
        'userInfo'
    ];
    public function blogs() 
    {
        return $this -> hasMany(blog::class);
    }
    public function userInfo()
    {
        return $this ->hasOne(UserInfo::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','id','created_at','updated_at','email'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getProfilePictureAttribute($value)
    {
        //if the user does not have profile picture give the default picture
        if($value == '0')
            return asset('assets/user.png');
        //return the profile picture
        return asset($value);
    }
    public function toArray()
    {
        if(Auth::check() && Auth::user()->id===1)
        {
            $this->makeVisible(['email']);
        }
        return parent::toArray();
    }
}
