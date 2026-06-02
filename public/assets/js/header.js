/* header-menu.js — menu modal accessible + lock scroll + focus trap */
(function () {
    const html      = document.documentElement;
    const body      = document.body;

    const menu      = document.querySelector('[data-hdr-menu]');
    const openBtn   = document.querySelector('[data-hdr-menu-open]');
    const closeBtn  = document.querySelector('[data-hdr-menu-close]');
    const backdrop  = document.querySelector('[data-hdr-menu-backdrop]');

    if (!menu || !openBtn || !backdrop) return;

    // Elements focusables dans le modal
    const FOCUSABLE = [
        'a[href]', 'area[href]',
        'button:not([disabled])',
        'input:not([disabled]):not([type="hidden"])',
        'select:not([disabled])',
        'textarea:not([disabled])',
        '[tabindex]:not([tabindex="-1"])'
    ].join(',');

    let lastFocused = null;
    let isOpen = false;

    /* --------- helpers --------- */
    const setSBW = () => {
        const sbw = window.innerWidth - document.documentElement.clientWidth;
        html.style.setProperty('--sbw', sbw + 'px');
    };

    const lockScroll = () => {
        setSBW();
        const y = window.scrollY;
        body.dataset.lockY = String(y);
        body.style.top = `-${y}px`;
        body.style.position = 'fixed';
        body.style.width = '100%';
        html.classList.add('is-menu-open');
    };

    const unlockScroll = () => {
        const y = +(body.dataset.lockY || 0);
        body.style.position = '';
        body.style.top = '';
        body.style.width = '';
        html.classList.remove('is-menu-open');
        window.scrollTo(0, y);
    };

    const firstFocusable = () => menu.querySelector(FOCUSABLE);
    const focusables = () => Array.from(menu.querySelectorAll(FOCUSABLE));

    const trapTab = (e) => {
        if (!isOpen || e.key !== 'Tab') return;
        const items = focusables();
        if (items.length === 0) return;

        const first = items[0];
        const last  = items[items.length - 1];

        // SHIFT + TAB
        if (e.shiftKey) {
            if (document.activeElement === first || !menu.contains(document.activeElement)) {
                e.preventDefault();
                last.focus();
            }
            return;
        }
        // TAB
        if (document.activeElement === last) {
            e.preventDefault();
            first.focus();
        }
    };

    const onKeydown = (e) => {
        if (!isOpen) return;
        if (e.key === 'Escape') {
            e.preventDefault();
            close();
        }
    };

    /* --------- open / close --------- */
    const open = () => {
        if (isOpen) return; isOpen = true;
        lastFocused = document.activeElement;

        // ARIA + affichage
        openBtn.setAttribute('aria-expanded','true');
        menu.hidden = false; backdrop.hidden = false;

        // force reflow puis ajoute la classe d'ouverture (pour que la transition se joue)
        void menu.offsetHeight;
        menu.classList.add('is-open');
        backdrop.classList.add('is-visible');

        lockScroll();

        const first = firstFocusable();
        (first || menu).focus();

        document.addEventListener('keydown', trapTab, { capture:true });
        document.addEventListener('keydown', onKeydown);
    };

    const close = () => {
        if (!isOpen) return; isOpen = false;

        openBtn.setAttribute('aria-expanded','false');
        // joue l'animation de sortie
        menu.classList.remove('is-open');
        backdrop.classList.remove('is-visible');

        // après la transition, masque réellement l’UI
        const onEnd = () => {
            menu.hidden = true; backdrop.hidden = true;
            menu.removeEventListener('transitionend', onEnd);
        };
        menu.addEventListener('transitionend', onEnd);

        unlockScroll();

        if (lastFocused && lastFocused.focus) lastFocused.focus();

        document.removeEventListener('keydown', trapTab, { capture:true });
        document.removeEventListener('keydown', onKeydown);
    };


    /* --------- wiring --------- */
    openBtn.addEventListener('click', open);
    closeBtn?.addEventListener('click', close);
    backdrop.addEventListener('click', close);

    // Fermer si un lien du menu est cliqué (navigation)
    menu.addEventListener('click', (e) => {
        const a = e.target.closest('a');
        if (!a) return;
        // Laisse le navigateur suivre le lien, mais ferme tout de suite le modal
        close();
    });

    // Recalcule la scrollbar width si la fenêtre change de taille pendant l'ouverture
    window.addEventListener('resize', () => {
        if (isOpen) setSBW();
    });

    // Accessibilité : assure un tabindex sur le dialog si absent
    if (!menu.hasAttribute('tabindex')) {
        menu.setAttribute('tabindex', '-1');
    }

    // Bouton d’ouverture : initialise aria-controls/expanded si manquants
    if (!openBtn.hasAttribute('aria-controls')) {
        const id = menu.id || 'hdrMenu';
        if (!menu.id) menu.id = id;
        openBtn.setAttribute('aria-controls', id);
    }
    if (!openBtn.hasAttribute('aria-expanded')) {
        openBtn.setAttribute('aria-expanded', 'false');
    }
})();
