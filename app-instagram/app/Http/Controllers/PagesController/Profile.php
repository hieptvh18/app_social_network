<?php

namespace App\Http\Controllers\PagesController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Profile extends Controller
{
    // show view profile
    public function index(){
        return view('pages.profile');
    }

    // show view page edit profile
    public function edit(Request $request,$id){
        return view('pages.edit-profile');
    }
}
