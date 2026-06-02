<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Adulte', 'Enfant', 'Compétiteur']),
            'price_cents' => fake()->randomElement([25000, 35000, 45000]), // 250€ / 350€ / 450€
            'allow_split' => true,
            'description' => fake()->sentence(10),
            'is_active' => true,
        ];
    }
}
