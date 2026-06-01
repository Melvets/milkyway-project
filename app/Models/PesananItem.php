<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananItem extends Model
{
    protected $table = 'pesanan_item';

    protected $fillable = [
        'pesanan_id',
        'varian_id',
        'qty',
        'harga_satuan',
        'subtotal',
    ];

    /**
     * Item ini milik satu pesanan
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    /**
     * Item ini merujuk ke satu varian produk
     */
    public function varian()
    {
        return $this->belongsTo(ProdukVarian::class, 'varian_id');
    }
}
