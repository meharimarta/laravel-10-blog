<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\blog;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with('blog',blog::select('blog.id','blog.Title','blog.Image','blog.created_at','users.name',)->
                                  join('users','users.id','=','blog.user_id')-get());
    }
}
