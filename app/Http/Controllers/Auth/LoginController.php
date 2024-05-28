<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function Login(Request $request) 
    {
        $request -> validate([
            'email' => 'required',
            'password' => 'required' 
        ]);
        
        $credentials = $request -> only('email','password');
        if(Auth::attempt($credentials)) 
        {
            if(!Gate::allows('banned')) 
            {
                Auth::logout();
            }
            if($request ->ajax()) 
            {
                $url = url('/dashboard');
                if(Auth::check())
                    return response()->json(array('url' => "$url"));
                else
                    return response()->make('sorry you can\'t access this page :-(',403);
//                json(array('message'=>'sorry you can\'t access this page :-('));
            }
        } else {
            return response()->json(["loginerr"=>true]);
        }
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
