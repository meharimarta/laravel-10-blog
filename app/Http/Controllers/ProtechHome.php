<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use App\Models\User_subscriber;
use App\Models\Category;
use App\Models\UserInfo;
use App\Models\Subscriber;
use Mail;
use App\Mail\Newvisitor;
class ProtechHome extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search'))
        {
            $search = $request->input('search');
            $blogs = blog::where('published',1)
                ->where('title','like','%'.$search.'%')
                ->orWhere('post','like','%'.$search.'%')
                ->with('user')->orderBy('id','DESC')
                ->paginate(12);
        }else {
            $blogs = Blog::where('published',1)->with('user')->orderBy('id','DESC')->paginate(12);   
        }
        
        $catagories = Category::where('user_id',1)->get();
        
        if($request->ajax())
        {
            return response()->json($blog);
        }
        return view('home')
            ->with('blogs',$blogs)
            ->with('catagories',$catagories)
            ->with('social_links',$this -> userSocialLink());
    }
    //just returns the view
    public function becomeMember()
    {
           return view('page.member'); 
    }
    private function userSocialLink($id = 1)
    {
        $ui = UserInfo::where('user_id',$id)->get();
        if(count($ui) && $ui[0]->social_link_available)
            return $ui;
        return false;
    }
    
    
    public function getCatagoryPosts(Request $request)
    {
        $catagories = Catagory::all();
        $current_catagory = Catagory::where('id',$request->input('id'))->get();
        return view('home')
            ->with('blogs',blog::where('catagory_id',$request ->input('id'))->paginate(12))
            ->with('catagories',$catagories)
            ->with('current_catagory',$current_catagory[0]->catagory)
            ->with('social_links',$this->userSocialLink());
    }
    
    
    public function userPost($user,blog $blog,Request $request)
    {
        $user = User::with('userInfo')->select('id','profile_picture','name','banned')
            ->where('name',$user)
            ->get()
            ->makeVisible('id');
        if($user[0]->banned)
            return view('banned');
        //catagory id
        $id = $request->input('id');
        //search query
        $search = $request->input('search');
        //posts
        $posts = blog::with('user')
            ->where('user_id',$user[0]['id'])
            ->when($id,function($query,$id){
                $query->where('catagory_id',$id);
            })
            ->when($search,function($query,$search){
                $query->where('title','like','%'.$search.'%')->orWhere('post','like','%'.$search.'%');
            })
            ->paginate(12);
        if($id!=null)
        { 
            //currently requested catagory
            $current_catagory = Catagory::where('id',$request->input('id'))->get();
        } else {
            $current_catagory = false;
        }
        //if we dont find the users by its name redirect to home page
        if(!count($user)) return redirect('/');
        //get only the users catagory
        $catagories = Catagory::where('user_id',$user[0] -> id) -> orWhere('user_id',1) -> get();
        return view('home') -> with('blogs',$posts) -> with('user',$user)
            ->with('catagories',$catagories)
            ->with('current_catagory',($current_catagory) ? $current_catagory[0]->catagory : '')
            ->with('social_links',$this->userSocialLink($user[0]['id']));
    }
    
    
    public function read($id,Request $request,Response $response)
    {
        if(!Cookie::has("visited_post_".$id))
        {
            $blog = blog::find($id);
            if(!Auth::check() || $blog->user_id != Auth()->user()->id)
            {
                $blog -> views++;    
                $blog -> save();
                Cookie::queue("visited_post_".$id,"visited",0);
            }
        }
        
        $blog = blog::with('user')->where('id',$id)->get();
        //no post redirect to home page
        if(!count($blog)) return redirect('/');
        $user_id = $blog[0]->user_id;
        $recent_posts = blog::with('user')->where('published',1)->where('user_id',$user_id)->orderBy('id','DESC')->limit(5)->get();
        $comments = Comment::with('reply') -> with('user') -> where('blog_id', $blog[0]->id) -> get();
        return view('blog.readBlog') -> with('blog',$blog) 
                ->with('comments',$comments)
                ->with('recent_posts',$recent_posts);
    }
    
    public function like($id)
    {
        if(!Cookie::has("liked_post_".$id))
        {
            $blog = blog::find($id);
            $blog -> likes++;
            $blog -> save();
            Cookie::queue("liked_post_".$id,"liked",0);
            return $blog -> likes;   
        }
        return false;
    }
    public function subscribe(Request $request)
    {
        if(!$request->has('user_name'))
        {
            $request -> validate([
                'email' => 'email|required|unique:Subscribers'
            ]);
            //subscriber for entire application
             $subscriber = new Subscriber;
        }else{
            $request -> validate([
                'email' => 'email|required|unique:User_subscribers'
            ]);
            
            //subscriber for spscific user
            $subscriber = new User_subscriber;
            $user_id = User::where('name',$request->input('user_name'))->get('id')->makeVisible('id')[0]->id;
            $subscriber -> user_id =$user_id;
        }
        $email = $request -> input('email');
        $subscriber -> email = $email;
        $subscriber -> save();
        return true;
    }
    //reads trsdhed post or soft deleted posts
    public function readTrash($id)
    {
        $comments = Comment::with('reply') -> with('user') -> where('blog_id', $id) -> get();
        $post = blog::with('user') -> where('id',$id) -> onlyTrashed() -> get();
        //no post redirect to home page
        if(!count($post)) return redirect('/');
        return view('blog.readBlog')
                ->with('blog',$post)
                ->with('comments',$comments);
    }
}
