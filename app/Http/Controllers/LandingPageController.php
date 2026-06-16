<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class LandingPageController extends Controller
{
    public function index()
    {
        $produks = Produk::with('varian')->get();
        return view('index', compact('produks'));
    }
}
