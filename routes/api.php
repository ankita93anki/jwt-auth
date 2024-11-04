<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('v1/posts', [PostController::class, 'index']);

Route::get('v1/posts/{post}', [PostController::class, 'show']);

Route::post('v1/posts', [PostController::class, 'store']);

Route::put('v1/posts/{post}', [PostController::class, 'update']);

Route::delete('v1/posts/{post}', [PostController::class, 'destroy']);

Route::group(['prefix' => 'auth'], function($router) {
    Route::post('login', [AuthController::class,'login']);
    Route::post('register', [AuthController::class,'register']);

});

Route::middleware(['auth' => 'api'])->group(function() {
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);
    Route::post('logout', [AuthController::class,'logout']);
});