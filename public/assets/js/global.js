// Header v2 — Burger accessible (ARIA + focus trap + fermeture intelligente)
(function () {
    const root   = document.documentElement;
    const header = document.querySelector('.site-header.v2');
    if (!header) return;

    const toggle = header.querySelector('.nav-toggle');
    const nav    = header.querySelector('[data-nav]');
    if (!toggle || !nav) return;

    const FOCUS_SELECTOR = 'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])';

    // Assure ARIA
    toggle.setAttribute('aria-controls', 'primary-nav');
    toggle.setAttribute('aria-expanded', 'false');
    toggle.setAttribute('aria-label', 'Ouvrir le menu');

    function isOpen() {
        return root.classList.contains('nav-open');
    }

    function openNav() {
        root.classList.add('nav-open');
        toggle.setAttribute('aria-expanded', 'true');
        toggle.setAttribute('aria-label', 'Fermer le menu');

        // Focus premier élément du menu
        const first = nav.querySelector(FOCUS_SELECTOR);
        first && first.focus();

        // Option : bloquer le scroll du body en mobile
        // document.body.classList.add('no-scroll');
    }

    function closeNav() {
        root.classList.remove('nav-open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Ouvrir le menu');
        toggle.focus();

        // document.body.classList.remove('no-scroll');
    }

    // Toggle via bouton
    toggle.addEventListener('click', () => (isOpen() ? closeNav() : openNav()));

    // Fermer en cliquant un lien du menu (mobile)
    nav.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => isOpen() && closeNav());
    });

    // Échap pour fermer
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isOpen()) closeNav();
    });

    // Focus trap quand le menu est ouvert
    document.addEventListener('keydown', (e) => {
        if (!isOpen() || e.key !== 'Tab') return;
        const items = nav.querySelectorAll(FOCUS_SELECTOR);
        if (!items.length) return;

        const first = items[0];
        const last  = items[items.length - 1];

        if (e.shiftKey && document.activeElement === first) {
            last.focus(); e.preventDefault();
        } else if (!e.shiftKey && document.activeElement === last) {
            first.focus(); e.preventDefault();
        }
    });

    // Fermer si clic en dehors du header
    document.addEventListener('click', (e) => {
        if (!isOpen()) return;
        if (!e.target.closest('.site-header.v2')) closeNav();
    });

    // Fermer si on repasse en desktop (resize)
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 961 && isOpen()) closeNav();
    });
})();
// Burger + focus trap + close on link
(function(){
    const root = document.documentElement;
    const btn = document.querySelector('.burger');
    const nav = document.querySelector('.nav');
    if(!btn || !nav) return;

    const focusSel = 'a[href],button:not([disabled]),[tabindex]:not([tabindex="-1"])';
    const toggle = (open)=> {
        root.classList.toggle('nav-open', open);
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        if(open){ (nav.querySelector(focusSel)||btn).focus(); }
        else { btn.focus(); }
    };

    btn.addEventListener('click', ()=> toggle(!root.classList.contains('nav-open')));
    nav.addEventListener('click', e=>{ if(e.target.closest('a')) toggle(false); });

    // Esc
    document.addEventListener('keydown', e=>{
        if(e.key==='Escape' && root.classList.contains('nav-open')) toggle(false);
        if(e.key!=='Tab' || !root.classList.contains('nav-open')) return;
        const f = nav.querySelectorAll(focusSel); if(!f.length) return;
        const first=f[0], last=f[f.length-1];
        if(e.shiftKey && document.activeElement===first){ last.focus(); e.preventDefault(); }
        else if(!e.shiftKey && document.activeElement===last){ first.focus(); e.preventDefault(); }
    });

    // Scroll: ombre + hide on scroll down (mobile)
    const hdr = document.querySelector('.hdr');
    let lastY = window.scrollY;
    const onScroll = ()=>{
        const y = window.scrollY;
        hdr.classList.toggle('is-scrolled', y>10);
        if(matchMedia('(hover:none)').matches){
            if(y>lastY && y>80){ hdr.classList.add('hide'); hdr.classList.remove('show'); }
            else { hdr.classList.remove('hide'); hdr.classList.add('show'); }
        }
        lastY = y;
    };
    onScroll();
    window.addEventListener('scroll', onScroll, {passive:true});
})();
