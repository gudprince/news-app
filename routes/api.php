<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;

Route::apiResource('v1/articles', ArticleController::class);
Route::get('v1/categories', [CategoryController::class, 'index']);


