<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::controller(ProductController::class)->group(function () {
    Route::get('/', 'index');
});

Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index');
    Route::get('/cart/remove/{id}', 'destroy');
    Route::get('/cart/add/{id}/{quantity}', 'store');
});

Route::controller(SessionController::class)->group(function () {
    Route::get('/login', 'create');
    Route::post('/login', 'store');
});
