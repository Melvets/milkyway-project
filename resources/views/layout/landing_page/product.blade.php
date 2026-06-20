<!-- Wave: About (white) → Products (sky2) -->
<div style="line-height:0; background:#fff;">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 72" preserveAspectRatio="none" style="display:block; width:100%; height:72px;">
        <path fill="#C8F3FA" d="M0,36 C240,72 480,0 720,36 C960,72 1200,0 1440,36 L1440,72 L0,72 Z"/>
    </svg>
</div>

<!-- ═══════════════════════════════════════
     PRODUCTS
════════════════════════════════════════ -->
<section class="section-products" id="products">

  <div class="container">

    {{-- Header --}}
    <div class="text-center mb-5">
      <p class="prod-label-top">VARIAN PILIHAN</p>
      <h2 class="prod-title">Pilihan Produk <em>Milkyway</em></h2>
      <p class="prod-subtitle">
        Varian terbaik dari peternakan sendiri, langsung ke tanganmu.
      </p>
    </div>

    {{-- Product Cards --}}
    <div class="prod-scroll-wrap">
      <div class="prod-cards-row">

        @forelse ($produks as $produk)
          @php $isBs = $produk->status === 'best seller'; @endphp
          <div class="prod-card {{ $isBs ? 'prod-card--dark' : '' }}">

            {{-- Badge --}}
            @if ($isBs)
              <span class="prod-badge prod-badge--bs">⭐ BEST SELLER</span>
            @elseif ($produk->status === 'new')
              <span class="prod-badge prod-badge--new">✦ NEW</span>
            @endif

            {{-- Gambar --}}
            <div class="prod-img-wrap {{ $isBs ? 'prod-img-wrap--dark' : '' }}">
              @if ($produk->gambar)
                <img src="{{ asset($produk->gambar) }}" alt="{{ $produk->nama }}">
              @else
                <img src="img/produk/produk_original.png" alt="{{ $produk->nama }}">
              @endif
            </div>

            {{-- Info --}}
            <div class="prod-name {{ $isBs ? 'prod-name--light' : '' }}">{{ $produk->nama }}</div>
            <div class="prod-desc {{ $isBs ? 'prod-desc--light' : '' }}">
              {{ $produk->deskripsi ?? 'Susu kambing segar berkualitas tinggi' }}
            </div>

            {{-- Harga --}}
            <div class="prod-price {{ $isBs ? 'prod-price--light' : '' }}">
              @forelse ($produk->varian as $i => $v)
                @if ($i === 0)
                  Rp{{ number_format($v->harga, 0, ',', '.') }}
                @endif
              @empty
                —
              @endforelse
            </div>
            <div class="prod-price-sub {{ $isBs ? 'prod-price-sub--light' : '' }}">
              @forelse ($produk->varian as $v)
                {{ $v->ukuran }}@if (!$loop->last) · @endif
              @empty
                &nbsp;
              @endforelse
            </div>

            {{-- Tombol --}}
            <a href="{{ route('pesan.create') }}"
              class="prod-btn {{ $isBs ? 'prod-btn--light' : '' }}">
              Beli Sekarang
            </a>

          </div>
        @empty
          <p style="color:#4a5e7a; text-align:center; width:100%;">Produk belum tersedia.</p>
        @endforelse

      </div>
    </div>

    {{-- Footer note --}}
    <div class="prod-footer-wrap">
      <div class="prod-footer-note">
        <span>🧡 Pengiriman khusus Kota Semarang</span>
        <span class="prod-sep">·</span>
        <span>✅ Segar Garansi</span>
      </div>
    </div>

  </div>
</section>

<script>
(function () {
  const cards = document.querySelectorAll('.prod-card');
  const io = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        // delay bertahap tiap card
        const idx = Array.from(cards).indexOf(entry.target);
        setTimeout(() => {
          entry.target.classList.add('prod-visible');
        }, idx * 80);
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  cards.forEach(card => io.observe(card));
})();
</script>
