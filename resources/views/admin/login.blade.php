@extends('layouts.minimal-admin')

@section('title', 'Espace responsable')

@section('content')
    <div class="login-page">
        <h1 class="login-title">Espace Mampuya</h1>
        <p class="login-subtitle">Connecte-toi pour gérer la boutique Team Bafounta.</p>

        @if ($errors->any())
            <div class="admin-alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="login-form">
            @csrf

            <div class="form-group">
                <label for="login">Identifiant</label>
                <input type="text" id="login" name="login" value="{{ old('login') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="login-actions">
                <button class="btn-primary">Se connecter</button>
            </div>
        </form>

    </div>
@endsection
