<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="icon" type="image/png" href="{{ asset('img/icon1.png') }}">
  <title>Pesanan Berhasil — Milkyway</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/pemesanan.css') }}">
  <style>
    .sukses-wrap {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 32px 16px;
    }
    .sukses-card {
      background: #fff;
      border-radius: 24px;
      padding: 48px 40px 40px;
      max-width: 480px;
      width: 100%;
      text-align: center;
      box-shadow: 0 16px 60px rgba(27,58,107,.13);
      animation: cardIn .55s cubic-bezier(.22,.68,0,1.2) both;
    }
    @keyframes cardIn {
      from { opacity:0; transform:translateY(32px) scale(.97); }
      to   { opacity:1; transform:translateY(0) scale(1); }
    }
    .sukses-icon {
      width: 80px; height: 80px;
      border-radius: 50%;
      background: linear-gradient(135deg, #22c55e, #16a34a);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 24px;
      font-size: 36px;
      color: #fff;
      box-shadow: 0 8px 24px rgba(34,197,94,.3);
      animation: popIn .6s .2s cubic-bezier(.22,.68,0,1.4) both;
    }
    @keyframes popIn {
      from { opacity:0; transform:scale(.5); }
      to   { opacity:1; transform:scale(1); }
    }
    .sukses-title {
      font-family: 'Nunito', sans-serif;
      font-size: 22px;
      font-weight: 800;
      color: #1b3a6b;
      margin-bottom: 10px;
    }
    .sukses-sub {
      font-size: 14px;
      color: #4a5e7a;
      line-height: 1.7;
      margin-bottom: 28px;
    }
    .sukses-order-id {
      display: inline-block;
      background: #f0fdf4;
      border: 1.5px solid #bbf7d0;
      border-radius: 10px;
      padding: 8px 20px;
      font-size: 13px;
      font-weight: 700;
      color: #16a34a;
      margin-bottom: 28px;
    }
    .sukses-divider {
      border: none;
      border-top: 1px solid #e8eef5;
      margin: 0 0 24px;
    }
    .sukses-contact-label {
      font-size: 12px;
      font-weight: 700;
      color: #4a5e7a;
      text-transform: uppercase;
      letter-spacing: .8px;
      margin-bottom: 12px;
    }
    .sukses-wa-btn {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: #25d366;
      color: #fff;
      border: none;
      border-radius: 14px;
      padding: 13px 28px;
      font-family: 'Nunito', sans-serif;
      font-size: 15px;
      font-weight: 700;
      text-decoration: none;
      transition: transform .18s, box-shadow .18s;
      box-shadow: 0 6px 20px rgba(37,211,102,.3);
      width: 100%;
      justify-content: center;
      margin-bottom: 12px;
    }
    .sukses-wa-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(37,211,102,.4);
      color: #fff;
    }
    .sukses-wa-btn i { font-size: 20px; }
    .sukses-wa-number {
      font-size: 13px;
      color: #4a5e7a;
      margin-bottom: 24px;
    }
    .sukses-back {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      color: #0096C8;
      font-size: 13.5px;
      font-weight: 600;
      text-decoration: none;
    }
    .sukses-back:hover { text-decoration: underline; color: #006e92; }
  </style>
</head>
<body>

<div class="bubbles" id="bubbles"></div>

<div class="sukses-wrap">
  <div class="sukses-card">

    {{-- Logo --}}
    <div class="mb-4">
      <img src="{{ asset('img/logo_potong.png') }}" alt="Milkyway" style="max-width:110px; height:auto;">
    </div>

    {{-- Ikon centang --}}
    <div class="sukses-icon">
      <i class="bi bi-check-lg"></i>
    </div>

    <div class="sukses-title">Terima kasih telah memesan!</div>

    <p class="sukses-sub">
      Pesanan Anda sudah kami terima dan sedang dalam proses konfirmasi.
      Kami akan menghubungi Anda melalui WhatsApp secepatnya.
    </p>

    @if(session('pesanan_id'))
      <div class="sukses-order-id">
        <i class="bi bi-receipt me-1"></i>
        Order ID: #MW-{{ str_pad(session('pesanan_id'), 4, '0', STR_PAD_LEFT) }}
      </div>
    @endif

    <hr class="sukses-divider">

    <p class="sukses-contact-label">Hubungi kami untuk informasi lebih lanjut</p>

    @php
      $adminNumber = env('FONNTE_ADMIN_NUMBER', '6285236596684');
      $waMsg = urlencode('Halo Milkyway, saya ingin menanyakan tentang pesanan saya.');
      $waLink = "https://wa.me/{$adminNumber}?text={$waMsg}";
      // Format nomor untuk tampilan: 628xxx → +62 8xxx
      $displayNumber = '+' . substr($adminNumber, 0, 2) . ' ' . substr($adminNumber, 2, 3) . '-' . substr($adminNumber, 5, 4) . '-' . substr($adminNumber, 9);
    @endphp

    <a href="{{ $waLink }}" target="_blank" class="sukses-wa-btn">
      <i class="bi bi-whatsapp"></i>
      Chat via WhatsApp
    </a>
    <p class="sukses-wa-number">{{ $displayNumber }}</p>

    <a href="/" class="sukses-back">
      <i class="bi bi-arrow-left"></i> Kembali ke Beranda
    </a>

  </div>
</div>

<script>
  // Bubble animasi dari pemesanan.css
  const wrap = document.getElementById('bubbles');
  if (wrap) {
    for (let i = 0; i < 8; i++) {
      const b = document.createElement('div');
      b.className = 'bubble';
      const size = 30 + Math.random() * 60;
      b.style.cssText = `width:${size}px;height:${size}px;left:${Math.random()*100}%;animation-duration:${6+Math.random()*8}s;animation-delay:${Math.random()*5}s`;
      wrap.appendChild(b);
    }
  }
</script>
</body>
</html>
