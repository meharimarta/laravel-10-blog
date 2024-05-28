<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\blog;
use App\User;
use App\User_subscriber;
use App\Catagory;
use App\Comment;
use App\Subscriber;
use App\Notifications\NewPostAvailable;

class blogActionController extends Controller
{
    private $user;
    public function __construct()
    {
        $this -> middleware(function($request,$next){
            $this -> user = Auth::user();
            return $next($request);
        });
    }
    public function create(Request $request,User $user)
    {
        //validate the datas 
        $request -> validate ([
            'title' => 'required|max:100',
            'post' => 'required|min:300',
            'catagory_id' => 'required|Numeric',
            'img' => 'url|nullable'
        ]);
        if($request->input('status') == 'publish')
        {
            $request->validate([
               'img'=>'required'
            ]);
            
        }
//        $id = $request->input('id');
        //if we already have the blog id in the session wecan emsure that
        //the blog already created then we can modify the created blog
        //other wise create new blog
        if(session()->has('blogId') && blog::find(session('blogId')) != '')
        {
            $blog = blog::find(session('blogId'));
        } else {
            $blog = new blog;
        }
        $user_id = $this->user->id;
        $blog-> title = clean($request->input('title'));
        $blog-> post = clean($request->input('post'));
        //am checking here if the real url is the same with the session cover_url
        //if it is the same i dont need to process the url to retrive the cover image just save session cover_relative value
        //else extract the image relative path from the real
        //deferent urll will be available in the request if the user decided to use images from previos cover images
        $req_img = $request -> input('img');
        if(session()->has('cover_relative') && $req_img == session()-> get('cover_url'))
        {    
            $blog -> image = session()->get('cover_relative');
        }elseif(preg_match('/^https?:\/\/(www\.)?protecheth\./',$req_img)){
            //else extract only the image path which willbe peceded by user id then blog id to insert into the database
            //get substring staring from covers word 
            $image = substr($req_img,strpos($req_img,'covers'));
            //get substr starting from $user_id
            $image = substr($image,strpos($image,"$user_id"));
            //save to database
            $blog -> image = $image;
        }elseif(preg_match('/^https?:\/\/(www\.)?(.*)(\.jpg|\.png|\.jpeg|\.bmp|\.svg)$/',$req_img)){
            $blog -> image = $req_img;
        }else{
            if($request->input('status') == 'publish')
                return response()->make('Invalid url',422);
        }
        $blog-> published = ($request->input('status')=='save') ? 0 : 1;
        $blog-> catagory_id = $request -> input('catagory_id');
        $blog-> user_id = $this->user->id;
        $blog-> save();
        //if the post is published send notification
        if($blog-> published == 1 && !session()->has('editing'))
        {
            //if the user is not admin send the notification to thair subscribers 
            if($user_id !== 1) 
            {
                $subscribers = User_subscriber::where('user_id',$user_id)->get();
            }else {
                $subscribers = Subscriber::all();
            }
            //Send notification to all subscribers
            foreach($subscribers as $sbscriber)
            {
                $sbscriber -> notify(new NewPostAvailable($blog,$this->user));
            }   
        }
        //after careating or updaating store the blog id in the session
        //variablee
        session(['blogId'=>$blog->id,'editing'=>true]);
        return $blog -> id;
    }
    public function delete($id)
    {
        $blog = blog::find($id);
        $blog -> published = 0;
        $blog -> save();
        if($blog -> delete())
            return true;
        return false;
    }
    //restore soft deleted post
    public function restore($id) 
    {
        $blog = blog::withTrashed()->find($id);
        if($blog->title == "" || strlen($blog->post)<300)
            return false;
        if($blog->restore())
            return true;
        return false;
    }
    //delete  post permanently
    public function permanentDelete($id)
    {
        $blog = blog::onlyTrashed()->with('comment')->where('id',$id);
        if($blog-> forceDelete())
            return true;
        return false;
    }
    //private function get all catagories
    private function getCatagories(Request $request)
    {
        return Catagory::whereIn('user_id',[1,$request->user()->id])->get();
    }
    //edit posts
    public function edit($id,blog $blog,Request $request)
    {
        $blog = $blog->where('id',$id)->get();
        $catagories = $this->getCatagories($request);
        //sest the session varaiable of the blog id to update
        session(['blogId'=>$blog[0]['id'],'editing'=>true]);
        //post images
        $post_images = Storage::disk('web_asset')->allFiles('postimgs/'. $this->user->id);
        for($i=0; $i<count($post_images); $i++)
        {
            $post_images[$i] = asset('storage/'.$post_images[$i]);
        }
        return view('blog.createBlog')->with('blog',$blog)->with('catagorys',$catagories)->with('post_images',$post_images);
    }
    //edit trshed posts
    public function trashedit($id,blog $blog,Request $request)
    {
        $post_images = Storage::disk('web_asset')->allFiles('postimgs/'. $this->user->id);
        for($i=0; $i<count($post_images); $i++)
        {
            $post_images[$i] = asset('storage/'.$post_images[$i]);
        }
        $blog = $blog->where('id',$id)->onlyTrashed()->get();
        $catagories = $this->getCatagories($request);
        //sest the session varaiable of the blog id to update
        session(['blogId'=>$blog[0]['id'],'editing'=>true]);
        return view('blog.createBlog')->with('blog',$blog)->with('catagorys',$catagories)->with('post_images',$post_images);
    }
    public function update($id)
    {

    }
    public function uploadBLogImg(Request $request)
    {
        //first check wheter the blog already exists in the
        //database
        //if it exists get it and update
        //else create new record with user id and continue to update
        if(session()->has('blogId') && blog::find(session('blogId'))!='')
           {
             $blog = blog::find(session('blogId'));   
           }else {
            $blog = new blog;
            $blog->user_id = $request -> user() -> id;
            $blog -> catagory_id = $request -> input('catagory_id');
            $blog->save();
           }
        $id = $blog->id;
        session(['blogId'=>$blog->id]);
        if($request->hasFile('coverimg'))
        {
            $request->validate([
               'coverimg' => 'image' 
            ]);
            $user_id = $this -> user->id;
            //before saveing any thing t
            $path = $request->coverimg->store('/covers/'. $user_id . '/' .$id,'web_asset');
            $blog->image = $relative_path = substr($path,strpos($path,"$user_id"));
            $blog->save();
            //the user upladed the cover image relative path and absolute url insession 
            //which will be used in $this -> create() function
            session(['cover_relative'=>$relative_path,'cover_url'=>asset('storage/'.$path)]);
            //return absolute url
            return ['image'=>asset('storage/'.$path),session('blogId')];
        }
        if($request->hasFile('postimg'))
        {
            $request->validate([
               'postimg' => 'image' 
            ]);
            $path = $request->postimg->store('/postimgs/'. $this->user->id. '/' .$id,'web_asset');
            return asset('storage/'.$path);
        }
        return 'please upload';
    }
    public function getUserPostAlbum()
    {
        $user_id = $this->user->id;
        //get all user uploaded images from dtorage the directory is associated with user id
        $cover_images = Storage::disk('web_asset')->allFiles("covers/$user_id");
        //iterate over the relative path and generate absolute urls for all images
        for($i = 0; $i<count($cover_images); $i++)
        {
            $cover_images[$i] = asset('storage/'.$cover_images[$i]);
        }
        $post_images = Storage::disk('web_asset')->allFiles("postimgs/$user_id");
        for($i = 0; $i<count($post_images); $i++)
        {
            $post_images[$i] = asset('storage/'.$post_images[$i]);
        }
        $images = array("cover_images" => $cover_images, "post_images" => $post_images);
        return response() -> json($images);
    }
}
