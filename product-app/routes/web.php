<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SPA\SPAAdminProductController;
use App\Http\Controllers\SPA\SPACartController;
use App\Http\Controllers\SPA\SPAOrderController;
use App\Http\Controllers\SPA\SPAProductController;
use App\Http\Controllers\SPA\SPAUserController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Guest;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware([SetLocale::class])->group(function () {

    Route::controller(ProductController::class)->group(function () {
        Route::get('/', 'index')->name('products.index');

        Route::middleware([Admin::class])->group(function () {
            Route::get('/products', 'dashboard')->name('products.dashboard');
            Route::post('/products', 'store')->name('products.store');
            Route::get('/product/publish', 'create')->name('products.create');
            Route::get('/products/{product}/edit', 'edit')->name('products.edit');
            Route::delete('/product/{product}', 'destroy')->name('products.destroy');
            Route::patch('/product/{product}', 'update')->name('products.update');
        });
    });

    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'index')->name('cart.index');
        Route::get('/cart/remove/{product}', 'destroy')->name('cart.remove');
        Route::post('/cart/add/{product}', 'store')->name('cart.add');
    });

    Route::controller(SessionController::class)->group(function () {
        Route::middleware([Guest::class])->group(function () {
            Route::get('/login', 'create')->name('login');
            Route::post('/login', 'login')->name('login.post');
        });

        Route::get('/logout', 'logout')->name('logout');
    });

    Route::middleware([Admin::class])->group(function () {
        Route::controller(OrderController::class)->group(function () {
            Route::get('/orders', 'index')->name('orders.index');
            Route::post('/orders', 'store')->name('orders.store');
            Route::get('/order/{order}', 'show')->name('order.show');
        });
    });
});

Route::prefix('/spa')->group(function () {
    Route::controller(SPAProductController::class)->group(function () {
        Route::get('/products', 'index');
    });

    Route::controller(SPAAdminProductController::class)->group(function () {
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::get('/products/all', 'index');
            Route::get('/products/{product}', 'show');
            Route::put('/products/{product}', 'update');
            Route::post('/products', 'store');
            Route::delete('/products/{product}', 'destroy');
        });
    });

    Route::controller(SPACartController::class)->group(function () {
        Route::get('/cart', 'index');
        Route::delete('/cart/{product}', 'destroy');
        Route::post('/cart', 'store');
    });

    Route::controller(SPAOrderController::class)->group(function () {
        Route::post('/orders', 'store');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/orders', 'index');
            Route::get('/orders/{order}', 'products');
        });
    });

    Route::get('/csrf-token', function () {
        return response()->json(['csrf_token' => csrf_token()]);
    });

    Route::controller(SPAUserController::class)->group(function () {
        Route::post('/login', 'login');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', 'logout');
            Route::get('/user', function () {
                return Auth::user();
            });
        });
    });

    Route::get('/change-locale', function () {
        return response()->json();
    });
});


Route::fallback(function () {
    if (request()->isMethod('GET')) {
        abort(404);
    }
})->name('fallback');
