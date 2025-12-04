<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tes billets – Team Bafounta</title>
</head>
<body>
<h1>👊 Merci pour ton achat !</h1>

<p>Voici tes billets pour le gala <strong>Sous Haute Tension</strong>.</p>

<p>
    Ils sont <strong>en pièce jointe</strong> sous forme de QR codes.<br>
    Présente-les à l’entrée du gala.
</p>

<hr>

<h2>Détails de la commande :</h2>

<ul>
    @foreach($order->items as $item)
        <li>
            {{ $item->quantity }} ×
            {{ $item->ticketType->label ?? $item->ticketType->name }}
        </li>
    @endforeach
</ul>

<p>
    À bientôt,<br>
    La Team Bafounta 🔥
</p>
</body>
</html>
