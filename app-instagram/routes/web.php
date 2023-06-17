<?php

use Illuminate\Support\Facades\Route;

// route any

Route::get('/{any}', function () {
  return view('layouts.app');
})->where('any', '.*');
