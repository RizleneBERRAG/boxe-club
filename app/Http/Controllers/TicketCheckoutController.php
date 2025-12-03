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

class TicketCheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'cart'  => ['required', 'string'],
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
            $qty = (int) $qty;
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
            'email' => $data['email'],
            'total_cents' => $totalCents,
            'stripe_session_id' => $session->id,
            'status' => 'pending',
        ]);

        foreach ($cart as $slug => $qty) {
            $type = $ticketTypes[$slug] ?? null;
            $qty  = (int) $qty;

            if (!$type || $qty <= 0) continue;

            OrderItem::create([
                'order_id'        => $order->id,
                'ticket_type_id'  => $type->id,
                'quantity'        => $qty,
                'unit_price_cents'=> $type->price_cents,
                'total_cents'     => $qty * $type->price_cents,
            ]);
        }


        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        $order = Order::where('stripe_session_id', $sessionId)->firstOrFail();

        if ($order->status !== 'paid') {
            $order->update(['status' => 'paid']);

            // Génère les billets + QR une seule fois
            if ($order->generatedTickets()->count() === 0) {
                $this->generateTicketsForOrder($order);
            }
        }

        $order->load('items.ticketType', 'items.generatedTickets');

        return view('gala.success', compact('order'));
    }

    public function cancel()
    {
        return view('gala.cancel');
    }

    protected function generateTicketsForOrder(Order $order): void
    {
        // charge items + type de billet
        $order->load('items.ticketType');

        foreach ($order->items as $item) {
            // pour chaque billet acheté
            for ($i = 0; $i < $item->quantity; $i++) {

                $uuid = (string)Str::uuid();

                // URL encodée dans le QR
                $url = route('tickets.verify', ['uuid' => $uuid]);

                // QR en SVG (pas besoin d’Imagick)
                $svg = QrCode::format('svg')
                    ->size(400)
                    ->margin(1)
                    ->generate($url);

                // stocké dans storage/app/public/qrcodes
                $path = "qrcodes/{$uuid}.svg";
                Storage::disk('public')->put($path, $svg);

                // on enregistre le ticket lié à l’order_item
                $item->generatedTickets()->create([
                    'uuid' => $uuid,
                    'qr_code_path' => $path,
                    'status' => 'valid',
                ]);
            }
        }
    }
}
