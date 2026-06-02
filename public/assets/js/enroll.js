(function () {

    /* ==========================
       Reveal animation
       ========================== */
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('[data-reveal]').forEach(el => io.observe(el));


    /* ==========================
       STEP 2 — Paiement
       ========================== */
    const baseEl      = document.getElementById('amountBase');
    const passSport   = document.getElementById('usePassSport');
    const amountPayEl = document.getElementById('amountToPay');
    const noteEl      = document.getElementById('amountNote');
    const splitBox    = document.querySelector('input[name="split"]');
    const splitEachEl = document.getElementById('splitEach');

    const AID = 7000; // 70 € en centimes

    function formatEUR(cents) {
        return (cents / 100).toLocaleString('fr-FR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }) + ' €';
    }

    function recompute() {
        if (!baseEl || !amountPayEl) return;

        const baseCents = parseInt(baseEl.dataset.cents || '0', 10);
        let net = baseCents - (passSport?.checked ? AID : 0);
        if (net < 0) net = 0;

        amountPayEl.textContent = formatEUR(net);

        if (noteEl) {
            noteEl.textContent = passSport?.checked
                ? "Le Pass’Sport sera vérifié par le club. Le dossier restera en attente jusqu’à validation."
                : "Carte bancaire : paiement sécurisé via Stripe.";
        }

        if (splitEachEl) {
            splitEachEl.textContent = formatEUR(Math.ceil(net / 2));
        }
    }

    passSport?.addEventListener('change', recompute);
    splitBox?.addEventListener('change', recompute);


    /* ==========================
       Sélection mode de paiement
       ========================== */
    document.querySelectorAll('.pay-tile input[type=radio]').forEach(radio => {
        radio.addEventListener('change', () => {
            document.querySelectorAll('.pay-tile')
                .forEach(tile => tile.classList.remove('is-active'));

            radio.closest('.pay-tile')?.classList.add('is-active');

            const splitRow = document.getElementById('split-row');
            if (splitRow) {
                splitRow.classList.toggle('hidden', radio.value !== 'card');
            }

            recompute();
        });
    });

    recompute();

})();
