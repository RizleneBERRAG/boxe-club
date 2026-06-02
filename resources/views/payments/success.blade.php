@extends('layouts.minimal')

@section('title', 'Paiement réussi')

@section('content')
    <div style="max-width:600px;margin:80px auto;text-align:center;color:#fff;">
        <h1>Paiement réussi ✅</h1>
        <p>Merci, le paiement a bien été enregistré.</p>

        <a href="{{ route('home') }}" class="btn-primary" style="
            display:inline-block;margin-top:20px;padding:10px 18px;border-radius:999px;
            background:linear-gradient(135deg,#E10600,#ff5c3c);color:#fff;text-decoration:none;
        ">
            Retour au site
        </a>
    </div>
@endsection
