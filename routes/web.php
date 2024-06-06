<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index']);
Route::get('/categories', [MainController::class, 'categories']);
Route::get('/{category}', [MainController::class, 'category']);

Route::get('/mobiles/{product?}', [MainController::class, 'product']);




Route::get('/admin', AdminController::class)->name('admin');
