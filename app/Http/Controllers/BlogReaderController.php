<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\blog;
use App\Comment;
use App\CommentReply;
use App\Notification;
use Illuminate\Support\Facades\Auth;
use App\Events\NewCommentEvent;
class BlogReaderController extends Controller
{
    public function index($id)
    {
        return view('blog.readBlog')->with('blog',blog::where('id',$id)->get());
    }
    //    *******************************************************************
    //    *******************************************************************
    public function insertComment(Request $request)
    {
        //if the request has parent comment id it is comment reply, insert into comment reply table
        //else it is c=new comment insert in to comments table
        if($request -> has('parent_comment_id'))
        {
            $comment = new CommentReply;
            $comment -> parent_comment_id = $request -> input('parent_comment_id');  
        }else {
            $comment = new Comment;
        }
        $comment -> comment = clean($request -> input('comment'));
        $comment -> blog_id = $request -> input('blog_id');
        //        check if the user is Anonymous or not
        //        if the user is authrntcated set thair real id
        //        if not set anonymous user id 2
        if(Auth::check()) 
        {
            //if the user is authentcated use its id and name
            $comment -> user_id = Auth::user()->id;
            $comment -> name = Auth::user() -> name;
        } else {
            //else use anonymous user
            $comment -> user_id = 2;
            if($request -> session() -> has('commenter_name'))
                $comment -> name = $request -> session()->get('commenter_name');
            else
                $comment -> name = clean($request -> input('name'));
        }
        //if the comment is saved add to the notification table
        //with blog_id and user_id who created the blog
        if($comment -> save())
        {
            //and we dont need to notify if the blog creator is replying or commenting on its own post
            $user = Auth::check() ? Auth::user() : false;
            $blog = blog::find($comment->blog_id);
            if(!$user || $comment -> user_id != $blog ->user_id)
            {
                event(new NewCommentEvent($blog,$comment));
            }
            //set thecommenter name in the session so the visitor did not need to re type his name again
            if(!$request -> session() -> has('commenter_name'))
                session(["commenter_name"=> $comment -> name]);
            if($comment instanceof Comment)
                return Comment::where('id',$comment->id)->with('user')->get();
            else
                return CommentReply::where('id',$comment->id)->get();
        }
        return false;
    }
    public function getComment($blog_id,$notification_id)
    {
        $notification = Notification::find($notification_id);
        $notification -> seen = 1;
        $notification -> save();
        return Comment::with('reply')->with('user')->where('blog_id',$blog_id)->orderBy('id','DESC')->get();
    }
}
