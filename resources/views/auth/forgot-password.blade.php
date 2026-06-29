<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password — Milkyway</title>
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
          <i class="bi bi-lock-fill"></i>
        </div>

        <div class="auth-card-header">
          <h3 class="auth-card-title">Lupa Password?</h3>
          <p class="auth-card-sub">Masukkan email Anda dan kami akan mengirimkan link untuk reset password.</p>
        </div>

        {{-- Status --}}
        @if (session('status'))
          <div class="auth-alert auth-alert-success mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
          </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
          @csrf

          <div class="auth-field">
            <label class="auth-label" for="email">Alamat Email</label>
            <div class="auth-input-wrap">
              <i class="bi bi-envelope auth-input-icon"></i>
              <input id="email" type="email" name="email" value="{{ old('email') }}"
                class="auth-input @error('email') is-invalid @enderror"
                placeholder="nama@email.com" required autofocus>
            </div>
            @error('email')<div class="auth-error">{{ $message }}</div>@enderror
          </div>

          <button type="submit" class="auth-btn-primary w-100 mt-2">
            <i class="bi bi-send me-2"></i>Kirim Link Reset Password
          </button>

          <p class="auth-footer-text mt-4">
            Ingat password? <a href="{{ route('login') }}" class="auth-link fw-600">Kembali ke Login</a>
          </p>
        </form>
      </div>
    </div>

  </div>

</body>
</html>
