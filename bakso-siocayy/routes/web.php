<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\ReturnModelController;
use App\Http\Controllers\Admin\StockIncidentController;

// user
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot');
Route::post('/forgot-password', [AuthController::class, 'resetPassword']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// role user
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

//role admin
Route::middleware(['auth', RoleMiddleware::class . ':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Kategori Produk
        Route::resource('categories', CategoryController::class);

        // Produk
        Route::resource('products', ProductController::class);

        // Pesanan
        Route::resource('orders', OrderController::class);

        // 🔹 Update status & pembayaran cepat
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');
        Route::patch('orders/{order}/payment', [OrderController::class, 'updatePayment'])
            ->name('orders.updatePayment');

        // Pengiriman
        Route::resource('shipments', ShipmentController::class);

        // Retur / Reject / Stock Incident
        Route::resource('stock-incidents', StockIncidentController::class);

        // Route::resource('returns', ReturnModelController::class)
        Route::resource('returns', ReturnModelController::class);
    });


Route::fallback(function () {
    return redirect('/login');
});
