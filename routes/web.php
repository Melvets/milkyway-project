<?php

use App\Http\Controllers\ExportPesananController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index']);

// Pemesanan (publik)
Route::get('/pesan-sekarang', [PemesananController::class, 'create'])->name('pesan.create');
Route::post('/pesan-sekarang', [PemesananController::class, 'store'])->name('pesan.store');

// Dashboard & Orders (protected)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [PesananController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/orders', [PesananController::class, 'orders'])->name('orders.index');
    Route::get('/dashboard/orders/{id}/edit', [PesananController::class, 'edit'])->name('orders.edit');
    Route::put('/dashboard/orders/{id}', [PesananController::class, 'update'])->name('orders.update');
    Route::post('/dashboard/orders/{id}/terima', [PesananController::class, 'terima'])->name('orders.terima');
    Route::post('/dashboard/orders/{id}/tolak', [PesananController::class, 'tolak'])->name('orders.tolak');
    Route::post('/dashboard/orders/{id}/selesai', [PesananController::class, 'selesai'])->name('orders.selesai');
    Route::get('/dashboard/orders/export', [ExportPesananController::class, 'export'])->name('orders.export');
});

Route::resource('/dashboard/produk', ProdukController::class)->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
