<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->string('aid_type')->nullable()->after('status');           // ex: 'pass_sport'
            $table->integer('aid_amount_cents')->default(0)->after('aid_type'); // montant de l'aide en centimes
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->dropColumn(['aid_type', 'aid_amount_cents']);
        });
    }
};
