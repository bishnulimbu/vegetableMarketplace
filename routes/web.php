<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarketplaceController;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $settings = Setting::pluck('value', 'key')->all();

    return view('marketplace', ['settings' => $settings]);
});

Route::view('/about', 'about')->name('about');

Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.perform');
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.perform');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Vendor
    Route::get('vendor/products', [MarketplaceController::class, 'vendorProducts'])->name('vendor.products');
    Route::post('vendor/products', [MarketplaceController::class, 'storeVendorProduct'])->name('vendor.products.store');

    // Consumer — Market & Product
    Route::get('consumer/market', [MarketplaceController::class, 'consumerMarket'])->name('consumer.market');
    Route::get('consumer/product/{vegetable}', [CartController::class, 'viewProduct'])->name('product.view');

    // Consumer — Cart
    Route::post('cart/add/{vegetable}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::patch('cart/update/{cart}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('cart/remove/{cart}', [CartController::class, 'removeFromCart'])->name('cart.remove');

    // Consumer — Checkout & Orders
    Route::get('checkout', [CartController::class, 'showCheckout'])->name('checkout.show');
    Route::post('checkout', [CartController::class, 'placeOrder'])->name('order.place');
    Route::get('order/{order}/confirmation', [CartController::class, 'orderConfirmation'])->name('order.confirmation');
    Route::get('orders', [CartController::class, 'myOrders'])->name('orders.index');

    // Admin
    Route::get('admin/settings', [MarketplaceController::class, 'adminSettings'])->name('admin.settings');
    Route::post('admin/settings', [MarketplaceController::class, 'updateSettings'])->name('admin.settings.update');
});
