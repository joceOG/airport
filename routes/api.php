<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DeliveryController;
use App\Models\Post;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ads', [AdController::class, 'index']);
Route::post('/ads/search',[AdController::class, 'search']);
Route::prefix('/ad')->group(function() {
    Route::post('/store', [AdController::class, 'store']);
    Route::put('/{id}', [AdController::class, 'update']);
    Route::delete('/{id}', [AdController::class, 'destroy']);
});

Route::get('/packages', [PackageController::class, 'index']);
Route::prefix('/package')->group(function() {
    Route::post('/store', [PackageController::class, 'store']);
    Route::put('/{id}', [PackageController::class, 'update']);
    Route::delete('/{id}', [PackageController::class, 'destroy']);
});

Route::get('/orders', [OrderController::class, 'index']);
Route::prefix('/order')->group(function() {
    Route::post('/store', [OrderController::class, 'store']);
    Route::patch('/{id}', [OrderController::class, 'update']);
    Route::delete('/{id}', [OrderController::class, 'destroy']);
});

Route::get('/deliveries', [DeliveryController::class, 'index']);
Route::prefix('/delivery')->group(function() {
    Route::post('/store', [DeliveryController::class, 'store']);
    Route::post('/show', [DeliveryController::class, 'show']);
    Route::patch('/{id}', [DeliveryController::class, 'update']);
    Route::delete('/{id}', [DeliveryController::class, 'destroy']);
});

Route::get('/users', [UserController::class, 'index']);
Route::prefix('/user')->group(function() {
    Route::post('/store', [UserController::class, 'store']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/oneuser', [UserController::class, 'oneuser']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::patch('/validate/{id}', [UserController::class, 'validation']);
    Route::patch('/reset/{id}', [UserController::class, 'resetPassword']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});


Route::get('/posts', function() {
   return Post::all();
});

Route::post('/posts' , function () {
    return Post::create([
        'title' => request('title'),
        'content' => request('content'),
    ]);
});
