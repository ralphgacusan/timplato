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
use App\Http\Controllers\Web\OrderPDFController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\SettingController;
use App\Http\Controllers\Web\PaymentMethodController;
use App\Http\Controllers\Web\DeliveryMethodController;
use App\Http\Controllers\Web\VoucherController;
use App\Http\Controllers\Web\StaticPagesController;
use App\Http\Controllers\Web\CMSController;
use App\Http\Controllers\Web\AdminAuditTrailController;
use App\Http\Controllers\Web\NotificationSettingController;

use App\Http\Controllers\Web\DashboardController;





// Landing page
Route::get('/', [ProductController::class, 'landingPage'])->name('customer.home');
// About Us Page
Route::get('/about-us', [StaticPagesController::class, 'aboutUsPage'])->name('customer.about-us');
// Contact Page
Route::get('/contact', [StaticPagesController::class, 'contactPage'])->name('customer.contact');
// Privacy Policy
Route::get('/privacy-policy', [StaticPagesController::class, 'privacyPolicyPage'])->name('customer.privacy-policy');
// FAQs
Route::get('/customer-support', [StaticPagesController::class, 'customerSupportPage'])->name('customer.customer-support.index');


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

// Request Cancel
Route::patch('orders/{order}/cancel', [OrderController::class, 'requestCancel'])->name('customer.orders.cancel');

//Request Return
Route::patch('/orders/{order}/return-refund', [OrderController::class, 'requestReturnRefund'])->name('customer.orders.return-refund');

// Buy Again
Route::post('orders/{order}/buy-again', [OrderController::class, 'buyAgain'])->name('customer.orders.buy-again');


//PayMongo Payement Page
Route::get('payment/paymongo/callback', [OrderController::class, 'handlePaymongoCallback'])->name('paymongo.callback');

//Redirect to Paymongo
Route::get('payment/paymongo/{amount}/{order}/{paymentMethod}', [OrderController::class, 'redirectToPaymongo'])->name('paymongo.redirect');

// // Resourceful routes for products (CRUD)
// Route::resource('products', ProductController::class);



// Review Routes
Route::post('/products/{product_id}/reviews', [ReviewController::class, 'store'])->name('customer.reviews.store')->middleware('auth');



// Wishlists Routes
Route::post('/wishlist/add/{productId}', [WishlistController::class, 'add'])->name('customer.wishlist.add')->middleware('auth');

Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('customer.wishlist.remove')->middleware('auth');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('customer.wishlist.index')->middleware('auth');



// Customer Supoprt Routes

Route::post('/customer-support', [SupportTicketController::class, 'store'])->name('customer.customer-support.store')->middleware('auth');




// ADMIN ROUTES

Route::middleware(['auth', 'role:admin'])->group(function () {

    //Admin Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/products/management', [ProductController::class, 'showProductManagement'])->name('admin.product-management');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create')->middleware('auth');
    Route::post('/admin/products/store', [ProductController::class, 'store'])->name('admin.products.store')->middleware('auth');
    Route::get('/admin/products/{product}', [ProductController::class, 'show'])->name('admin.show')->middleware('auth');
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit')->middleware('auth');
    Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update')->middleware('auth');
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy')->middleware('auth');


    // Order Management page
    Route::get('/admin/orders/management', [OrderController::class, 'showOrderManagement'])->name('admin.order-management')->middleware('auth');
    // Order Specific page
    Route::get('/admin/orders/management/{order}', [OrderController::class, 'showSpecific'])->name('admin.order-specific')->middleware('auth');

    Route::patch('/admin/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status')->middleware('auth');
    // Aprove Cancel
    Route::patch('/admin/orders/{order}/approve-cancel', [OrderController::class, 'approveCancel'])->name('admin.orders.approve-cancel')->middleware('auth');

    // Reject Cancel
    Route::patch('/admin/orders/{order}/reject-cancel', [OrderController::class, 'rejectCancel'])->name('admin.orders.reject-cancel')->middleware('auth');

    // Delete Order
    Route::delete('/admin/orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy')->middleware('auth');

    // Refund Management
    Route::patch('admin/orders/{order}/approve-refund', [OrderController::class, 'approveRefund'])->name('admin.orders.approve-refund');
    Route::patch('admin/orders/{order}/reject-refund', [OrderController::class, 'rejectRefund'])->name('admin.orders.reject-refund');
    Route::patch('admin/orders/{order}/process-refund', [OrderController::class, 'processRefund'])->name('admin.orders.process-refund');

    // Return Management
    Route::patch('admin/orders/{order}/approve-return', [OrderController::class, 'approveReturn'])->name('admin.orders.approve-return');
    Route::patch('admin/orders/{order}/reject-return', [OrderController::class, 'rejectReturn'])->name('admin.orders.reject-return');
    Route::patch('admin/orders/{order}/process-return', [OrderController::class, 'processReturn'])->name('admin.orders.process-return');




    // User Management
    Route::get('/admin/users/management', [AuthController::class, 'showUserManagement'])->name('admin.user-management');
    // Delete User
    Route::delete('/admin/users/{id}', [AuthController::class, 'destroy'])->name('admin.users.destroy');
    // Suspend User
    Route::post('/admin/users/{user}/suspend', [AuthController::class, 'suspend'])->name('admin.users.suspend');
    // unuspend User
    Route::post('/admin/users/{user}/unsuspend', [AuthController::class, 'unsuspend'])->name('admin.users.unsuspend');


    // User Profile Page
    Route::get('/admin/users/management/user/{id}/view', [AuthController::class, 'userAccountViewPage'])->name('admin.user-account-view')->middleware('auth');
    // User Profile Edit Information Page
    Route::get('/admin/users/management/user/{user}/edit-information', [AuthController::class, 'userAccountViewEditInformationPage'])->name('admin.user-account-edit-information')->middleware('auth');
    // User Profile Update Information
    Route::put('/admin/users/management/user/{user}/update-information', [AuthController::class, 'updateUserAccountInformation'])->name('admin.user-account-update-information')->middleware('auth');

    // User Profile Edit Address Page
    Route::get('/admin/users/management/user/{id}/edit-address', [AuthController::class, 'userAccountViewEditAddressPage'])->name('admin.user-account-edit-address')->middleware('auth');
    // Add new address for a specific user
    Route::post('/admin/users/{userId}/addresses', [UserAddressController::class, 'adminStoreAddress'])->name('admin.users.addresses.store');

    // Update existing address for a specific user
    Route::put('/admin/users/{userId}/addresses/{id}', [UserAddressController::class, 'adminUpdateAddress'])->name('admin.users.addresses.update');

    // Delete address for a specific user
    Route::delete('/admin/users/{userId}/addresses/{id}', [UserAddressController::class, 'adminDestroyAddress'])->name('admin.users.addresses.destroy');

    // Add User (Admin)
    Route::get('/admin/users/create', [AuthController::class, 'createUserPage'])->name('admin.user-management.create');
    Route::post('/admin/users/store', [AuthController::class, 'storeUser'])->name('admin.user-management.store');





    // Inventory Management
    Route::get('/admin/inventory/management', [ProductController::class, 'showInventoryManagement'])->name('admin.inventory-management');

    Route::patch('/admin/inventory/{product}/update-stock', [ProductController::class, 'updateStock'])->name('admin.inventory.updateStock');

    Route::get('/admin/inventory/{product}/history', [ProductController::class, 'viewStockHistory'])->name('admin.inventory.history');




    // Printing Invoice
    Route::get('/admin/orders/{orderId}/invoice', [OrderController::class, 'generateInvoice'])->name('admin.orders.invoice');
    Route::get('/admin/orders/{orderId}/packing-slip', [OrderController::class, 'generatePackingSlip'])->name('admin.orders.packing-slip');




    // Sales and Analytics Reports
    Route::get('/admin/sales-analytics', [PaymentController::class, 'salesAnalyticsPage'])->name('admin.sales-analytics');
    // Sales and Analytics Reports Filter
    Route::get('/admin/sales-analytics/filter', [PaymentController::class, 'filterSalesAnalytics'])->name('admin.sales.analytics.filter');
    // Product Performance 
    Route::get('/admin/sales-analytics/product/{id}', [PaymentController::class, 'getProductAnalytics']);
    // Product Search
    Route::get('/admin/sales-analytics/products/filter', [PaymentController::class, 'filterProducts'])->name('admin.sales-analytics.filter-products');


    // Settings and Configuration
    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::put('/settings/update', [SettingController::class, 'update'])->name('settings.update');

    // Payment Methods
    Route::get('/payment-methods/create', [PaymentMethodController::class, 'create'])->name('payment.create');
    Route::post('/payment-methods/store', [PaymentMethodController::class, 'store'])->name('payment.store');
    Route::get('/payment-methods/{id}/edit', [PaymentMethodController::class, 'edit'])->name('payment.edit');
    Route::put('/payment-methods/{id}', [PaymentMethodController::class, 'update'])->name('payment.update');
    Route::delete('/payment-methods/{id}', [PaymentMethodController::class, 'destroy'])->name('payment.destroy');

    // Delivery Methods
    Route::get('/delivery-methods/create', [DeliveryMethodController::class, 'create'])->name('delivery.create');
    Route::post('/delivery-methods/store', [DeliveryMethodController::class, 'store'])->name('delivery.store');
    Route::get('/delivery-methods/{id}/edit', [DeliveryMethodController::class, 'edit'])->name('delivery.edit');
    Route::put('/delivery-methods/{id}', [DeliveryMethodController::class, 'update'])->name('delivery.update');
    Route::delete('/delivery-methods/{id}', [DeliveryMethodController::class, 'destroy'])->name('delivery.destroy');

    // Voucher Management
    Route::get('/admin/settings/vouchers', [App\Http\Controllers\Web\VoucherController::class, 'index'])->name('voucher.index');
    Route::post('/vouchers', [App\Http\Controllers\Web\VoucherController::class, 'store'])->name('voucher.store');
    Route::put('/vouchers/{id}', [App\Http\Controllers\Web\VoucherController::class, 'update'])->name('voucher.update');
    Route::delete('/vouchers/{id}', [App\Http\Controllers\Web\VoucherController::class, 'destroy'])->name('voucher.destroy');

    Route::get('/voucher/validate', [\App\Http\Controllers\Web\VoucherController::class, 'validateVoucher'])->name('voucher.validate');


    // Display notification settings and manual send form
    Route::get('/admin/notifications', [NotificationSettingController::class, 'index'])->name('admin.notifications.index');

    // Toggle a specific notification setting
    Route::post('/admin/notifications/{setting}/toggle', [NotificationSettingController::class, 'toggle'])->name('admin.notifications.toggle');

    // Send a manual notification
    Route::post('/admin/notifications/send', [NotificationSettingController::class, 'sendManual'])->name('admin.notifications.send');


    Route::get('/admin/cms', [CMSController::class, 'index'])->name('admin.cms');
    Route::post('/admin/content-pages', [CMSController::class, 'storePage'])->name('admin.pages.store');
    Route::put('/admin/content-pages/{page}', [CMSController::class, 'updatePage'])->name('admin.pages.update');
    Route::delete('/admin/content-pages/{page}', [CMSController::class, 'destroyPage'])->name('admin.pages.destroy');

    Route::post('/admin/team-members', [CMSController::class, 'storeTeam'])->name('admin.team-members.store');
    Route::put('/admin/team-members/{teamMember}', [CMSController::class, 'updateTeam'])->name('admin.team-members.update');
    Route::delete('/admin/team-members/{teamMember}', [CMSController::class, 'destroyTeam'])->name('admin.team-members.destroy');

    Route::post('/admin/banners', [CMSController::class, 'storeBanner'])->name('admin.banners.store');
    Route::put('/admin/banners/{banner}', [CMSController::class, 'updateBanner'])->name('admin.banners.update');
    Route::delete('/admin/banners/{banner}', [CMSController::class, 'destroyBanner'])->name('admin.banners.destroy');



    // Audit Trail
    Route::get('/admin/audit-trail', [AdminAuditTrailController::class, 'index'])->name('admin.audit-trail');
    
});


