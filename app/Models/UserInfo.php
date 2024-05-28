<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $hidden = [
        'user_id'
    ];
    public function getSocialLinkAvailableAttribute()
    {
        if(
            $this->attributes['fb'] ||
            $this->attributes['yb'] || 
            $this->attributes['tg'] || 
            $this->attributes['twt']
          ) return true;
        return false;
    }
    public function getCoverAttribute()
    {
        return asset($this->attributes['cover_image']);
    }
    protected $appends = [
        'social_link_available',
        'cover'
    ];
}
