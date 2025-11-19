@extends('layouts.app')

@section('styles')
    <!-- Feuilles de styles pour la page d’authentification -->
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
@endsection

@section('content')
    <div class="admin-login-page">
        <h1 class="text-2xl font-bold mb-6">Espace responsable</h1>

        <form method="POST" action="{{ route('admin.login.submit') }}" class="admin-login-form space-y-4">
            @csrf

            <div class="field">
                <label for="identifier" class="block mb-1">Identifiant</label>
                <input id="identifier"
                       type="text"
                       name="identifier"
                       value="{{ old('identifier') }}"
                       required
                       class="w-full rounded-md border border-gray-600 px-3 py-2 bg-gray-800 text-white">
            </div>

            <div class="field">
                <label for="password" class="block mb-1">Mot de passe</label>
                <input id="password"
                       type="password"
                       name="password"
                       required
                       class="w-full rounded-md border border-gray-600 px-3 py-2 bg-gray-800 text-white">
            </div>

            @if($errors->has('identifier'))
                <p class="text-red-500 text-sm">Identifiants incorrects.</p>
            @endif

            <button type="submit"
                    class="btn btn-primary px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white font-semibold">
                Se connecter
            </button>
        </form>
    </div>
@endsection
