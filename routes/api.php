<?php

use App\Http\Controllers\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->name('v1.')->group(function(){
    Route::prefix('auth')->name('auth.')->group(function(){
        Route::post('login_register' , [AuthController::class,'login_register'])->name('login_register');
        Route::post('verify_code' , [AuthController::class,'verify_code'])->name('verify_code');
    });

});
