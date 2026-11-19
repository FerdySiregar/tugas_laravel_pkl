<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
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

// Rute Login & Logout
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

// Halaman Katalog & Transaksi Kasir (Bisa diakses oleh Kasir maupun Pemilik setelah login)
Route::middleware(['auth', 'role:kasir,pemilik'])->group(function () {
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');

    Route::get('/katalog/{id}', [KatalogController::class, 'show'])
        ->whereNumber('id')
        ->name('katalog.show');

    // Rute Transaksi Kasir
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi/tambah', [TransaksiController::class, 'tambahKeranjang'])->name('transaksi.tambah');
    Route::delete('/transaksi/hapus/{id}', [TransaksiController::class, 'hapusItem'])->name('transaksi.hapus');
    Route::post('/transaksi/bayar', [TransaksiController::class, 'bayar'])->name('transaksi.bayar');
});
