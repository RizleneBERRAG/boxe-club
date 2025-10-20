<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1) Sortir de l'ENUM -> VARCHAR pour éviter tout conflit
        DB::statement("
            ALTER TABLE `enrollments`
            MODIFY COLUMN `status` VARCHAR(20) NOT NULL DEFAULT 'draft'
        ");

        // 2) Normaliser toutes les valeurs vers l'anglais
        try {
            // Nettoyage générique
            DB::statement("UPDATE `enrollments` SET `status` = LOWER(TRIM(`status`))");

            // Variantes FR & typos -> pending
            DB::statement("UPDATE `enrollments` SET `status`='pending' WHERE `status` IN (
                'en_attente','en attente','a_valider','à_valider','a valider','attente','pending '
            )");

            // Brouillon -> draft
            DB::statement("UPDATE `enrollments` SET `status`='draft' WHERE `status` IN (
                'brouillon','draft '
            )");

            // Payé -> paid
            DB::statement("UPDATE `enrollments` SET `status`='paid' WHERE `status` IN (
                'paye','payé','payee','payeee','paid '
            )");

            // Filet de sécurité : tout le reste -> draft
            DB::statement("
                UPDATE `enrollments`
                SET `status`='draft'
                WHERE `status` IS NULL
                   OR `status`=''
                   OR `status` NOT IN ('draft','pending','paid')
            ");
        } catch (\Throwable $e) {
            // ok si aucune ligne ne correspond
        }

        // 3) Recréer l'ENUM final propre
        DB::statement("
            ALTER TABLE `enrollments`
            MODIFY COLUMN `status` ENUM('draft','pending','paid')
            NOT NULL DEFAULT 'draft'
        ");
    }

    public function down(): void
    {
        // Retour à VARCHAR (simple)
        DB::statement("
            ALTER TABLE `enrollments`
            MODIFY COLUMN `status` VARCHAR(20) NOT NULL DEFAULT 'draft'
        ");
    }
};
