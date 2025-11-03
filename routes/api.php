<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\SubCategoryController;
use App\Http\Controllers\Category\SubSubCategoryController;

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
        Route::get('/index',[CategoryController::class,'index']);
        Route::post('/store',[CategoryController::class,'store']);
        Route::put('/update/{category}',[CategoryController::class,'update']);
        Route::delete('/delete/{category}',[CategoryController::class,'destroy']);
    });
    //sub-category routes
    Route::group(['prefix'=>'sub-category'], function(){
        Route::get('/index',[SubCategoryController::class,'index']);
        Route::post('/store',[SubCategoryController::class,'store']);
        Route::put('/update/{subCategory}',[SubCategoryController::class,'update']);
        Route::delete('/delete/{subCategory}',[SubCategoryController::class,'destroy']);
    });

    //sub-sub-category routes
    Route::group(['prefix'=>'sub-sub-category'], function(){
        Route::get('/index',[SubSubCategoryController::class,'index']);
        Route::post('/store',[SubSubCategoryController::class,'store']);
        Route::put('/update/{subsubCategory}',[SubSubCategoryController::class,'update']);
        Route::delete('/delete/{subsubCategory}',[SubSubCategoryController::class,'destroy']);
        Route::post('/apply-discount/{subsubCategory}',[SubSubCategoryController::class,'applyDiscount']);
        Route::post('/toggle-status/{subsubCategory}',[SubSubCategoryController::class,'toggleStatus']);
    });

});