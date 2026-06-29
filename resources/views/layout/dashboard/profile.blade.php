@extends('dashboard')

@section('title', 'Profile - ' . config('app.name'))

@section('container')

  <!-- Topbar -->
  <div class="topbar">
    <button class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></button>
    <div class="search-box">
      <i class="bi bi-search"></i>
      <input type="text" placeholder="Search data"/>
    </div>
    <div class="topbar-right">
      <div class="user-chip">
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
        <span class="user-chip-name">{{ Auth::user()->name }}</span>
      </div>
    </div>
  </div>

  <div class="page">

    <!-- Page Header -->
    <div class="page-header">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item page-date">
            <a href="/dashboard" style="color:#4a5e7a; text-decoration:none">Dashboard</a>
          </li>
          <li class="breadcrumb-item page-date active" style="color:#FFB201">Profile</li>
        </ol>
      </nav>
      <h2>Pengaturan <span class="page-name">Akun</span></h2>
      <p class="page-desc">Kelola informasi profil dan keamanan akun Anda.</p>
    </div>

    <div class="row g-4">

      {{-- ── Forms column (kiri) ── --}}
      <div class="col-12 col-lg-8 order-2 order-lg-1">

        {{-- Update Profile Info --}}
        <div class="profile-section-card mb-4">
          <div class="profile-section-header">
            <div class="profile-section-icon"><i class="bi bi-person-fill"></i></div>
            <div>
              <div class="profile-section-title">Informasi Profil</div>
              <div class="profile-section-sub">Perbarui nama dan alamat email akun Anda</div>
            </div>
          </div>

          <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

          <form method="post" action="{{ route('profile.update') }}" class="profile-form">
            @csrf
            @method('patch')

            <div class="profile-field">
              <label class="profile-label" for="name">Nama Lengkap</label>
              <div class="profile-input-wrap">
                <i class="bi bi-person profile-input-icon"></i>
                <input id="name" name="name" type="text"
                  value="{{ old('name', $user->name) }}"
                  class="profile-input @error('name') is-invalid @enderror"
                  required autofocus autocomplete="name">
              </div>
              @error('name')<div class="profile-error">{{ $message }}</div>@enderror
            </div>

            <div class="profile-field">
              <label class="profile-label" for="email">Email</label>
              <div class="profile-input-wrap">
                <i class="bi bi-envelope profile-input-icon"></i>
                <input id="email" name="email" type="email"
                  value="{{ old('email', $user->email) }}"
                  class="profile-input @error('email') is-invalid @enderror"
                  required autocomplete="username">
              </div>
              @error('email')<div class="profile-error">{{ $message }}</div>@enderror

              @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2" style="font-size:12px; color:#b37a00; background:rgba(255,178,1,.1); padding:8px 12px; border-radius:8px;">
                  Email belum terverifikasi.
                  <button form="send-verification"
                    style="background:none; border:none; color:var(--primary); font-size:12px; padding:0; cursor:pointer; text-decoration:underline;">
                    Kirim ulang verifikasi
                  </button>
                  @if (session('status') === 'verification-link-sent')
                    <span style="color:#2e9c4e; display:block; margin-top:4px;">Link verifikasi telah dikirim.</span>
                  @endif
                </div>
              @endif
            </div>

            <div class="d-flex align-items-center gap-3">
              <button type="submit" class="profile-btn-primary">
                <i class="bi bi-check2 me-1"></i>Simpan Perubahan
              </button>
              @if (session('status') === 'profile-updated')
                <span class="profile-saved-msg"><i class="bi bi-check-circle-fill me-1"></i>Tersimpan!</span>
              @endif
            </div>
          </form>
        </div>

        {{-- Update Password --}}
        <div class="profile-section-card mb-4">
          <div class="profile-section-header">
            <div class="profile-section-icon profile-section-icon--yellow"><i class="bi bi-lock-fill"></i></div>
            <div>
              <div class="profile-section-title">Ubah Password</div>
              <div class="profile-section-sub">Gunakan password yang panjang dan unik</div>
            </div>
          </div>

          <form method="post" action="{{ route('password.update') }}" class="profile-form">
            @csrf
            @method('put')

            <div class="profile-field">
              <label class="profile-label" for="current_password">Password Saat Ini</label>
              <div class="profile-input-wrap">
                <i class="bi bi-lock profile-input-icon"></i>
                <input id="current_password" name="current_password" type="password"
                  class="profile-input @error('current_password', 'updatePassword') is-invalid @enderror"
                  placeholder="••••••••" autocomplete="current-password">
              </div>
              @error('current_password', 'updatePassword')
                <div class="profile-error">{{ $message }}</div>
              @enderror
            </div>

            <div class="row g-3">
              <div class="col-12 col-sm-6">
                <div class="profile-field mb-0">
                  <label class="profile-label" for="new_password">Password Baru</label>
                  <div class="profile-input-wrap">
                    <i class="bi bi-key profile-input-icon"></i>
                    <input id="new_password" name="password" type="password"
                      class="profile-input @error('password', 'updatePassword') is-invalid @enderror"
                      placeholder="Min. 8 karakter" autocomplete="new-password">
                  </div>
                  @error('password', 'updatePassword')
                    <div class="profile-error">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <div class="profile-field mb-0">
                  <label class="profile-label" for="password_confirmation">Konfirmasi Password</label>
                  <div class="profile-input-wrap">
                    <i class="bi bi-key-fill profile-input-icon"></i>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                      class="profile-input @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                      placeholder="Ulangi password" autocomplete="new-password">
                  </div>
                </div>
              </div>
            </div>

            <div class="d-flex align-items-center gap-3 mt-4">
              <button type="submit" class="profile-btn-primary">
                <i class="bi bi-shield-lock me-1"></i>Update Password
              </button>
              @if (session('status') === 'password-updated')
                <span class="profile-saved-msg"><i class="bi bi-check-circle-fill me-1"></i>Password diperbarui!</span>
              @endif
            </div>
          </form>
        </div>

        {{-- Delete Account --}}
        <div class="profile-section-card profile-section-card--danger">
          <div class="profile-section-header">
            <div class="profile-section-icon profile-section-icon--red"><i class="bi bi-trash3-fill"></i></div>
            <div>
              <div class="profile-section-title" style="color:#c62828;">Hapus Akun</div>
              <div class="profile-section-sub">Tindakan ini tidak dapat dibatalkan</div>
            </div>
          </div>
          <p style="font-size:13px; color:#4a5e7a; margin-bottom:16px;">
            Setelah akun dihapus, semua data akan hilang secara permanen. Pastikan sudah mengunduh data yang dibutuhkan.
          </p>

          {{-- Trigger modal --}}
          <button type="button" class="profile-btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="bi bi-trash3 me-1"></i>Hapus Akun Saya
          </button>
        </div>

      </div>{{-- end forms col --}}

      {{-- ── Avatar Card (kanan) ── --}}
      <div class="col-12 col-lg-4 order-1 order-lg-2">
        <div class="profile-avatar-card">
          <div class="profile-avatar-wrap">
            <div class="profile-avatar-circle">
              {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <span class="profile-online-dot"></span>
          </div>
          <div class="profile-avatar-name">{{ Auth::user()->name }}</div>
          <div class="profile-avatar-email">{{ Auth::user()->email }}</div>
          <div class="profile-avatar-badge">
            <i class="bi bi-shield-check me-1"></i>Admin
          </div>
        </div>
      </div>

    </div>
  </div>

  {{-- ── Delete Modal ── --}}
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius:16px; overflow:hidden; border:none;">
        <div class="modal-header" style="background:#fdecea; border-bottom:1px solid #f5c6cb;">
          <h5 class="modal-title" id="deleteModalLabel" style="color:#c62828; font-weight:700;">
            <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus Akun
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form method="post" action="{{ route('profile.destroy') }}">
          @csrf
          @method('delete')
          <div class="modal-body p-4">
            <p style="font-size:13.5px; color:#4a5e7a; margin-bottom:16px;">
              Masukkan password Anda untuk mengonfirmasi penghapusan akun secara permanen.
            </p>
            <label class="profile-label" for="delete_password">Password</label>
            <div class="profile-input-wrap">
              <i class="bi bi-lock profile-input-icon"></i>
              <input id="delete_password" name="password" type="password"
                class="profile-input @error('password', 'userDeletion') is-invalid @enderror"
                placeholder="••••••••">
            </div>
            @error('password', 'userDeletion')
              <div class="profile-error">{{ $message }}</div>
            @enderror
          </div>
          <div class="modal-footer" style="border-top:1px solid #f5c6cb;">
            <button type="button" class="btn btn-sm btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="profile-btn-danger">
              <i class="bi bi-trash3 me-1"></i>Ya, Hapus Akun
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Open modal if there are deletion errors --}}
  @if ($errors->userDeletion->isNotEmpty())
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
      });
    </script>
  @endif

@endsection
