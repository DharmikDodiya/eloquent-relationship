<?php

use App\Http\Controllers\OneToManyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(UserController::class)->prefix('one-to-one')->group(function(){
    Route::post('create','create');
    Route::get('list','list');
    Route::get('get/{id}','get');
    Route::put('update/{id}','update');
    Route::delete('delete/{id}','destory');
    Route::get('latest-phone/{id}','latestPhone');
});


Route::controller(OneToManyController::class)->prefix('one-to-many')->group(function(){
    Route::post('create','create');
    Route::get('list','list');
    Route::get('get/{id}','get');
    Route::put('update/{id}','update');
    Route::delete('delete/{id}','destory');
});

Route::controller(SupplierController::class)->prefix('supplier')->group(function(){
    Route::post('create','create');
    Route::get('list','list');
    Route::get('get/{id}','get');
    Route::put('update/{id}','update');
    Route::delete('delete/{id}','destory');
});

Route::controller(ProductController::class)->prefix('product')->group(function(){
    Route::post('create','create');
    Route::get('list','list');
    Route::get('get/{id}','get');
    Route::put('update/{id}','update');
    Route::delete('delete/{id}','destory');
});

Route::controller(OrderController::class)->prefix('order')->group(function(){
    Route::post('create','create');
    Route::get('list','list');
    Route::get('get/{id}','get');
    Route::put('update/{id}','update');
    Route::delete('delete/{id}','destory');
});

Route::controller(RegionController::class)->prefix('many-to-many')->group(function(){
    Route::post('create','create');
    Route::get('list','list');
    Route::get('get/{id}','get');
    Route::put('update/{id}','update');
    Route::delete('delete/{id}','destory');
});

Route::controller(StoresController::class)->prefix('many-to-many-stores')->group(function(){
    Route::post('create','create');
    Route::get('list','list');
    Route::get('get/{id}','get');
    Route::put('update/{id}','update');
    Route::delete('delete/{id}','destory');
});

