<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdukRequest;
use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProdukController extends Controller
{
    public function index(): View
    {
        return view('produk.index', [
            'daftarProduk' => Produk::orderBy('nama')->get(),
        ]);
    }

    public function create(): View
    {
        return view('produk.form', [
            'produk' => new Produk,
        ]);
    }

    public function store(ProdukRequest $request): RedirectResponse
    {
        Produk::create($request->validated());

        return to_route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk): View
    {
        return view('produk.form', [
            'produk' => $produk,
        ]);
    }

    public function update(ProdukRequest $request, Produk $produk): RedirectResponse
    {
        $produk->update($request->validated());

        return to_route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk): RedirectResponse
    {
        $produk->delete();

        return to_route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
