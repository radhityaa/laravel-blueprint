<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('stores', App\Http\Controllers\StoreController::class)->except('destroy');
