// Tabs jours + reveal
(function(){
    const root = document.documentElement;
    const btns = document.querySelectorAll('.day-btn');
    const panels = document.querySelectorAll('.day-panel');

    function show(day){
        btns.forEach(b=>{
            const active = b.getAttribute('data-day') === day || (day==='all' && b.getAttribute('data-day')==='all');
            b.classList.toggle('is-active', active);
            b.setAttribute('aria-selected', active ? 'true' : 'false');
        });
        panels.forEach(p=>{
            const match = p.getAttribute('data-panel-day') === day || day==='all' && p.getAttribute('data-panel-day')==='all';
            p.classList.toggle('is-visible', match);
        });
    }

    btns.forEach(b=>{
        b.addEventListener('click', ()=> show(b.getAttribute('data-day')));
    });

    // Default: premier onglet
    const first = btns[0];
    first && show(first.getAttribute('data-day'));

    // Révélation douce
    const io = new IntersectionObserver((entries)=>{
        entries.forEach(e=>{
            if(e.isIntersecting){ e.target.classList.add('visible'); io.unobserve(e.target); }
        });
    }, {threshold:.15});
    document.querySelectorAll('[data-reveal]').forEach(el=>io.observe(el));
})();
