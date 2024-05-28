<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    protected $with = ['user'];
    
    protected $hidden = ['user_id'];
    
    public function user()
    {
        return $this -> belongsTo(User::class,'user_id');
    }
}
