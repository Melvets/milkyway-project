<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'nama_pemesan',
        'nomor_hp',
        'alamat',
        'status',
    ];

    /**
     * Pesanan memiliki banyak item (one-to-many)
     */
    public function items()
    {
        return $this->hasMany(PesananItem::class, 'pesanan_id');
    }
}
