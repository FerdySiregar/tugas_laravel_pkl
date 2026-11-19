<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KatalogController;
use Illuminate\Support\Facades\Route;

// Halaman utama langsung diarahkan ke halaman login
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/sapa', function () {
    return 'Halo, kelompok 2!';
});

// Rute Login & Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Halaman Khusus Pemilik
Route::middleware(['auth', 'role:pemilik'])->group(function () {
    Route::get('/dashboard-pemilik', function () {
        return view('pemilik.dashboard'); // Bisa sementara diganti: return "Halo Pemilik!";
    })->name('pemilik.dashboard');
});

// Halaman Katalog & Detail Produk (Bisa diakses oleh Kasir maupun Pemilik setelah login)
Route::middleware(['auth', 'role:kasir,pemilik'])->group(function () {
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');

    Route::get('/katalog/{id}', [KatalogController::class, 'show'])
        ->whereNumber('id')
        ->name('katalog.show');
});
