<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/about', [AboutController::class, 'index'])->middleware(['auth', 'verified'])->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Modul 4: Route::resource untuk CRUD produk, dilindungi middleware 'auth'
// Modul 5: Route export dilindungi Gate 'export-product' (hanya admin)
// Otorisasi granular (update/delete) ditangani oleh ProductPolicy (Modul 5)
Route::middleware('auth')->group(function () {
    // Route export harus sebelum resource agar tidak tertangkap oleh products/{product}
    Route::get('products/export', [ProductController::class, 'export'])
        ->middleware('can:export-product')
        ->name('products.export');

    Route::resource('products', ProductController::class);
});

require __DIR__ . '/auth.php';
