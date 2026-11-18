<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun 1: Pemilik
        User::create([
            'name' => 'Pemilik Toko',
            'email' => 'pemilik@kasir.com',
            'role' => 'pemilik',
            'password' => Hash::make('pemilik123'),
        ]);

        // Akun 2: Kasir
        User::create([
            'name' => 'Staff Kasir',
            'email' => 'kasir@kasir.com',
            'role' => 'kasir',
            'password' => Hash::make('kasir123'),
        ]);
    }
}
