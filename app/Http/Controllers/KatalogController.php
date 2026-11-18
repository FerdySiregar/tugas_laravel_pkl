<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KatalogController extends Controller
{
    public function index(Request $request): View
    {
        // 1. Tangkap kata kunci pencarian dari URL (?q=...)
        $q = $request->input('q', '');

        // 2. Query data dari database & filter jika kata kunci pencarian diisi
        $produk = Produk::when($q !== '', function ($query) use ($q) {
            $query->where('nama', 'like', '%' . $q . '%');
        })->get();

        // 3. Kirim variabel $produk dan $q ke view
        return view('katalog.index', compact('produk', 'q'));
    }
}
