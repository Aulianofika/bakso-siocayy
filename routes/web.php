<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Frontend\RiwayatController;
use App\Http\Controllers\Admin\ReturnModelController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\FronOrderController;
use App\Http\Controllers\Admin\StockIncidentController;

//auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot');
Route::post('/forgot-password', [AuthController::class, 'resetPassword']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Beranda dan Menu
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/produk/{id}', [HomeController::class, 'show'])->name('produk.show');

//user
Route::middleware('auth')->group(function () {


    // Keranjang
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
    Route::post('/keranjang/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/hapus/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/received', [FronOrderController::class, 'received'])
        ->name('orders.received');
    Route::patch('/orders/{id}/cancel', [FronOrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/orders/{id}/invoice', [FronOrderController::class, 'invoice'])->name('orders.invoice');
    Route::patch('/orders/{id}/cancel', [FronOrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('frontend.riwayat');

});

// admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export', [\App\Http\Controllers\Admin\DashboardController::class, 'exportPdf'])->name('dashboard.export');

    Route::resource('categories', CategoryController::class);
    Route::get('/products/preview', [ProductController::class, 'preview'])->name('products.preview');
    Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    Route::get('/shipments/preview', [ShipmentController::class, 'preview'])->name('shipments.preview');
    Route::get('/shipments/export', [ShipmentController::class, 'export'])->name('shipments.export');
    Route::resource('shipments', ShipmentController::class);
    Route::get('/stock-incidents/preview', [StockIncidentController::class, 'preview'])->name('stock-incidents.preview');
    Route::get('/stock-incidents/export', [StockIncidentController::class, 'export'])->name('stock-incidents.export');
    Route::resource('stock-incidents', StockIncidentController::class);
    Route::resource('returns', ReturnModelController::class);
    Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class)->only(['index', 'destroy']);

    // Update status order cepat
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::patch('orders/{order}/payment', [OrderController::class, 'updatePayment'])->name('orders.updatePayment');
    // Konfirmasi pembayaran
    Route::post('/orders/{id}/approve', [OrderController::class, 'approve'])->name('admin.orders.approve');
    Route::post('/orders/{id}/reject', [OrderController::class, 'reject'])->name('admin.orders.reject');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');
    Route::patch('/admin/orders/{order}/payment', [OrderController::class, 'updatePayment'])
        ->name('admin.orders.updatePayment');

    Route::post(
        '/admin/orders/{order}/ready-to-ship',
        [OrderController::class, 'readyToShip']
    )->name('admin.orders.readyToShip');
    Route::post(
        '/shipments/{shipment}/send',
        [ShipmentController::class, 'kirim']
    )->name('shipments.send');

    Route::post(
        '/shipments/{shipment}/received',
        [ShipmentController::class, 'terima']
    )->name('shipments.received');



});

// fallback
Route::fallback(function () {
    return redirect('/login');
});
