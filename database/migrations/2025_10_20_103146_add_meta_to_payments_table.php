<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // JSON si dispo, sinon TEXT en fallback
            if (Schema::hasColumn('payments', 'meta')) return;

            // MySQL 5.7+ : JSON ok ; sinon change en ->text('meta')
            $table->json('meta')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'meta')) {
                $table->dropColumn('meta');
            }
        });
    }
};
