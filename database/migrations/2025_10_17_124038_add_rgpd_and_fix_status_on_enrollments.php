<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            // 1) Ajouter rgpd si absent
            if (!Schema::hasColumn('enrollments', 'rgpd')) {
                // place-le où tu veux ; ici après plan_id
                $table->boolean('rgpd')->default(false)->after('plan_id');
            }

            // 2) S'assurer que dossier_ref existe (au cas où)
            if (!Schema::hasColumn('enrollments', 'dossier_ref')) {
                $table->string('dossier_ref')->nullable()->after('id');
            }

            // 3) S'assurer que status existe et a les bonnes valeurs
            if (!Schema::hasColumn('enrollments', 'status')) {
                $table->enum('status', ['draft','pending','paid'])->default('draft')->after('rgpd');
            }
        });

        // 4) Normaliser d'anciennes valeurs FR si présentes
        try {
            DB::statement("UPDATE enrollments SET status='draft'   WHERE status IN ('brouillon')");
            DB::statement("UPDATE enrollments SET status='pending' WHERE status IN ('en_attente','à_valider','a_valider')");
            DB::statement("UPDATE enrollments SET status='paid'    WHERE status IN ('paye','payé')");
        } catch (\Throwable $e) {
            // ignore si la colonne n'était pas encore là / ou valeurs absentes
        }
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            if (Schema::hasColumn('enrollments', 'rgpd')) {
                $table->dropColumn('rgpd');
            }
            // on ne touche pas à status/dossier_ref au rollback
        });
    }
};
