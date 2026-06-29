<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\ProdukVarian;
use App\Services\FonnteService;

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
            'nama_pemesan'       => 'required|string|max:100',
            'nomor_hp'           => 'required|string|max:20',
            'alamat'             => 'required|string',
            'items'              => 'required|array|min:1',
            'items.*.varian_id'  => 'required|exists:produk_varian,id',
            'items.*.qty'        => 'required|integer|min:1',
        ]);

        // Simpan pesanan ke database
        $pesanan = Pesanan::create([
            'nama_pemesan' => $request->nama_pemesan,
            'nomor_hp'     => $request->nomor_hp,
            'alamat'       => $request->alamat,
            'status'       => 'Pending',
        ]);

        foreach ($request->items as $item) {
            $varian = ProdukVarian::findOrFail($item['varian_id']);
            PesananItem::create([
                'pesanan_id'   => $pesanan->id,
                'varian_id'    => $varian->id,
                'qty'          => $item['qty'],
                'harga_satuan' => $varian->harga,
                'subtotal'     => $varian->harga * $item['qty'],
            ]);
        }

        // Reload relasi untuk pesan WA
        $pesanan->load('items.varian.produk');

        // Kirim WA ke customer & admin via Fonnte
        $fonnte = new FonnteService();
        $fonnte->confirmToCustomer($pesanan);
        $fonnte->notifyAdmin($pesanan);

        return response()->json([
            'success'      => true,
            'message'      => 'Pesanan berhasil dikirim! Konfirmasi telah dikirim ke WhatsApp Anda.',
            'pesanan_id'   => $pesanan->id,
            'redirect_url' => route('pesan.sukses'),
        ]);
    }

    /**
     * Halaman sukses setelah pemesanan
     */
    public function sukses()
    {
        return view('pesan-sukses');
    }
}
