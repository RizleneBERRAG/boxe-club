@extends('layouts.app')
@section('styles') <link rel="stylesheet" href="{{ asset('assets/css/gallery.css') }}"> @endsection

@section('content')
    <section class="section">
        <h1 class="page-title">Galerie</h1>
        <div class="gallery">
            @foreach(['g1.jpg','g2.jpg','g3.jpg','g4.jpg','g5.jpg','g6.jpg'] as $img)
                <figure class="card"><img src="/assets/img/{{ $img }}" alt="Galerie"></figure>
            @endforeach
        </div>
    </section>
@endsection

@section('scripts') <script src="{{ asset('assets/js/gallery.js') }}" defer></script> @endsection
