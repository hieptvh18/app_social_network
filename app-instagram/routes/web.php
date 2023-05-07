<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController\HomePage;
use App\Http\Controllers\PagesController\Profile;
use App\Http\Controllers\PagesController\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::middleware('auth')->prefix('/')->group(function () {
//     // homepage view
//     Route::get('/', [HomePage::class, 'index'])->name('page.home');

//     // profile view
//     Route::get('/profile', [Profile::class, 'index'])->name('page.profile');

//     // edit profile view
//     Route::get('/my-profile/{username}', [Profile::class, 'edit'])->name('page.edit-profile');
// });

// // auth page
// Route::middleware('guest')->prefix('/')->group(function () {
//     Route::get('/login', [Auth::class, 'login'])->name('login');
//     Route::get('/register', [Auth::class, 'register'])->name('register');
//     Route::post('/register', [Auth::class, 'registerPost'])->name('registerPost');
// });



Route::get('/{any}', function () {
  return view('layouts.app');
})->where('any', '.*');
