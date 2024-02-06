<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\MaterialCategoryController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\MaterialDistributionController;
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

Route::controller(AuthController::class)->group(function(){
    Route::post('/auth/register', 'register');
    Route::post('/auth/login', 'login');
});

Route::middleware('auth:sanctum')->group(function() {
    Route::controller(MaterialController::class)->group(function(){
        Route::post('/material/create', 'create')->name('api.material.create');
        Route::get('/material/list', 'list')->name('api.material.list');
        Route::put('/material/update', 'update')->name('api.material.update');
        Route::delete('/material/delete', 'delete')->name('api.material.delete');
    });

    Route::controller(MaterialDistributionController::class)->group(function(){
        Route::post('/material-distribution/create', 'create')->name('api.material-distribution.create');
        Route::get('/material-distribution/list', 'list')->name('api.material-distribution.list');
        Route::put('/material-distribution/update', 'update')->name('api.material-distribution.update');
        Route::delete('/material-distribution/delete', 'delete')->name('api.material-distribution.delete');
    });

    Route::controller(MaterialCategoryController::class)->group(function(){
        //Route::post('/material-category/create', 'create')->name('api.material-category.create');
        Route::get('/material-category/list', 'list')->name('api.material-category.list');
        //Route::put('/material-category/update', 'update')->name('api.material-category.update');
        //Route::delete('/material-category/delete', 'delete')->name('api.material-category.delete');
    });

    Route::controller(EquipmentController::class)->group(function(){
        Route::post('/equipment/create', 'create')->name('api.equipment.create');
        Route::get('/equipment/list', 'list')->name('api.equipment.list');
        Route::put('/equipment/update', 'update')->name('api.equipment.update');
        Route::delete('/equipment/delete', 'delete')->name('api.equipment.delete');
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
