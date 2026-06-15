<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananController extends Controller
{
    /**
     * Dashboard — hanya pesanan Pending (perlu konfirmasi)
     */
    public function dashboard()
    {
        $pending   = Pesanan::with('items.varian.produk')
                        ->where('status', 'Pending')
                        ->latest()
                        ->get();

        $statPending   = Pesanan::where('status', 'Pending')->count();
        $statDiproses  = Pesanan::where('status', 'Diproses')->count();
        $statSelesai   = Pesanan::where('status', 'Selesai')->count();
        $statRevenue   = Pesanan::where('status', 'Selesai')
                            ->with('items')
                            ->get()
                            ->sum(fn($p) => $p->items->sum('subtotal'));

        return view('layout.dashboard.main', compact(
            'pending', 'statPending', 'statDiproses', 'statSelesai', 'statRevenue'
        ));
    }

    /**
     * Orders — semua pesanan
     */
    public function orders(Request $request)
    {
        $query = Pesanan::with('items.varian.produk')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pesanans = $query->paginate(10);

        return view('layout.dashboard.orders.main', compact('pesanans'));
    }

    /**
     * Edit pesanan
     */
    public function edit(string $id)
    {
        $pesanan = Pesanan::with('items.varian.produk')->findOrFail($id);
        $produks = \App\Models\Produk::with('varian')->get();
        return view('layout.dashboard.orders.edit', compact('pesanan', 'produks'));
    }

    /**
     * Update pesanan
     */
    public function update(Request $request, string $id)
    {
        $pesanan = Pesanan::with('items')->findOrFail($id);

        $request->validate([
            'nama_pemesan' => 'required|string|max:100',
            'nomor_hp'     => 'required|string|max:20',
            'alamat'       => 'required|string',
            'status'       => 'required|in:Pending,Diproses,Selesai',
            'items'        => 'required|array|min:1',
            'items.*.varian_id' => 'required|exists:produk_varian,id',
            'items.*.qty'       => 'required|integer|min:1',
        ]);

        $pesanan->update([
            'nama_pemesan' => $request->nama_pemesan,
            'nomor_hp'     => $request->nomor_hp,
            'alamat'       => $request->alamat,
            'status'       => $request->status,
        ]);

        // Hapus item lama, insert baru
        $pesanan->items()->delete();

        foreach ($request->items as $item) {
            $varian = \App\Models\ProdukVarian::findOrFail($item['varian_id']);
            \App\Models\PesananItem::create([
                'pesanan_id'   => $pesanan->id,
                'varian_id'    => $varian->id,
                'qty'          => $item['qty'],
                'harga_satuan' => $varian->harga,
                'subtotal'     => $varian->harga * $item['qty'],
            ]);
        }

        return redirect()->route('orders.index')
            ->with('success', "Pesanan #{$pesanan->id} berhasil diperbarui.");
    }

    /**
     * Terima pesanan → status jadi Diproses
     */
    public function terima(string $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => 'Diproses']);

        return back()->with('success', "Pesanan #{$pesanan->id} diterima.");
    }

    /**
     * Tolak pesanan → hapus dari database
     */
    public function tolak(string $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return back()->with('success', "Pesanan #{$id} ditolak dan dihapus.");
    }

    /**
     * Selesaikan pesanan → status jadi Selesai
     */
    public function selesai(string $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => 'Selesai']);

        return back()->with('success', "Pesanan #{$pesanan->id} diselesaikan.");
    }
}
