@extends('layouts.app')
@section('styles') <link rel="stylesheet" href="{{ asset('assets/css/news.css') }}"> @endsection
@section('content')
    <section class="section">
        <h1 class="page-title">Actualités</h1>
        <div class="card"><p class="muted">Bientôt : articles & annonces de la Team Bafounta.</p></div>
    </section>
@endsection
@section('scripts') <script src="{{ asset('assets/js/news.js') }}" defer></script> @endsection
