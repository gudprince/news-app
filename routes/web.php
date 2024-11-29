<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('article/create', [ArticleController::class, 'create']);
