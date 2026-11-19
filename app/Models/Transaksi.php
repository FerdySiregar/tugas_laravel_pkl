<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['user_id', 'total_harga', 'uang_bayar', 'kembalian'];

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
