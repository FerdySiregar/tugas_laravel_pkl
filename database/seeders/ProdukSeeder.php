<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Kopi Ende',
                'kategori' => 'Minuman',
                'harga' => 15000,
                'stok' => 12,
            ],
            [
                'nama' => 'Roti Cokelat',
                'kategori' => 'Makanan',
                'harga' => 8000,
                'stok' => 0,
            ],
            [
                'nama' => 'Brownies',
                'kategori' => 'Makanan',
                'harga' => 12000,
                'stok' => 5,
            ],
            [
                'nama' => 'Teh Manis',
                'kategori' => 'Minuman',
                'harga' => 5000,
                'stok' => 20,
            ],
        ];

        foreach ($data as $item) {
            Produk::create($item);
        }
    }
}
