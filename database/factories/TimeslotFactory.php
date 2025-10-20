<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timeslot>
 */
class TimeslotFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->randomElement(['18:00','19:30','20:00']);
        $end   = match($start) {
            '18:00' => '19:15',
            '19:30' => '20:45',
            default => '21:15',
        };

        return [
            'course_id' => \App\Models\Course::factory(),
            'weekday'   => fake()->numberBetween(1,5), // lundi-vendredi
            'start'     => $start,
            'end'       => $end,
            'location'  => fake()->randomElement(['Salle A', 'Salle B', 'Ring Principal']),
        ];
    }
}
