<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            PlanSeeder::class,
            // CourseTimeslotSeeder::class, // <-- désactive-le
            TeamBafountaScheduleSeeder::class, // <-- laisse celui-ci
        ]);
    }

}
