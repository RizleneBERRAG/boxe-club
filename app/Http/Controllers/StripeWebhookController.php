<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook_secret')
            );
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        // Event principal pour Checkout
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            // On retrouve ton paiement via stripe_session_id
            $payment = Payment::where('stripe_session_id', $session->id)->first();

            if ($payment && $payment->status !== 'paid') {
                $payment->update(['status' => 'paid']);

                // Sécurise aussi le dossier
                $enrollment = Enrollment::find($payment->enrollment_id);
                if ($enrollment && $enrollment->status !== 'paid') {
                    $enrollment->update([
                        'status' => 'paid',
                        'payment_method' => 'card',
                    ]);
                }
            }
        }

        return response('ok', 200);
    }
}
