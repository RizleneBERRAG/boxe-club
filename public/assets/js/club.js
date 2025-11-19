/* =========================================================
   Team Bafounta — JS page Club (clean+)
   - Intro logo overlay (durée + 1x/session optionnel)
   - Scroll doux (respecte Reduced Motion)
   - Reveal au scroll
   - Hero: bouton son + scroll vers la section suivante
   - Effet “tilt” léger sur cartes valeur
   - Parallaxe des blocs studio via var CSS --py (compatible hover)
   - Timeline: ligne de progression
   - Toggle thème (si #themeToggle présent)
   ========================================================= */

/* ---------- Config ---------- */
const INTRO_LOGO_DURATION = 2200;          // ms — change la durée ici
const INTRO_ONLY_ONCE_PER_SESSION = false; // true = 1x / session

/* ---------- Capabilities ---------- */
const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const supportsIO = 'IntersectionObserver' in window;

/* ---------- Scroll doux ---------- */
(() => {
    if (!prefersReduced) document.documentElement.style.scrollBehavior = 'smooth';
})();

/* ---------- Reveal au scroll ---------- */
(() => {
    const els = document.querySelectorAll('.reveal');
    if (!els.length) return;

    if (!supportsIO) { els.forEach(el => el.classList.add('is-in')); return; }

    const io = new IntersectionObserver((entries) => {
        entries.forEach(({ isIntersecting, target }) => {
            if (!isIntersecting) return;
            target.classList.add('is-in');
            io.unobserve(target);
        });
    }, { threshold: 0.15 });

    els.forEach(el => io.observe(el));
})();

/* ---------- Intro LOGO overlay ---------- */
(() => {
    const overlay = document.querySelector('.logo-intro');
    if (!overlay) return;

    const KEY = 'tb_intro_logo_seen';

    if (INTRO_ONLY_ONCE_PER_SESSION) {
        try {
            if (sessionStorage.getItem(KEY)) { overlay.remove(); return; }
        } catch { /* ignore */ }
    }

    const duration = prefersReduced ? 200 : INTRO_LOGO_DURATION;

    setTimeout(() => {
        overlay.classList.add('logo-intro--fade'); // (.6s en CSS)
        setTimeout(() => {
            if (overlay && overlay.parentNode) overlay.remove();
        }, 650);
        try { if (INTRO_ONLY_ONCE_PER_SESSION) sessionStorage.setItem(KEY, '1'); } catch {}
    }, duration);
})();

/* ---------- Hero: son + scroll vers section suivante ---------- */
(() => {
    const hero  = document.querySelector('.hero-vid--club');
    if (!hero) return;

    const video    = hero.querySelector('.hero-vid__video');
    const btnSound = hero.querySelector('.hero-sound');

    // 1) Mute/unmute
    if (video && btnSound) {
        const updateUI = () => btnSound.setAttribute('aria-pressed', String(!video.muted));
        updateUI();

        btnSound.addEventListener('click', (e) => {
            e.stopPropagation();
            video.muted = !video.muted;
            video.play?.().catch(() => {});
            updateUI();
        });
    }

    // 2) Clic sur le hero -> scroll à la section suivante
    const nextSection = () => {
        const next = hero.nextElementSibling;
        if (next) {
            const top = next.getBoundingClientRect().top + window.scrollY;
            window.scrollTo({ top, behavior: 'smooth' });
        } else {
            window.scrollBy({ top: window.innerHeight * 0.9, behavior: 'smooth' });
        }
    };

    hero.addEventListener('click', (e) => {
        const control = e.target.closest('a,button,[role="button"],input,select,textarea,label,video,.hero-sound');
        if (control) return;
        nextSection();
    });
})();

/* ---------- Valeurs: halo “tilt” au survol ---------- */
(() => {
    const cards = document.querySelectorAll('.v-card[data-tilt]');
    if (!cards.length) return;

    let rafId = null;
    let last = { el:null, x:50, y:0 };

    const schedule = (el, x, y) => {
        last = { el, x, y };
        if (rafId) return;
        rafId = requestAnimationFrame(() => {
            last.el.style.setProperty('--mx', `${last.x}%`);
            last.el.style.setProperty('--my', `${last.y}%`);
            rafId = null;
        });
    };

    cards.forEach(el => {
        el.addEventListener('mousemove', (e) => {
            const r = el.getBoundingClientRect();
            const x = ((e.clientX - r.left) / r.width) * 100;
            const y = ((e.clientY - r.top)  / r.height) * 100;
            schedule(el, x, y);
        });
        el.addEventListener('mouseleave', () => {
            el.style.removeProperty('--mx');
            el.style.removeProperty('--my');
        });
    });
})();

/* ---------- Studio: parallaxe douce via CSS var --py ---------- */
(() => {
    if (prefersReduced) return;

    const items = document.querySelectorAll('.studio-block[data-parallax]');
    if (!items.length) return;

    let ticking = false;
    const strength = 12; // px max

    const compute = () => {
        items.forEach(el => {
            const r = el.getBoundingClientRect();
            const center = r.top + r.height / 2;
            const viewportCenter = window.innerHeight / 2;
            const dist = (center - viewportCenter) / viewportCenter; // ~[-1..1]
            const offset = Math.max(-1, Math.min(1, -dist)) * strength;
            el.style.setProperty('--py', `${offset.toFixed(1)}px`);
        });
        ticking = false;
    };

    const onScroll = () => {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(compute);
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    compute(); // init
})();

/* ---------- Timeline: ligne de progression ---------- */
(() => {
    const section = document.querySelector('.club-timeline');
    const line = section?.querySelector('.timeline-list');
    if (!section || !line) return;

    const onScroll = () => {
        const rect = section.getBoundingClientRect();
        const vh = window.innerHeight || 1;
        // progress 0→1 quand la section parcourt la fenêtre
        const start = Math.min(1, Math.max(0, 1 - rect.top / vh));
        const end   = Math.min(1, Math.max(0, (vh - rect.bottom) / vh + 1));
        const progress = Math.max(start, end); // un peu plus généreux
        line.style.setProperty('--progress', `${(progress * 100).toFixed(0)}%`);
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
})();

/* ---------- Thème (optionnel — si #themeToggle existe) ---------- */
(() => {
    const btn = document.querySelector('#themeToggle');
    if (!btn) return;

    btn.addEventListener('click', () => {
        const html = document.documentElement;
        html.classList.toggle('theme-light');
        html.classList.toggle('theme-dark');
        localStorage.setItem('theme', html.classList.contains('theme-light') ? 'light' : 'dark');
    });

    const saved = localStorage.getItem('theme');
    if (saved) document.documentElement.className = `theme-${saved}`;
})();
