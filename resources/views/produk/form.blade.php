@extends('layouts.app')

@section('title', ($produk->exists ? 'Edit Produk' : 'Tambah Produk') . ' | Kasir Ende')

@section('content')
<div style="max-width: 500px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
    <a href="{{ route('produk.index') }}" style="color: #2563eb; text-decoration: none;">← Kembali ke kelola produk</a>
    <h1 style="font-size: 22px; font-weight: bold; margin: 12px 0;">
        {{ $produk->exists ? 'Edit Produk' : 'Tambah Produk' }}
    </h1>

    <form method="POST" action="{{ $produk->exists ? route('produk.update', $produk) : route('produk.store') }}">
        @csrf
        @if ($produk->exists)
            @method('PUT')
        @endif

        <div style="margin-bottom: 12px;">
            <label for="nama">Nama Produk</label><br>
            <input id="nama" name="nama" type="text" value="{{ old('nama', $produk->nama) }}" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            @error('nama') <small style="color: red;">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom: 12px;">
            <label for="kategori">Kategori</label><br>
            <select id="kategori" name="kategori" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                <option value="">-- Pilih Kategori --</option>
                <option value="Minuman" {{ old('kategori', $produk->kategori) === 'Minuman' ? 'selected' : '' }}>Minuman</option>
                <option value="Makanan" {{ old('kategori', $produk->kategori) === 'Makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="Snack" {{ old('kategori', $produk->kategori) === 'Snack' ? 'selected' : '' }}>Snack</option>
            </select>
            @error('kategori') <small style="color: red;">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom: 12px;">
            <label for="harga">Harga (Rp)</label><br>
            <input id="harga" name="harga" type="number" min="0" value="{{ old('harga', $produk->harga) }}" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            @error('harga') <small style="color: red;">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label for="stok">Stok</label><br>
            <input id="stok" name="stok" type="number" min="0" value="{{ old('stok', $produk->stok) }}" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            @error('stok') <small style="color: red;">{{ $message }}</small> @enderror
        </div>

        <button type="submit" style="width: 100%; padding: 10px; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer;">
            {{ $produk->exists ? 'Simpan Perubahan' : 'Tambah Produk' }}
        </button>
    </form>
</div>
@endsection
