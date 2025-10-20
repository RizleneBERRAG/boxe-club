<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timeslots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('weekday');   // 1 = lundi ... 7 = dimanche
            $table->time('start');                    // heure début
            $table->time('end');                      // heure fin
            $table->string('location')->nullable();   // salle / adresse courte
            $table->timestamps();
        });
    }

};
