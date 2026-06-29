/* ── BUBBLES ── */
(function() {
const wrap = document.getElementById('bubbles');
const sizes = [18,26,38,14,22,32,20,44,16,28];
sizes.forEach((s, i) => {
    const b = document.createElement('div');
    b.className = 'bubble';
    b.style.cssText = `width:${s}px;height:${s}px;left:${Math.random()*96}%;`
    + `animation-duration:${7+Math.random()*9}s;`
    + `animation-delay:${Math.random()*8}s;`;
    wrap.appendChild(b);
});
})();

/* ── CARD SCROLL-IN ── */
const cards = document.querySelectorAll('.form-card');
const io = new IntersectionObserver(entries => {
entries.forEach(e => {
    if (e.isIntersecting) {
    const delay = e.target.dataset.delay || 0;
    setTimeout(() => e.target.classList.add('visible'), +delay);
    io.unobserve(e.target);
    }
});
}, { threshold: 0.15 });
cards.forEach(c => io.observe(c));

/* ── RIPPLE ON PESAN BUTTON ── */
document.getElementById('btnPesan').addEventListener('mousedown', function(e) {
const r = document.createElement('span');
r.className = 'ripple';
const rect = this.getBoundingClientRect();
const size = Math.max(rect.width, rect.height);
r.style.cssText = `width:${size}px;height:${size}px;`
    + `left:${e.clientX-rect.left-size/2}px;top:${e.clientY-rect.top-size/2}px;`;
this.appendChild(r);
r.addEventListener('animationend', () => r.remove());
});

/* ── UTILS ── */
let orders = [];

function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2400);
}

function changeQty(delta) {
    const input = document.getElementById('qty');
    let val = parseInt(input.value) || 1;
    val = Math.max(1, Math.min(99, val + delta));
    input.value = val;
    input.style.transform = 'scale(1.2)';
    setTimeout(() => input.style.transform = '', 150);
}

function formatRupiah(num) {
    return 'Rp ' + num.toLocaleString('id-ID');
}

/* ── Tambah Pesanan ── */
function tambahPesanan() {
    const produkSel = document.getElementById('produk');
    const varianSel = document.getElementById('varian');
    const qty = parseInt(document.getElementById('qty').value) || 1;

    if (!produkSel.value) { showToast('⚠️ Pilih produk terlebih dahulu!'); return; }
    if (!varianSel.value) { showToast('⚠️ Pilih ukuran terlebih dahulu!'); return; }

    const varianId   = varianSel.value;
    const harga      = parseInt(varianSel.selectedOptions[0].dataset.harga);
    const produkNama = produkSel.selectedOptions[0].text;
    const ukuran     = varianSel.selectedOptions[0].dataset.ukuran;
    const label      = `${produkNama} – ${ukuran}`;

    const existing = orders.find(o => o.varianId === varianId);
    if (existing) {
        existing.qty += qty;
    } else {
        orders.push({ varianId, label, qty, harga });
    }

    renderOrders();
    produkSel.selectedIndex = 0;
    document.getElementById('varian-wrap').style.display = 'none';
    varianSel.innerHTML = '<option value="" disabled selected>-- Pilih Ukuran --</option>';
    document.getElementById('qty').value = 1;
    showToast('✅ Item ditambahkan ke pesanan!');
}

function loadVarian(produkSel) {
    const produkId = produkSel.value;
    const varianSel = document.getElementById('varian');
    const varianWrap = document.getElementById('varian-wrap');

    varianSel.innerHTML = '<option value="" disabled selected>-- Pilih Ukuran --</option>';

    if (produkId && varianData[produkId]) {
        varianData[produkId].forEach(v => {
            const opt = document.createElement('option');
            opt.value = v.id;
            opt.dataset.harga = v.harga;
            opt.dataset.ukuran = v.ukuran;
            opt.textContent = `${v.ukuran} — Rp ${v.harga.toLocaleString('id-ID')}`;
            varianSel.appendChild(opt);
        });
        varianWrap.style.display = '';
    } else {
        varianWrap.style.display = 'none';
    }
}

function hapusItem(idx) {
    const items = document.querySelectorAll('.order-item');
    const target = items[idx];
    if (target) {
        target.style.transition = 'transform .2s, opacity .2s';
        target.style.transform = 'translateX(20px)';
        target.style.opacity = '0';
        setTimeout(() => { orders.splice(idx, 1); renderOrders(); }, 200);
    } else {
        orders.splice(idx, 1); renderOrders();
    }
}

function renderOrders() {
    const list = document.getElementById('orderList');
    const empty = document.getElementById('emptyMsg');
    const totalRow = document.getElementById('totalRow');

    list.querySelectorAll('.order-item').forEach(el => el.remove());

    if (orders.length === 0) {
        empty.style.display = '';
        totalRow.classList.add('d-none');
        return;
    }
    empty.style.display = 'none';
    totalRow.classList.remove('d-none');

    let total = 0;
    orders.forEach((o, i) => {
        const subtotal = o.qty * o.harga;
        total += subtotal;
        const div = document.createElement('div');
        div.className = 'order-item';
        div.innerHTML = `
        <div>
            <div class="order-item-name">${o.label}</div>
            <div class="order-item-qty">${o.qty} pcs × ${formatRupiah(o.harga)}</div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="order-item-price">${formatRupiah(subtotal)}</span>
            <button class="btn-remove" onclick="hapusItem(${i})" title="Hapus">
            <i class="bi bi-x-circle-fill"></i>
            </button>
        </div>`;
        list.appendChild(div);
    });

    const tv = document.getElementById('totalVal');
    tv.textContent = formatRupiah(total);
    tv.classList.remove('total-bump');
    void tv.offsetWidth;
    tv.classList.add('total-bump');
}

function pesanSekarang(btn, e) {
    const nama   = document.getElementById('nama').value.trim();
    const hp     = document.getElementById('hp').value.trim();
    const alamat = document.getElementById('alamat').value.trim();

    if (!nama)          { showToast('⚠️ Nama lengkap wajib diisi!'); return; }
    if (!hp)            { showToast('⚠️ Nomor HP wajib diisi!'); return; }
    if (!alamat)        { showToast('⚠️ Alamat pengiriman wajib diisi!'); return; }
    if (!orders.length) { showToast('⚠️ Belum ada pesanan!'); return; }

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const payload = {
        nama_pemesan: nama,
        nomor_hp: hp,
        alamat: alamat,
        items: orders.map(o => ({ varian_id: o.varianId, qty: o.qty })),
    };

    fetch('/pesan-sekarang', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify(payload),
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast('✅ Pesanan berhasil! Mengalihkan...');
            setTimeout(() => {
                window.location.href = data.redirect_url || '/pesan-sukses';
            }, 1200);
        } else {
            showToast('❌ Gagal mengirim pesanan.');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-whatsapp me-2"></i>Pesan Sekarang';
        }
    })
    .catch(() => {
        showToast('❌ Terjadi kesalahan. Coba lagi.');
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-whatsapp me-2"></i>Pesan Sekarang';
    });
}