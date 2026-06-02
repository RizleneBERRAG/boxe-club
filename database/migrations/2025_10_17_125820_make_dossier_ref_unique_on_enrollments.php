<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1) Backfill les NULL (rare mais safe)
        // Format: TBF-YYYY-XXXXXX
        DB::statement("
            UPDATE enrollments
            SET dossier_ref = CONCAT('TBF-', YEAR(NOW()), '-', UPPER(SUBSTRING(REPLACE(UUID(),'-',''),1,6)))
            WHERE dossier_ref IS NULL OR dossier_ref = ''
        ");

        // 2) NOT NULL
        Schema::table('enrollments', function (Blueprint $table) {
            $table->string('dossier_ref')->nullable(false)->change();
        });

        // 3) Index UNIQUE si pas déjà présent
        DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS enrollments_dossier_ref_unique ON enrollments (dossier_ref)');
    }

    public function down(): void
    {
        // On revient à nullable et on retire l’unique index
        try {
            DB::statement('DROP INDEX IF EXISTS enrollments_dossier_ref_unique ON enrollments');
        } catch (\Throwable $e) {
            // MySQL versions: fallback nom d’index
            try { DB::statement('ALTER TABLE enrollments DROP INDEX enrollments_dossier_ref_unique'); } catch (\Throwable $e2) {}
        }

        Schema::table('enrollments', function (Blueprint $table) {
            $table->string('dossier_ref')->nullable()->change();
        });
    }
};
