<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController\HomePage;
use App\Http\Controllers\PagesController\Profile;
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

Route::get('/', [HomePage::class,'index'])->name('page.home');
Route::get('/profile', [Profile::class,'index'])->name('page.profile');
Route::get('/my-profile/{username}', [Profile::class,'edit'])->name('page.edit-profile');
