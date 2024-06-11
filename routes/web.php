<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::get('/logout', [LoginController::class, 'logout'])->name('get-logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/categories', [MainController::class, 'categories'])->name('categories');
Route::get('/basket', [BasketController::class, 'basket'])->name('basket');

//Route::get('/login', [AuthController::class, 'login'])->name('login');
//Route::get('/register', [AuthController::class, 'register'])->name('register');


Route::get('/{category}', [MainController::class, 'category'])->name('category');



Route::get('/basket/place', [BasketController::class, 'basketPlace'])->name('basket-place');
Route::post('/basket/add/{id}', [BasketController::class, 'basketAdd'])->name('basket-add');
Route::post('/basket/remove/{id}', [BasketController::class, 'basketRemove'])->name('basket-remove');

Route::get('/{category}/{product?}', [MainController::class, 'product'])->name('product');
Route::post('/basket/place', [BasketController::class, 'basketConfirm'])->name('basket-confirm');



Route::get('/admin', AdminController::class)->name('admin');


//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
