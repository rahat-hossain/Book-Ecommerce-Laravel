<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Http\Requests\PasswordValidation;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }
    function profile()
    {
        return view('profile.index');
    }
    function passwordchange(PasswordValidation $request)
    {
        $user_id = Auth::id();
        $from_database = User::find($user_id)->password;
        if(Hash::check($request->old_password, $from_database))
        {
            User::findOrFail($user_id)->update([
                'password' => Hash::make($request->new_password),
            ]);
            return back()->with('status', 'Password changed successfully!!');
        }
        else
        {
            echo "mile nai";
        }
    }
}
