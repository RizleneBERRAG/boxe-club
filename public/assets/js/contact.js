// assets/js/contact.js
document.addEventListener("DOMContentLoaded", () => {
    /* ==========================
       1) CARTE INTERACTIVE
       ========================== */
    const pills  = document.querySelectorAll(".contact-map__pill");
    const items  = document.querySelectorAll(".contact-map__item");
    const iframe = document.querySelector(".contact-map__iframe");

    // URLs Google Maps (uniquement le src de chaque iframe)
    const MAP_URLS = {
        brel: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11147.05875186333!2d4.861466263975859!3d45.695694117961054!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f4c2687bfd3861%3A0x1fd74fa68bb05f23!2sGymnase%20Jacques%20Brel!5e0!3m2!1sfr!2sfr!4v1763128035175!5m2!1sfr!2sfr',
        guimier: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2785.6380519697414!2d4.88488831058639!3d45.71829757095856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f4c222eb94b201%3A0x1df779cad1231d29!2sGymnase%20Jean%20Guimier!5e0!3m2!1sfr!2sfr!4v1763128104786!5m2!1sfr!2sfr',
        oms: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2786.696201419574!2d4.890746918005209!3d45.697068397051964!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f4c245074c7d39%3A0x9b6dbbfbd944e587!2sOffice%20Municipal%20du%20Sport%20de%20V%C3%A9nissieux!5e0!3m2!1sfr!2sfr!4v1763124820759!5m2!1sfr!2sfr'
    };

    if (pills.length && items.length && iframe) {
        pills.forEach(pill => {
            pill.addEventListener("click", () => {
                const place = pill.dataset.place; // "brel", "guimier" ou "oms"

                // bouton actif
                pills.forEach(p => p.classList.remove("is-active"));
                pill.classList.add("is-active");

                // bloc texte actif
                items.forEach(it => {
                    it.classList.toggle("is-active", it.dataset.place === place);
                });

                // changement de carte
                if (MAP_URLS[place]) {
                    iframe.src = MAP_URLS[place];
                }
            });
        });
    }

    /* ==========================
       2) EMAILJS
       ========================== */
    const form      = document.getElementById("contact-form");
    const feedback  = document.getElementById("contact-feedback");
    const submitBtn = form ? form.querySelector(".contact-submit") : null;
    const honeypot  = form ? form.querySelector("[name='company']") : null;

    if (!form || typeof emailjs === "undefined") return;

    if (form.dataset.publicKey) {
        emailjs.init(form.dataset.publicKey);
    }

    let isSending = false;

    form.addEventListener("submit", (e) => {
        e.preventDefault();
        if (isSending) return;

        // Honeypot anti-bot
        if (honeypot && honeypot.value.trim() !== "") {
            form.reset();
            return;
        }

        isSending = true;
        setFeedback("Envoi en cours...", "#cccccc");
        if (submitBtn) {
            submitBtn.classList.add("is-loading");
            submitBtn.disabled = true;
        }

        emailjs
            .sendForm(form.dataset.serviceId, form.dataset.templateId, form)
            .then(() => {
                setFeedback("Message envoyé, merci ! 👊", "#4CAF50");
                form.reset();
            })
            .catch(err => {
                console.error(err);
                setFeedback("Erreur lors de l’envoi. Réessaie dans un instant.", "#ff6b6b");
            })
            .finally(() => {
                isSending = false;
                if (submitBtn) {
                    submitBtn.classList.remove("is-loading");
                    submitBtn.disabled = false;
                }
            });
    });

    function setFeedback(msg, color){
        if (!feedback) return;
        feedback.textContent = msg;
        feedback.style.color = color;
    }
});
