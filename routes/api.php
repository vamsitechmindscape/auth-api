<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use GuzzleHttp\Middleware;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/post',function(){
    return "Api";
});
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('posts', PostController::class);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
