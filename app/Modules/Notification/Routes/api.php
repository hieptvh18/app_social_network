<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/notification', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix'=>'v1',
    'name'=>'notification'
],function(){
    Route::group([
        'middleware'=>'auth:sanctum'
    ],function(){


        
    });
});