<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\LogController;
use App\Http\Controllers\Api\Master\ProductController;
use App\Http\Controllers\Api\Master\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\Transaction\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware('api')->group(function(){
    Route::controller(AuthController::class)->prefix('auth')->group(function(){
        Route::post('register', 'save');
        Route::post('login', 'auth');
    });

    Route::get('/roles', [RoleController::class, 'all']);
});

Route::middleware(['api', 'auth:sanctum'])->group(function(){
    Route::controller(AuthController::class)->group(function(){
        Route::any('logout', 'logout');
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/profile', [ProfileController::class, 'getProfile']);

    Route::middleware('role:manager')->group(function(){
        Route::resource('product', ProductController::class);

        Route::patch('/product/{product}/stock', [ProductController::class, 'updateStock']);
    });

    Route::middleware('role:admin')->group(function(){
        Route::patch('/give-role/{user}', [UserController::class, 'giveRole']);

        Route::get('/activity-log', [LogController::class, 'all']);
    });

    Route::middleware('role:cashier')->group(function(){
        Route::resource('product', ProductController::class)->only('show', 'index');
        Route::post('/place-order', [OrderController::class, 'placeOrder']);
        Route::post('/pay/{order}', [OrderController::class, 'pay']);
    });
});


