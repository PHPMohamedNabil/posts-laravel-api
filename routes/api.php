<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StateController;


//auth routes

Route::post('/register',[App\Http\Controllers\UserController::class,'register'])->name('register');
Route::post('/login',[App\Http\Controllers\UserController::class,'login']);
Route::post('/logout',[App\Http\Controllers\UserController::class,'logout'])->middleware('auth:sanctum');
Route::post('/verify-code', [UserController::class, 'VerifyUserCode']);

//user posts operations

Route::post('/restore/post/{id}',[App\Http\Controllers\PostController::class,'restore'])->middleware('auth:sanctum');

Route::get('/deleted/posts/',[App\Http\Controllers\PostController::class,'trashed'])->middleware('auth:sanctum');

//state route
Route::get('/state', App\Http\Controllers\StateController::class);

Route::apiResources([
    'tags'  => TagController::class,
    'posts' => PostController::class,
]);


