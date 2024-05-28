<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contacts;
class ContactsController extends Controller
{
    public function contact()
    {
        return view('contact')->with('contact',Contacts::all());
    }
    public function store(Request $request)
    {
        $contact = new Contacts();
        $contact->name = $request->input('name');
        $contact->email = $request->input('email');
        $contact->phone = $request->input('phone');
        $contact->save();
        
        return redirect('/contacts');
    }
}
