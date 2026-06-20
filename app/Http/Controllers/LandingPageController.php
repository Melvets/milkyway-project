<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class LandingPageController extends Controller
{
    public function index()
    {
        // Urutkan: best seller → new → default
        $produks = Produk::with('varian')
            ->orderByRaw("FIELD(status, 'best seller', 'new', 'default')")
            ->get();

        return view('index', compact('produks'));
    }
}
