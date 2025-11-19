{{-- resources/views/contact.blade.php --}}
@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}?v=3">
@endsection

@section('content')
    <main class="contact-hero">

        <section class="contact-hero__grid">

            {{-- ================= COLONNE GAUCHE : TEXTE + CARTE ================= --}}
            <div class="contact-hero__left">

                <header class="contact-hero__head">
                    <h1 class="contact-hero__title">Viens boxer avec nous.</h1>
                    <p class="contact-hero__subtitle">
                        Deux salles, une équipe, une ambiance famille. Choisis ton coin de ring
                        et envoie-nous ton message, on t’accueille comme à la maison.
                    </p>
                </header>

                {{-- ===================== CARTE INTERACTIVE ===================== --}}
                <article class="contact-map">
                    <div class="contact-map__inner">

                        <!-- ======================= FOND DE CARTE ======================= -->
                        <div class="contact-map__bg">

                            <!-- IFRAME PRINCIPALE (mise à jour par JS) -->
                            <!-- ======================= FOND DE CARTE ======================= -->
                            <div class="contact-map__bg">

                                <!-- IFRAME PRINCIPALE (par défaut : Jacques Brel) -->
                                <iframe
                                    class="contact-map__iframe"
                                    loading="lazy"
                                    allowfullscreen
                                    referrerpolicy="no-referrer-when-downgrade"
                                    style="border:0;"
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11147.05875186333!2d4.861466263975859!3d45.695694117961054!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f4c2687bfd3861%3A0x1fd74fa68bb05f23!2sGymnase%20Jacques%20Brel!5e0!3m2!1sfr!2sfr!4v1763128035175!5m2!1sfr!2sfr">
                                </iframe>

                                <!-- ⭐ Watermark du logo -->
                                <div class="contact-map__logo">
                                    <img src="{{ asset('assets/img/logo.png') }}" alt="Team Bafounta">
                                </div>

                                <!-- Décorations -->
                                <div class="contact-map__grid-overlay"></div>
                                <div class="contact-map__glow"></div>
                            </div>


                            <!-- ======================= PILLS D’ADRESSES ======================= -->
                        <div class="contact-map__places" id="contact-map-places">
                            <button type="button"
                                    class="contact-map__pill is-active"
                                    data-place="brel">
                                Jacques Brel – Vénissieux
                            </button>

                            <button type="button"
                                    class="contact-map__pill"
                                    data-place="guimier">
                                Jean Guimier – Vénissieux
                            </button>

                            <button type="button"
                                    class="contact-map__pill"
                                    data-place="oms">
                                Siège social – Vénissieux
                            </button>
                        </div>
                    </div>

                    <!-- ======================= DÉTAILS DES LIEUX ======================= -->
                    <div class="contact-map__details" id="contact-map-details">

                        <div class="contact-map__item is-active" data-place="brel">
                            <h2>Complexe Jacques Brel</h2>
                            <p>7 Av. d’Oschatz, 69200 Vénissieux</p>
                            <p class="contact-map__tag">Cours jeunes & adultes · Cœur de la Team Bafounta</p>
                        </div>

                        <div class="contact-map__item" data-place="guimier">
                            <h2>Gymnase Jean Guimier</h2>
                            <p>Avenue Jules Guesde, 69200 Vénissieux</p>
                            <p class="contact-map__tag">Préparation, technique & travail de fond</p>
                        </div>

                        <div class="contact-map__item" data-place="oms">
                            <h2>22 Rue Ethel et Julius Rosenberg</h2>
                            <p>69200 Vénissieux</p>
                            <p class="contact-map__tag">Office Municipal du Sport · Siège social</p>
                        </div>

                    </div>

                </article>

                {{-- Infos rapides stylées --}}
                <div class="contact-chips">
                    <span class="chip">Boxe éducative & loisirs</span>
                    <span class="chip">Compétition & préparation</span>
                    <span class="chip">Ambiance familiale</span>
                </div>

            </div>

            {{-- ================= COLONNE DROITE : FORMULAIRE ================= --}}
            <div class="contact-hero__right">
                <section class="contact-form-card">
                    <h2 class="contact-form-card__title">Écris-nous</h2>
                    <p class="contact-form-card__lead">
                        Une question sur les inscriptions, les horaires ou les entraînements ?
                        Laisse-nous un message, on te répond entre deux rounds.
                    </p>

                    <form id="contact-form"
                          data-public-key="{{ config('services.emailjs.public_key') }}"
                          data-service-id="{{ config('services.emailjs.service_id') }}"
                          data-template-id="{{ config('services.emailjs.template_id') }}">

                    @csrf

                        {{-- Honeypot anti-spam --}}
                        <div class="contact-hp">
                            <label for="company">Société</label>
                            <input type="text" id="company" name="company" autocomplete="off">
                        </div>

                        <div class="field-row">
                            <div class="field">
                                <label for="name">Nom / Prénom</label>
                                <input type="text" id="name" name="user_name" required>
                            </div>

                            <div class="field">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" name="user_email" required>
                            </div>
                        </div>

                        <div class="field-row">
                            <div class="field">
                                <label for="phone">Téléphone (optionnel)</label>
                                <input type="tel" id="phone" name="user_phone">
                            </div>

                            <div class="field">
                                <label for="subject">Sujet</label>
                                <input type="text" id="subject" name="subject" placeholder="Inscription, horaires…">
                            </div>
                        </div>

                        <div class="field">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>

                        <div class="field field--bottom">
                            <p class="contact-rgpd">
                                En envoyant ce formulaire, tu acceptes que nous utilisions ces informations
                                uniquement pour te répondre. Aucun spam, juste de la boxe.
                            </p>

                            <button type="submit" class="btn btn-primary contact-submit">
                                <span>Envoyer le message</span>
                            </button>
                        </div>

                        <p id="contact-feedback" class="contact-feedback" aria-live="polite"></p>
                    </form>
                </section>
            </div>

        </section>
    </main>

    {{-- EmailJS + script de la page contact --}}
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js" defer></script>
    <script src="{{ asset('assets/js/contact.js') }}" defer></script>
@endsection
