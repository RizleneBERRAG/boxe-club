<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('price_cents');           // 2500 = 25.00€
            $table->string('image_path')->nullable(); // /storage/products/...
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

    }
};
