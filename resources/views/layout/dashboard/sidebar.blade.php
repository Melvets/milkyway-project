<!-- ══ SIDEBAR ══════════════════════════════ -->
<aside id="sidebar">
  <div class="sidebar-brand">
    <div>
      <div class="brand-name">Milkyway<br/><span>Admin</span></div>
      <div class="brand-sub">Modern Purity · Susu Kambing</div>
    </div>
    <button class="sidebar-close" id="sidebarClose"><i class="bi bi-x-lg"></i></button>
  </div>

  <nav class="sidebar-nav">
    <a class="nav-item-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
      <i class="bi bi-cart3"></i> Dashboard
    </a>
    <a class="nav-item-link {{ request()->routeIs('orders*') ? 'active' : '' }}" data-page="orders">
      <i class="bi bi-cart3"></i> Orders
    </a>
    <a class="nav-item-link {{ request()->routeIs('produk*') ? 'active' : '' }}" href="/dashboard/produk" data-page="produk">
      <i class="bi bi-box-seam"></i> Produk
    </a>
    <a class="nav-item-link {{ request()->routeIs('customers*') ? 'active' : '' }}" data-page="customers">
      <i class="bi bi-people"></i> Customers
    </a>
    <a class="nav-item-link {{ request()->routeIs('reports*') ? 'active' : '' }}" data-page="reports">
      <i class="bi bi-bar-chart-line"></i> Reports
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