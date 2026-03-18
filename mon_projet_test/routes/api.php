<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;

Route::apiResource('/categories', CategoriesController::class);
Route::apiResource('/comments', CommentsController::class);
Route::apiResource('/posts', PostsController::class);
Route::apiResource('/users', UsersController::class);
