<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::get('/categories', function () {
    return view('categories');
});Route::get('/mobiles/phone_x_64', function () {
    return view('product');
});



Route::get('/admin', AdminController::class)->name('admin');
