// Reveal simple (cohérent avec home/courses)
(function(){
    const io = new IntersectionObserver((entries)=>{
        entries.forEach(e=>{
            if(e.isIntersecting){ e.target.classList.add('visible'); io.unobserve(e.target); }
        });
    }, {threshold:.15});
    document.querySelectorAll('[data-reveal]').forEach(el=>io.observe(el));
})();
