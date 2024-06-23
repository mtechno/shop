<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\SkusController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ResetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Auth::routes([
//    'reset' => false,
//    'confirm' => false,
//    'verify' => false,
//]);
Route::get('/categories', [\App\Http\Controllers\Api\CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [\App\Http\Controllers\Api\CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{code}', [\App\Http\Controllers\Api\CategoryController::class, 'show'])->name('categories.show');
Route::put('/categories/{code}', [\App\Http\Controllers\Api\CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{code}', [\App\Http\Controllers\Api\CategoryController::class, 'destroy'])->name('categories.destroy');


Route::get('/products', [\App\Http\Controllers\Api\ProductController::class, 'index'])->name('products.index');
Route::post('/products', [\App\Http\Controllers\Api\ProductController::class, 'store'])->name('products.store');
Route::get('/products/{code}', [\App\Http\Controllers\Api\ProductController::class, 'show'])->name('products.show');
Route::put('/products/{code}', [\App\Http\Controllers\Api\ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{code}', [\App\Http\Controllers\Api\ProductController::class, 'destroy'])->name('products.destroy');



Route::get('/orders', [\App\Http\Controllers\Api\OrderController::class, 'index'])->name('orders.index');
Route::post('/orders', [\App\Http\Controllers\Api\OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{code}', [\App\Http\Controllers\Api\OrderController::class, 'show'])->name('orders.show');
Route::put('/orders/{code}', [\App\Http\Controllers\Api\OrderController::class, 'update'])->name('orders.update');
Route::delete('/orders/{code}', [\App\Http\Controllers\Api\OrderController::class, 'destroy'])->name('orders.destroy');





Route::post('/login', [\App\Http\Controllers\Api\LoginController::class, 'login'])->name('login');




Route::get('skus', [SkusController::class, 'getSkus']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('reset', [ResetController::class, 'reset']);

Route::post('/logout', [LoginController::class, 'logout']);

Route::middleware('auth')->group(function () {
    Route::group([
        'prefix' => 'person',
        'as' => 'person.',
    ], function () {
        Route::get('/orders', [\App\Http\Controllers\Person\OrderController::class, 'index']);
        Route::get('/orders/{order}', [\App\Http\Controllers\Person\OrderController::class, 'show']);
    });

    Route::group([
        'prefix' => 'admin',
    ], function () {
        Route::group(['middleware' => 'is_admin'], function () {
            Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index']);
            Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show']);
        });
        Route::resource('categories', \App\Http\Controllers\Api\CategoryController::class);
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    });
});


Route::post('/basket/add/{product}', [BasketController::class, 'basketAdd'])->name('basket-add');

Route::group([
    'middleware' => 'basket_not_empty',
    'prefix' => 'basket',
], function () {
    Route::get('/', [BasketController::class, 'basket'])->name('basket');
    Route::get('/place', [BasketController::class, 'basketPlace'])->name('basket-place');
    Route::post('/remove/{product}', [BasketController::class, 'basketRemove']);
    Route::post('/place', [BasketController::class, 'basketConfirm']);

});


Route::get('/', [MainController::class, 'index']);

Route::post('subscription/{product}', [MainController::class, 'subscribe']);


//Route::get('/register', [AuthController::class, 'register'])->name('register');



Route::get('/{category}/{product}', [MainController::class, 'product']);


Route::get('/admin', AdminController::class);
