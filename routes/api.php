<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\AuthenticationController;

// Posts
Route::get('/posts', [PostsController::class, 'index'])->middleware('auth:sanctum');;
Route::get('/posts/{id}', [PostsController::class, 'show'])->middleware('auth:sanctum');

// Authentication
Route::post('/login', [AuthenticationController::class, 'login']);
Route::delete('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

// Account

Route::get('/me',  [AuthenticationController::class, 'me'])->middleware('auth:sanctum');