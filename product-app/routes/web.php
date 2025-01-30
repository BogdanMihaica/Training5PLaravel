<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsGuest;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::middleware([SetLocale::class])->group(function () {

    Route::controller(ProductController::class)->group(function () {
        Route::get('/', 'index');
        Route::middleware([IsAdmin::class])->group(function () {
            Route::get('/products', 'dashboard');
            Route::post('/products', 'store');
            Route::get('/product/publish', 'create');
            Route::get('/product/{id}/edit', 'edit');
            Route::delete('/product/{id}', 'destroy');
            Route::patch('/product/{id}', 'update');
        });
    });

    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'index');
        Route::get('/cart/remove/{id}', 'destroy');
        Route::get('/cart/add/{id}/{quantity}', 'store');
    });

    Route::controller(SessionController::class)->group(function () {
        Route::middleware([IsGuest::class])->group(function () {
            Route::get('/login', 'create');
            Route::post('/login', 'store');
        });
        Route::get('/logout', 'destroy');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'index');
        Route::post('/orders', 'store');
        Route::get('/order/{id}', 'inspect');
    });
});
