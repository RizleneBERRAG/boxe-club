<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class StripeController extends Controller
{
    /**
     * Lance un paiement test (ex : maillot à 50 €)
     */
    public function checkoutTest()
    {
        // Clé secrète Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        // Création de la session Checkout
        $session = StripeSession::create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Maillot Team Bafounta (test)',
                    ],
                    // Montant en CENTIMES → 50 € = 5000
                    'unit_amount' => 5000,
                ],
                'quantity' => 1,
            ]],
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('stripe.cancel'),
        ]);

        // Redirection vers la page de paiement Stripe
        return redirect()->away($session->url);
    }

    /**
     * Page en cas de succès du paiement
     */
    public function success(Request $request)
    {
        // Ici plus tard on pourra marquer une inscription comme payée, etc.
        return view('payments.success');
    }

    /**
     * Page si l’utilisateur annule le paiement
     */
    public function cancel()
    {
        return view('payments.cancel');
    }
}
