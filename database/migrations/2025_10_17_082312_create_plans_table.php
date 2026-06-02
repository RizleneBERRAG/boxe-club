<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // Nom de la formule (ex: Adulte, Enfant, Compétiteur)
            $table->integer('price_cents');            // Prix en centimes (ex: 35000 = 350€)
            $table->boolean('allow_split')->default(true); // Autoriser paiement en 2x ?
            $table->text('description')->nullable();   // Détails ou conditions de la formule
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
};
