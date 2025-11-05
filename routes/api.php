<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Attribute\VariantController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Attribute\AttributeController;
use App\Http\Controllers\Category\SubCategoryController;
use App\Http\Controllers\Product\Admin\productController;
use App\Http\Controllers\Category\SubSubCategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Admin Routes
Route::group(['prefix'=>'admin','middleware'=>'auth:sanctum'], function(){

    //Admin Routes
    Route::post('/admin-create',[AdminController::class,'store']);
    Route::put('/admin-update/{admin}',[AdminController::class,'update']);
    Route::put('/resetPassword/{admin}',[AdminController::class,'resetPassword']);
    Route::put('/toggleStatus/{admin}',[AdminController::class,'toggleStatus']);

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

    //AttributeRoutes
    Route::post('/attribute/store',[AttributeController::class,'storeAttribute']);
    Route::get('/attribute/index',[AttributeController::class,'index']);
    Route::get('/attribute/show/{attribute}',[AttributeController::class,'show']);
    Route::get('/attribute/toggle-status/{attribute}',[AttributeController::class,'toggleStatus']);
    Route::delete('/attribute/delete/{attribute}',[AttributeController::class,'destroy']);
    //Variant Routes
    Route::post('/variant/store',[VariantController::class,'storeVariant']);
    Route::get('/variant/index',[VariantController::class,'index']);
    Route::get('/variant/toggle-status/{variant}',[VariantController::class,'toggleStatus']);
    Route::delete('/variant/delete/{variant}',[VariantController::class,'destroy']);

    Route::group(['prefix'=>'product'], function(){
        Route::post('/store',[productController::class,'store']);
        Route::put('/update/{product}',[productController::class,'update']);
        Route::get('/index',[productController::class,'index']);
        Route::get('/change-status/{product}',[productController::class,'toggleStatus']);
    });

});