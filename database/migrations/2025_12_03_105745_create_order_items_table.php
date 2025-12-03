<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Doit correspondre EXACTEMENT à orders.id (bigint unsigned)
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // ticket_types.id pareil (bigint unsigned)
            $table->foreignId('ticket_type_id')
                ->constrained('ticket_types');

            $table->unsignedInteger('quantity');
            $table->unsignedInteger('unit_price_cents');
            $table->unsignedInteger('total_cents');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
