<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Category\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Admin Routes
Route::group(['prefix'=>'admin','middleware'=>'auth:sanctum'], function(){
    //category routes
    Route::group(['prefix'=>'category'], function(){
        Route::post('/store',[CategoryController::class,'store']);
        Route::get('/index',[CategoryController::class,'index']);
        Route::put('/update/{category}',[CategoryController::class,'update']);
        Route::delete('/delete/{category}',[CategoryController::class,'destroy']);
    });

});