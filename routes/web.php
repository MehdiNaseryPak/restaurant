<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SliderController;

Route::get('/', function () {
    dd('as;dfk');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('sliders')->name('sliders.')->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('index');
        Route::get('/create', [SliderController::class, 'create'])->name('create');
        Route::post('/store', [SliderController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [SliderController::class, 'update'])->name('update');
    });
});
