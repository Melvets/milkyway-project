@extends('dashboard')

@section('title', 'Tambah Produk - Milkyway')

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
      <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item page-date"><a href="/dashboard" style="color: #4a5e7a; text-decoration:none">Dashboard</a></li>
          <li class="breadcrumb-item page-date"><a href="/dashboard/produk" style="color: #4a5e7a; text-decoration:none">Produk</a></li>
          <li class="breadcrumb-item page-date active" style="color: #FFB201" aria-current="page">Tambah Produk</li>
        </ol>
      </nav>
      <h2>Tambah <span class="page-name">Produk</span></h2>
      <p class="page-desc">Isi informasi produk dan varian harga di bawah ini.</p>
    </div>

    {{-- Error --}}
    @if ($errors->any())
      <div class="mb-3 p-3 rounded-3" style="background:#fdecea; border:1px solid #f5c6cb; color:#c62828; font-size:13px;">
        <ul class="mb-0 ps-3">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="row g-4">

        {{-- Kolom kiri: Informasi Produk --}}
        <div class="col-12 col-lg-7">
          <div class="table-section p-4 mb-4">
            <p class="stat-label text-uppercase mb-3" style="letter-spacing:.8px;">Informasi Produk</p>

            <div class="mb-3">
              <label class="form-label" style="font-size:13px; color:#4a5e7a;" for="nama">Nama Produk <span class="text-danger">*</span></label>
              <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                placeholder="Contoh: Susu Kambing Murni"
                class="form-control form-control-sm @error('nama') is-invalid @enderror" />
              @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label" style="font-size:13px; color:#4a5e7a;" for="deskripsi">Deskripsi</label>
              <textarea name="deskripsi" id="deskripsi" rows="3"
                placeholder="Deskripsi produk (opsional)..."
                class="form-control form-control-sm">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label" style="font-size:13px; color:#4a5e7a;" for="status">Label Produk</label>
              <select name="status" id="status" class="form-select form-select-sm">
                <option value="default"     {{ old('status') == 'default'     ? 'selected' : '' }}>Default</option>
                <option value="new"         {{ old('status') == 'new'         ? 'selected' : '' }}>New</option>
                <option value="best seller" {{ old('status') == 'best seller' ? 'selected' : '' }}>Best Seller</option>
              </select>
            </div>

            <div>
              <label class="form-label" style="font-size:13px; color:#4a5e7a;" for="gambar">Foto Produk</label>
              <input type="file" name="gambar" id="gambar" accept="image/*"
                onchange="previewGambar(this)"
                class="form-control form-control-sm" />
              <div id="preview-wrap" class="mt-2" style="display:none;">
                <img id="preview-img" src="" alt="Preview"
                  style="width:80px; height:80px; object-fit:cover; border-radius:10px; border:1px solid #C8F3FA;" />
              </div>
            </div>
          </div>
        </div>

        {{-- Kolom kanan: Varian --}}
        <div class="col-12 col-lg-5">
          <div class="table-section p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <p class="stat-label text-uppercase mb-0" style="letter-spacing:.8px;">Varian Produk</p>
              <button type="button" onclick="addVarian()"
                class="act-btn act-edit d-flex align-items-center gap-1" style="width:auto; padding:6px 12px; border-radius:8px;">
                <i class="bi bi-plus-lg"></i> Tambah
              </button>
            </div>

            <div id="varian-list" class="d-flex flex-column gap-2"></div>
            <p id="empty-msg" class="stat-label text-center py-3 mb-0">
              Belum ada varian. Klik "Tambah" untuk mulai.
            </p>
          </div>
        </div>

      </div>

      {{-- Actions --}}
      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('produk.index') }}"
          class="act-btn" style="width:auto; padding:8px 20px; text-decoration:none; color:#4a5e7a; background:#f4f6f9; border-radius:10px; font-size:14px;">
          Batal
        </a>
        <button type="submit"
          class="act-btn act-edit" style="width:auto; padding:8px 20px; font-size:14px; border-radius:10px;">
          <i class="bi bi-check2"></i> Simpan Produk
        </button>
      </div>

    </form>

  </div><!-- /page -->

<script>
  let varianCount = 0;

  function addVarian() {
    const list = document.getElementById('varian-list');
    document.getElementById('empty-msg').style.display = 'none';

    const idx = varianCount++;
    const row = document.createElement('div');
    row.id = 'varian-row-' + idx;
    row.className = 'd-flex gap-2 align-items-center';
    row.innerHTML = `
      <input type="text" name="varians[${idx}][ukuran]" placeholder="Ukuran (250ml, 1L...)"
        class="form-control form-control-sm" style="flex:1;" />
      <div class="input-group input-group-sm" style="flex:1;">
        <span class="input-group-text" style="font-size:12px; background:#f4f6f9; border-color:#dee2e6;">Rp</span>
        <input type="number" name="varians[${idx}][harga]" placeholder="0" min="0"
          class="form-control form-control-sm" />
      </div>
      <button type="button" onclick="removeVarian(${idx})"
        class="act-btn act-delete" style="flex:none;" aria-label="Hapus">
        <i class="bi bi-trash3"></i>
      </button>
    `;
    list.appendChild(row);
  }

  function removeVarian(idx) {
    const row = document.getElementById('varian-row-' + idx);
    if (row) row.remove();
    if (document.getElementById('varian-list').children.length === 0) {
      document.getElementById('empty-msg').style.display = '';
    }
  }

  function previewGambar(input) {
    const file = input.files[0];
    if (!file) return;
    const wrap = document.getElementById('preview-wrap');
    const img  = document.getElementById('preview-img');
    const reader = new FileReader();
    reader.onload = e => { img.src = e.target.result; wrap.style.display = ''; };
    reader.readAsDataURL(file);
  }
</script>

@endsection
