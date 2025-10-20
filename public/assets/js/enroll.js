(function(){
    // === reveal ===
    const io = new IntersectionObserver((es)=>es.forEach(e=>{
        if (e.isIntersecting){ e.target.classList.add('visible'); io.unobserve(e.target); }
    }), {threshold:.1});
    document.querySelectorAll('[data-reveal]').forEach(el=>io.observe(el));

    // === mineur / autorisation parentale (step1) ===
    const birth = document.getElementById('birthdate');
    const parental = document.getElementById('parent-authorization'); // <- nom aligné
    function toggleParental(){
        if(!birth || !parental) return;
        if(!birth.value){ parental.classList.add('hidden'); return; }
        const b = new Date(birth.value), t = new Date();
        let age = t.getFullYear() - b.getFullYear();
        const m = t.getMonth() - b.getMonth();
        if (m < 0 || (m === 0 && t.getDate() < b.getDate())) age--;
        parental.classList.toggle('hidden', age >= 18);
    }
    birth && (birth.addEventListener('change', toggleParental), toggleParental());

    // === sélection moyen de paiement (step2) ===
    document.querySelectorAll('.pay-tile input[type=radio]').forEach(r=>{
        r.addEventListener('change', ()=>{
            document.querySelectorAll('.pay-tile').forEach(c=>c.classList.remove('is-active'));
            r.closest('.pay-tile')?.classList.add('is-active');

            const splitRow = document.getElementById('split-row'); // <- ajoute cet id autour de la case 2×
            if (splitRow){
                splitRow.classList.toggle('hidden', r.value !== 'card');
            }
            // on peut aussi relancer le recalcul des montants
            recompute?.();
        });
    });

    // === calcul montants / Pass'Sport (step2) ===
    const baseEl       = document.getElementById('amountBase');
    const passSport    = document.getElementById('usePassSport');
    const amountToPay  = document.getElementById('amountToPay');
    const amountNote   = document.getElementById('amountNote');
    const splitBox     = document.querySelector('input[name="split"]');
    const splitEachEl  = document.getElementById('splitEach');
    const AID = 5000; // 50,00 €

    function formatEUR(cents){
        return (cents/100).toLocaleString('fr-FR',{minimumFractionDigits:2, maximumFractionDigits:2})+' €';
    }

    function recompute(){
        if (!baseEl || !amountToPay) return;
        const baseCents = parseInt(baseEl.dataset.cents || '0', 10);
        let net = baseCents - (passSport?.checked ? AID : 0);
        if (net < 0) net = 0;

        amountToPay.textContent = formatEUR(net);
        if (amountNote){
            amountNote.textContent = passSport?.checked
                ? "Le Pass’Sport sera vérifié par le club. Le dossier restera en attente jusqu’à validation du justificatif."
                : "CB = succès simulé (statut Payé). Les autres modes restent en En attente.";
        }
        if (splitBox && splitEachEl){
            splitEachEl.textContent = formatEUR(Math.ceil(net/2));
        }
    }

    passSport?.addEventListener('change', recompute);
    splitBox?.addEventListener('change', recompute);
    recompute();
})();
