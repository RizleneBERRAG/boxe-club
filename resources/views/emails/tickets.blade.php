<h2>👊 Merci pour ton achat !</h2>

<p>Voici tes billets pour le gala <strong>Sous Haute Tension</strong>.</p>

<p>Ils sont attachés à cet email sous forme de QR codes.<br>
    Présente-les à l’entrée du gala.</p>

<hr>

<p><strong>Détails de ta commande :</strong></p>

<ul>
    @foreach($order->items as $item)
        <li>
            {{ $item->quantity }} × {{ $item->ticketType->label ?? $item->ticketType->name }}
        </li>
    @endforeach
</ul>

<p>À bientôt,<br>La Team Bafounta 🔥</p>
