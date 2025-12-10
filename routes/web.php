<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:web'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});
