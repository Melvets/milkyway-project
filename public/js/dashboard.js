// ── Page date ─────────────────────────────────
const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
const now = new Date();
document.getElementById('page-date').textContent =
days[now.getDay()] + ' · ' + now.getDate() + ' ' + months[now.getMonth()] + ' · ' + now.getFullYear();

// ── Counter animation ─────────────────────────
function animateCount(el, target) {
let v = 0;
const step = target / 55;
const tick = () => {
    v = Math.min(v + step, target);
    el.textContent = Math.round(v).toLocaleString('id-ID');
    if (v < target) requestAnimationFrame(tick);
};
setTimeout(tick, 400);
}
document.querySelectorAll('.stat-value[data-target]').forEach(el => {
animateCount(el, parseInt(el.dataset.target));
});

// Revenue counter
const revEl = document.getElementById('revenue-val');
let rv = 0, rvTarget = 1100000;
const rvTick = () => {
rv = Math.min(rv + rvTarget / 55, rvTarget);
const m = rv / 1000000;
revEl.textContent = m >= 1 ? m.toFixed(1) + 'M' : Math.round(rv / 1000) + 'K';
if (rv < rvTarget) requestAnimationFrame(rvTick);
};
setTimeout(rvTick, 400);

// ── Build mobile order cards ───────────────────
const orderData = [
{ id:'#MW-8820', name:'Carmenita Ayu', phone:'+62 812-3456-7890', variant:'Strawberry 1L', vClass:'v-strawberry', qty:1, price:'Rp.30.000', status:'Pending', sClass:'s-pending' },
{ id:'#MW-8821', name:'Kimberly Salim', phone:'+62 812-3456-7891', variant:'Original Botol 250ml', vClass:'v-original', qty:3, price:'Rp.30.000', status:'Shipped', sClass:'s-shipped' },
{ id:'#MW-8822', name:'Zayyan Fahri', phone:'+62 812-3456-7892', variant:'Cokelat Botol 250ml', vClass:'v-cokelat', qty:5, price:'Rp.50.000', status:'Processing', sClass:'s-processing' },
{ id:'#MW-8823', name:'Edward Martin', phone:'+62 812-3456-7893', variant:'Alpukat 1L', vClass:'v-alpukat', qty:1, price:'Rp.30.000', status:'Pending', sClass:'s-pending' },
{ id:'#MW-8824', name:'Nadia Permata', phone:'+62 812-3456-7894', variant:'Vanilla 1L', vClass:'v-vanilla', qty:2, price:'Rp.60.000', status:'Shipped', sClass:'s-shipped' },
];

function buildMobileCards(data) {
const list = document.getElementById('mobile-order-list');
list.innerHTML = data.map(o => `
    <div class="order-card" data-status="${o.status.toLowerCase()}">
    <div class="order-card-top">
        <div>
        <div class="order-card-id">${o.id}</div>
        <div class="order-card-name">${o.name}</div>
        <div class="order-card-phone">${o.phone}</div>
        </div>
        <span class="status-badge ${o.sClass}">${o.status}</span>
    </div>
    <div class="order-card-row">
        <div class="order-card-meta">
        <span class="variant-badge ${o.vClass}">${o.variant}</span>
        <span class="order-card-qty">×${o.qty}</span>
        </div>
        <div style="display:flex;align-items:center;gap:10px">
        <span class="order-card-price">${o.price}</span>
        <div class="order-card-actions">
            <button class="act-btn act-edit"><i class="bi bi-pencil"></i></button>
            <button class="act-btn act-delete"><i class="bi bi-trash3"></i></button>
        </div>
        </div>
    </div>
    </div>
`).join('');

// Attach delete handlers for mobile cards
list.querySelectorAll('.act-delete').forEach(btn => {
    btn.addEventListener('click', () => {
    const card = btn.closest('.order-card');
    card.style.transition = 'opacity .28s, transform .28s';
    card.style.opacity = '0';
    card.style.transform = 'translateX(20px)';
    setTimeout(() => card.remove(), 300);
    });
});
}
buildMobileCards(orderData);

// ── Filter tabs ────────────────────────────────
const allRows  = [...document.querySelectorAll('#order-tbody tr')];

function applyFilter(filter) {
// Desktop rows
allRows.forEach(row => {
    const st = row.dataset.status || '';
    row.style.display = (filter === 'all' || st === filter) ? '' : 'none';
});
// Mobile cards
document.querySelectorAll('#mobile-order-list .order-card').forEach(card => {
    const st = card.dataset.status || '';
    card.style.display = (filter === 'all' || st === filter) ? '' : 'none';
});
}

document.querySelectorAll('.filter-tab').forEach(tab => {
tab.addEventListener('click', () => {
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
    applyFilter(tab.dataset.filter);
});
});

// ── Sidebar drawer (mobile) ────────────────────
const sidebar  = document.getElementById('sidebar');
const overlay  = document.getElementById('overlay');
const menuToggle  = document.getElementById('menuToggle');
const sidebarClose = document.getElementById('sidebarClose');

function openSidebar() {
sidebar.classList.add('open');
overlay.classList.add('show');
document.body.style.overflow = 'hidden';
}
function closeSidebar() {
sidebar.classList.remove('open');
overlay.classList.remove('show');
document.body.style.overflow = '';
}

menuToggle.addEventListener('click', openSidebar);
sidebarClose.addEventListener('click', closeSidebar);
overlay.addEventListener('click', closeSidebar);

// ── Nav active state ───────────────────────────
function setActivePage(page) {
document.querySelectorAll('.nav-item-link[data-page]').forEach(l => l.classList.remove('active'));
document.querySelectorAll(`.nav-item-link[data-page="${page}"]`).forEach(l => l.classList.add('active'));
document.querySelectorAll('.bn-item[data-page]').forEach(b => b.classList.remove('active'));
document.querySelectorAll(`.bn-item[data-page="${page}"]`).forEach(b => b.classList.add('active'));
}

document.querySelectorAll('.nav-item-link[data-page]').forEach(link => {
link.addEventListener('click', () => {
    setActivePage(link.dataset.page);
    closeSidebar();
});
});

document.querySelectorAll('.bn-item[data-page]').forEach(btn => {
btn.addEventListener('click', () => setActivePage(btn.dataset.page));
});

// ── Desktop table delete ───────────────────────
document.querySelectorAll('#order-tbody .act-delete').forEach(btn => {
btn.addEventListener('click', () => {
    const row = btn.closest('tr');
    row.style.transition = 'opacity .28s, transform .28s';
    row.style.opacity = '0';
    row.style.transform = 'translateX(20px)';
    setTimeout(() => row.remove(), 300);
});
});

// ── Pagination ─────────────────────────────────
document.querySelectorAll('.page-btn').forEach(btn => {
btn.addEventListener('click', () => {
    document.querySelectorAll('.page-btn').forEach(b => b.classList.remove('active'));
    if (!btn.querySelector('i')) btn.classList.add('active');
});
});