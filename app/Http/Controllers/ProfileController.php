<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function __contruct() {
        $this->middleware->Auth();
    }

    public function show_profile() {
        $user   = Auth::user();

        return view('show_profile', compact('user'));
    }

    public function edit_profile(Request $request) {
        $request->validate([
            'name'      => 'required',
            'password'  => 'required|min:8|confirmed'
        ]);

        // import User
        $user   = Auth::user();
        
        // function edit
        $user->update([
            'name'      => $request->name,
            'password'  => Hash::make($request->password)
        ]);

        return Redirect::back();
    }
}
