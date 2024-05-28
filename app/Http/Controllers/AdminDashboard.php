<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\blog;
use App\User;
use App\Catagory;
use App\Notification;
use Mail;
use App\Mail\NewUserMailer;
class AdminDashboard extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $published  = blog::where('user_id',$user_id)->count();
        $total_blogs = blog::where('user_id',$user_id)->withTrashed()->count();
        $catagories = Catagory::where('user_id',$user_id)->count();
        $drafts = blog::where('user_id',$user_id)->where('published',0)->count();
        $data = array('published'=>$published,'total_blogs'=>$total_blogs,'catagories'=>$catagories,'drafts'=>$drafts);
        return view('dashboard.dashBoard')->with('data',$data);
    }
    //get 6 users per page
    public function members()
    {
        $response = Gate::authorize('member-approve');
        if(!$response->allowed()) return $response->message();
        return User::select('name','email','profile_picture')->orderBy('id','DESC')->paginate(6);
    }
    //get user
    public function user(Request $request)
    {
        return User::where('email',$request->input('email'))->get()->makeVisible('email');
    }
    //ban user
    public function ban(Request $request)
    {
        $response = Gate::authorize('member-approve');
        if(!$response->allowed()) return $response->message();
        $user = User::where('email',$request->input('email'))->first();
        if($user->banned == 1)
            $user->banned = 0;
        else
            $user->banned = 1;
        if($user->save()) return $user->banned;
        return false;
    }
    //delete user post
    public function deleteUserPost(Request $request)
    {
        $response = Gate::authorize('member-approve');
        if(!$response->allowed()) return $response->message();
        
        $user = User::where('email',$request->input('email'))->first();
        $posts = blog::where('user_id',$user->id)->get();
        foreach($posts as $post)
        {
            $post -> published = 0;
            $post->save();
            $post -> delete();
        }
        return true;
    }
    public function trashes(Request $request)
    {
        if($request->ajax())
            return blog::where('user_id',Auth::user()->id)->orderBy('id','DESC')->onlyTrashed()->paginate(10);
        return view('blog.allBlogs')->with('allBlogs',blog::where('user_id',Auth::user()->id)->orderBy('id','DESC')->onlyTrashed()->paginate(10));
    }
    public function allBlogs(Request $request)
    {
        if($request -> has('get') && $request->input('get')=='draft')
            $allBlogs = blog::where('user_id',Auth::user()->id)->where('published',0)->orderBy('id','DESC')->paginate(10);
        else
            $allBlogs = blog::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(10);
        
        if($request->ajax()) return $allBlogs;
        return view('blog.allBlogs')->with('allBlogs',$allBlogs);
    }
    public function editProfile(Request $request)
    {
        return view('dashboard.editProfile')->with('user',User::select('users.*','user_infos.*')
                                         ->leftjoin('user_infos','users.id','=','user_infos.user_id')
                                         ->where('users.id',$request->user()->id)
                                         ->get()->makeVisible("Email"));
    }
    public function catagories(Request $request)
    {
        return view('blog.catagories')->with('catagories',Catagory::whereIn('user_id',[1,$request->user()->id])->get());
    }
    public function addCatagory(Request $request)
    {
        $catagory = new Catagory;
        $catagory -> catagory = $request -> input('catagory');
        $catagory -> user_id = $request->user()->id; 
        if($catagory -> save())
            return $catagory -> id;
        return false;
    }
    public function deleteCatagory($id,Request $request)
    {
        $msg = array('status'=> 403);
        $catagory = Catagory::find($id);
        //if the user is the admin we allow to delete predefined catagories
        if($request->user()->id!=1) {
            if($catagory -> user_id == 1)
            return json_encode($msg);
        }
       
        if($catagory -> delete())
            return json_encode(array('status' => 200));
        return json_encode(array('status' => 'unkown error'));
    }
    public function createBlog(Request $request)
    {
//        before creating new blog remove pre existiing blog ids
        session()->forget(['blogId','editing']);
        return view('blog.createBlog')->with('catagorys',Catagory::whereIn('user_id',[1,$request->user()->id])->get());
    }
    public function notifications()
    {
        return view('dashboard.notification')
            ->with('notifications',
                   Notification::with('user:id,name,profile_picture')
                   ->with('post:id,title')
                   ->where('to_user_id',Auth::user()->id)
                   ->orderBy('id','DESC')
                   ->get()
                  );
    }
    public function searchMember(Request $request)
    {
        if(Gate::allows('member-approve'))
        {
            $query = clean($request->input('query'));
            return User::select('name','email')->where("name", "like" ,'%'.$query.'%')->orWhere('email','like','%'.$query.'%')->get()->makeVisible('email');   
        }
    }
    public function emailUser(Request $request)
    {
        $response = Gate::authorize('member-approve');
        if($response->allowed())
        {
            $request -> validate([
                'message' => 'required|min:5'
            ]);
            $message = clean($request->input('message'));
            if(!$request->has('toAll')) {
                $request -> validate([
                    'email' => 'required|email',
                ]);
                Mail::to($request->input('email'))->send(new NewUserMailer($message));
            }else{
                $users = User::all();
                foreach($users as $user)
                {
                    Mail::to($user->email)->send(new NewUserMailer($message));
                }
            }   
        }else {
            return $response->message();
        }
    }
}
