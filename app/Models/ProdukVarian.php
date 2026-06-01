<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukVarian extends Model
{
    protected $table = 'produk_varian';

    protected $fillable = [
        'produk_id',
        'ukuran',
        'harga',
        'stok',
    ];

    /**
     * Varian ini milik satu produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    /**
     * Varian bisa ada di banyak pesanan_item
     */
    public function pesananItems()
    {
        return $this->hasMany(PesananItem::class, 'varian_id');
    }
}
