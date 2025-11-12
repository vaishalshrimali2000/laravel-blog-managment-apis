<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogLikeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class,'logout']);

    Route::post('/blogs',[BlogController::class,'store']);
    Route::get('/blogs',[BlogController::class,'index']);
    Route::get('/blogs/{blog}',[BlogController::class,'show']);
    Route::post('/blogs/{blog}',[BlogController::class,'update']);
    Route::delete('/blogs/{blog}',[BlogController::class,'destory']);

    Route::post('/blogs/{blog}/like-toggle',[BlogLikeController::class,'toggle']);
});