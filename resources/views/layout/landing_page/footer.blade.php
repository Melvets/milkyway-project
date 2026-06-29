<!-- ═══════════════════════════════════════
     FOOTER
════════════════════════════════════════ -->
<footer class="py-5" id="footer">
  <div class="container py-3">
    <div class="row g-5">

      <!-- Brand -->
      <div class="col-lg-4 col-md-6">
        <div class="mb-3"><img src="{{ asset('img/logo_putih.png') }}" alt="Logo Milkyway" style="max-width:160px; height:auto;"></div>
        <p>
          Milkyway hadir untuk mengubah persepsi susu kambing. Dari yang dianggap kurang, bau prengus, dan hanya untuk orang tua – menjadi pilihan yang tahu, sehat, dan dekat dengan Hidup Gen Z. Dari peternakan sendiri, kambing Saanen Swiss.
        </p>
      </div>

      <!-- Quick links -->
      <div class="col-lg-2 col-md-6 col-sm-6">
        <h6>Menu</h6>
        <ul>
          <li><a href="#hero">Home</a></li>
          <li><a href="#about">Our Story</a></li>
          <li><a href="#products">Product</a></li>
          <li><a href="#why">Benefit</a></li>
          <li><a href="#lokasi">Lokasi</a></li>
        </ul>
      </div>

      <!-- Products -->
      <div class="col-lg-2 col-md-6 col-sm-6">
        <h6>Produk</h6>
        <ul>
          @foreach ($produks as $p)
            <li><a href="{{ route('pesan.create') }}">{{ $p->nama }}</a></li>
          @endforeach
        </ul>
      </div>

      <!-- Contact -->
      <div class="col-lg-4 col-md-6">
        <h6>Kontak</h6>
        <div class="contact-item">
          <i class="bi bi-geo-alt-fill"></i>
          <span>Jl. Sapan Raya, Plamongan Indah – Pemesanan Khusus Kota Semarang</span>
        </div>
        <div class="contact-item">
          <i class="bi bi-whatsapp"></i>
          <span>+62 882-003-47409</span>
        </div>
        <div class="contact-item">
          <i class="bi bi-instagram"></i>
          <span>@milkywayindonesia_</span>
        </div>
        <div class="contact-item">
          <i class="bi bi-tiktok"></i>
          <span>@milkyway_indonesia</span>
        </div>
        <div class="contact-item">
          <i class="bi bi-envelope-fill"></i>
          <span>indonesiamilky@gmail.com</span>
        </div>
      </div>

    </div>

    <hr class="footer-divider mt-5 mb-3" />
    <p class="footer-bottom text-center mb-0">©2026 Milkyway. All rights reserved.</p>
  </div>
</footer>