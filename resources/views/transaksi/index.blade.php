@extends('layouts.app')

@section('title', 'Transaksi Kasir | Kasir Ende')

@section('content')
<div style="max-width: 1000px; margin: 20px auto;">
    <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 16px;">Transaksi Kasir</h1>

    @if (session('success'))
        <div style="padding: 12px; background: #dcfce7; color: #166534; border-radius: 6px; margin-bottom: 16px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error') || $errors->any())
        <div style="padding: 12px; background: #fee2e2; color: #991b1b; border-radius: 6px; margin-bottom: 16px;">
            {{ session('error') ?? $errors->first() }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1.3fr; gap: 24px;">
        {{-- Kolom Kiri: Form Pilih Produk --}}
        <div style="padding: 20px; border: 1px solid #ddd; border-radius: 8px; height: fit-content;">
            <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 12px;">Pilih Produk</h2>
            <form action="{{ route('transaksi.tambah') }}" method="POST">
                @csrf
                <div style="margin-bottom: 12px;">
                    <label>Produk Tersedia</label><br>
                    <select name="produk_id" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($produks as $produk)
                            <option value="{{ $produk->id }}">
                                {{ $produk->nama }} - Rp {{ number_format($produk->harga, 0, ',', '.') }} (Stok: {{ $produk->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 16px;">
                    <label>Jumlah Beli</label><br>
                    <input type="number" name="jumlah" value="1" min="1" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <button type="submit" style="width: 100%; padding: 10px; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer;">
                    + Tambah ke Keranjang
                </button>
            </form>
        </div>

        {{-- Kolom Kanan: Keranjang & Pembayaran --}}
        <div style="padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
            <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 12px;">Keranjang Belanja</h2>

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 16px;">
                <thead>
                    <tr style="background: #f3f4f6; text-align: left;">
                        <th style="padding: 8px; border: 1px solid #ddd;">Produk</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Harga</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Qty</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Subtotal</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($keranjang as $id => $item)
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ddd;">{{ $item['nama'] }}</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">{{ $item['jumlah'] }}</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">
                                <form action="{{ route('transaksi.hapus', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: #dc2626; background: none; border: none; cursor: pointer;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 16px; text-align: center; color: #666;">Keranjang masih kosong.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="padding: 12px; background: #f9fafb; border-radius: 6px; margin-bottom: 16px;">
                <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: bold;">
                    <span>Total Belanja:</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            @if ($total > 0)
                <form action="{{ route('transaksi.bayar') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 12px;">
                        <label>Uang Bayar (Rp)</label><br>
                        <input type="number" id="uang_bayar" name="uang_bayar" min="{{ $total }}" required placeholder="Masukkan nominal uang..." style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>

                    <div style="margin-bottom: 16px; font-size: 16px;">
                        <strong>Kembalian: </strong>
                        <span id="teks_kembalian" style="color: #16a34a; font-weight: bold;">Rp 0</span>
                    </div>

                    <button type="submit" style="width: 100%; padding: 12px; background: #16a34a; color: white; font-weight: bold; border: none; border-radius: 6px; cursor: pointer;">
                        Selesaikan Pembayaran
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<script>
    const totalBelanja = {{ $total }};
    const inputBayar = document.getElementById('uang_bayar');
    const teksKembalian = document.getElementById('teks_kembalian');

    if (inputBayar) {
        inputBayar.addEventListener('input', function () {
            const bayar = parseInt(this.value) || 0;
            const kembali = bayar - totalBelanja;

            if (kembali >= 0) {
                teksKembalian.textContent = 'Rp ' + kembali.toLocaleString('id-ID');
                teksKembalian.style.color = '#16a34a';
            } else {
                teksKembalian.textContent = 'Uang kurang Rp ' + Math.abs(kembali).toLocaleString('id-ID');
                teksKembalian.style.color = '#dc2626';
            }
        });
    }
</script>
@endsection
