<!-- ═══════════════════════════════════════
     PRODUCTS
════════════════════════════════════════ -->
<section class="section-products py-5 py-lg-6" id="products">
  <div class="prod-dot-grid"></div>
  <div class="prod-deco prod-deco-1"></div>
  <div class="prod-deco prod-deco-2"></div>
  <div class="prod-deco prod-deco-3"></div>
  <div class="prod-deco prod-deco-4"></div>

  <div class="container py-4" style="position:relative;z-index:1;">
    <div class="text-center mb-5">
      <p class="section-label">Varian Pilihan</p>
      <h2 class="section-title">Pilihan Produk <span class="accent">Milkyway</span></h2>
      <div class="divider-line mx-auto"></div>
      <p style="color:rgba(255,255,255,.65);font-size:.92rem;max-width:480px;margin:0 auto;">
        Varian terbaik dari peternakan sendiri, segar dan bermutu — langsung ke tanganmu.
      </p>
    </div>

    <div class="products-layout">

      @forelse ($produks as $produk)
        <div>
          <div class="product-card {{ $produk->status === 'best seller' ? 'bestseller' : '' }}"
            style="display:flex; flex-direction:column; height:100%;">

            {{-- Badge status (fixed height area) --}}
            <div style="min-height:28px; margin-bottom:4px;">
              @if ($produk->status === 'best seller')
                <span class="badge-bestseller">⭐ Best Seller</span>
              @elseif ($produk->status === 'new')
                <span class="badge-bestseller" style="background: linear-gradient(135deg, #00c853, #1de9b6); color:#fff;">✨ New</span>
              @endif
            </div>

            {{-- Gambar (fixed height) --}}
            <div style="height:160px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
              @if ($produk->gambar)
                <img src="{{ asset($produk->gambar) }}" alt="{{ $produk->nama }}"
                  style="max-height:160px; max-width:100%; object-fit:contain;" />
              @else
                <img src="https://images.unsplash.com/photo-1563636619-e9143da7973b?w=300&q=80"
                  alt="{{ $produk->nama }}"
                  style="max-height:160px; max-width:100%; object-fit:contain;" />
              @endif
            </div>

            {{-- Nama --}}
            <div class="product-name" style="margin-top:12px;">{{ $produk->nama }}</div>

            {{-- Deskripsi (flex-grow agar mendorong harga & tombol ke bawah) --}}
            <div class="product-desc mb-3" style="flex:1;">
              {{ $produk->deskripsi ?? 'Susu kambing segar berkualitas tinggi' }}
            </div>

            {{-- Harga --}}
            <div class="product-price" style="min-height:44px;">
              @forelse ($produk->varian as $v)
                Rp{{ number_format($v->harga, 0, ',', '.') }}/{{ $v->ukuran }}<br>
              @empty
                <span style="font-size:.8rem; opacity:.7;">Hubungi untuk harga</span>
              @endforelse
            </div>

            {{-- Tombol selalu di bawah --}}
            <a href="{{ route('pesan.create') }}" class="btn-beli" style="margin-top:auto;">
              {{ $produk->status === 'best seller' ? '🛒 ' : '' }}Beli Sekarang
            </a>

          </div>
        </div>
      @empty
        <div class="text-center w-100" style="color:rgba(255,255,255,.65);">
          Produk belum tersedia.
        </div>
      @endforelse

    </div>

    <div class="text-center mt-5">
      <p style="color:rgba(255,255,255,.65);font-size:.88rem;margin-bottom:2rem;">
        <i class="bi bi-truck me-1" style="color:var(--amber)"></i>
        Pengiriman khusus Kota Semarang &nbsp;·&nbsp;
        <i class="bi bi-shield-check me-1" style="color:var(--amber)"></i>
        Segar Garansi
      </p>
      <a href="{{ route('pesan.create') }}" class="btn-primary-brand" style="font-size:1rem;">
        <i class="bi bi-cart me-2"></i>Pesan Sekarang
      </a>
    </div>

  </div>
</section>
