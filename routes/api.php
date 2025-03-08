<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\ReportController;

// user auth routes
Route::post('/login', [UserController::class, 'Login']);
Route::post('/signup', [UserController::class, 'Signup']);
Route::put('/forgetpassword', [UserController::class, 'forgetpassword']);
Route::post('/otp', [UserController::class, 'otp']);
// User resource routes
Route::get('/users', [UserController::class, 'index']);
Route::post('/users/image/{id}', [UserController::class, 'UpdateUserFunction']);
Route::put('/users/security/{id}', [UserController::class, 'UpdatePassword']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'updateuser']);


// Post Routes
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/saved', [PostController::class, 'savedpost']);
Route::get('/posts/liked', [PostController::class, 'likedpost']);
Route::get('/posts/mine', [PostController::class, 'userPosts']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::post('/posts', [PostController::class, 'store']);
Route::put('/posts/{post}', [PostController::class, 'update']);
Route::delete('/posts/{post}', [PostController::class, 'destroy']);
// Like & Comment Routes
Route::post('/posts/{post}/like', [PostController::class, 'like']);
Route::post('/posts/{post}/comment', [PostController::class, 'comment']);
Route::post('/posts/{post}/save', [PostController::class, 'save']);


//folder routes
Route::prefix('folders')->group(function () {
    Route::get('/pdf/{id}', [FolderController::class, 'generatePdf']);
    Route::get('{id}', [FolderController::class, 'index']);
    Route::get('show/{id}', [FolderController::class, 'show']);
    Route::post('/', [FolderController::class, 'store']);
    Route::put('/{id}', [FolderController::class, 'update']);
    Route::delete('/{id}', [FolderController::class, 'destroy']);
});

//report routes
Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index']);
    Route::get('{id}', [ReportController::class, 'show']);
    Route::post('/', [ReportController::class, 'store']);
    Route::put('{id}', [ReportController::class, 'update']);
    Route::delete('{id}', [ReportController::class, 'destroy']);
});
