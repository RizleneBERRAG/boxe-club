<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // si la colonne price n'existe pas encore :
            if (!Schema::hasColumn('products', 'price')) {
                $table->decimal('price', 8, 2)->default(0);
            }

            // rendre price_cents optionnel ou carrément le supprimer si tu veux
            if (Schema::hasColumn('products', 'price_cents')) {
                $table->integer('price_cents')->nullable()->change();
            }

            if (!Schema::hasColumn('products', 'slug')) {
                $table->string('slug')->nullable();
            }

            if (!Schema::hasColumn('products', 'image_path')) {
                $table->string('image_path')->nullable();
            }

            if (!Schema::hasColumn('products', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }

            if (!Schema::hasColumn('products', 'sizes')) {
                $table->json('sizes')->nullable();
            }
        });
    }

    public function down(): void
    {
        // on laisse vide, pas besoin de rollback compliqué
    }
};
