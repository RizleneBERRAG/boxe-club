<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement([
                'Boxe anglaise - Débutants',
                'Boxe anglaise - Intermédiaires',
                'Prépa Physique',
            ]),
            'description' => fake()->sentence(12),
            'level' => fake()->randomElement(['débutant','intermédiaire','avancé']),
            'is_active' => true,
        ];
    }
}
