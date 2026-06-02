@extends('dashboard')

@section('title', 'Produk - Milkyway')

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
      <div class="mb-3 page-header">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
          <ol class="breadcrumb m-0">
            <li class="breadcrumb-item page-date"><a href="/dashboard" style="color: #4a5e7a; text-decoration:none">Dashboard</a></li>
            <li class="breadcrumb-item page-date active" style="color: #FFB201" aria-current="page">Produk</li>
          </ol>
        </nav>
        <h2>Produk <span class="page-name">Milkyway</span></h2>
        <p class="page-desc">Kelola daftar produk susu kambing Anda.</p>
        <div class="page-title-sub mb-4">
          <span>Kelola Produk</span>
          <span class="sep">·</span>
        </div>
        <a href="/dashboard/produk/create" style="text-decoration: none;" class="act-create"><i class="bi bi-plus-lg fw-bold" style="font-style: normal">Tambah Produk</i></a>
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
