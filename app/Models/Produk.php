<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'nama',
        'deskripsi',
        'gambar',
        'status',
    ];

    /**
     * Produk memiliki banyak varian ukuran/harga
     */
    public function varian()
    {
        return $this->hasMany(ProdukVarian::class, 'produk_id');
    }
}
