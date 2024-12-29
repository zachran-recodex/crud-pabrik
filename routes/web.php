<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class);

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('orders/{order}/process', [OrderController::class, 'process'])->name('orders.process');
    Route::post('orders/{order}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');

    Route::post('/cart/add/{product}', [CheckoutController::class, 'add'])->name('cart.add');
    Route::delete('/cart/item/{itemId}/remove', [CheckoutController::class, 'removeItem'])->name('cart.removeItem');
    Route::delete('/cart/clear', [CheckoutController::class, 'clear'])->name('cart.clear');
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('cart.checkout');
    Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/complete', [CheckoutController::class, 'complete'])->name('checkout.complete');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});

require __DIR__.'/auth.php';
