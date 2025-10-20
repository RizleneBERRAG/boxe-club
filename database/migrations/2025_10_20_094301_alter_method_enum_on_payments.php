<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) Ajouter la colonne 'status' si elle n'existe pas encore
        if (!Schema::hasColumn('payments', 'status')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->enum('status', ['pending','paid'])
                    ->default('pending')
                    ->after('method');
            });
        }

        // 2) Passer method -> VARCHAR pour éviter les warnings de truncation
        try {
            DB::statement("ALTER TABLE `payments` MODIFY COLUMN `method` VARCHAR(20) NOT NULL DEFAULT 'card'");
        } catch (\Throwable $e) {
            // si la colonne est déjà en VARCHAR, on ignore
        }

        // 3) Normaliser les anciennes valeurs (FR -> EN)
        try {
            // Méthodes
            DB::statement("UPDATE `payments` SET `method`='card'       WHERE `method` IN ('cb','carte','carte_bancaire','CB')");
            DB::statement("UPDATE `payments` SET `method`='cash'       WHERE `method` IN ('especes','espèces','Espèces')");
            DB::statement("UPDATE `payments` SET `method`='wire'       WHERE `method` IN ('virement','Virement','bank','transfer')");
            DB::statement("UPDATE `payments` SET `method`='pass_sport' WHERE `method` IN ('passsport','pass_sport','PassSport')");

            // Statuts (au cas où tu aurais rempli quelque chose)
            DB::statement("UPDATE `payments` SET `status`='paid'    WHERE `status` IN ('payé','paye')");
            DB::statement("UPDATE `payments` SET `status`='pending' WHERE `status` IS NULL OR `status`='' OR `status` NOT IN ('pending','paid')");
        } catch (\Throwable $e) {
            // ok si rien à mettre à jour
        }

        // 4) Recréer un ENUM propre
        try {
            DB::statement("ALTER TABLE `payments` MODIFY COLUMN `method` ENUM('card','cash','wire','pass_sport') NOT NULL DEFAULT 'card'");
        } catch (\Throwable $e) {
            // certains moteurs n'aiment pas repasser à ENUM; si besoin on peut rester en VARCHAR
        }
    }

    public function down(): void
    {
        // Revenir à VARCHAR pour method
        try {
            DB::statement("ALTER TABLE `payments` MODIFY COLUMN `method` VARCHAR(20) NOT NULL DEFAULT 'card'");
        } catch (\Throwable $e) {}

        // (Optionnel) supprimer la colonne status si tu veux un down strict
        if (Schema::hasColumn('payments', 'status')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
