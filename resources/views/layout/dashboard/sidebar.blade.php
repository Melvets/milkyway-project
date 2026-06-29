<!-- ══ SIDEBAR ══════════════════════════════ -->
<aside id="sidebar">
  <div class="sidebar-brand">
    <div>
      <div class="mb-1"><img src="{{ asset('img/logo_fiks.png') }}" alt="Logo Milkyway" style="max-width:160px; height:auto;"></div>
      <p class="sidebar-brand-desc m-0">Aplikasi manajemen penjualan susu kambing</p>
    </div>
    <button class="sidebar-close" id="sidebarClose"><i class="bi bi-x-lg"></i></button>
  </div>

  <hr class="sidebar-divider">

  {{-- PROFILE CARD --}}
  <div class="sidebar-profile">
    <div class="sidebar-profile-avatar-wrap">
      <img
        src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6c63ff&color=fff&size=64&bold=true&rounded=true"
        alt="Avatar"
        class="sidebar-profile-avatar"
      >
      <span class="sidebar-profile-online-dot"></span>
    </div>
    <div class="sidebar-profile-info">
      <span class="sidebar-profile-name">{{ auth()->user()->name }}</span>
      <span class="sidebar-profile-status">● Online</span>
    </div>
  </div>

  <nav class="sidebar-nav">
    <a class="nav-item-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
      <i class="bi bi-house"></i> Dashboard
    </a>
    <a class="nav-item-link {{ request()->routeIs('orders*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
      <i class="bi bi-cart3"></i> Orders
    </a>
    <a class="nav-item-link {{ request()->routeIs('produk*') ? 'active' : '' }}" href="/dashboard/produk" data-page="produk">
      <i class="bi bi-box-seam"></i> Produk
    </a>
  </nav>

  <div class="sidebar-footer">

    {{-- PROFILE --}}
    <a class="nav-item-link {{ request()->routeIs('profile*') ? 'active' : '' }}" href="{{ route('profile.edit') }}" data-page="profile">
      <i class="bi bi-gear"></i> Profile
    </a>

    {{-- LOGOUT --}}
    <form action="/logout" method="POST">
        @csrf
        <button type="submit" class="btn nav-item-link logout">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>

  </div>
</aside>