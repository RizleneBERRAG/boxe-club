document.addEventListener("DOMContentLoaded", () => {
    const logoIntro = document.getElementById("logoIntro");

    // Faire disparaître l'intro après ~1.7s
    if (logoIntro) {
        setTimeout(() => {
            logoIntro.classList.add("logo-intro--hide");
        }, 1700);
    }

    /* ==== PARALLAX DOUX SUR LE HERO ==== */
    const layers = document.querySelectorAll(".hero-layer");
    document.addEventListener("mousemove", (e) => {
        const x = (e.clientX / window.innerWidth) - 0.5;
        const y = (e.clientY / window.innerHeight) - 0.5;
        layers.forEach(layer => {
            const depth = parseFloat(layer.dataset.depth || 0.2);
            const translateX = -x * depth * 30;
            const translateY = -y * depth * 20;
            layer.style.transform = `translate3d(${translateX}px, ${translateY}px, 0)`;
        });
    });

    /* ==== SCROLL DOUX POUR LES ANCRES ==== */
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener("click", (e) => {
            const id = link.getAttribute("href").slice(1);
            const target = document.getElementById(id);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({behavior: "smooth", block: "start"});
            }
        });
    });

    /* ==== RÉVÉLATION AU SCROLL ==== */
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("is-visible");
                    observer.unobserve(entry.target);
                }
            });
        },
        {threshold: 0.15}
    );

    document.querySelectorAll(".reveal").forEach(el => observer.observe(el));

    /* ==== TILT AU HOVER (CARDS) ==== */
    const tiltCards = document.querySelectorAll(".tilt");
    tiltCards.forEach(card => {
        card.addEventListener("mousemove", (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = ((y - centerY) / centerY) * -6;
            const rotateY = ((x - centerX) / centerX) * 6;
            card.classList.add("is-tilting");
            card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) translate3d(0,0,0)`;
        });

        card.addEventListener("mouseleave", () => {
            card.classList.remove("is-tilting");
            card.style.transform = "rotateX(0deg) rotateY(0deg)";
        });
    });

    /* ==== BARRE DE SCROLL + NAV STICKY ==== */
    const scrollProgress = document.getElementById("scrollProgress");
    const topNav = document.getElementById("topNav");
    const hero = document.querySelector(".hero");

    function handleScrollUI() {
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const progress = docHeight > 0 ? (scrollTop / docHeight) : 0;

        if (scrollProgress) {
            scrollProgress.style.width = `${progress * 100}%`;
        }

        if (topNav && hero) {
            const heroHeight = hero.offsetHeight * 0.7;
            if (scrollTop > heroHeight) {
                topNav.classList.add("top-nav--visible");
            } else {
                topNav.classList.remove("top-nav--visible");
            }
        }
    }

    window.addEventListener("scroll", handleScrollUI);
    handleScrollUI();

    /* ==== COMPTE A REBOURS ==== */
    const targetDate = new Date("2025-12-19T16:00:00"); // 19 décembre 2025 à 16h
    const countdownEl = document.getElementById("countdown");

    function updateCountdown() {
        if (!countdownEl) return;
        const now = new Date();
        let diff = targetDate - now;
        if (diff < 0) diff = 0;

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor(diff / (1000 * 60 * 60)) % 24;
        const minutes = Math.floor(diff / (1000 * 60)) % 60;
        const seconds = Math.floor(diff / 1000) % 60;

        countdownEl.querySelector('[data-unit="days"]').textContent = String(days).padStart(2, "0");
        countdownEl.querySelector('[data-unit="hours"]').textContent = String(hours).padStart(2, "0");
        countdownEl.querySelector('[data-unit="minutes"]').textContent = String(minutes).padStart(2, "0");
        countdownEl.querySelector('[data-unit="seconds"]').textContent = String(seconds).padStart(2, "0");
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);

    /* ==== PARTAGE ==== */
    const shareButton = document.getElementById("shareButton");

    function showShareToast(message) {
        let toast = document.querySelector(".share-toast");
        if (!toast) {
            toast = document.createElement("div");
            toast.className = "share-toast";
            document.body.appendChild(toast);
        }
        toast.textContent = message;
        toast.classList.add("share-toast--visible");
        setTimeout(() => toast.classList.remove("share-toast--visible"), 2200);
    }

    if (shareButton) {
        shareButton.addEventListener("click", async () => {
            const shareData = {
                title: "Sous Haute Tension – Gala Team Bafounta",
                text: "Viens vivre le gala de boxe Sous Haute Tension avec moi 🔥",
                url: window.location.href
            };

            try {
                if (navigator.share) {
                    await navigator.share(shareData);
                } else if (navigator.clipboard) {
                    await navigator.clipboard.writeText(shareData.url);
                    showShareToast("Lien copié dans le presse-papier");
                } else {
                    showShareToast("Partage impossible sur ce navigateur");
                }
            } catch (e) {
                // annulation du partage
            }
        });
    }

    /* ------------------------------------------------
   PANIER BILLETS
--------------------------------------------------- */

    const prices = {
        ring: 5000,     // 50 €
        tribune: 2500,  // 25 €
        enfant: 1000,   // 10 €
        vip: 50000      // 500 €
    };

    const cart = {}; // { ring: 1, tribune: 2, ... }

    const cartInput = document.querySelector('.js-cart-input');
    const cartCountEl = document.querySelector('.js-cart-count');
    const cartTotalEl = document.querySelector('.js-cart-total');

    function updateCartDisplay() {
        // 1) Remettre toutes les quantités visibles à 0
        document.querySelectorAll('.js-ticket-qty').forEach(span => {
            span.textContent = '0';
        });

        // 2) Recalcul du panier réel
        let totalQty = 0;
        let totalCents = 0;

        Object.keys(cart).forEach(slug => {
            const qty = cart[slug] || 0;
            const price = prices[slug] || 0;

            totalQty += qty;
            totalCents += qty * price;

            // Mise à jour du compteur associé à ce type de billet
            const qtySpan = document.querySelector(
                `.js-ticket-qty[data-ticket="${slug}"]`
            );
            if (qtySpan) {
                qtySpan.textContent = qty;
            }
        });

        // 3) Texte "0 billet" / "1 billet" / "2 billets"
        const label = totalQty <= 1 ? 'billet' : 'billets';
        if (cartCountEl) {
            cartCountEl.textContent = `${totalQty} ${label}`;
        }

        // 4) Total en €
        if (cartTotalEl) {
            const euros = (totalCents / 100).toFixed(2).replace('.', ',');
            cartTotalEl.textContent = `${euros} €`;
        }

        // 5) Valeur JSON envoyée au backend
        if (cartInput) {
            cartInput.value = JSON.stringify(cart);
        }
    }

// + ajouter
    document.querySelectorAll('.js-add-ticket').forEach(btn => {
        btn.addEventListener('click', () => {
            const slug = btn.dataset.ticket;
            if (!slug) return;

            cart[slug] = (cart[slug] || 0) + 1;
            updateCartDisplay();
        });
    });

// – retirer
    document.querySelectorAll('.js-remove-ticket').forEach(btn => {
        btn.addEventListener('click', () => {
            const slug = btn.dataset.ticket;
            if (!slug) return;

            cart[slug] = (cart[slug] || 0) - 1;
            if (cart[slug] <= 0) {
                delete cart[slug];
            }
            updateCartDisplay();
        });
    });

// init au chargement (panier vide)
    updateCartDisplay();

});
