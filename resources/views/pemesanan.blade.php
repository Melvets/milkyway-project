<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Pemesanan - Milkyway Susu Kambing</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/pemesanan.css') }}">
</head>
<body>

<div class="bubbles" id="bubbles"></div>

<div class="page-wrap">

  <div class="logo-wrap">
    <div class="logo-box">
      <div class=""><img src="{{ asset('img/logo_potong.png') }}" alt="Logo Milkyway"></div>
    </div>
  </div>

  <div class="page-title">FORM PEMESANAN MILKYWAY</div>
  <div class="title-line"></div>

  {{-- DATA DIRI --}}
  <div class="form-card" data-delay="0">
    <div class="section-label">Data Diri</div>
    <div class="mb-3">
      <input type="text" id="nama" class="form-control" placeholder="Nama Lengkap"/>
    </div>
    <div class="mb-3">
      <input type="tel" id="hp" class="form-control" placeholder="Nomor HP (WhatsApp)"/>
    </div>
    <div class="mb-0">
      <input type="text" id="alamat" class="form-control" placeholder="Alamat pengiriman (Pemesanan khusus Kota Semarang)"/>
    </div>
  </div>

  {{-- PILIH PRODUK & VARIAN --}}
  <div class="form-card" data-delay="120">
    <div class="section-label">Pilih Produk</div>

    {{-- Dropdown 1: Produk --}}
    <div class="mb-3">
      <select id="produk" class="form-select" onchange="loadVarian(this)">
        <option value="" disabled selected>-- Pilih Produk --</option>
        @foreach ($produks as $p)
          <option value="{{ $p->id }}">{{ $p->nama }}</option>
        @endforeach
      </select>
    </div>

    {{-- Dropdown 2: Varian (muncul setelah produk dipilih) --}}
    <div class="mb-3" id="varian-wrap" style="display:none;">
      <select id="varian" class="form-select">
        <option value="" disabled selected>-- Pilih Ukuran --</option>
      </select>
    </div>

    {{-- Data varian per produk (disimpan di JS) --}}
    <script>
      const varianData = {
        @foreach ($produks as $p)
          {{ $p->id }}: [
            @foreach ($p->varian as $v)
              { id: {{ $v->id }}, ukuran: "{{ $v->ukuran }}", harga: {{ $v->harga }} },
            @endforeach
          ],
        @endforeach
      };
    </script>

    <div class="d-flex align-items-center gap-3 varian-row">
      <div class="qty-wrap">
        <button class="qty-btn" onclick="changeQty(-1)">−</button>
        <input type="number" id="qty" class="qty-val" value="1" min="1" max="99"/>
        <button class="qty-btn" onclick="changeQty(1)">+</button>
      </div>
      <button class="btn-tambah" onclick="tambahPesanan()">
        <i class="bi bi-cart-plus-fill"></i> Tambah
      </button>
    </div>
  </div>

  {{-- LIST PESANAN --}}
  <div class="form-card" data-delay="240">
    <div class="section-label">List Pesanan</div>
    <div id="orderList">
      <div class="order-empty" id="emptyMsg">Belum ada pesanan. Pilih varian di atas.</div>
    </div>
    <div class="order-total d-none" id="totalRow">
      <span class="order-total-label">Total</span>
      <span class="order-total-val" id="totalVal">Rp 0</span>
    </div>
  </div>

  <button class="btn-pesan" id="btnPesan" onclick="pesanSekarang(this, event)">
    <i class="bi bi-whatsapp me-2"></i>Pesan Sekarang
  </button>
  <div class="d-flex justify-content-center">
    <a class="btn-kembali mt-3" href="/"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
  </div>

  <footer>©2026 Milkyway. All rights reserved.</footer>
</div>

<div class="toast-box" id="toast"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/pemesanan.js') }}"></script>
</body>
</html>
