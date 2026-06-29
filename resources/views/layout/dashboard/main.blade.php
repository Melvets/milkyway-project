@extends('dashboard')

@section('title', 'Dashboard - Milkyway')

@section('container')

  <!-- Topbar -->
  <div class="topbar">
      <button class="menu-toggle" id="menuToggle">
        <i class="bi bi-list"></i>
      </button>
      <div class="">
        <p>Milkyway - Susu Kambing</p>
      </div>
      <div class="topbar-right">
        <div class="user-chip">
          <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
          <span class="user-chip-name">{{ Auth::user()->name }}</span>
        </div>
      </div>
    </div>

    <!-- Page -->
    <div class="page">

      <!-- Page Header -->
      <div class="page-header">
        <div class="page-date" id="page-date"></div>
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
            <div class="stat-value">{{ $statPending }}</div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="stat-card c-process">
            <div class="stat-icon-wrap ic-process"><i class="bi bi-arrow-repeat"></i></div>
            <div class="stat-label">Diproses</div>
            <div class="stat-value">{{ $statDiproses }}</div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="stat-card c-shipped">
            <div class="stat-icon-wrap ic-shipped"><i class="bi bi-truck"></i></div>
            <div class="stat-label">Selesai</div>
            <div class="stat-value">{{ $statSelesai }}</div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="stat-card c-revenue">
            <div class="stat-icon-wrap ic-revenue"><i class="bi bi-cash-coin"></i></div>
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">{{ $statRevenue >= 1000000 ? number_format($statRevenue/1000000, 1).'M' : number_format($statRevenue/1000, 0).'K' }}</div>
          </div>
        </div>
      </div>

      {{-- Alert success --}}
      @if (session('success'))
        <div class="mb-3 p-3 rounded-3" style="background:#e8f5e9; border:1px solid #a5d6a7; color:#2e7d32; font-size:13px;">
          {{ session('success') }}
        </div>
      @endif

      <!-- Pesanan Pending - Perlu Konfirmasi -->
      <div class="table-section">
        <div class="table-head-row">
          <h6>Pesanan Masuk <span style="font-size:12px; font-weight:400; color:#4a5e7a;">— perlu konfirmasi</span></h6>
        </div>

        <div class="table-wrap">
          <table class="custom-table">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Alamat</th>
                <th>Detail Pesanan</th>
                <th>Total</th>
                <th>Waktu</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="order-tbody">
              @forelse ($pending as $p)
                <tr data-status="pending">
                  <td><span class="order-id">#MW-{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                  <td>
                    <div class="customer-name">{{ $p->nama_pemesan }}</div>
                    <div class="customer-phone">{{ $p->nomor_hp }}</div>
                  </td>
                  <td style="font-size:12px; color:#4a5e7a; max-width:150px;">{{ $p->alamat }}</td>
                  <td>
                    @foreach ($p->items as $item)
                      <div style="font-size:12px;">
                        {{ $item->varian?->produk?->nama ?? '[Produk dihapus]' }}
                        {{ $item->varian?->ukuran ?? '' }}
                        × {{ $item->qty }}
                      </div>
                    @endforeach
                  </td>
                  <td><strong>Rp {{ number_format($p->items->sum('subtotal'), 0, ',', '.') }}</strong></td>
                  <td style="font-size:12px; color:#4a5e7a;">{{ $p->created_at->diffForHumans() }}</td>
                  <td>
                    <div class="action-btns">
                      <form action="{{ route('orders.terima', $p->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="act-btn act-edit" title="Terima" style="background:rgba(46,156,78,.12); color:#2e9c4e;">
                          <i class="bi bi-check-lg"></i>
                        </button>
                      </form>
                      <form action="{{ route('orders.tolak', $p->id) }}" method="POST"
                        onsubmit="return confirm('Tolak pesanan ini?')">
                        @csrf
                        <button type="submit" class="act-btn act-delete" title="Tolak">
                          <i class="bi bi-x-lg"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center" style="color:#4a5e7a; padding:32px;">
                    Tidak ada pesanan baru yang menunggu konfirmasi.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Mobile cards -->
        <div class="mobile-order-list" id="mobile-order-list">
          @forelse ($pending as $p)
            <div class="order-card" data-status="pending">
              <div class="order-card-top">
                <div>
                  <div class="order-card-id">#MW-{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</div>
                  <div class="order-card-name">{{ $p->nama_pemesan }}</div>
                  <div class="order-card-phone">{{ $p->nomor_hp }}</div>
                </div>
                <span class="status-badge s-pending">Pending</span>
              </div>
              <div class="order-card-row">
                <div class="order-card-meta" style="flex-direction:column; align-items:flex-start;">
                  @foreach ($p->items as $item)
                    <span style="font-size:12px;">
                      {{ $item->varian?->produk?->nama ?? '[Produk dihapus]' }}
                      {{ $item->varian?->ukuran ?? '' }} ×{{ $item->qty }}
                    </span>
                  @endforeach
                  <strong style="font-size:13px; margin-top:4px;">Rp {{ number_format($p->items->sum('subtotal'), 0, ',', '.') }}</strong>
                </div>
                <div class="order-card-actions">
                  <form action="{{ route('orders.terima', $p->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="act-btn act-edit" title="Terima" style="background:rgba(46,156,78,.12); color:#2e9c4e;">
                      <i class="bi bi-check-lg"></i>
                    </button>
                  </form>
                  <form action="{{ route('orders.tolak', $p->id) }}" method="POST"
                    onsubmit="return confirm('Tolak pesanan ini?')">
                    @csrf
                    <button type="submit" class="act-btn act-delete" title="Tolak">
                      <i class="bi bi-x-lg"></i>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          @empty
            <div style="text-align:center; padding:32px; color:#4a5e7a; font-size:13px;">
              Tidak ada pesanan baru yang menunggu konfirmasi.
            </div>
          @endforelse
        </div>

        <div class="table-footer">
          <span>{{ $pending->count() }} pesanan menunggu konfirmasi</span>
          <a href="{{ route('orders.index') }}" style="font-size:13px; color:var(--primary); text-decoration:none; font-weight:600;">
            Lihat semua pesanan →
          </a>
        </div>
      </div>

    </div><!-- /page -->

@endsection
