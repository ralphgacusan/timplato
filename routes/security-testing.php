<?php

use App\Http\Controllers\Web\SecurityTestController;
use App\Http\Middleware\SecurityTestingOnly;
use Illuminate\Support\Facades\Route;

Route::middleware(SecurityTestingOnly::class)->group(function () {
    Route::get('/signin-test', [SecurityTestController::class, 'signinForm'])
        ->name('security-testing.signin');
    Route::post('/signin-test', [SecurityTestController::class, 'signin'])
        ->name('security-testing.signin.submit');

    Route::get('/review-test', [SecurityTestController::class, 'reviews'])
        ->name('security-testing.reviews');
    Route::post('/review-test', [SecurityTestController::class, 'storeReview'])
        ->name('security-testing.reviews.store');
    Route::post('/review-test/reset', [SecurityTestController::class, 'resetReviews'])
        ->name('security-testing.reviews.reset');
});
