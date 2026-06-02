<?php

use App\Http\Controllers\StripeWebhookController;

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);
