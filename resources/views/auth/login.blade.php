<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — Milkyway</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="/css/auth.css">
</head>
<body class="auth-body">

  <div class="auth-wrapper">

    {{-- Panel kiri: ilustrasi --}}
    <div class="auth-left d-none d-lg-flex">
      <div class="auth-left-top">
        <img src="{{ asset('img/logo_putih.png') }}" alt="Milkyway" class="auth-logo-white">
      </div>
    </div>

    {{-- Panel kanan: form --}}
    <div class="auth-right">
      <div class="auth-card">

        <div class="auth-card-logo d-lg-none mb-4">
          <img src="{{ asset('img/logo_fiks.png') }}" alt="Milkyway" style="max-width:140px;">
        </div>

        <div class="auth-card-header">
          <h3 class="auth-card-title">Masuk ke Akun</h3>
          <p class="auth-card-sub">Masukkan email dan password Anda</p>
        </div>

        {{-- Session status --}}
        @if (session('status'))
          <div class="auth-alert auth-alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
          @csrf

          {{-- Email --}}
          <div class="auth-field">
            <label class="auth-label" for="email">Email</label>
            <div class="auth-input-wrap">
              <i class="bi bi-envelope auth-input-icon"></i>
              <input id="email" type="email" name="email" value="{{ old('email') }}"
                class="auth-input @error('email') is-invalid @enderror"
                placeholder="nama@email.com" required autofocus autocomplete="username">
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
                placeholder="••••••••" required autocomplete="current-password">
              <button type="button" class="auth-eye" onclick="togglePwd('password', this)">
                <i class="bi bi-eye"></i>
              </button>
            </div>
            @error('password')<div class="auth-error">{{ $message }}</div>@enderror
          </div>

          {{-- Remember + Forgot --}}
          <div class="d-flex align-items-center justify-content-between mb-4">
            <label class="auth-check">
              <input type="checkbox" name="remember" id="remember_me">
              <span>Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="auth-link">Lupa password?</a>
            @endif
          </div>

          <button type="submit" class="auth-btn-primary w-100">
            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
          </button>

          <p class="auth-footer-text mt-4">
            Belum punya akun?
            @if(config('app.register_token'))
              <a href="{{ route('register') }}?token={{ config('app.register_token') }}" class="auth-link fw-600">Daftar sekarang</a>
            @else
              <span style="font-size:13px; color:#4a5e7a;">Hubungi admin untuk mendaftar</span>
            @endif
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
