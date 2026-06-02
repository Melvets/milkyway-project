<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\ProdukVarian;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::with('varian')->latest()->paginate(10);
        return view('layout.dashboard.produk.main', compact('produks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layout.dashboard.produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'              => 'required|string|max:255',
            'deskripsi'         => 'nullable|string',
            'gambar'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'            => 'required|in:new,best seller,default',
            'varians'           => 'nullable|array',
            'varians.*.ukuran'  => 'required_with:varians|string|max:100',
            'varians.*.harga'   => 'required_with:varians|integer|min:0',
        ]);
 
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('produk'), $filename);
            $gambarPath = 'produk/' . $filename;
        }
 
        $produk = Produk::create([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'gambar'    => $gambarPath,
            'status'    => $request->status,
        ]);
 
        if ($request->filled('varians')) {
            $varians = collect($request->varians)->map(fn($v) => [
                'produk_id'  => $produk->id,
                'ukuran'     => $v['ukuran'],
                'harga'      => $v['harga'],
                'created_at' => now(),
                'updated_at' => now(),
            ])->toArray();
 
            ProdukVarian::insert($varians);
        }
 
        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Produk::with('varian')->findOrFail($id);
        return view('layout.dashboard.produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produk = Produk::with('varian')->findOrFail($id);

        $request->validate([
            'nama'              => 'required|string|max:255',
            'deskripsi'         => 'nullable|string',
            'gambar'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'            => 'required|in:new,best seller,default',
            'varians'           => 'nullable|array',
            'varians.*.ukuran'  => 'required_with:varians|string|max:100',
            'varians.*.harga'   => 'required_with:varians|integer|min:0',
        ]);

        // Update gambar jika ada file baru
        $gambarPath = $produk->gambar;
        if ($request->hasFile('gambar')) {
            if ($gambarPath && file_exists(public_path($gambarPath))) {
                unlink(public_path($gambarPath));
            }
            $file = $request->file('gambar');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('produk'), $filename);
            $gambarPath = 'produk/' . $filename;
        }

        $produk->update([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'gambar'    => $gambarPath,
            'status'    => $request->status,
        ]);

        // Hapus semua varian lama, insert yang baru
        $produk->varian()->delete();

        if ($request->filled('varians')) {
            $varians = collect($request->varians)
                ->filter(fn($v) => !empty($v['ukuran']))
                ->map(fn($v) => [
                    'produk_id'  => $produk->id,
                    'ukuran'     => $v['ukuran'],
                    'harga'      => $v['harga'] ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])->toArray();

            if (!empty($varians)) {
                ProdukVarian::insert($varians);
            }
        }

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->gambar && file_exists(public_path($produk->gambar))) {
            unlink(public_path($produk->gambar));
        }

        $produk->delete(); // cascade hapus varian otomatis

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
