<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// api authen account
Route::prefix('v1')->group(function(){
    Route::post('accounts/register',[AuthController::class,'registerPost'])->middleware('guest');
    Route::post('accounts/login',[AuthController::class,'loginUsername'])->middleware('guest');

    Route::get('/user',[AuthController::class,'getUser'])->middleware('auth:sanctum');
});
