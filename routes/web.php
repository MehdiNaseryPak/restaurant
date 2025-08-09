<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dd('as;dfk');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('slider')->name('slider.')->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('index');
        
    });
});
