<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('generated_tickets', function (Blueprint $table) {
            $table->string('holder_name')->nullable()->after('uuid');
        });
    }

    public function down(): void
    {
        Schema::table('generated_tickets', function (Blueprint $table) {
            $table->dropColumn('holder_name');
        });
    }
};
