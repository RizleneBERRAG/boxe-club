<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();

            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();

            $table->integer('amount_cents'); // montant payé/à payer
            $table->enum('method', ['card','cash','transfer','pass_sport']);
            $table->enum('state', ['pending','requires_action','succeeded','failed'])
                ->default('pending');

            // IDs fournisseur (Stripe, etc.)
            $table->string('provider')->nullable();      // ex: stripe
            $table->string('provider_id')->nullable();   // ex: payment_intent id
            $table->json('provider_payload')->nullable();// logs utiles/debug

            $table->timestamps();

            $table->index(['enrollment_id','state']);
            $table->index(['provider','provider_id']);
        });
    }

};
