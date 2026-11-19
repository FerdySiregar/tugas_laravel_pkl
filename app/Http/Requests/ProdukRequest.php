<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'harga' => ['required', 'integer', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'integer' => ':attribute harus bilangan bulat.',
            'min' => ':attribute minimal :min.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'Nama produk',
            'kategori' => 'Kategori',
            'harga' => 'Harga',
            'stok' => 'Stok',
        ];
    }
}
