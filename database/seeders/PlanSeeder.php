<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Formule 1
            ['name' => 'Boxe éducative', 'price_cents' => 35000, 'allow_split' => false, 'description' => '(assurance comprise)'],
            // Formule 2
            ['name' => 'Aéro Boxe', 'price_cents' => 35000, 'allow_split' => false, 'description' => '(assurance comprise)'],
            // Formule 3
            ['name' => 'Boxe amateur', 'price_cents' => 63000, 'allow_split' => true,  'description' => '(assurance comprise) — inclut 50 € salle de musculation (obligatoire)'],
            // Formule 4
            ['name' => 'Boxe loisir', 'price_cents' => 38000, 'allow_split' => true,  'description' => '(assurance comprise)'],
            // Baby
            ['name' => 'Baby Boxe Initiation (5–9 ans)', 'price_cents' => 30000, 'allow_split' => false, 'description' => '(assurance comprise) — Apprentissage ludique et sécurisé, coordination & confiance.'],
        ];

        foreach ($data as $p) {
            Plan::updateOrCreate(
                ['name' => $p['name']],
                [
                    'price_cents'  => $p['price_cents'],
                    'allow_split'  => $p['allow_split'],
                    'description'  => $p['description'],
                    'is_active'    => true,
                ]
            );
        }
    }
}
