<?php

use Illuminate\Http\Request;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\V1\Admin\SliderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->name('v1.')->group(function(){

    // Auth
    Route::prefix('auth')->name('auth.')->group(function(){
        Route::post('login_register' , [AuthController::class,'login_register'])->name('login_register');
        Route::post('verify_code' , [AuthController::class,'verify_code'])->name('verify_code');
    });

    // Admin
    Route::prefix('admin')->name('admin.')->middleware(['auth:sanctum',IsAdmin::class])->group(function(){

        // Sliders
        Route::prefix('slider')->name('slider.')->group(function(){
            Route::get('/list',[SliderController::class,'list'])->name('list');
            Route::get('/show/{id}',[SliderController::class, 'show'])->name('show');
            Route::post('/create',[SliderController::class,'create'])->name('create');
            Route::put('/update/{id}',[SliderController::class,'update'])->name('update');
            Route::delete('/delete/{id}',[SliderController::class,'delete'])->name('delete');
        });

    });
});
