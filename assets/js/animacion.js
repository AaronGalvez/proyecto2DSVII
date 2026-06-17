// assets/js/animacion.js — Interacciones del navbar y footer (Panamá Turismo)

document.addEventListener('DOMContentLoaded', function () {

    /*  NAVBAR: efecto al hacer scroll  */
    const nav = document.getElementById('ptNav');
    if (nav) {
        const toggleScrolled = () => {
            if (window.scrollY > 10) nav.classList.add('is-scrolled');
            else nav.classList.remove('is-scrolled');
        };
        toggleScrolled();
        window.addEventListener('scroll', toggleScrolled);
    }

    /*  NAVBAR: menú móvil (burger)  */
    const burger  = document.getElementById('ptBurger');
    const links   = document.getElementById('ptLinks');
    const overlay = document.getElementById('ptOverlay');

    function closeMenu() {
        burger?.classList.remove('is-open');
        links?.classList.remove('is-open');
        overlay?.classList.remove('is-open');
        burger?.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    function openMenu() {
        burger?.classList.add('is-open');
        links?.classList.add('is-open');
        overlay?.classList.add('is-open');
        burger?.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    if (burger) {
        burger.addEventListener('click', () => {
            const isOpen = links?.classList.contains('is-open');
            isOpen ? closeMenu() : openMenu();
        });
    }

    overlay?.addEventListener('click', closeMenu);
    links?.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeMenu();
    });

    /*  NAVBAR: resaltar el enlace activo  */
    const params = new URLSearchParams(window.location.search);
    const rutaActual = params.get('ruta') || '';

    document.querySelectorAll('.pt-links a[href]').forEach(a => {
        try {
            const url = new URL(a.getAttribute('href'), window.location.href);
            const ruta = url.searchParams.get('ruta') || '';
            if (ruta === rutaActual) a.classList.add('active');
        } catch (err) { /* ignora enlaces no válidos */ }
    });

    /*  FOOTER: botón volver arriba  */
    const scrollTopBtn = document.getElementById('ptScrollTop');
    scrollTopBtn?.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    /*  FOOTER: newsletter (demo visual, sin backend)  */
    const newsletterForm = document.querySelector('.pt-newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = newsletterForm.querySelector('button');
            const original = btn.innerHTML;
            btn.innerHTML = '<i class="ti ti-check"></i> ¡Listo!';
            newsletterForm.reset();
            setTimeout(() => { btn.innerHTML = original; }, 2500);
        });
    }

});