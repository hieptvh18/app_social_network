<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;


// view admin
// Route::get('/admin/dashboard/', [AdminController::class,'dashboard']);

// route any
Route::get('/{any}', function () {
  return view('layouts.app');
})->where('any', '^(?!api.*$).*'); // match all route not start = api
