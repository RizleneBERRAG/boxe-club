@extends('layouts.app')
@section('styles') <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}"> @endsection
@section('content')
    <section class="section card">
        <h1 class="page-title">Mentions légales & RGPD</h1>
        <p class="muted">Coordonnées du club, responsable de publication, hébergeur, politique de confidentialité, droits RGPD (accès, rectification, suppression), etc.</p>
    </section>
@endsection
@section('scripts') <script src="{{ asset('assets/js/legal.js') }}" defer></script> @endsection
