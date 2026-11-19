<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

// Halaman utama: cek status login & role dulu sebelum mengarahkan
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'pemilik'
            ? redirect('/dashboard-pemilik')
            : redirect('/katalog');
    }

    return redirect('/login');
});

Route::get('/sapa', function () {
    return 'Halo, kelompok 2!';
});

// Rute Login & Logout (middleware 'guest' dihapus agar tidak looping)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Halaman Khusus Pemilik
Route::middleware(['auth', 'role:pemilik'])->group(function () {
    Route::get('/dashboard-pemilik', function () {
        return view('pemilik.dashboard');
    })->name('pemilik.dashboard');

    // Rute Kelola Produk (Tambah, Edit, Hapus) khusus Pemilik
    Route::resource('produk', ProdukController::class)->except(['show']);
});

// Halaman Katalog & Detail Produk (Bisa diakses oleh Kasir maupun Pemilik setelah login)
Route::middleware(['auth', 'role:kasir,pemilik'])->group(function () {
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');

    Route::get('/katalog/{id}', [KatalogController::class, 'show'])
        ->whereNumber('id')
        ->name('katalog.show');
});
