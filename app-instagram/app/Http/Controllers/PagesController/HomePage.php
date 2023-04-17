<?php

namespace App\Http\Controllers\PagesController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomePage extends Controller
{
    // return view homepage
    public function index(){
        return view('pages.homepage');
    }
}
