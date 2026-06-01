<!-- ══ BOTTOM NAV (mobile) ══════════════════ -->
<nav class="bottom-nav">
  <a class="bn-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" data-page="dashboard">
    <i class="bi bi-cart3"></i>
    <span>Dashboard</span>
  </a>
  <a class="bn-item" data-page="inventory">
    <i class="bi bi-box-seam"></i>
    <span>Inventory</span>
  </a>
  <a class="bn-item" data-page="customers">
    <i class="bi bi-people"></i>
    <span>Customers</span>
  </a>
  <a class="bn-item" data-page="reports">
    <i class="bi bi-bar-chart-line"></i>
    <span>Reports</span>
  </a>
  <a class="bn-item" data-page="settings">
    <i class="bi bi-gear"></i>
    <span>Settings</span>
  </a>
</nav>