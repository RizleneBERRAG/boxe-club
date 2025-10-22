// ======================================================
// HEADER GLOBAL — NAV PRINCIPALE + MODALE MENU POPUP
// ======================================================
(function(){
    const root = document.documentElement;
    const hdr = document.querySelector('.hdr');
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('[data-nav]');
    const focusSel = 'a[href],button:not([disabled]),[tabindex]:not([tabindex="-1"])';

    if(burger && nav){
        const toggleNav = (open)=>{
            root.classList.toggle('nav-open', open);
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
            if(open){ (nav.querySelector(focusSel)||burger).focus(); }
            else { burger.focus(); }
        };

        burger.addEventListener('click', ()=> toggleNav(!root.classList.contains('nav-open')));
        nav.addEventListener('click', e=>{ if(e.target.closest('a')) toggleNav(false); });

        document.addEventListener('keydown', e=>{
            if(e.key==='Escape' && root.classList.contains('nav-open')) toggleNav(false);
            if(e.key!=='Tab' || !root.classList.contains('nav-open')) return;
            const f = nav.querySelectorAll(focusSel); if(!f.length) return;
            const first=f[0], last=f[f.length-1];
            if(e.shiftKey && document.activeElement===first){ last.focus(); e.preventDefault(); }
            else if(!e.shiftKey && document.activeElement===last){ first.focus(); e.preventDefault(); }
        });

        // Animation scroll
        let lastY = window.scrollY;
        const onScroll = ()=>{
            const y = window.scrollY;
            hdr?.classList.toggle('is-scrolled', y>10);
            if(matchMedia('(hover:none)').matches){
                if(y>lastY && y>80){ hdr.classList.add('hide'); hdr.classList.remove('show'); }
                else { hdr.classList.remove('hide'); hdr.classList.add('show'); }
            }
            lastY = y;
        };
        onScroll();
        window.addEventListener('scroll', onScroll, {passive:true});
    }
})();


// ======================================================
// MENU POP-UP CENTRÉ (modale design moderne)
// ======================================================
(function(){
    const root = document.documentElement;
    const openBtn   = document.querySelector('[data-hdr-menu-open]');
    const modal     = document.querySelector('[data-hdr-menu]');
    const backdrop  = document.querySelector('[data-hdr-menu-backdrop]');
    const closeBtn  = document.querySelector('[data-hdr-menu-close]');
    if(!openBtn || !modal || !backdrop || !closeBtn) return;

    const focusSel = 'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])';
    let lastFocus = null;

    function open(){
        lastFocus = document.activeElement;
        modal.hidden = false; backdrop.hidden = false;
        root.classList.add('hdr-menu-open');
        const first = modal.querySelector(focusSel);
        first && first.focus();
    }
    function close(){
        root.classList.remove('hdr-menu-open');
        modal.hidden = true; backdrop.hidden = true;
        lastFocus && lastFocus.focus();
    }

    openBtn.addEventListener('click', open);
    closeBtn.addEventListener('click', close);
    backdrop.addEventListener('click', close);

    document.addEventListener('keydown', (e)=>{
        if(e.key === 'Escape' && root.classList.contains('hdr-menu-open')) close();
        if(e.key === 'Tab' && root.classList.contains('hdr-menu-open')){
            const f = modal.querySelectorAll(focusSel);
            if(!f.length) return;
            const first = f[0], last = f[f.length-1];
            if(e.shiftKey && document.activeElement === first){ last.focus(); e.preventDefault(); }
            else if(!e.shiftKey && document.activeElement === last){ first.focus(); e.preventDefault(); }
        }
    });


})();
