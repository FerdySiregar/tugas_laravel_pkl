<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // Menampilkan halaman kasir & isi keranjang
    public function index()
    {
        $produks = Produk::where('stok', '>', 0)->orderBy('nama')->get();
        $keranjang = session()->get('keranjang', []);

        $total = 0;
        foreach ($keranjang as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        return view('transaksi.index', compact('produks', 'keranjang', 'total'));
    }

    // Menambah produk ke keranjang (Session)
    public function tambahKeranjang(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        $keranjang = session()->get('keranjang', []);

        $jumlahDiKeranjang = isset($keranjang[$produk->id]) ? $keranjang[$produk->id]['jumlah'] : 0;
        $totalDiminta = $jumlahDiKeranjang + $request->jumlah;

        if ($totalDiminta > $produk->stok) {
            return back()->with('error', "Stok {$produk->nama} tidak mencukupi (Sisa stok: {$produk->stok}).");
        }

        $keranjang[$produk->id] = [
            'produk_id' => $produk->id,
            'nama' => $produk->nama,
            'harga' => $produk->harga,
            'jumlah' => $totalDiminta,
        ];

        session()->put('keranjang', $keranjang);

        return back()->with('success', "{$produk->nama} ditambahkan ke keranjang.");
    }

    // Menghapus satu item dari keranjang
    public function hapusItem($id)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session()->put('keranjang', $keranjang);
        }

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    // Proses simpan transaksi & potong stok
    public function bayar(Request $request)
    {
        $keranjang = session()->get('keranjang', []);

        if (empty($keranjang)) {
            return back()->with('error', 'Keranjang belanja masih kosong.');
        }

        $total = 0;
        foreach ($keranjang as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        $request->validate([
            'uang_bayar' => "required|integer|min:{$total}",
        ], [
            'uang_bayar.min' => 'Uang bayar kurang dari total belanja.',
        ]);

        $kembalian = $request->uang_bayar - $total;

        DB::transaction(function () use ($keranjang, $total, $request, $kembalian) {
            $transaksi = Transaksi::create([
                'user_id' => auth()->id(),
                'total_harga' => $total,
                'uang_bayar' => $request->uang_bayar,
                'kembalian' => $kembalian,
            ]);

            foreach ($keranjang as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item['produk_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['jumlah'],
                ]);

                // Kurangi stok produk otomatis
                Produk::where('id', $item['produk_id'])->decrement('stok', $item['jumlah']);
            }
        });

        session()->forget('keranjang');

        return back()->with('success', 'Transaksi berhasil! Kembalian: Rp ' . number_format($kembalian, 0, ',', '.'));
    }
}
