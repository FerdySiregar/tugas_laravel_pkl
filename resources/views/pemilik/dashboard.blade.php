@extends('layouts.app')

@section('title', 'Dashboard Pemilik - Kasir Ende')

@section('content')
    <div style="max-width: 800px; margin: 20px auto;">
        <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">Dashboard Pemilik Toko</h1>
        <p style="margin-bottom: 20px;">Selamat datang, <strong>{{ auth()->user()->name }}</strong>! Anda login dengan hak akses penuh sebagai <strong>Pemilik</strong>.</p>

        <div style="display: flex; gap: 15px; margin-top: 20px;">
            <a href="{{ route('produk.index') }}" style="padding: 12px 20px; background-color: #16a34a; color: white; text-decoration: none; border-radius: 6px;">
                Kelola Produk
            </a>

            <a href="{{ route('katalog.index') }}" style="padding: 12px 20px; background-color: #2563eb; color: white; text-decoration: none; border-radius: 6px;">
                Lihat Katalog Produk
            </a>
        </div>
    </div>
@endsection
