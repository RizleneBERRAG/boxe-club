// ======================================================
// HERO VIDÉO — autoplay robuste + fallback + motion safety
// ======================================================

(function () {
    const video = document.getElementById('heroVideo');
    const fallback = document.querySelector('.hero-vid__fallback');
    if (!video) return;

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const showFallback = () => { if (fallback) fallback.style.opacity = '1'; };

    // Toujours muted au démarrage (sinon l'autoplay est souvent bloqué)
    video.muted = true;

    // Tente la lecture, retourne une promesse
    const tryPlay = () => {
        const p = video.play();
        if (p && typeof p.then === 'function') {
            return p.catch(() => {
                // Affiche l'image de repli et on retentera au premier geste utilisateur
                showFallback();
                attachFirstGestureRetry();
            });
        }
        return Promise.resolve();
    };

    // Retente la lecture au premier geste utilisateur (tap/clic/touche)
    const attachFirstGestureRetry = () => {
        const once = () => {
            window.removeEventListener('pointerdown', once);
            window.removeEventListener('keydown', once);
            video.play().catch(showFallback);
        };
        window.addEventListener('pointerdown', once, { once: true });
        window.addEventListener('keydown', once, { once: true });
    };

    // Respect des préférences "réduire les animations"
    if (reduceMotion) {
        video.removeAttribute('autoplay');
        video.pause();
        showFallback();
    } else {
        if (video.readyState >= 2) {
            tryPlay();
        } else {
            // on se cale dès que les metadata/frames mini sont là
            video.addEventListener('loadeddata', tryPlay, { once: true });
        }
    }

    // Si la vidéo lève une erreur réseau/codec → fallback
    video.addEventListener('error', showFallback, { passive: true });
    // Si la lecture s'interrompt (réseau), on n'insiste pas mais on affiche le fallback
    video.addEventListener('stalled', showFallback, { passive: true });
    video.addEventListener('suspend', () => {/* no-op, évite de spammer */}, { passive: true });

    // Pause quand onglet non visible, reprise au retour
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            video.pause();
        } else if (!reduceMotion) {
            video.play().catch(showFallback);
        }
    });

    // (Optionnel) Bouton son si présent dans le DOM :
    // <button class="hero-vid__sound" aria-pressed="false" type="button">🔇</button>
    const soundBtn = document.querySelector('.hero-vid__sound');
    if (soundBtn) {
        soundBtn.addEventListener('click', () => {
            const on = soundBtn.getAttribute('aria-pressed') === 'true';
            const next = !on;
            soundBtn.setAttribute('aria-pressed', String(next));
            video.muted = !next;                // si "on" → son activé → muted=false
            // tenter la lecture si elle était stoppée par le navigateur
            if (!reduceMotion) video.play().catch(showFallback);
        });
    }
})();


// ======================================================
// MICRO-PARALLAXE (optionnel) sur un collage s'il existe
// ======================================================
(() => {
    const wrap = document.querySelector('.cta-collage');
    if (!wrap) return;

    wrap.addEventListener('mousemove', (e) => {
        const r = wrap.getBoundingClientRect();
        const cx = (e.clientX - r.left) / r.width - 0.5;
        const cy = (e.clientY - r.top)  / r.height - 0.5;
        wrap.style.transform = `perspective(900px) rotateX(${(-cy * 2)}deg) rotateY(${(cx * 2)}deg)`;
    });

    wrap.addEventListener('mouseleave', () => {
        wrap.style.transform = '';
    });
})();


// Toggle "En savoir plus" sur les cartes membres
document.addEventListener('click', (e) => {
    const btn = e.target.closest('.m-card__more');
    if (!btn) return;

    const id = btn.getAttribute('data-target');
    const panel = document.getElementById(`m-${id}`);
    if (!panel) return;

    const expanded = btn.getAttribute('aria-expanded') === 'true';
    btn.setAttribute('aria-expanded', String(!expanded));

    // Afficher/cacher avec attributes accessibles
    if (expanded) {
        panel.setAttribute('hidden', '');
        panel.setAttribute('aria-hidden', 'true');
        btn.textContent = 'En savoir plus';
    } else {
        panel.removeAttribute('hidden');
        panel.setAttribute('aria-hidden', 'false');
        btn.textContent = 'Fermer';
    }
});

// =======================
// Compteurs "Notre histoire" + effet pulse
// =======================
(() => {
    const wrap = document.getElementById('historyNumbers');
    if (!wrap) return;

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const fmt = new Intl.NumberFormat('fr-FR');
    const easeOutCubic = t => 1 - Math.pow(1 - t, 3);

    const animateCounter = (el) => {
        const target = parseInt(el.getAttribute('data-to') || '0', 10);
        const prefix = el.getAttribute('data-prefix') || '';
        const duration = 1600; // ms

        if (reduceMotion) {
            el.textContent = prefix + fmt.format(target);
            return;
        }

        el.classList.add('active');
        const start = performance.now();
        const tick = (now) => {
            const p = Math.min(1, (now - start) / duration);
            const value = Math.round(target * easeOutCubic(p));
            el.textContent = prefix + fmt.format(value);
            if (p < 1) requestAnimationFrame(tick);
            else {
                el.classList.remove('active'); // retire le glow à la fin
            }
        };
        requestAnimationFrame(tick);
    };

    let done = false;
    const io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (done) return;
            if (entry.isIntersecting && entry.intersectionRatio > 0.4) {
                wrap.querySelectorAll('.counter').forEach(animateCounter);
                done = true;
                io.disconnect();
            }
        });
    }, { threshold: [0.4] });

    io.observe(wrap);
})();

    document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('img[data-fallback-exts]').forEach(img => {
        const base = img.dataset.base;                      // ex: /assets/img/partners/oms
        const exts = img.dataset.fallbackExts.split(',');   // ex: "png,jpg,jpeg,webp"
        let i = 0;
        const tryNext = () => {
            if (i >= exts.length) return;
            img.src = base + '.' + exts[i++].trim();
        };
        img.addEventListener('error', tryNext, { once:false });
        // 1er essai (déclenche onerror si 404)
        tryNext();
    });
});
