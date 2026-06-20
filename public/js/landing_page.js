// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(a => {
a.addEventListener('click', e => {
    const target = document.querySelector(a.getAttribute('href'));
    if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
});
});

// Navbar glassmorphism on scroll
(function () {
    const navbar = document.querySelector('.navbar');
    if (!navbar) return;
    const onScroll = () => {
        if (window.scrollY > 40) {
            navbar.classList.add('navbar--scrolled');
            navbar.classList.remove('shadow-sm');
        } else {
            navbar.classList.remove('navbar--scrolled');
        }
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); // jalankan sekali saat load
})();

// Simple fade-in on scroll
const observer = new IntersectionObserver((entries) => {
entries.forEach(e => {
    if (e.isIntersecting) { e.target.style.opacity = 1; e.target.style.transform = 'translateY(0)'; }
});
}, { threshold: 0.15 });

document.querySelectorAll('.product-card, .why-item, .about-img-wrap, .why-img-wrap, .testi-card').forEach(el => {
    el.style.opacity = 0;
    el.style.transform = 'translateY(28px)';
    el.style.transition = 'opacity .6s ease, transform .6s ease';
    observer.observe(el);
});