<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\OrderTypeController;

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\WorkerController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api')->name('get_user');

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
Route::apiResource('/workers', WorkerController::class)->middleware('auth:api');

Route::middleware('auth:api')->prefix('workers')->group( function () {
    Route::post('{worker}/set_order', [WorkerController::class, 'setOrder'])->name('set_order');
    Route::post('{worker}/exclude_order_type', [WorkerController::class, 'excludeOrderType'])->name('exclude_order_type');
});