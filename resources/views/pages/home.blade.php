@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endsection

@section('content')
    <section class="section hero">
        <div class="grid grid-2">
            <div>
                <p class="kicker">Boxe — Vénissieux</p>
                <h1 class="h1">L’esprit <span class="accent">Team Bafounta</span></h1>
                <p class="muted lead">
                    Club moderne, exigeant et humain. Des cours pour débutants, confirmés et compétiteurs.
                </p>
                <div class="actions">
                    <a href="{{ route('enroll.step1') }}" class="btn btn-primary">Séance d’essai gratuite</a>
                    <a href="{{ route('courses') }}" class="link">Voir les horaires</a>
                </div>
                <ul class="badges">
                    <li>Encadrement diplômé</li>
                    <li>Ambiance famille</li>
                    <li>Résultats en compétitions</li>
                </ul>
            </div>

            <div>
                <div class="card hero-media">
                    <img src="/assets/img/hero.jpg" alt="Ring Team Bafounta">
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="grid grid-3 features">
            <div class="card reveal">
                <h3>Technique</h3>
                <p class="muted">Apprentissage des fondamentaux, placement, garde, esquives et combinaisons.</p>
            </div>
            <div class="card reveal">
                <h3>Physique</h3>
                <p class="muted">Condition, puissance, vitesse et endurance avec planification adaptée.</p>
            </div>
            <div class="card reveal">
                <h3>Esprit</h3>
                <p class="muted">Respect, dépassement de soi et cohésion du groupe au quotidien.</p>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="card reveal">
            <h2 class="section-title">Horaires (extrait)</h2>
            @php
                $days = [1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi',7=>'Dimanche'];
                $courses = \App\Models\Course::with(['timeslots' => fn($q)=>$q->orderBy('weekday')->orderBy('start')])
                            ->where('is_active',1)->limit(3)->get();
            @endphp
            <div class="grid grid-3 sched">
                @foreach($courses as $course)
                    <div class="sched-card">
                        <h3 class="tt">{{ $course->title }}</h3>
                        <ul class="slots">
                            @forelse($course->timeslots as $s)
                                <li>
                                    <span class="d">{{ $days[$s->weekday] }}</span>
                                    <span class="t">{{ \Illuminate\Support\Str::limit($s->start,5,'') }}–{{ \Illuminate\Support\Str::limit($s->end,5,'') }}</span>
                                    @if($s->location)<span class="loc">{{ $s->location }}</span>@endif
                                </li>
                            @empty
                                <li class="muted">Créneaux à venir.</li>
                            @endforelse
                        </ul>
                    </div>
                @endforeach
            </div>
            <div class="mt">
                <a class="link" href="{{ route('courses') }}">Voir le planning complet</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="grid grid-3">
            @foreach([['“Top encadrement, super ambiance.”','Yacine'],
                      ['“Idéal pour débuter, j’ai progressé vite.”','Sarah'],
                      ['“Exigeant et bienveillant : j’adore.”','Nicolas']] as [$quote,$name])
                <div class="card reveal testim">
                    <p class="q">{{ $quote }}</p>
                    <p class="author">— {{ $name }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="section cta">
        <div class="card cta-box reveal">
            <div>
                <h2 class="cta-title">Prêt à monter sur le ring ?</h2>
                <p class="muted">Réserve ta séance d’essai gratuite dès maintenant.</p>
            </div>
            <a href="{{ route('enroll.step1') }}" class="btn btn-primary">Je m’inscris</a>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/home.js') }}" defer></script>
@endsection
