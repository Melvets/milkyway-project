@extends('dashboard')

@section('title', 'Edit Pesanan - Milkyway')

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

  <div class="page">

    <div class="page-header">
      <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item page-date"><a href="/dashboard" style="color:#4a5e7a; text-decoration:none">Dashboard</a></li>
          <li class="breadcrumb-item page-date"><a href="{{ route('orders.index') }}" style="color:#4a5e7a; text-decoration:none">Orders</a></li>
          <li class="breadcrumb-item page-date active" style="color:#FFB201">Edit Pesanan</li>
        </ol>
      </nav>
      <h2>Edit <span class="page-name">Pesanan</span></h2>
      <p class="page-desc">Perbarui data pesanan #MW-{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</p>
    </div>

    @if ($errors->any())
      <div class="mb-3 p-3 rounded-3" style="background:#fdecea; border:1px solid #f5c6cb; color:#c62828; font-size:13px;">
        <ul class="mb-0 ps-3">
          @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('orders.update', $pesanan->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="row g-4">

        {{-- Kolom kiri: Data Customer --}}
        <div class="col-12 col-lg-5">
          <div class="table-section p-4">
            <p class="stat-label text-uppercase mb-3" style="letter-spacing:.8px;">Data Customer</p>

            <div class="mb-3">
              <label class="form-label" style="font-size:13px; color:#4a5e7a;">Nama Pemesan <span class="text-danger">*</span></label>
              <input type="text" name="nama_pemesan" value="{{ old('nama_pemesan', $pesanan->nama_pemesan) }}"
                class="form-control form-control-sm @error('nama_pemesan') is-invalid @enderror" />
              @error('nama_pemesan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label" style="font-size:13px; color:#4a5e7a;">Nomor HP <span class="text-danger">*</span></label>
              <div class="input-group input-group-sm">
                <span class="input-group-text" style="background:#f4f6f9;"><i class="bi bi-whatsapp" style="color:#25d366;"></i></span>
                <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $pesanan->nomor_hp) }}"
                  class="form-control @error('nomor_hp') is-invalid @enderror" />
              </div>
              @error('nomor_hp')<div class="text-danger" style="font-size:12px; margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label" style="font-size:13px; color:#4a5e7a;">Alamat <span class="text-danger">*</span></label>
              <textarea name="alamat" rows="3"
                class="form-control form-control-sm @error('alamat') is-invalid @enderror">{{ old('alamat', $pesanan->alamat) }}</textarea>
              @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div>
              <label class="form-label" style="font-size:13px; color:#4a5e7a;">Status</label>
              <div class="d-flex gap-2 flex-wrap mt-1">

                <label class="status-radio-label">
                  <input type="radio" name="status" value="Pending"
                    {{ old('status', $pesanan->status) === 'Pending' ? 'checked' : '' }}>
                  <span class="status-radio-pill s-pending-pill">
                    <i class="bi bi-clock me-1"></i>Pending
                  </span>
                </label>

                <label class="status-radio-label">
                  <input type="radio" name="status" value="Diproses"
                    {{ old('status', $pesanan->status) === 'Diproses' ? 'checked' : '' }}>
                  <span class="status-radio-pill s-process-pill">
                    <i class="bi bi-arrow-repeat me-1"></i>Diproses
                  </span>
                </label>

                <label class="status-radio-label">
                  <input type="radio" name="status" value="Selesai"
                    {{ old('status', $pesanan->status) === 'Selesai' ? 'checked' : '' }}>
                  <span class="status-radio-pill s-done-pill">
                    <i class="bi bi-check-circle me-1"></i>Selesai
                  </span>
                </label>

              </div>
            </div>
          </div>
        </div>

        {{-- Kolom kanan: Item Pesanan --}}
        <div class="col-12 col-lg-7">
          <div class="table-section p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <p class="stat-label text-uppercase mb-0" style="letter-spacing:.8px;">Item Pesanan</p>
              <button type="button" onclick="addItem()"
                class="act-btn act-edit d-flex align-items-center gap-1"
                style="width:auto; padding:6px 12px; border-radius:8px;">
                <i class="bi bi-plus-lg"></i> Tambah Item
              </button>
            </div>

            {{-- Data varian --}}
            <script>
              const varianData = {
                @foreach ($produks as $p)
                  {{ $p->id }}: [
                    @foreach ($p->varian as $v)
                      { id: {{ $v->id }}, ukuran: "{{ $v->ukuran }}", harga: {{ $v->harga }} },
                    @endforeach
                  ],
                @endforeach
              };
              const produkList = [
                @foreach ($produks as $p)
                  { id: {{ $p->id }}, nama: "{{ addslashes($p->nama) }}" },
                @endforeach
              ];
            </script>

            <div id="item-list" class="d-flex flex-column gap-2">
              @foreach ($pesanan->items as $i => $item)
                @php
                  $varianAda    = $item->varian !== null;
                  $produkAda    = $varianAda && $item->varian->produk !== null;
                  $produkId     = $produkAda ? $item->varian->produk_id : 0;
                  $varianId     = $varianAda ? $item->varian_id : 0;
                @endphp
                <div id="item-row-{{ $i }}" class="p-3 rounded-3" style="background:#f8fdfe; border:1px solid rgba(200,243,250,.7);">
                  @if (!$varianAda || !$produkAda)
                    {{-- Varian/produk sudah dihapus --}}
                    <div class="d-flex align-items-center gap-2" style="font-size:12px; color:#e53935;">
                      <i class="bi bi-exclamation-triangle"></i>
                      <span>Item ini produknya sudah dihapus (subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }})</span>
                      <button type="button" onclick="removeItem({{ $i }})" class="act-btn act-delete ms-auto" style="margin-top:0;">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </div>
                    {{-- Kirim varian_id dummy agar form tetap valid jika dihapus --}}
                  @else
                  <div class="row g-2 align-items-end">
                    <div class="col-5">
                      <label class="form-label mb-1" style="font-size:11px; color:#4a5e7a;">Produk</label>
                      <select name="items[{{ $i }}][produk_id]" class="form-select form-select-sm"
                        onchange="updateVarian(this, {{ $i }}, {{ $produkId }}, {{ $varianId }})">
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($produks as $p)
                          <option value="{{ $p->id }}"
                            {{ $produkId == $p->id ? 'selected' : '' }}>
                            {{ $p->nama }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-4">
                      <label class="form-label mb-1" style="font-size:11px; color:#4a5e7a;">Ukuran</label>
                      <select name="items[{{ $i }}][varian_id]" class="form-select form-select-sm" id="varian-sel-{{ $i }}">
                        @foreach ($item->varian->produk->varian as $v)
                          <option value="{{ $v->id }}"
                            data-harga="{{ $v->harga }}"
                            {{ $varianId == $v->id ? 'selected' : '' }}>
                            {{ $v->ukuran }} — Rp {{ number_format($v->harga, 0, ',', '.') }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-2">
                      <label class="form-label mb-1" style="font-size:11px; color:#4a5e7a;">Qty</label>
                      <input type="number" name="items[{{ $i }}][qty]" value="{{ $item->qty }}"
                        min="1" class="form-control form-control-sm" />
                    </div>
                    <div class="col-1 d-flex justify-content-end">
                      <button type="button" onclick="removeItem({{ $i }})"
                        class="act-btn act-delete" style="margin-top:2px;">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </div>
                  </div>
                  @endif
                </div>
              @endforeach
            </div>

            <p id="item-empty" class="stat-label text-center py-3 mb-0"
              style="{{ $pesanan->items->count() > 0 ? 'display:none;' : '' }}">
              Belum ada item. Klik "Tambah Item".
            </p>
          </div>
        </div>

      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('orders.index') }}"
          class="act-btn" style="width:auto; padding:8px 20px; text-decoration:none; color:#4a5e7a; background:#f4f6f9; border-radius:10px; font-size:14px;">
          Batal
        </a>
        <button type="submit" class="act-btn act-edit" style="width:auto; padding:8px 20px; font-size:14px; border-radius:10px;">
          <i class="bi bi-check2"></i> Simpan Perubahan
        </button>
      </div>

    </form>
  </div>

<script>
  let itemCount = {{ $pesanan->items->count() }};

  function updateVarian(sel, idx, currentProdukId, currentVarianId) {
    const produkId = parseInt(sel.value);
    const varianSel = document.getElementById('varian-sel-' + idx);
    if (!varianSel) return;

    varianSel.innerHTML = '<option value="">-- Pilih Ukuran --</option>';
    if (varianData[produkId]) {
      varianData[produkId].forEach(v => {
        const opt = document.createElement('option');
        opt.value = v.id;
        opt.dataset.harga = v.harga;
        opt.textContent = `${v.ukuran} — Rp ${v.harga.toLocaleString('id-ID')}`;
        if (v.id === currentVarianId && produkId === currentProdukId) opt.selected = true;
        varianSel.appendChild(opt);
      });
    }
  }

  function addItem() {
    const list = document.getElementById('item-list');
    document.getElementById('item-empty').style.display = 'none';

    const idx = itemCount++;
    const div = document.createElement('div');
    div.id = 'item-row-' + idx;
    div.className = 'p-3 rounded-3';
    div.style.cssText = 'background:#f8fdfe; border:1px solid rgba(200,243,250,.7);';

    const produkOptions = produkList.map(p =>
      `<option value="${p.id}">${p.nama}</option>`
    ).join('');

    div.innerHTML = `
      <div class="row g-2 align-items-end">
        <div class="col-5">
          <label class="form-label mb-1" style="font-size:11px; color:#4a5e7a;">Produk</label>
          <select name="items[${idx}][produk_id]" class="form-select form-select-sm"
            onchange="addUpdateVarian(this, ${idx})">
            <option value="">-- Pilih Produk --</option>
            ${produkOptions}
          </select>
        </div>
        <div class="col-4">
          <label class="form-label mb-1" style="font-size:11px; color:#4a5e7a;">Ukuran</label>
          <select name="items[${idx}][varian_id]" class="form-select form-select-sm" id="varian-sel-${idx}">
            <option value="">-- Pilih Ukuran --</option>
          </select>
        </div>
        <div class="col-2">
          <label class="form-label mb-1" style="font-size:11px; color:#4a5e7a;">Qty</label>
          <input type="number" name="items[${idx}][qty]" value="1"
            min="1" class="form-control form-control-sm" />
        </div>
        <div class="col-1 d-flex justify-content-end">
          <button type="button" onclick="removeItem(${idx})"
            class="act-btn act-delete" style="margin-top:2px;">
            <i class="bi bi-trash3"></i>
          </button>
        </div>
      </div>
    `;
    list.appendChild(div);
  }

  function addUpdateVarian(sel, idx) {
    const produkId = parseInt(sel.value);
    const varianSel = document.getElementById('varian-sel-' + idx);
    varianSel.innerHTML = '<option value="">-- Pilih Ukuran --</option>';
    if (varianData[produkId]) {
      varianData[produkId].forEach(v => {
        const opt = document.createElement('option');
        opt.value = v.id;
        opt.textContent = `${v.ukuran} — Rp ${v.harga.toLocaleString('id-ID')}`;
        varianSel.appendChild(opt);
      });
    }
  }

  function removeItem(idx) {
    const row = document.getElementById('item-row-' + idx);
    if (row) row.remove();
    if (document.getElementById('item-list').children.length === 0) {
      document.getElementById('item-empty').style.display = '';
    }
  }
</script>

@endsection
