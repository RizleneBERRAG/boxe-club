<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();          // ring, tribune, enfant, vip...
            $table->string('name');                    // Nom “technique” ou affiché
            $table->string('label')->nullable();       // Petit label marketing (Immersion totale, etc.)
            $table->unsignedInteger('price_cents');    // Prix en centimes
            $table->unsignedInteger('max_per_order');  // Limite par commande
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_types');
    }
};
