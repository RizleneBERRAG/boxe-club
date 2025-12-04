<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Mail\TicketsPurchased;
use Illuminate\Support\Facades\Mail;

class TicketCheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'cart' => ['required', 'string'],
        ]);


        $cart = json_decode($data['cart'], true) ?? [];
        if (!is_array($cart) || empty($cart)) {
            return back()->with('error', 'Panier vide.');
        }

        // Récup des types de billets concernés
        $ticketTypes = TicketType::whereIn('slug', array_keys($cart))->get()->keyBy('slug');

        $lineItems = [];
        $totalCents = 0;

        foreach ($cart as $slug => $qty) {
            $qty = (int)$qty;
            if ($qty <= 0 || !isset($ticketTypes[$slug])) {
                continue;
            }

            $type = $ticketTypes[$slug];
            $unit = $type->price_cents;

            $totalCents += $unit * $qty;

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $unit,
                    'product_data' => [
                        'name' => $type->label,
                    ],
                ],
                'quantity' => $qty,
            ];
        }

        if (empty($lineItems)) {
            return back()->with('error', 'Panier invalide.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'customer_email' => $data['email'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => config('app.url') . '/billets/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => config('app.url') . '/billets/cancel',
        ]);

        // Création de la commande en pending
        $order = Order::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'total_cents' => $totalCents,
            'stripe_session_id' => $session->id,
            'status' => 'pending',
        ]);


        foreach ($cart as $slug => $qty) {
            $type = $ticketTypes[$slug] ?? null;
            $qty = (int)$qty;

            if (!$type || $qty <= 0) continue;

            OrderItem::create([
                'order_id' => $order->id,
                'ticket_type_id' => $type->id,
                'quantity' => $qty,
                'unit_price_cents' => $type->price_cents,
                'total_cents' => $qty * $type->price_cents,
            ]);
        }


        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        $order = Order::where('stripe_session_id', $sessionId)->firstOrFail();

        // On charge tout ce qu’il faut pour la vue + mail
        $order->load('items.ticketType', 'items.generatedTickets');

        // Si ce n’est pas encore payé, on le passe à paid,
        // on génère les billets et on envoie le mail UNE SEULE FOIS
        if ($order->status !== 'paid') {
            $order->update(['status' => 'paid']);

            if ($order->items->flatMap->generatedTickets->count() === 0) {
                $this->generateTicketsForOrder($order);
                $order->load('items.ticketType', 'items.generatedTickets');
            }

            // Envoi de l’email avec tous les billets
            Mail::to($order->email)->send(new TicketsPurchased($order));
        }

        return view('gala.success', compact('order'));
    }


    public function cancel()
    {
        return view('gala.cancel');
    }

    protected function generateTicketsForOrder(Order $order): void
    {
        $order->load('items.ticketType');

        foreach ($order->items as $item) {
            for ($i = 0; $i < $item->quantity; $i++) {

                $uuid = (string)Str::uuid();
                $url = route('tickets.verify', ['uuid' => $uuid]);

                // Génération du PNG via un service externe
                $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=400x400&data='
                    . urlencode($url);

                $png = file_get_contents($qrUrl);   // récupère l’image PNG

                $path = "qrcodes/{$uuid}.png";
                Storage::disk('public')->put($path, $png);

                $item->generatedTickets()->create([
                    'uuid' => $uuid,
                    'holder_name' => $order->first_name . ' ' . $order->last_name,
                    'qr_code_path' => $path,
                    'status' => 'valid',
                ]);
            }
        }
    }
}
