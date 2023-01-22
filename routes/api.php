<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\AuthenticationController;

// Posts
Route::get('/posts', [PostsController::class, 'index']);
Route::get('/posts/{id}', [PostsController::class, 'show']);


Route::middleware(['auth:sanctum'])->group(function (){
	// Account
	Route::get('/me',  [AuthenticationController::class, 'me']);
	Route::delete('/logout', [AuthenticationController::class, 'logout']);
	// Posts
	Route::post('/posts', [PostsController::class, 'store']);
	Route::patch('/posts/{id}', [PostsController::class, 'update'])->middleware('PemilikPostingan');
	Route::delete('/posts/{id}', [PostsController::class, 'destroy'])->middleware('PemilikPostingan');
});

Route::post('/login', [AuthenticationController::class, 'login']);