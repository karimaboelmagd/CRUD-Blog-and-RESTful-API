<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});



Route::group(['middleware'=>['auth:sanctum']],function (){
    Route::get('/posts',[PostController::class,'Index']);
    Route::get('/posts/{id}',[PostController::class,'Show']);
    Route::post('/posts',[PostController::class,'Store']);
    Route::patch('/posts/{id}',[PostController::class,'Update']);
    Route::delete('/posts/{id}',[PostController::class,'Destroy']);
});



//Route::resource('posts',PostController::class);
//php artisan make:controller PostController --resource --model=Post



