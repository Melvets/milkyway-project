@extends('dashboard')

@section('title', 'Produk - Milkyway')

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
          <h6>Product List</h6>
        </div>

        <!-- Desktop table -->
        <div class="table-wrap">
          <table class="custom-table">
            <thead>
              <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Produk</th>
                <th>Deskripsi</th>
                <th>Label</th>
                <th>Varian</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($produks as $produk)
                <tr>
                  <td>{{ $loop->iteration + ($produks->currentPage() - 1) * $produks->perPage() }}</td>
                  <td>
                    @if ($produk->gambar)
                      <img src="{{ asset($produk->gambar) }}" alt="{{ $produk->nama }}"
                        style="width:48px; height:48px; object-fit:cover; border-radius:8px; border:1px solid #C8F3FA;">
                    @else
                      <div style="width:48px; height:48px; border-radius:8px; background:#f4f6f9; display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-image" style="color:#4a5e7a; font-size:18px;"></i>
                      </div>
                    @endif
                  </td>
                  <td>
                    <div class="customer-name">{{ $produk->nama }}</div>
                  </td>
                  <td>
                    <div style="font-size:13px; color:#4a5e7a; max-width:200px;">
                      {{ $produk->deskripsi ? Str::limit($produk->deskripsi, 60) : '-' }}
                    </div>
                  </td>
                  <td>
                    @if ($produk->status === 'best seller')
                      <span class="status-badge s-shipped">Best Seller</span>
                    @elseif ($produk->status === 'new')
                      <span class="status-badge s-pending">New</span>
                    @else
                      <span class="status-badge s-processing">Default</span>
                    @endif
                  </td>
                  <td>
                    @forelse ($produk->varian as $v)
                      <span class="variant-badge v-original" style="display:inline-block; margin:2px 2px 2px 0;">
                        {{ $v->ukuran }} — Rp {{ number_format($v->harga, 0, ',', '.') }}
                      </span>
                    @empty
                      <span style="font-size:12px; color:#4a5e7a;">-</span>
                    @endforelse
                  </td>
                  <td>
                    <div class="action-btns">
                      <a href="{{ route('produk.edit', $produk->id) }}" class="act-btn act-edit">
                        <i class="bi bi-pencil"></i>
                      </a>
                      <form id="delete-form-{{ $produk->id }}" action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display:none;">
                        @csrf @method('DELETE')
                      </form>
                      <button type="button" class="act-btn act-delete"
                        onclick="confirmDelete({{ $produk->id }}, '{{ addslashes($produk->nama) }}')">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center" style="color:#4a5e7a; padding:32px;">
                    Belum ada produk. <a href="{{ route('produk.create') }}">Tambah sekarang</a>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Mobile order cards -->
        <div class="mobile-order-list" id="mobile-order-list">
          @forelse ($produks as $produk)
            <div class="order-card">
              <div class="order-card-top">
                <div>
                  <div class="order-card-id">#{{ $loop->iteration + ($produks->currentPage() - 1) * $produks->perPage() }}</div>
                  <div class="order-card-name">{{ $produk->nama }}</div>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                  @if ($produk->gambar)
                    <img src="{{ asset($produk->gambar) }}" alt="{{ $produk->nama }}"
                      style="width:40px; height:40px; object-fit:cover; border-radius:8px; border:1px solid #C8F3FA;">
                  @else
                    <div style="width:40px; height:40px; border-radius:8px; background:#f4f6f9; display:flex; align-items:center; justify-content:center;">
                      <i class="bi bi-image" style="color:#4a5e7a;"></i>
                    </div>
                  @endif
                </div>
              </div>

              <div class="order-card-row">
                <div class="order-card-meta">
                  @if ($produk->status === 'best seller')
                    <span class="status-badge s-shipped">Best Seller</span>
                  @elseif ($produk->status === 'new')
                    <span class="status-badge s-pending">New</span>
                  @else
                    <span class="status-badge s-processing">Default</span>
                  @endif

                  @foreach ($produk->varian as $v)
                    <span class="variant-badge v-original" style="margin:2px 2px 2px 0;">
                      {{ $v->ukuran }} — Rp {{ number_format($v->harga, 0, ',', '.') }}
                    </span>
                  @endforeach
                </div>

                <div class="order-card-actions">
                  <a href="{{ route('produk.edit', $produk->id) }}" class="act-btn act-edit">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <button type="button" class="act-btn act-delete"
                    onclick="confirmDelete({{ $produk->id }}, '{{ addslashes($produk->nama) }}')">
                    <i class="bi bi-trash3"></i>
                  </button>
                </div>
              </div>
            </div>
          @empty
            <div style="text-align:center; padding:32px; color:#4a5e7a; font-size:13px;">
              Belum ada produk. <a href="{{ route('produk.create') }}">Tambah sekarang</a>
            </div>
          @endforelse
        </div>

        <div class="table-footer">
          <span>Showing {{ $produks->firstItem() }}–{{ $produks->lastItem() }} of {{ $produks->total() }} produk</span>
          <div class="pager">
            @for ($i = 1; $i <= $produks->lastPage(); $i++)
              <a href="{{ $produks->url($i) }}"
                class="page-btn {{ $produks->currentPage() === $i ? 'active' : '' }}">
                {{ $i }}
              </a>
            @endfor
            @if ($produks->hasMorePages())
              <a href="{{ $produks->nextPageUrl() }}" class="page-btn">
                <i class="bi bi-chevron-right" style="font-size:11px"></i>
              </a>
            @endif
          </div>
        </div>
      </div>

    </div><!-- /page -->

@endsection

@push('scripts')
{{-- Delete Confirmation Modal --}}
<div id="deleteModal" style="
  display:none; position:fixed; inset:0; z-index:9999;
  background:rgba(15,23,42,.45); backdrop-filter:blur(4px);
  align-items:center; justify-content:center;">
  <div style="
    background:#fff; border-radius:16px; padding:32px 28px 24px;
    width:100%; max-width:380px; margin:16px;
    box-shadow:0 20px 60px rgba(0,0,0,.18); text-align:center; animation:modalIn .2s ease;">
    <div style="width:56px; height:56px; border-radius:50%; background:#fff0f0;
      display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
      <i class="bi bi-trash3-fill" style="font-size:24px; color:#e53e3e;"></i>
    </div>
    <h5 style="font-size:1.05rem; font-weight:700; color:#1a202c; margin-bottom:8px;">Hapus Produk?</h5>
    <p style="font-size:.875rem; color:#64748b; margin-bottom:24px; line-height:1.5;">
      Produk <strong id="deleteProdukName" style="color:#1a202c;"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
    </p>
    <div style="display:flex; gap:10px; justify-content:center;">
      <button onclick="closeDeleteModal()"
        style="flex:1; padding:10px 0; border-radius:10px; border:1.5px solid #e2e8f0;
          background:#fff; color:#4a5e7a; font-size:.875rem; font-weight:600; cursor:pointer;">
        Batal
      </button>
      <button onclick="submitDelete()"
        style="flex:1; padding:10px 0; border-radius:10px; border:none;
          background:#e53e3e; color:#fff; font-size:.875rem; font-weight:600; cursor:pointer;">
        <i class="bi bi-trash3 me-1"></i> Hapus
      </button>
    </div>
  </div>
</div>

<style>
@keyframes modalIn {
  from { opacity:0; transform:scale(.92); }
  to   { opacity:1; transform:scale(1); }
}
</style>

<script>
  let _deleteId = null;

  function confirmDelete(id, nama) {
    _deleteId = id;
    document.getElementById('deleteProdukName').textContent = nama;
    const modal = document.getElementById('deleteModal');
    modal.style.display = 'flex';
  }

  function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    _deleteId = null;
  }

  function submitDelete() {
    if (_deleteId) {
      document.getElementById('delete-form-' + _deleteId).submit();
    }
  }

  // Tutup modal jika klik backdrop
  document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
  });
</script>
@endpush
