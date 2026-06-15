<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\ProdukVarian;

class PemesananController extends Controller
{
    public function create()
    {
        $produks = \App\Models\Produk::with('varian')->get();
        return view('pemesanan', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan'  => 'required|string|max:100',
            'nomor_hp'      => 'required|string|max:20',
            'alamat'        => 'required|string',
            'items'         => 'required|array|min:1',
            'items.*.varian_id' => 'required|exists:produk_varian,id',
            'items.*.qty'   => 'required|integer|min:1',
        ]);

        $pesanan = Pesanan::create([
            'nama_pemesan' => $request->nama_pemesan,
            'nomor_hp'     => $request->nomor_hp,
            'alamat'       => $request->alamat,
            'status'       => 'Pending',
        ]);

        foreach ($request->items as $item) {
            $varian = ProdukVarian::findOrFail($item['varian_id']);
            $harga  = $varian->harga;
            $qty    = $item['qty'];

            PesananItem::create([
                'pesanan_id'   => $pesanan->id,
                'varian_id'    => $varian->id,
                'qty'          => $qty,
                'harga_satuan' => $harga,
                'subtotal'     => $harga * $qty,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dikirim!',
            'pesanan_id' => $pesanan->id,
        ]);
    }
}
