<!-- Wave: Why/Benefit (white) → Lokasi (sky2) -->
<div style="line-height:0; background:#fff;">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 72" preserveAspectRatio="none" style="display:block; width:100%; height:72px;">
        <path fill="#C8F3FA" d="M0,36 C360,0 720,72 1080,36 C1260,18 1380,54 1440,36 L1440,72 L0,72 Z"/>
    </svg>
</div>

<!-- ═══════════════════════════════════════
     LOKASI
════════════════════════════════════════ -->
<section class="section-testimoni" id="lokasi">
  <div class="container">
    <div class="text-center mb-5">
      <p class="section-label">Temukan Kami</p>
      <h2 class="section-title">Lokasi <span class="accent"><em style="font-family: 'Caveat Brush', cursive; font-weight: 500; font-style: normal;">Milkyway</em></span></h2>
      <div class="divider-line mx-auto"></div>
      <p class="testi-subtitle">Kunjungi langsung toko kami atau hubungi untuk pemesanan.</p>
    </div>

    <div class="row g-4 align-items-stretch justify-content-center">

      {{-- Map --}}
      <div class="col-lg-8">
        <div style="border-radius:20px; overflow:hidden; box-shadow:0 8px 32px rgba(0,150,200,.18); height:400px;">
          <div id="milkyway-map" style="width:100%; height:100%;"></div>
        </div>
      </div>

      {{-- Info --}}
      <div class="col-lg-4">
        <div class="testi-card h-100 d-flex flex-column justify-content-between" style="padding:28px;">
          <div>
            <div class="testi-stars mb-3"><i class="bi bi-geo-alt-fill" style="color:var(--primary); font-size:1.8rem;"></i></div>
            <div class="testi-name mb-1" style="font-size:1.1rem;">Milkyway</div>
            <p class="testi-role mb-4" style="font-size:.85rem; line-height:1.6; color:var(--gray);">
              Jl. Sapen Raya, RT.5/RW.5,<br>
              Tlogomulyo, Pedurungan,<br>
              Kota Semarang, Jawa Tengah
            </p>

            <div class="d-flex align-items-center gap-2 mb-3">
              <i class="bi bi-telephone-fill" style="color:var(--primary);"></i>
              <span style="font-size:.88rem; color:var(--navy);">+62 882-003-47409</span>
            </div>
            <div class="d-flex align-items-center gap-2 mb-3">
              <i class="bi bi-clock-fill" style="color:var(--primary);"></i>
              <span style="font-size:.88rem; color:var(--navy);">Buka setiap hari</span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-geo-alt-fill" style="color:var(--primary);"></i>
              <span style="font-size:.88rem; color:var(--navy); font-weight:600;">Kota Semarang</span>
            </div>
          </div>

          <div class="mt-4">
            <a href="/pesan-sekarang" class="btn-primary-brand d-block text-center">
              <i class="bi bi-cart me-2"></i>Pesan Sekarang
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- Leaflet CSS & JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const lat = -6.9956, lng = 110.4625; // Jl. Sapen Raya, Tlogomulyo, Pedurungan, Semarang

    const map = L.map('milkyway-map', { scrollWheelZoom: false }).setView([lat, lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      maxZoom: 19,
    }).addTo(map);

    const icon = L.divIcon({
      html: '<div style="background:var(--primary,#0096C8);width:36px;height:36px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid #fff;box-shadow:0 4px 12px rgba(0,150,200,.4);"></div>',
      iconSize: [36, 36],
      iconAnchor: [18, 36],
      popupAnchor: [0, -38],
      className: '',
    });

    L.marker([lat, lng], { icon })
      .addTo(map)
      .bindPopup('<strong>Milkyway</strong><br>Jl. Sapen Raya, RT.5/RW.5<br>Tlogomulyo, Pedurungan, Semarang')
      .openPopup();
  });
</script>
