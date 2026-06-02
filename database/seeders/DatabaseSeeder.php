<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            PlanSeeder::class,
            // CourseTimeslotSeeder::class, // <-- désactivé comme demandé
            TeamBafountaScheduleSeeder::class,
            TicketTypeSeeder::class, // <-- AJOUT CORRECT
        ]);
    }
}
