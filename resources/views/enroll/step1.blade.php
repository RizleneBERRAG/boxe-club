@extends('layouts.minimal')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/enroll.css') }}">
    <link rel="stylesheet" href="{{ asset('views/partials/footer') }}?v=2">

@endsection

@section('content')
    <section class="section enroll">
        {{-- Wizard header --}}
        <div class="wizard" aria-label="Progression">
            <div class="step-dot active">1</div><div class="step-line"></div><div class="step-label">Infos boxeur</div>
            <div class="step-dot">2</div><div class="step-line"></div><div class="step-label">Paiement</div>
            <div class="step-dot">3</div><div class="step-label">Attestation</div>
        </div>

        <h1 class="page-title">Inscription — Étape 1</h1>

        <div class="notice-soft panel" data-reveal>
            <span class="badge-soft">Astuce</span>
            <div>Renseigne tes infos tranquillement. On sauvegarde dans ce navigateur pour éviter toute perte.</div>
        </div>

        <form method="post" action="{{ route('enroll.postStep1') }}" class="panel" data-draft="enroll-step1" novalidate>
            @csrf

            <div class="grid-2">
                <div class="field">
                    <label class="label" for="first_name">Prénom *</label>
                    <input class="input" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                    @error('first_name')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label class="label" for="last_name">Nom *</label>
                    <input class="input" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                    @error('last_name')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label class="label" for="email">E-mail *</label>
                    <input type="email" class="input" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label class="label" for="phone">Téléphone</label>
                    <input class="input" id="phone" name="phone" value="{{ old('phone') }}">
                    @error('phone')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label class="label" for="birthdate">Date de naissance *</label>
                    <input type="date" class="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required>
                    <div class="help">Si mineur, l’autorisation parentale s’affiche automatiquement.</div>
                    @error('birthdate')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label class="label" for="plan_id">Formule *</label>
                    <select class="select" id="plan_id" name="plan_id" required>
                        <option value="" disabled {{ old('plan_id') ? '' : 'selected' }}>— Choisir —</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ old('plan_id')==$plan->id? 'selected':'' }}>
                                {{ $plan->name }} — {{ number_format($plan->price_cents/100, 0, ',', ' ') }} €
                                @if($plan->allow_split) (2× possible) @endif
                            </option>
                        @endforeach
                    </select>
                    @error('plan_id')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Autorisation parentale : cachée par défaut --}}
            <div id="parent-authorization" class="panel mt-4 hidden">
                <h5 class="kicker" style="margin:0 0 8px">Autorisation parentale</h5>
                <div class="grid-2">
                    <div class="field">
                        <label class="label">Nom/Prénom du parent *</label>
                        <input type="text" class="input" name="parent_name">
                    </div>
                    <div class="field">
                        <label class="label">Date de signature *</label>
                        <input type="date" class="input" name="parent_date">
                    </div>
                </div>
            </div>

            <div class="hr"></div>

            <label style="display:flex; gap:10px; align-items:flex-start">
                <input type="checkbox" name="rgpd" value="1" required>
                <span class="help">J’accepte que mes données soient utilisées pour gérer mon inscription.
                <a class="link" href="{{ route('legal') }}">Mentions légales</a>
            </span>
            </label>
            @error('rgpd')<div class="error">{{ $message }}</div>@enderror

            <div class="actions">
                <button class="btn btn-primary" type="submit">Continuer</button>
                <a class="btn btn-ghost" href="{{ route('home') }}">Annuler</a>
            </div>
        </form>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const birthInput  = document.querySelector('input[name="birthdate"]');
            const parentBlock = document.getElementById('parent-authorization');

            function toggleParentFields() {
                if (!birthInput.value) { parentBlock.classList.add('hidden'); return; }

                const birthDate = new Date(birthInput.value);
                const today     = new Date();

                let age = today.getFullYear() - birthDate.getFullYear();
                const m  = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;

                const isMinor = age < 18;

                parentBlock.classList.toggle('hidden', !isMinor);
            }

            birthInput.addEventListener('change', toggleParentFields);
            toggleParentFields(); // au chargement
        });
    </script>
@endsection
