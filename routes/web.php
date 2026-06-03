<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarketplaceController;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $settings = Setting::pluck('value', 'key')->all();

    return view('marketplace', ['settings' => $settings]);
});

Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.perform');
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.perform');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('vendor/products', [MarketplaceController::class, 'vendorProducts'])->name('vendor.products');
    Route::post('vendor/products', [MarketplaceController::class, 'storeVendorProduct'])->name('vendor.products.store');
    Route::get('consumer/market', [MarketplaceController::class, 'consumerMarket'])->name('consumer.market');
    Route::get('admin/settings', [MarketplaceController::class, 'adminSettings'])->name('admin.settings');
    Route::post('admin/settings', [MarketplaceController::class, 'updateSettings'])->name('admin.settings.update');
});
