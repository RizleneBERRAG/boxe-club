<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Billets – Sous Haute Tension</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: #050509;
            color: #f6f6f6;
            padding: 2rem;
        }
        .wrap {
            max-width: 960px;
            margin: 0 auto;
        }
        h1 {
            font-size: 2.4rem;
            margin-bottom: 0.5rem;
        }
        h2 {
            margin-top: 2rem;
        }
        .tickets {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .card {
            background: #0b0b14;
            border-radius: 16px;
            padding: 1rem 1.25rem;
            border: 1px solid rgba(255,255,255,0.08);
            text-align: center;
        }
        .card h3 {
            margin-bottom: 0.5rem;
        }
        .small {
            font-size: 0.8rem;
            opacity: 0.7;
            margin-top: 0.5rem;
        }
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
<div class="wrap">
    <h1>Merci, ton paiement est confirmé ✅</h1>

    <p>
        Un email te sera prochainement envoyé avec tes billets.<br>
        En attendant, tu peux déjà présenter ces QR codes à l’entrée du gala.
    </p>

    <p><strong>Total :</strong> {{ number_format($order->total_cents / 100, 2, ',', ' ') }} €</p>

    <h2>Tes billets</h2>

    @php
        // On prépare une collection plate de tous les tickets générés
        $tickets = $order->items->flatMap(function ($item) {
            return $item->generatedTickets->map(function ($ticket) use ($item) {
                $ticket->ticket_label = $item->ticketType->label ?? $item->ticketType->name;
                return $ticket;
            });
        });
    @endphp

    @if ($tickets->count() > 0)
        <div class="tickets">
            @foreach ($tickets as $ticket)
                <div class="card">
                    <h3>{{ $ticket->ticket_label }}</h3>

                    <img
                        src="{{ asset('storage/' . $ticket->qr_code_path) }}"
                        alt="QR code billet"
                        style="background:#fff;padding:8px;border-radius:8px;"
                    >

                    <div class="small">
                        UUID : {{ $ticket->uuid }}<br>
                        Statut : {{ $ticket->status }}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Aucun billet généré pour cette commande.</p>
    @endif
</div>
</body>
</html>
