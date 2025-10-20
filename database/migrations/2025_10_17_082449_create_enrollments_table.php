<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();

            // Référence lisible (ex: TBF-2025-000123)
            $table->string('reference')->unique();

            // Identité boxeur
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthdate');
            $table->enum('minor_status', ['minor','adult']);

            // Contact
            $table->string('email');
            $table->string('phone')->nullable();

            // Formule choisie
            $table->foreignId('plan_id')->constrained()->cascadeOnUpdate();

            // Statut du dossier
            $table->enum('status', ['draft','pending_payment','paid','awaiting_validation'])
                ->default('draft');

            // RGPD + autorisation parentale (si mineur)
            $table->boolean('rgpd_consent')->default(false);
            $table->json('parental_consent')->nullable(); // { "name":"...", "date":"YYYY-MM-DD" }

            // Traces
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            // Index utiles
            $table->index(['email']);
            $table->index(['status']);
            $table->index(['plan_id']);
        });
    }
};
