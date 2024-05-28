<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $hidden = ['user_id'];
    
    protected $with = ['user','reply'];
    public function reply()
    {
        return $this->hasMany(CommentReply::class,'parent_comment_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
