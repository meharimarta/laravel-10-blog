<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\UserInfo;
use App\User;
use Mail;
use App\Mail\ConfirmYourEmailProtecheth;
use Illuminate\Support\Facades\Storage;

//use Illuminate\Eloquent\ModelNotFoundExecption;
class UserInfoEditor extends Controller
{
    private $res_info = array();
    private $user;
    public function __construct() 
    {
        $this -> middleware(function($request,$next){
            $this -> user = User::find(Auth::user() -> id);
            return $next($request);
        });
    }
    //handle change email
    private function changeEmail($email)
    {
        Mail::to($email)->send(new ConfirmYourEmailProtecheth);
    }
    //Update ser info on user model and user info table
    public function UpadateUserInfo(Request $request)
    {
        $user_password = $this -> user -> password;
        if(HASH::check($request -> input('oldPassword'),$user_password))
        {
            if($this->user->name != $request->input('name'))
            {
                $vaild = $request->validate([
                    'name'=>'unique:users|required|min:3|max:20'
                ]);
                $change_page = User::find($this->user->id);
                $change_page -> name = $valid['name'];
                $change_page->save();
            }
            if($request -> has('changePwd'))
            {
                $request -> validate([
                    'newPassword' => 'required|min:8',
                    'confNewPassword' => 'required|min:8'
                ]);
                if($request -> input('newPassword') === $request -> input('confNewPassword'))
                {
                    $new_password = HASH::make($request -> input('newPassword'));
                    $this -> user -> password = $new_password;
                    if($this -> user -> save()) $this -> res_info['pswd'] = 'Your password has been changed!';
                } else {
                    $this -> res_info['confirmerr'] = 'Confirmation password is not match';
                }
            }
            if($request -> has('changeEmail'))
            {
                $valid = $request -> validate([
                    'email' => 'required|email'
                ]);
                $this->changeEmail($valid['email']);
                $this -> res_info ['emailChange'] = "we have sent verification email to your new email";
            }
            //if first and last name is changed
            if($request -> has('firstLastNameDirty'))
            {
                $valid = $request -> validate([
                    'firstName' => "required|min:4|max:20",
                    'lastName' => "required|min:4|max:20"
                ]);
                $this -> user -> firstName = $valid['firstName'];
                $this -> user -> lastName = $valid['lastName'];
                if($this -> user -> save()) $this -> res_info['name'] = 'Your name has changed';
            }
            //if userinfo changed
            if($request -> has('userInfoDirty'))
            {
                $ui = $this -> UserInfoExists($request);
                $valid = $request -> validate([
                    'skill' => 'required:min:3|max:100',
                    'about' => 'required:min:3|max:500'
                ]);
                //if we dont have user info with the assicated id we will create new 
                //user info insatance or use already avilable to updatethe datas
                if(!$ui) $ui = new UserInfo;
                $ui -> skill = $valid['skill'];
                $ui -> about = $valid['about'];
                $ui -> user_id = $this -> user ->id;
                if($ui -> save()) $this -> res_info['additionalinfo'] = "You additional info has been changed";
            }
            if($request -> has('slinks'))
            {
                $ui = $this -> UserInfoExists($request);
                if(!$ui) $ui = new UserInfo;
                $request -> validate([
                    'sfb' => 'url|nullable',
                    'stg' => 'url|nullable',
                    'syb' => 'url|nullable',
                    'stwt' => 'url|nullable'
                ]);
                $ui -> user_id = $this -> user ->id;
                $ui -> fb = $request -> input('sfb');
                $ui -> yb = $request -> input('syb');
                $ui -> tg = $request -> input('stg');
                $ui -> twt = $request -> input('stwt');
                $ui -> save();
                $this -> res_info['social_link'] = "your social link has been updated!";
            }
        }else{
            $this -> res_info['incorrectpwd'] = "incorrect password";            
        }
        $json = response() -> json($this -> res_info);
        $this -> res_info = array();
        return $json;
    }
    
    //Check the user Info is availabele
    private function UserInfoExists(Request $request)
    {
        //check if the user info exists
        $user = UserInfo::where('user_id',$request->user()->id)->count();
        //if exists get the instance else retun false
        if($user) return UserInfo::where('user_id',$request->user()->id)->first();
        return false;
    }
    
    //handles profile picture to upload for the user
    public function UploadProfilePicture(Request $request)
    {
        if($request->has('img'))
        {   
            $request->validate([
                'img'=>'image'
            ]);
            if($request->input('type') == 'profile')
            {
                $path = $request->img->store('/profiles/'.$this -> user ->id,'web_asset');
                $this -> user -> profile_picture = 'storage/'.$path;
                $this -> user -> save();
                return asset('storage/'.$path);   
            }
            if($request->input('type') == 'cover')
            {
                $path = $request->img->store('/profiles/cover/'.$this -> user ->id,'web_asset');
                $ui = $this->UserInfoExists($request);
                if(!$ui) $ui = new UserInfo;
                
                $ui -> cover_image = 'storage/'.$path;
                $ui -> user_id = $this->user->id;
                $ui -> save();
                return asset('storage/'.$path);  
            }
        }
        return "cannot upload your profile picture";
    }
}
