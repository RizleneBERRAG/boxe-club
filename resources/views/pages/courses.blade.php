@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/courses.css') }}">
@endsection

@section('content')
    @php
        $days = [1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi',7=>'Dimanche'];
        $slots = \App\Models\Timeslot::with('course')->orderBy('weekday')->orderBy('start')->get();
        $byDay = [];
        foreach ($slots as $s) { $byDay[$s->weekday][] = $s; }
    @endphp

    <section class="section">

        {{-- HERO COURS & HORAIRES --}}
        <header class="courses-hero">
            <div class="courses-hero__bg"></div>
            <div class="courses-hero__overlay"></div>

            <div class="courses-hero__content">
                <p class="courses-hero__eyebrow">
                    Team Bafounta · Lyon - Vénissieux
                </p>

                <h1 class="courses-hero__title">
                    Cours & horaires
                    <span>Planning hebdo</span>
                </h1>

                <p class="courses-hero__subtitle">
                    Choisis le créneau qui te correspond : découverte, loisir,
                    perfectionnement ou préparation compétition. On s’occupe du reste.
                </p>

                <div class="courses-hero__chips">
                    <span class="courses-chip">Encadrement diplômé</span>
                    <span class="courses-chip">Deux gymnases accessibles</span>
                    <span class="courses-chip">Groupes par niveau & âge</span>
                </div>
            </div>

            <div class="courses-hero__media" aria-hidden="true">
                {{-- tu peux changer l’image par la tienne --}}
                <img src="{{ asset('assets/img/ju.jpg') }}"
                     alt="Séance de boxe Team Bafounta">
            </div>
        </header>

        {{-- Infos salles --}}
        <div class="venue-grid">

        <div class="venue card">
                <div class="v-dot"></div>
                <div>
                    <h3>Gymnase <span>Jacques Brel</span></h3>
                    <p class="muted">7 avenue d’Oschatz — T4/C12, arrêt « Lycée Jacques Brel »</p>
                </div>
            </div>
            <div class="venue card">
                <div class="v-dot alt"></div>
                <div>
                    <h3>Gymnase <span>Jean Guimier</span></h3>
                    <p class="muted">Avenue Jules Guesde — métro/bus, arrêt « Parilly »</p>
                </div>
            </div>
        </div>

        {{-- Filtres par jour (sticky) --}}
        <div class="day-filter card stick" role="tablist" aria-label="Filtre par jour">
            @foreach($days as $num => $label)
                <button class="day-btn{{ $loop->first ? ' is-active' : '' }}"
                        role="tab"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                        aria-controls="panel-day-{{ $num }}"
                        data-day="{{ $num }}">
                    {{ $label }}
                </button>
            @endforeach
            <button class="day-btn" role="tab" aria-selected="false" aria-controls="panel-day-all" data-day="all">Tous</button>
        </div>

        {{-- Panneaux (timeline) --}}
        <div class="panels">
            @foreach($days as $num => $label)
                <section id="panel-day-{{ $num }}" class="day-panel{{ $loop->first ? ' is-visible' : '' }}" role="tabpanel" data-panel-day="{{ $num }}">
                    <div class="timeline card">
                        @if(!empty($byDay[$num]))
                            @foreach($byDay[$num] as $slot)
                                <article class="tl-item" data-reveal>
                                    <div class="tl-time">
                                        <strong>{{ \Illuminate\Support\Str::limit($slot->start,5,'') }}</strong>
                                        <span>→ {{ \Illuminate\Support\Str::limit($slot->end,5,'') }}</span>
                                    </div>
                                    <div class="tl-dot {{ str_contains(strtolower($slot->location),'guimier') ? 'alt' : '' }}"></div>
                                    <div class="tl-card">
                                        <h2 class="tl-title">{{ $slot->course->title }}</h2>
                                        <p class="tl-sub muted">
                                            {{ $slot->location }}
                                        </p>
                                        @if($slot->course->level)
                                            <span class="tl-tag">{{ ucfirst($slot->course->level) }}</span>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        @else
                            <div class="empty muted">Aucun créneau pour {{ strtolower($label) }}.</div>
                        @endif
                    </div>
                </section>
            @endforeach

            {{-- Panel Tous --}}
            <section id="panel-day-all" class="day-panel" role="tabpanel" data-panel-day="all">
                <div class="timeline card">
                    @forelse($slots as $slot)
                        <article class="tl-item" data-reveal>
                            <div class="tl-time">
                                <span class="mini-day">{{ $days[$slot->weekday] }}</span>
                                <strong>{{ \Illuminate\Support\Str::limit($slot->start,5,'') }}</strong>
                                <span>→ {{ \Illuminate\Support\Str::limit($slot->end,5,'') }}</span>
                            </div>
                            <div class="tl-dot {{ str_contains(strtolower($slot->location),'guimier') ? 'alt' : '' }}"></div>
                            <div class="tl-card">
                                <h2 class="tl-title">{{ $slot->course->title }}</h2>
                                <p class="tl-sub muted">{{ $slot->location }}</p>
                                @if($slot->course->level)
                                    <span class="tl-tag">{{ ucfirst($slot->course->level) }}</span>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="empty muted">Aucun créneau défini pour le moment.</div>
                    @endforelse
                </div>
            </section>
        </div>


    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/courses.js') }}" defer></script>
@endsection
