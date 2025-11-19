<footer class="ft-hero ft" role="contentinfo" aria-labelledby="ft-title">
    <div class="ft-hero__grid">

        <!-- Colonne gauche -->
        <div class="ft-hero__left">
            <header class="ft-head">
                <h2 class="ft-ghost" id="ft-title">Team Bafounta</h2>
                <p class="ft-ghost__tag">ESPACE ECOLE SPORT BOXE</p>

                <div class="ft-cta">
                    <a href="{{ route('enroll.step1') }}" class="btn btn-primary">S’inscrire</a>
                    <a href="{{ route('courses') }}" class="btn btn-ghost">Voir les horaires</a>
                </div>
            </header>

            <div class="ft-hero__socials">
                <!-- Facebook -->
                <a class="ft-ico ft-ico--fb" href="https://facebook.com" target="_blank" rel="noopener" aria-label="Facebook">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M13.5 21V12.7h2.8l.4-3h-3.2V7.3c0-.9.3-1.5 1.6-1.5h1.8V3.2c-.3 0-1.3-.1-2.4-.1-2.4 0-4.1 1.5-4.1 4.3v2.3H7.8v3h2.6V21h3.1Z"/>
                    </svg>
                </a>

                <!-- Instagram -->
                <a class="ft-ico ft-ico--ig"
                   href="https://instagram.com"
                   target="_blank"
                   rel="noopener"
                   aria-label="Instagram">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7zm5 3.5A5.5 5.5 0 1 1 6.5 13 5.5 5.5 0 0 1 12 7.5zm0 2A3.5 3.5 0 1 0 15.5 13 3.5 3.5 0 0 0 12 9.5zm5.25-4a1.25 1.25 0 1 1-1.25 1.25A1.25 1.25 0 0 1 17.25 5.5z"/>
                    </svg>
                </a>

                <!-- TikTok -->
                <a class="ft-ico ft-ico--tt" href="https://tiktok.com" target="_blank" rel="noopener" aria-label="TikTok">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M16.5 3.1c.3 1.5 1.3 2.8 2.8 3.3.5.2 1 .3 1.5.3v3.2c-1.6-.1-3.2-.6-4.6-1.6V16c0 3.5-2.8 6.3-6.3 6.3A6.3 6.3 0 0 1 3.7 13.7C3.7 10.2 6.5 7.4 10 7.4c.5 0 1 .1 1.5.2v3.3c-.5-.3-1-.4-1.5-.4a3 3 0 1 0 3 3V3h3.5Z"/>
                    </svg>
                </a>
            </div>

            <!-- Téléphone -->
            <div class="contact-line contact-line--static">
                <a class="contact-line__link is-tel" href="tel:0636132175">
                    <span class="contact-line__ico" aria-hidden="true">
                        <svg viewBox="0 0 24 24" aria-hidden="true"
                             fill="none" stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6.5 3h3a1 1 0 0 1 1 .8l.7 3.7a1 1 0 0 1-.5 1.1l-1.6 1
                                     a11.5 11.5 0 0 0 5.3 5.3l1-1.6a1 1 0 0 1 1.1-.5l3.7.7a1 1 0 0 1 .8 1v3
                                     a1 1 0 0 1-1 1H18C10.8 22 5 16.2 5 9V4a1 1 0 0 1 1-1Z"/>
                        </svg>
                    </span>
                    <span class="contact-line__value">06 36 13 21 75</span>
                </a>
            </div>

            <!-- Email -->
            <div class="contact-line contact-line--static">
                <a class="contact-line__link is-mail" href="mailto:espaceecolesportboxe@gmail.com">
                    <span class="contact-line__ico" aria-hidden="true">
                        <svg viewBox="0 0 24 24" aria-hidden="true"
                             fill="none" stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="5" width="18" height="14" rx="2" ry="2"></rect>
                            <path d="M5 7l7 5 7-5"></path>
                        </svg>
                    </span>
                    <span class="contact-line__value">EspaceEcoleSportBoxe@gmail.com</span>
                </a>
            </div>

            <address class="ft-hero__addr">
                Jacques Brel — 7 Av. d’Oschatz · Jean Guimier — Av. Jules Guesde
            </address>

            <nav class="ft-links" aria-label="Liens utiles du site">
                <a href="{{ route('club') }}">Le club</a>
                <a href="{{ route('courses') }}">Horaires</a>
                <a href="{{ route('enroll.step1') }}">Inscription</a>
                <a href="{{ route('news.index') }}">Actualités</a>
            </nav>
        </div>

        <!-- Colonne droite (logo) -->
        <div class="ft-hero__right">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Team Bafounta" class="ft-hero__logo">
        </div>

    </div>

    <div class="ft-hero__bottom">
        <p class="ft-hero__copy">© {{ date('Y') }} Team Bafounta — Tous droits réservés</p>
        <p class="ft-hero__legal">
            <a href="{{ asset('assets/docs/mentions-legales-rgpd.pdf') }}" download>Mentions légales & RGPD</a>
        </p>
    </div>

    <script src="{{ asset('assets/js/footer.js') }}?v=1" defer></script>
</footer>
