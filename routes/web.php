<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\AuthController;
// Landing page
Route::get('/', [ProductController::class, 'landingPage'])->name('customer.home');

// Products Page
Route::get('/products', [ProductController::class, 'products'])->name('customer.products');

// Specific Product Page
Route::get('/product/{product}', [ProductController::class, 'specificProduct'])->name('customer.specific-product');
// Sign in Page
Route::get('/signin', [AuthController::class, 'signinPage'])->name('auth.signin');

// Sign up Page
Route::get('/signup', [AuthController::class, 'signupPage'])->name('auth.signup');


// // Resourceful routes for products (CRUD)
// Route::resource('products', ProductController::class);
