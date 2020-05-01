<?php

namespace App\Http\Controllers;

use App\User;
use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('checkrole');  //custom
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::id();
        $users = User::where('id', '!=', $user_id)->get();
        return view('home', compact('users'));
    }
    function contactmessages()
    {
        $contacts = Contact::all();
        return view('contact.index', compact('contacts'));
    }
    function contactuploaddownload($file_name)
    {
        return Storage::download('contact_uploads/'.$file_name);
    }
}
