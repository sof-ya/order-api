<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\PartnershipController;
// use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderTypeController;

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\OrderController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api')->name('get_user');

Route::middleware('auth:api')->group( function () {
    Route::get('workers', WorkerController::class);
})->name('workers');

Route::middleware('auth:api')->group( function () {
    Route::get('partnerships', PartnershipController::class);
})->name('partnerships');


Route::middleware('auth:api')->group( function () {
    Route::get('order_types', OrderTypeController::class);
})->name('order_types');

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('register', [AuthenticationController::class, 'register'])->name('register');

    Route::group(['middleware' => 'auth:api'], function() {
      Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
      Route::get('user', [AuthenticationController::class, 'user'])->name('user');
    });
});

Route::apiResource('/orders', OrderController::class)->middleware('auth:api');