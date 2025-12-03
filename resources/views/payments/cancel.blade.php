@extends('layouts.minimal')

@section('title', 'Paiement annulé')

@section('content')
    <div style="max-width:600px;margin:80px auto;text-align:center;color:#fff;">
        <h1>Paiement annulé ❌</h1>
        <p>Le paiement a été annulé. Aucun montant n’a été débité.</p>

        <a href="{{ route('home') }}" class="btn-primary" style="
            display:inline-block;margin-top:20px;padding:10px 18px;border-radius:999px;
            background:linear-gradient(135deg,#E10600,#ff5c3c);color:#fff;text-decoration:none;
        ">
            Retour au site
        </a>
    </div>
@endsection
