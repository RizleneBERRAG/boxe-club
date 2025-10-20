@extends('layouts.app')

@section('styles') <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}"> @endsection

@section('content')
    <section class="section">
        <h1 class="page-title">Contact</h1>

        @if(session('ok')) <div class="card success">{{ session('ok') }}</div> @endif

        <form class="card contact-form" method="POST" action="{{ route('contact.submit') }}" novalidate>
            @csrf
            <div class="row">
                <label>Nom *</label>
                <input type="text" name="name" value="{{ old('name') }}" class="@error('name') is-invalid @enderror">
                @error('name') <p class="err">{{ $message }}</p> @enderror
            </div>
            <div class="row">
                <label>Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror">
                @error('email') <p class="err">{{ $message }}</p> @enderror
            </div>
            <div class="row">
                <label>Message *</label>
                <textarea name="message" rows="6" class="@error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                @error('message') <p class="err">{{ $message }}</p> @enderror
            </div>
            <div class="row check">
                <label><input type="checkbox" name="rgpd" value="1"> J’accepte l’utilisation de mes données pour traiter ma demande.</label>
                @error('rgpd') <p class="err">{{ $message }}</p> @enderror
            </div>
            <button class="btn btn-primary">Envoyer</button>
        </form>
    </section>
@endsection

@section('scripts') <script src="{{ asset('assets/js/contact.js') }}" defer></script> @endsection
