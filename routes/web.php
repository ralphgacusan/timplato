<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\UserAddressController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\WishlistController;
use App\Http\Controllers\Web\SupportTicketController;




// Landing page
Route::get('/', [ProductController::class, 'landingPage'])->name('customer.home');

// Products Page
Route::get('/products', [ProductController::class, 'products'])->name('customer.products');

// Specific Product Page
Route::get('/product/{product}', [ProductController::class, 'specificProduct'])->name('customer.specific-product');

// Filter Products
Route::get('/products/filter', [ProductController::class, 'filterProducts'])->name('customer.filter-products');



// Google OAuth Routes
Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');



// Sign in Page
Route::get('/signin', [AuthController::class, 'signinPage'])->name('login');

// Sign up Page
Route::get('/signup', [AuthController::class, 'signupPage'])->name('auth.signup');

// Submit Sign up 
Route::post('/signup', [AuthController::class, 'signup'])->name('auth.submit.signup');

// Submit Sign in Page
Route::post('/signin', [AuthController::class, 'signin'])->name('auth.submit.signin');

//Log out
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// User Profile Page
Route::get('/user', [AuthController::class, 'showUserProfile'])->name('auth.user-profile')->middleware('auth');

//Display Manage Address Page
Route::get('/user/manage-address', [UserAddressController::class, 'showManageAddressPage'])->name('auth.user-profile.manage-address')->middleware('auth');


// CRUD routes for addresses
Route::post('/addresses', [UserAddressController::class, 'store'])->name('auth.user-profile.manage-address.store')->middleware('auth');

Route::put('/addresses/{id}', [UserAddressController::class, 'update'])->name('auth.user-profile.manage-address.update')->middleware('auth');

Route::delete('/addresses/{id}', [UserAddressController::class, 'destroy'])->name('auth.user-profile.manage-address.destroy')->middleware('auth');

//Display Edit Page
Route::get('/user/edit', [AuthController::class, 'showEditProfilePage'])->name('auth.user-profile.edit')->middleware('auth');

//Update User Profile
Route::put('/user/update', [AuthController::class, 'updateProfile'])->name('auth.user-profile.update')->middleware('auth');

// // CRUD routes for editing profile
// Route::post('/addresses', [UserAddressController::class, 'store'])->name('auth.user-profile.manage-address.store');

// Route::put('/addresses/{id}', [UserAddressController::class, 'update'])->name('auth.user-profile.manage-address.update');

// Route::delete('/addresses/{id}', [UserAddressController::class, 'destroy'])->name('auth.user-profile.manage-address.destroy');


// Cart Page
Route::get('/cart', [CartController::class, 'cartPage'])->name('customer.cart');




// Add to Cart
Route::post('/add-to-cart/{product}', [CartController::class, 'addToCart'])->name('customer.add-to-cart');

// Product Quantity
Route::put('/cart/update-quantity/{cartItem}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

//Remove Cart Item
Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');



// Checkout Page
Route::get('/checkout', [OrderController::class, 'checkoutPage'])->name('customer.checkout')->middleware('auth');

// Full cart checkout
Route::get('/checkout', [OrderController::class, 'checkoutCart'])->name('customer.checkout')->middleware('auth');

// Single product checkout (Buy Now)
Route::post('/checkout/buy-now/{product}', [OrderController::class, 'checkoutBuyNow'])->name('customer.checkout.buyNow')->middleware('auth');

// Place order
Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('customer.placeOrder')->middleware('auth');

// Route to display a single order's details
Route::get('/orders/{order}', [OrderController::class, 'showOrderDetails'])->name('customer.orderDetails')->middleware('auth');

//PayMongo Payement Page
Route::get('checkout/payment/{order}', [OrderController::class, 'paymentPage'])->name('customer.checkout.payment');


// // Resourceful routes for products (CRUD)
// Route::resource('products', ProductController::class);



// Review Routes
Route::post('/products/{product_id}/reviews', [ReviewController::class, 'store'])->name('customer.reviews.store')->middleware('auth');



// Wishlists Routes
Route::post('/wishlist/add/{productId}', [WishlistController::class, 'add'])->name('customer.wishlist.add')->middleware('auth');

Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('customer.wishlist.remove')->middleware('auth');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('customer.wishlist.index')->middleware('auth');



// Customer Supoprt Routes

Route::get('/customer-support', [SupportTicketController::class, 'index'])->name('customer.customer-support.index');
Route::post('/customer-support', [SupportTicketController::class, 'store'])->name('customer.customer-support.store')->middleware('auth');




// ADMIN ROUTES

// Product Management page
Route::get('/admin/products/management', [ProductController::class, 'showProductManagement'])->name('admin.product-management')->middleware('auth');

Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create')->middleware('auth');
Route::post('/admin/products/store', [ProductController::class, 'store'])->name('admin.products.store')->middleware('auth');
Route::get('/admin/products/{product}', [ProductController::class, 'show'])->name('admin.show')->middleware('auth');
Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit')->middleware('auth');
Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update')->middleware('auth');
Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy')->middleware('auth');


// Order Management page
Route::get('/admin/orders/management', [OrderController::class, 'showOrderManagement'])->name('admin.order-management')->middleware('auth');
