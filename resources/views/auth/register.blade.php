<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar — Milkyway</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="/css/auth.css">
</head>
<body class="auth-body">

  <div class="auth-wrapper">

    {{-- Panel kiri --}}
    <div class="auth-left d-none d-lg-flex">
      <div class="auth-left-top">
        <img src="{{ asset('img/logo_putih.png') }}" alt="Milkyway" class="auth-logo-white">
      </div>
    </div>

    {{-- Panel kanan --}}
    <div class="auth-right">
      <div class="auth-card">

        <div class="auth-card-logo d-lg-none mb-4">
          <img src="{{ asset('img/logo_fiks.png') }}" alt="Milkyway" style="max-width:140px;">
        </div>

        <div class="auth-card-header">
          <h3 class="auth-card-title">Buat Akun Baru</h3>
          <p class="auth-card-sub">Lengkapi data di bawah untuk mendaftar</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
          @csrf

          {{-- Name --}}
          <div class="auth-field">
            <label class="auth-label" for="name">Nama Lengkap</label>
            <div class="auth-input-wrap">
              <i class="bi bi-person auth-input-icon"></i>
              <input id="name" type="text" name="name" value="{{ old('name') }}"
                class="auth-input @error('name') is-invalid @enderror"
                placeholder="Nama Anda" required autofocus autocomplete="name">
            </div>
            @error('name')<div class="auth-error">{{ $message }}</div>@enderror
          </div>

          {{-- Email --}}
          <div class="auth-field">
            <label class="auth-label" for="email">Email</label>
            <div class="auth-input-wrap">
              <i class="bi bi-envelope auth-input-icon"></i>
              <input id="email" type="email" name="email" value="{{ old('email') }}"
                class="auth-input @error('email') is-invalid @enderror"
                placeholder="nama@email.com" required autocomplete="username">
            </div>
            @error('email')<div class="auth-error">{{ $message }}</div>@enderror
          </div>

          {{-- Password --}}
          <div class="auth-field">
            <label class="auth-label" for="password">Password</label>
            <div class="auth-input-wrap">
              <i class="bi bi-lock auth-input-icon"></i>
              <input id="password" type="password" name="password"
                class="auth-input @error('password') is-invalid @enderror"
                placeholder="Min. 8 karakter" required autocomplete="new-password">
              <button type="button" class="auth-eye" onclick="togglePwd('password', this)">
                <i class="bi bi-eye"></i>
              </button>
            </div>
            @error('password')<div class="auth-error">{{ $message }}</div>@enderror
          </div>

          {{-- Confirm Password --}}
          <div class="auth-field">
            <label class="auth-label" for="password_confirmation">Konfirmasi Password</label>
            <div class="auth-input-wrap">
              <i class="bi bi-lock-fill auth-input-icon"></i>
              <input id="password_confirmation" type="password" name="password_confirmation"
                class="auth-input @error('password_confirmation') is-invalid @enderror"
                placeholder="Ulangi password" required autocomplete="new-password">
              <button type="button" class="auth-eye" onclick="togglePwd('password_confirmation', this)">
                <i class="bi bi-eye"></i>
              </button>
            </div>
            @error('password_confirmation')<div class="auth-error">{{ $message }}</div>@enderror
          </div>

          <button type="submit" class="auth-btn-primary w-100 mt-2">
            <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
          </button>

          <p class="auth-footer-text mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="auth-link fw-600">Masuk di sini</a>
          </p>
        </form>
      </div>
    </div>

  </div>

  <script>
    function togglePwd(id, btn) {
      const input = document.getElementById(id);
      const icon  = btn.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
      } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
      }
    }
  </script>
</body>
</html>
