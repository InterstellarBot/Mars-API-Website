<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:web'])->group(function () {
    Route::get('/', function () {
        return redirect("https://github.com/InterstellarBot/Mars-API-Website#readme");
    });
});
