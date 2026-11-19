@extends('layouts.app')

@section('title', 'Kelola Produk | Kasir Ende')

@section('content')
<div style="max-width: 900px; margin: 20px auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1 style="font-size: 24px; font-weight: bold;">Kelola Produk</h1>
            <p style="color: #666;">Tambah, ubah, atau hapus produk yang tersedia di katalog.</p>
        </div>
        <a href="{{ route('produk.create') }}" style="padding: 10px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px;">
            + Tambah Produk
        </a>
    </div>

    @if (session('success'))
        <div style="padding: 12px; background: #dcfce7; color: #166534; border-radius: 6px; margin-bottom: 16px;">
            {{ session('success') }}
        </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
        <thead>
            <tr style="background: #f3f4f6; text-align: left;">
                <th style="padding: 10px; border: 1px solid #ddd;">Nama Produk</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Kategori</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Harga</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Stok</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($daftarProduk as $produk)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;"><strong>{{ $produk->nama }}</strong></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $produk->kategori }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $produk->stok }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <div style="display: flex; gap: 10px;">
                            <a href="{{ route('produk.edit', $produk) }}" style="color: #2563eb;">Edit</a>
                            <form action="{{ route('produk.destroy', $produk) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #dc2626; background: none; border: none; cursor: pointer; padding: 0;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 20px; text-align: center; color: #666;">Belum ada produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
