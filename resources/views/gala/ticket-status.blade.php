<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vérification billet – Team Bafounta</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700" rel="stylesheet" />

    <style>
        :root {
            --bg: #050509;
            --card: #0b0b14;
            --border: rgba(255,255,255,0.08);
            --valid: #16a34a;
            --used: #f97316;
            --invalid: #ef4444;
            --text-muted: #9ca3af;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Space Grotesk", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background:
                radial-gradient(circle at top, #1b0c26 0, transparent 55%),
                radial-gradient(circle at bottom, #3b0a20 0, transparent 55%),
                var(--bg);
            color: #f9fafb;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .wrap { width: 100%; max-width: 480px; }

        .card {
            background: radial-gradient(circle at top, rgba(248,113,113,0.12), transparent 60%) var(--card);
            border-radius: 24px;
            border: 1px solid var(--border);
            padding: 2rem 1.75rem;
            box-shadow: 0 18px 45px rgba(0,0,0,0.65);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.9rem;
            border-radius: 999px;
            font-size: 0.75rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            border: 1px solid var(--border);
            background: rgba(15,23,42,0.75);
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .status-valid   .badge  { border-color: rgba(34,197,94,0.5); color: #bbf7d0; }
        .status-already_used .badge { border-color: rgba(249,115,22,0.6); color: #fed7aa; }
        .status-invalid .badge  { border-color: rgba(248,113,113,0.6); color: #fecaca; }

        .status-title {
            font-size: 1.9rem;
            margin: 0 0 .5rem;
        }

        .status-valid   .status-title { color: var(--valid); }
        .status-already_used .status-title { color: var(--used); }
        .status-invalid .status-title { color: var(--invalid); }

        .status-message {
            font-size: 0.98rem;
            color: #e5e7eb;
            margin-bottom: 1.8rem;
        }

        .ticket-info {
            margin-top: 1.2rem;
            padding: 0.9rem 1rem;
            border-radius: 14px;
            background: rgba(15,23,42,0.8);
            border: 1px dashed rgba(148,163,184,0.6);
            font-size: 0.85rem;
            text-align: left;
        }

        .ticket-info dt {
            font-weight: 600;
            color: #e5e7eb;
        }
        .ticket-info dd {
            margin: 0 0 .4rem;
            color: var(--text-muted);
            word-break: break-all;
        }

        .footer {
            margin-top: 1.2rem;
            font-size: 0.8rem;
            color: var(--text-muted);
            text-align: center;
        }
        .footer strong { color: #f9fafb; }

        .big-emoji {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
        }

        .status-valid   .big-emoji { filter: drop-shadow(0 0 18px rgba(34,197,94,0.6)); }
        .status-already_used .big-emoji { filter: drop-shadow(0 0 18px rgba(249,115,22,0.6)); }
        .status-invalid .big-emoji { filter: drop-shadow(0 0 18px rgba(248,113,113,0.6)); }
    </style>
</head>
<body class="status-{{ $status }}">
<div class="wrap">
    <div class="card">
        <div class="badge">
            Contrôle billet – Team Bafounta
        </div>

        <div class="big-emoji">
            @if ($status === 'valid')
                ✅
            @elseif ($status === 'already_used')
                ⚠️
            @else
                ❌
            @endif
        </div>

        <h1 class="status-title">
            @if ($status === 'valid')
                Billet valide
            @elseif ($status === 'already_used')
                Billet déjà scanné
            @else
                Billet invalide
            @endif
        </h1>

        <p class="status-message">{{ $message }}</p>

        @if($ticket)
            <dl class="ticket-info">
                <dt>UUID</dt>
                <dd>{{ $ticket->uuid }}</dd>

                @if($ticket->orderItem && $ticket->orderItem->ticketType)
                    <dt>Type de billet</dt>
                    <dd>{{ $ticket->orderItem->ticketType->label ?? $ticket->orderItem->ticketType->name }}</dd>
                @endif

                @if($ticket->scanned_at)
                    <dt>Scanné le</dt>
                    <dd>{{ $ticket->scanned_at->format('d/m/Y H:i') }}</dd>
                @endif
            </dl>
        @endif

        <div class="footer">
            <strong>Consigne :</strong>
            @if ($status === 'valid')
                laisser entrer la personne et garder le billet.
            @elseif ($status === 'already_used')
                demander une pièce d’identité et prévenir un responsable.
            @else
                refuser l’entrée avec ce billet.
            @endif
        </div>
    </div>
</div>
</body>
</html>
