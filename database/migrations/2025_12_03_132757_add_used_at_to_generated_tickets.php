<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('generated_tickets', function (Blueprint $table) {

            // Ajout du code unique pour chaque billet
            if (!Schema::hasColumn('generated_tickets', 'code')) {
                $table->uuid('code')->after('id');
            }

            // Ajout du chemin vers le QR code
            if (!Schema::hasColumn('generated_tickets', 'qr_path')) {
                $table->string('qr_path')->nullable()->after('code');
            }

            // Ajout du champ indiquant si le ticket a été scanné
            if (!Schema::hasColumn('generated_tickets', 'used_at')) {
                $table->timestamp('used_at')->nullable()->after('qr_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('generated_tickets', function (Blueprint $table) {
            if (Schema::hasColumn('generated_tickets', 'used_at')) {
                $table->dropColumn('used_at');
            }
            if (Schema::hasColumn('generated_tickets', 'qr_path')) {
                $table->dropColumn('qr_path');
            }
            if (Schema::hasColumn('generated_tickets', 'code')) {
                $table->dropColumn('code');
            }
        });
    }
};
