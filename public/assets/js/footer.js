/* ===========================================================
   FOOTER INTERACTIF — Team Bafounta (clean + A11Y + RM safe)
   =========================================================== */
(() => {
    const footer = document.querySelector('.ft');           // wrapper commun
    if (!footer) return;

    const logo = footer.querySelector('.ft-hero__right img');
    const socialIcons = footer.querySelectorAll('.ft-ico'); // icônes sociales
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* -------------------------------
       1) Apparition douce du footer
    -------------------------------- */
    if ('IntersectionObserver' in window) {
        const io = new IntersectionObserver((entries, obs) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    footer.classList.add('is-visible');
                    obs.disconnect();
                }
            });
        }, { threshold: 0.2 });
        io.observe(footer);
    } else {
        footer.classList.add('is-visible');
    }

    /* -------------------------------------
       2) Parallaxe subtile sur le logo (RM safe)
    -------------------------------------- */
    if (logo && !reduceMotion) {
        let rafId = null;
        const mouse = { x: 0, y: 0 };

        const onMove = (e) => {
            const { innerWidth: w, innerHeight: h } = window;
            mouse.x = (e.clientX - w / 2) / w;
            mouse.y = (e.clientY - h / 2) / h;
            cancelAnimationFrame(rafId);
            rafId = requestAnimationFrame(() => {
                const moveX = mouse.x * 12; // amplitude X
                const moveY = mouse.y * 8;  // amplitude Y
                logo.style.transform = `translate(${moveX}px, ${moveY}px) scale(1.02)`;
            });
        };

        const onLeave = () => { logo.style.transform = ''; };

        footer.addEventListener('mousemove', onMove, { passive: true });
        footer.addEventListener('mouseleave', onLeave, { passive: true });
    }

    /* -----------------------------------------
       3) Ripple effect sur les icônes sociales
    ------------------------------------------ */
    socialIcons.forEach(icon => {
        icon.addEventListener('click', (e) => {
            // évite de superposer 2 ripples si double-clic
            const old = icon.querySelector('.ripple');
            if (old) old.remove();

            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            icon.appendChild(ripple);

            const rect = icon.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
            ripple.style.top  = (e.clientY - rect.top  - size / 2) + 'px';

            setTimeout(() => ripple.remove(), 600);
        });
    });

    /* -----------------------------------------
       4) Effet tactile (mobile-friendly)
    ------------------------------------------ */
    const addTouched = (el) => el.classList.add('touched');
    const clearTouched = () => footer.querySelectorAll('.touched').forEach(el => el.classList.remove('touched'));

    footer.addEventListener('touchstart', (e) => {
        const t = e.target.closest('.ft-ico, .contact-line__link, .contact-line__copy, a');
        if (t) addTouched(t);
    }, { passive: true });
    footer.addEventListener('touchend', clearTouched, { passive: true });
    footer.addEventListener('touchcancel', clearTouched, { passive: true });

})();

/* ===========================================================
   COPIE (téléphone / e-mail) — minimal + accessible
   =========================================================== */
(() => {
    const lines = document.querySelectorAll('.contact-line');
    if (!lines.length) return;

    // zone ARIA-live pour feedback user
    let live = document.getElementById('ft-live');
    if (!live) {
        live = document.createElement('div');
        live.id = 'ft-live';
        live.setAttribute('aria-live', 'polite');
        live.setAttribute('aria-atomic', 'true');
        live.style.position = 'absolute';
        live.style.width = '1px';
        live.style.height = '1px';
        live.style.overflow = 'hidden';
        live.style.clipPath = 'inset(50%)';
        live.style.clip = 'rect(1px, 1px, 1px, 1px)';
        live.style.whiteSpace = 'nowrap';
        document.body.appendChild(live);
    }

    const doCopy = async (text) => {
        try {
            await navigator.clipboard.writeText(text);
            return true;
        } catch {
            // fallback legacy
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.position = 'fixed';
            ta.style.top = '-9999px';
            document.body.appendChild(ta);
            ta.focus();
            ta.select();
            try { document.execCommand('copy'); } catch {}
            document.body.removeChild(ta);
            return true;
        }
    };

    const getValueToCopy = (line) => {
        const btn  = line.querySelector('.contact-line__copy');
        const link = line.querySelector('.contact-line__link');

        // priorité à data-copy si présent
        const data = btn?.dataset.copy || link?.dataset.copy;
        if (data) return data;

        // fallback depuis l'URL (tel: / mailto:)
        const href = link?.getAttribute('href') || '';
        if (href.startsWith('tel:')) return href.replace(/^tel:/, '');
        if (href.startsWith('mailto:')) return href.replace(/^mailto:/, '');
        // fallback depuis le texte
        const valEl = line.querySelector('.contact-line__value');
        return (valEl?.textContent || '').trim();
    };

    lines.forEach(line => {
        const btn = line.querySelector('.contact-line__copy');
        if (!btn) return;

        const value = getValueToCopy(line);

        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const ok = await doCopy(value);
            if (ok) {
                line.classList.add('is-copied');
                const original = btn.textContent;
                btn.textContent = 'Copié !';
                live.textContent = 'Copié dans le presse-papiers.';
                setTimeout(() => {
                    btn.textContent = original || 'Copier';
                    line.classList.remove('is-copied');
                    live.textContent = '';
                }, 1100);
            }
        });
    });
})();
