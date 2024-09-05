<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\Api\AuthenticationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api')->name('get_user');

Route::middleware('auth:api')->group( function () {
    Route::get('workers', WorkerController::class);
})->name('workers');

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('register', [AuthenticationController::class, 'register'])->name('register');

    Route::group(['middleware' => 'auth:api'], function() {
      Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
      Route::get('user', [AuthenticationController::class, 'user'])->name('user');
    });
});