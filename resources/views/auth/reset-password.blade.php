<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password — Milkyway</title>
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

        {{-- Icon --}}
        <div class="auth-icon-wrap mb-3">
          <i class="bi bi-shield-lock-fill"></i>
        </div>

        <div class="auth-card-header">
          <h3 class="auth-card-title">Buat Password Baru</h3>
          <p class="auth-card-sub">Masukkan password baru untuk akun Anda</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
          @csrf
          <input type="hidden" name="token" value="{{ $request->route('token') }}">

          {{-- Email --}}
          <div class="auth-field">
            <label class="auth-label" for="email">Email</label>
            <div class="auth-input-wrap">
              <i class="bi bi-envelope auth-input-icon"></i>
              <input id="email" type="email" name="email"
                value="{{ old('email', $request->email) }}"
                class="auth-input @error('email') is-invalid @enderror"
                placeholder="nama@email.com" required autofocus autocomplete="username">
            </div>
            @error('email')<div class="auth-error">{{ $message }}</div>@enderror
          </div>

          {{-- Password baru --}}
          <div class="auth-field">
            <label class="auth-label" for="password">Password Baru</label>
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

          {{-- Konfirmasi password --}}
          <div class="auth-field">
            <label class="auth-label" for="password_confirmation">Konfirmasi Password</label>
            <div class="auth-input-wrap">
              <i class="bi bi-lock-fill auth-input-icon"></i>
              <input id="password_confirmation" type="password" name="password_confirmation"
                class="auth-input @error('password_confirmation') is-invalid @enderror"
                placeholder="Ulangi password baru" required autocomplete="new-password">
              <button type="button" class="auth-eye" onclick="togglePwd('password_confirmation', this)">
                <i class="bi bi-eye"></i>
              </button>
            </div>
            @error('password_confirmation')<div class="auth-error">{{ $message }}</div>@enderror
          </div>

          <button type="submit" class="auth-btn-primary w-100 mt-2">
            <i class="bi bi-check2-circle me-2"></i>Reset Password
          </button>

          <p class="auth-footer-text mt-4">
            <a href="{{ route('login') }}" class="auth-link fw-600">
              <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
            </a>
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
