@extends('dashboard')

@section('title', 'Dashboard - Milkyway')

@section('container')

  <!-- Topbar -->
  <div class="topbar">
      <button class="menu-toggle" id="menuToggle">
        <i class="bi bi-list"></i>
      </button>
      <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Search data"/>
      </div>
      <div class="topbar-right">
        <div class="topbar-icon">
          <i class="bi bi-bell"></i>
          <span class="badge-dot"></span>
        </div>
        <div class="topbar-icon" style="display:none" id="topSearchBtn">
          <i class="bi bi-search"></i>
        </div>
        <div class="topbar-icon">
          <i class="bi bi-question-circle"></i>
        </div>
        <div class="user-chip">
          <div class="user-avatar">AM</div>
          <span class="user-chip-name">{{ Auth::user()->name }}</span>
        </div>
      </div>
    </div>

    <!-- Page -->
    <div class="page">

      <!-- Page Header -->
      <div class="page-header">
        <div class="page-date" id="page-date">Sabtu · 30 Mei · 2026</div>
        <h2>Selamat datang, <span class="page-name">{{ Auth::user()->name }}</span></h2>
        <p class="page-desc">Total pesanan hari ini <strong class="highlight-green">+12%</strong> dibanding kemarin. Stok produk masih aman dan 3 pengiriman baru masuk pagi ini.</p>
        <div class="page-title-sub">
          <span>Order Management</span>
          <span class="sep">·</span>
          <span>Track and process customer milk order</span>
        </div>
      </div>

      <!-- Stat Cards -->
      <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
          <div class="stat-card c-pending">
            <div class="stat-icon-wrap ic-pending"><i class="bi bi-clipboard2-pulse"></i></div>
            <div class="stat-label">Pending Order</div>
            <div class="stat-value" data-target="15">0</div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="stat-card c-process">
            <div class="stat-icon-wrap ic-process"><i class="bi bi-arrow-repeat"></i></div>
            <div class="stat-label">Processing</div>
            <div class="stat-value" data-target="15">0</div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="stat-card c-shipped">
            <div class="stat-icon-wrap ic-shipped"><i class="bi bi-truck"></i></div>
            <div class="stat-label">Shipped</div>
            <div class="stat-value" data-target="30">0</div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="stat-card c-revenue">
            <div class="stat-icon-wrap ic-revenue"><i class="bi bi-cash-coin"></i></div>
            <div class="stat-label">Revenue Today</div>
            <div class="stat-value" id="revenue-val">0</div>
          </div>
        </div>
      </div>

      <!-- Order Table -->
      <div class="table-section">
        <div class="table-head-row">
          <h6>Order List</h6>
          <div class="filter-tabs">
            <button class="filter-tab active" data-filter="all">All</button>
            <button class="filter-tab" data-filter="pending">Pending</button>
            <button class="filter-tab" data-filter="processing">Processing</button>
            <button class="filter-tab" data-filter="shipped">Shipped</button>
          </div>
        </div>

        <!-- Desktop table -->
        <div class="table-wrap">
          <table class="custom-table">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Variant</th>
                <th>QTY</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="order-tbody">
              <tr data-status="pending">
                <td><span class="order-id">#MW-8820</span></td>
                <td><div class="customer-name">Carmenita Ayu</div><div class="customer-phone">+62 812-3456-7890</div></td>
                <td><span class="variant-badge v-strawberry">Strawberry 1L</span></td>
                <td>1</td>
                <td><strong>Rp.30.000</strong></td>
                <td><span class="status-badge s-pending">Pending</span></td>
                <td><div class="action-btns"><button class="act-btn act-edit"><i class="bi bi-pencil"></i></button><button class="act-btn act-delete"><i class="bi bi-trash3"></i></button></div></td>
              </tr>
              <tr data-status="shipped">
                <td><span class="order-id">#MW-8821</span></td>
                <td><div class="customer-name">Kimberly Salim</div><div class="customer-phone">+62 812-3456-7891</div></td>
                <td><span class="variant-badge v-original">Original Botol 250ml</span></td>
                <td>3</td>
                <td><strong>Rp.30.000</strong></td>
                <td><span class="status-badge s-shipped">Shipped</span></td>
                <td><div class="action-btns"><button class="act-btn act-edit"><i class="bi bi-pencil"></i></button><button class="act-btn act-delete"><i class="bi bi-trash3"></i></button></div></td>
              </tr>
              <tr data-status="processing">
                <td><span class="order-id">#MW-8822</span></td>
                <td><div class="customer-name">Zayyan Fahri</div><div class="customer-phone">+62 812-3456-7892</div></td>
                <td><span class="variant-badge v-cokelat">Cokelat Botol 250ml</span></td>
                <td>5</td>
                <td><strong>Rp.50.000</strong></td>
                <td><span class="status-badge s-processing">Processing</span></td>
                <td><div class="action-btns"><button class="act-btn act-edit"><i class="bi bi-pencil"></i></button><button class="act-btn act-delete"><i class="bi bi-trash3"></i></button></div></td>
              </tr>
              <tr data-status="pending">
                <td><span class="order-id">#MW-8823</span></td>
                <td><div class="customer-name">Edward Martin</div><div class="customer-phone">+62 812-3456-7893</div></td>
                <td><span class="variant-badge v-alpukat">Alpukat 1L</span></td>
                <td>1</td>
                <td><strong>Rp.30.000</strong></td>
                <td><span class="status-badge s-pending">Pending</span></td>
                <td><div class="action-btns"><button class="act-btn act-edit"><i class="bi bi-pencil"></i></button><button class="act-btn act-delete"><i class="bi bi-trash3"></i></button></div></td>
              </tr>
              <tr data-status="shipped">
                <td><span class="order-id">#MW-8824</span></td>
                <td><div class="customer-name">Nadia Permata</div><div class="customer-phone">+62 812-3456-7894</div></td>
                <td><span class="variant-badge v-vanilla">Vanilla 1L</span></td>
                <td>2</td>
                <td><strong>Rp.60.000</strong></td>
                <td><span class="status-badge s-shipped">Shipped</span></td>
                <td><div class="action-btns"><button class="act-btn act-edit"><i class="bi bi-pencil"></i></button><button class="act-btn act-delete"><i class="bi bi-trash3"></i></button></div></td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Mobile order cards -->
        <div class="mobile-order-list" id="mobile-order-list">
          <!-- Injected by JS -->
        </div>

        <div class="table-footer">
          <span>Showing 5 of 27 orders</span>
          <div class="pager">
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">…</button>
            <button class="page-btn"><i class="bi bi-chevron-right" style="font-size:11px"></i></button>
          </div>
        </div>
      </div>

    </div><!-- /page -->

@endsection
