<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['prefix' => 'users', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'create']);
    Route::put('/', [UserController::class, 'update']);
    Route::delete('/', [UserController::class, 'delete']);
});

Route::group(['prefix' => 'posts', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [PostController::class, 'index']);
    Route::post('/', [PostController::class, 'create']);
    Route::post('/{post_id}', [PostController::class, 'createPostLike']);
    Route::put('/{post_id}', [PostController::class, 'update']);
    Route::delete('/{post_id}', [PostController::class, 'delete']);
});

Route::group(['prefix' => 'comments', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [CommentController::class, 'index']);
    Route::post('/', [CommentController::class, 'create']);
    Route::post('/{comment_id}', [CommentController::class, 'createCommentLike']);
    Route::put('/{comment_id}', [CommentController::class, 'update']);
    Route::delete('/{comment_id}', [CommentController::class, 'delete']);
});
