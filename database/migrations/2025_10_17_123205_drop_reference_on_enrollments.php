<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('enrollments', function (Blueprint $table) {
            if (!Schema::hasColumn('enrollments', 'dossier_ref')) {
                $table->string('dossier_ref')->nullable()->after('id');
            }
            if (!Schema::hasColumn('enrollments', 'is_minor')) {
                $table->boolean('is_minor')->default(false)->after('birthdate');
            }
            if (!Schema::hasColumn('enrollments', 'parent_name')) {
                $table->string('parent_name')->nullable()->after('is_minor');
            }
            if (!Schema::hasColumn('enrollments', 'parent_date')) {
                $table->date('parent_date')->nullable()->after('parent_name');
            }
            if (!Schema::hasColumn('enrollments', 'status')) {
                $table->enum('status', ['draft','pending','paid'])->default('draft')->after('rgpd');
            }
            if (!Schema::hasColumn('enrollments', 'payment_method')) {
                $table->enum('payment_method', ['card','cash','wire','pass_sport'])->nullable()->after('status');
            }
        });
    }

    public function down(): void {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn(['dossier_ref','is_minor','parent_name','parent_date','status','payment_method']);
        });
    }
};
