@extends('dashboard')

@section('title', 'Orders - Milkyway')

@section('container')

  <!-- Topbar -->
  <div class="topbar">
    <button class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></button>
    <div class="search-box">
      <i class="bi bi-search"></i>
      <input type="text" placeholder="Search data"/>
    </div>
    <div class="topbar-right">
      <div class="topbar-icon"><i class="bi bi-bell"></i><span class="badge-dot"></span></div>
      <div class="topbar-icon"><i class="bi bi-question-circle"></i></div>
      <div class="user-chip">
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
        <span class="user-chip-name">{{ Auth::user()->name }}</span>
      </div>
    </div>
  </div>

  <div class="page">

    <div class="page-header">
      <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item page-date"><a href="/dashboard" style="color:#4a5e7a; text-decoration:none">Dashboard</a></li>
          <li class="breadcrumb-item page-date active" style="color:#FFB201">Orders</li>
        </ol>
      </nav>
      <h2>Semua <span class="page-name">Pesanan</span></h2>
      <p class="page-desc">Daftar seluruh pesanan masuk dari pelanggan.</p>
    </div>

    @if (session('success'))
      <div class="mb-3 p-3 rounded-3" style="background:#e8f5e9; border:1px solid #a5d6a7; color:#2e7d32; font-size:13px;">
        {{ session('success') }}
      </div>
    @endif

    {{-- Filter status --}}
    <div class="table-section mb-0">
      <div class="table-head-row">
        <h6>Order List</h6>
        <div class="filter-tabs">
          <a href="{{ route('orders.index') }}"
            class="filter-tab {{ !request('status') ? 'active' : '' }}">All</a>
          <a href="{{ route('orders.index', ['status' => 'Pending']) }}"
            class="filter-tab {{ request('status') === 'Pending' ? 'active' : '' }}">Pending</a>
          <a href="{{ route('orders.index', ['status' => 'Diproses']) }}"
            class="filter-tab {{ request('status') === 'Diproses' ? 'active' : '' }}">Diproses</a>
          <a href="{{ route('orders.index', ['status' => 'Selesai']) }}"
            class="filter-tab {{ request('status') === 'Selesai' ? 'active' : '' }}">Selesai</a>
        </div>
      </div>

      <!-- Desktop table -->
      <div class="table-wrap">
        <table class="custom-table">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Customer</th>
              <th>Alamat</th>
              <th>Detail Pesanan</th>
              <th>Total</th>
              <th>Status</th>
              <th>Waktu</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($pesanans as $p)
              <tr data-status="{{ strtolower($p->status) }}">
                <td><span class="order-id">#MW-{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                <td>
                  <div class="customer-name">{{ $p->nama_pemesan }}</div>
                  <div class="customer-phone">{{ $p->nomor_hp }}</div>
                </td>
                <td style="font-size:12px; color:#4a5e7a; max-width:140px;">{{ $p->alamat }}</td>
                <td>
                  @foreach ($p->items as $item)
                    <div style="font-size:12px;">
                      {{ $item->varian?->produk?->nama ?? '[Produk dihapus]' }}
                      {{ $item->varian?->ukuran ?? '' }}
                      ×{{ $item->qty }}
                    </div>
                  @endforeach
                </td>
                <td><strong>Rp {{ number_format($p->items->sum('subtotal'), 0, ',', '.') }}</strong></td>
                <td>
                  @if ($p->status === 'Pending')
                    <span class="status-badge s-pending">Pending</span>
                  @elseif ($p->status === 'Diproses')
                    <span class="status-badge s-processing">Diproses</span>
                  @else
                    <span class="status-badge s-shipped">Selesai</span>
                  @endif
                </td>
                <td style="font-size:12px; color:#4a5e7a;">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                <td>
                  <div class="action-btns">
                    {{-- Tombol Edit (selalu ada) --}}
                    <a href="{{ route('orders.edit', $p->id) }}" class="act-btn act-edit" title="Edit Pesanan">
                      <i class="bi bi-pencil"></i>
                    </a>

                    @if ($p->status === 'Pending')
                      <form action="{{ route('orders.terima', $p->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="act-btn" title="Terima"
                          style="background:rgba(46,156,78,.12); color:#2e9c4e; width:32px; height:32px; border-radius:8px; border:none; cursor:pointer;">
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
                    @elseif ($p->status === 'Diproses')
                      {{-- Hubungi customer via WA --}}
                      @php
                        $noWa = preg_replace('/[^0-9]/', '', $p->nomor_hp);
                        if (str_starts_with($noWa, '0')) $noWa = '62' . substr($noWa, 1);
                        $msgWa = urlencode("Halo {$p->nama_pemesan}, pesanan Anda #MW-" . str_pad($p->id,4,'0',STR_PAD_LEFT) . " sedang kami proses. Terima kasih 🐐");
                      @endphp
                      <a href="https://wa.me/{{ $noWa }}?text={{ $msgWa }}" target="_blank"
                        class="act-btn" title="Hubungi Customer"
                        style="background:rgba(37,211,102,.12); color:#25d366; width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-whatsapp"></i>
                      </a>
                      <form action="{{ route('orders.selesai', $p->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="act-btn act-edit" title="Selesaikan">
                          <i class="bi bi-truck"></i>
                        </button>
                      </form>
                    @else
                      {{-- Selesai: hanya tombol WA --}}
                      @php
                        $noWa = preg_replace('/[^0-9]/', '', $p->nomor_hp);
                        if (str_starts_with($noWa, '0')) $noWa = '62' . substr($noWa, 1);
                        $msgWa = urlencode("Halo {$p->nama_pemesan}, pesanan Anda #MW-" . str_pad($p->id,4,'0',STR_PAD_LEFT) . " telah selesai. Terima kasih telah berbelanja di Milkyway 🐐");
                      @endphp
                      <a href="https://wa.me/{{ $noWa }}?text={{ $msgWa }}" target="_blank"
                        class="act-btn" title="Hubungi Customer"
                        style="background:rgba(37,211,102,.12); color:#25d366; width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-whatsapp"></i>
                      </a>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center" style="color:#4a5e7a; padding:32px;">
                  Belum ada pesanan.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Mobile cards -->
      <div class="mobile-order-list">
        @forelse ($pesanans as $p)
          <div class="order-card" data-status="{{ strtolower($p->status) }}">
            <div class="order-card-top">
              <div>
                <div class="order-card-id">#MW-{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="order-card-name">{{ $p->nama_pemesan }}</div>
                <div class="order-card-phone">{{ $p->nomor_hp }}</div>
              </div>
              @if ($p->status === 'Pending')
                <span class="status-badge s-pending">Pending</span>
              @elseif ($p->status === 'Diproses')
                <span class="status-badge s-processing">Diproses</span>
              @else
                <span class="status-badge s-shipped">Selesai</span>
              @endif
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
                {{-- Edit --}}
                <a href="{{ route('orders.edit', $p->id) }}" class="act-btn act-edit" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
                @if ($p->status === 'Pending')
                  <form action="{{ route('orders.terima', $p->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="act-btn" title="Terima"
                      style="background:rgba(46,156,78,.12); color:#2e9c4e; width:32px; height:32px; border-radius:8px; border:none; cursor:pointer;">
                      <i class="bi bi-check-lg"></i>
                    </button>
                  </form>
                  <form action="{{ route('orders.tolak', $p->id) }}" method="POST"
                    onsubmit="return confirm('Tolak?')">
                    @csrf
                    <button type="submit" class="act-btn act-delete"><i class="bi bi-x-lg"></i></button>
                  </form>
                @elseif ($p->status === 'Diproses')
                  @php
                    $noWa = preg_replace('/[^0-9]/', '', $p->nomor_hp);
                    if (str_starts_with($noWa, '0')) $noWa = '62' . substr($noWa, 1);
                    $msgWa = urlencode("Halo {$p->nama_pemesan}, pesanan Anda sedang kami proses 🐐");
                  @endphp
                  <a href="https://wa.me/{{ $noWa }}?text={{ $msgWa }}" target="_blank"
                    class="act-btn" style="background:rgba(37,211,102,.12); color:#25d366; width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-whatsapp"></i>
                  </a>
                  <form action="{{ route('orders.selesai', $p->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="act-btn act-edit" title="Selesaikan">
                      <i class="bi bi-truck"></i>
                    </button>
                  </form>
                @else
                  @php
                    $noWa = preg_replace('/[^0-9]/', '', $p->nomor_hp);
                    if (str_starts_with($noWa, '0')) $noWa = '62' . substr($noWa, 1);
                    $msgWa = urlencode("Halo {$p->nama_pemesan}, pesanan Anda telah selesai. Terima kasih 🐐");
                  @endphp
                  <a href="https://wa.me/{{ $noWa }}?text={{ $msgWa }}" target="_blank"
                    class="act-btn" style="background:rgba(37,211,102,.12); color:#25d366; width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-whatsapp"></i>
                  </a>
                @endif
              </div>
            </div>
          </div>
        @empty
          <div style="text-align:center; padding:32px; color:#4a5e7a; font-size:13px;">Belum ada pesanan.</div>
        @endforelse
      </div>

      <div class="table-footer">
        <span>Showing {{ $pesanans->firstItem() }}–{{ $pesanans->lastItem() }} of {{ $pesanans->total() }} pesanan</span>
        <div class="pager">
          @for ($i = 1; $i <= $pesanans->lastPage(); $i++)
            <a href="{{ $pesanans->url($i) }}"
              class="page-btn {{ $pesanans->currentPage() === $i ? 'active' : '' }}">{{ $i }}</a>
          @endfor
          @if ($pesanans->hasMorePages())
            <a href="{{ $pesanans->nextPageUrl() }}" class="page-btn">
              <i class="bi bi-chevron-right" style="font-size:11px"></i>
            </a>
          @endif
        </div>
      </div>
    </div>

  </div><!-- /page -->

@endsection
