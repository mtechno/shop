<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::get('/logout', [LoginController::class, 'logout'])->name('get-logout');

Route::group([
    'middleware' => 'auth:sanctum',
    'namespace' => 'Admin',
], function () {
    Route::group([
        'middleware' => 'is_admin',
    ], function () {
        Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('home');

    });



});
Route::post('/basket/add/{id}', [BasketController::class, 'basketAdd'])->name('basket-add');

Route::group([
    'middleware' => 'basket_not_empty',
    'prefix' => 'basket',
], function (){
    Route::get('/', [BasketController::class, 'basket'])->name('basket');
    Route::get('/place', [BasketController::class, 'basketPlace'])->name('basket-place');
    Route::post('/remove/{id}', [BasketController::class, 'basketRemove'])->name('basket-remove');
    Route::post('/place', [BasketController::class, 'basketConfirm'])->name('basket-confirm');

});


Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/categories', [MainController::class, 'categories'])->name('categories');

//Route::get('/login', [AuthController::class, 'login'])->name('login');
//Route::get('/register', [AuthController::class, 'register'])->name('register');


Route::get('/{category}', [MainController::class, 'category'])->name('category');
Route::get('/{category}/{product?}', [MainController::class, 'product'])->name('product');


Route::get('/admin', AdminController::class)->name('admin');
