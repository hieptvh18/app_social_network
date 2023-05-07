<?php

namespace App\Http\Controllers\PagesController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Auth extends Controller
{
    // page login
    public function login(){
        return view('pages.auth.login');
    }

    // register page
    public function register(){
        return view('pages.auth.register');
    }

    // register post
    public function registerPost(Request $request){
        dd($request->all());
    }
}
