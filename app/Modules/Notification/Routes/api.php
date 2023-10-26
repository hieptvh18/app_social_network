<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Notification\Http\Controllers\NotificationController;
use Modules\Notification\Http\Controllers\Admin\DeviceTokenAdminController;

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

Route::group(
    ['prefix' => 'v1'],
    function () {
        Route::controller(NotificationController::class)->group(function () {
            Route::post('save-token', 'saveToken')->name('notification.public.saveToken');
            Route::post('push-notification', 'pushNotification')->name('notification.public.send');
        });
    }
);

