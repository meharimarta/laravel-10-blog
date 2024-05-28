<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    //
    use SoftDeletes;
    use HasFactory;
    
    protected $dates = ["deleted_at"];
    

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function catagory()
    {
        return hasOne('App\Catagory');
    }
    public function comment()
    {
        return $this -> hasMany('App\Comment');
    }
    public function getCreatedAtAttribute($value)
    {
        return date("F-d-Y g:i:s:a",strtotime($value));
    }
    public function getImageAttribute($value)
    {
        if(Storage::disk('web_asset')->exists('covers/'.$value))
            return asset('storage/covers/'.$value);
        else
            return asset('storage/postimgs/'.$value);
    }
    public function getTotalCommentsAttribute()
    {
        return $this->hasMany('App\Comment')->where('blog_id',$this->id)->count();
    }
    public function getTotalRepliesAttribute()
    {
        return $this->hasMany('App\CommentReply')->where('blog_id',$this->id)->count();
    }
    public function getTotalSumCommentsAttribute()
    {
        return $this -> getTotalCommentsAttribute() + $this -> getTotalRepliesAttribute();
    }
    protected $hidden = ['user_id'];
    protected $fillable = [
         'Title','post','image','Catagory'
     ];
    protected $appends = ['total_sum_comments'];
}
