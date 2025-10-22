(function () {
    const root   = document.documentElement;
    const burger = document.querySelector('.hdr-min .burger');
    const drawer = document.getElementById('side-nav');
    const close  = document.querySelector('.drawer-close');
    const overlay= document.querySelector('.drawer-overlay');

    if(!burger || !drawer) return;

    function openNav(){
        root.classList.add('nav-open');
        burger.setAttribute('aria-expanded','true');
        drawer.setAttribute('aria-hidden','false');
        // focus 1er lien
        const first = drawer.querySelector('a,button,[tabindex]:not([tabindex="-1"])');
        first && first.focus();
    }
    function closeNav(){
        root.classList.remove('nav-open');
        burger.setAttribute('aria-expanded','false');
        drawer.setAttribute('aria-hidden','true');
        burger.focus();
    }

    burger.addEventListener('click', ()=> root.classList.contains('nav-open') ? closeNav() : openNav());
    close && close.addEventListener('click', closeNav);
    overlay && overlay.addEventListener('click', closeNav);
    document.addEventListener('keydown', (e)=>{ if(e.key === 'Escape' && root.classList.contains('nav-open')) closeNav(); });

    // fermer le drawer quand on clique un lien
    drawer.addEventListener('click', (e)=>{
        const a = e.target.closest('a');
        if(a) closeNav();
    });
})();
