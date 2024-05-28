<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $with = ['user','post'];
    
    public function user()
    {
        return $this -> belongsTo(User::class,'from_user_id');
    }
    public function post()
    {
        return $this -> belongsTo(blog::class,'blog_id');
    }
}
