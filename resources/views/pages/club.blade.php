@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/club.css') }}">
@endsection

@section('content')
    <section class="section">
        <h1 class="page-title">Le Club</h1>
        <div class="grid-2">
            <div class="card">
                <p>Valeurs : respect, exigence, cohésion. Encadrement diplômé, progression garantie du débutant au compétiteur.</p>
                <ul class="bullets">
                    <li>Coachs expérimentés</li>
                    <li>Groupes par niveau</li>
                    <li>Stages & événements</li>
                </ul>
            </div>
            <div class="card media"><img src="/assets/img/club.jpg" alt="Team Bafounta"></div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/club.js') }}" defer></script>
@endsection
