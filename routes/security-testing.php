<?php

use App\Http\Controllers\Web\SecurityTestController;
use App\Http\Middleware\SecurityTestingOnly;
use Illuminate\Support\Facades\Route;

Route::middleware(SecurityTestingOnly::class)->group(function () {
    Route::get('/signin-test', [SecurityTestController::class, 'signinForm'])
        ->name('security-testing.signin');
    Route::post('/signin-test', [SecurityTestController::class, 'signin'])
        ->name('security-testing.signin.submit');

    Route::get('/signup-test', [SecurityTestController::class, 'signupForm'])
        ->name('security-testing.signup');
    Route::post('/signup-test', [SecurityTestController::class, 'signup'])
        ->name('security-testing.signup.submit');
    Route::post('/logout-test', [SecurityTestController::class, 'logout'])
        ->name('security-testing.logout');

    Route::get('/products-test', [SecurityTestController::class, 'products'])
        ->name('security-testing.products');
    Route::get('/product-test/{id}', [SecurityTestController::class, 'product'])
        ->whereNumber('id')
        ->name('security-testing.product');

    Route::get('/review-test', [SecurityTestController::class, 'reviews'])
        ->name('security-testing.reviews');
    Route::post('/review-test', [SecurityTestController::class, 'storeReview'])
        ->name('security-testing.reviews.store');
    Route::post('/review-test/reset', [SecurityTestController::class, 'resetReviews'])
        ->name('security-testing.reviews.reset');

    Route::get('/database-test', [SecurityTestController::class, 'databasePage'])
        ->name('security-testing.database');
    Route::post('/database-test/reset', [SecurityTestController::class, 'resetDatabase'])
        ->name('security-testing.database.reset');

    Route::get('/cart-test', [SecurityTestController::class, 'cart'])
        ->name('security-testing.cart');
    Route::post('/cart-test', [SecurityTestController::class, 'updateCart'])
        ->name('security-testing.cart.store');
});
