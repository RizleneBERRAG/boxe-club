<?php

namespace Database\Seeders;

use App\Models\TicketType;
use Illuminate\Database\Seeder;

class TicketTypeSeeder extends Seeder
{
    public function run(): void
    {
        TicketType::updateOrCreate(
            ['slug' => 'ring'],
            [
                'name' => 'RING',
                'label' => 'Au bord du ring',
                'price_cents' => 5000, // 50 €
                'max_per_order' => 10,
            ]
        );

        TicketType::updateOrCreate(
            ['slug' => 'tribune'],
            [
                'name' => 'TRIBUNE',
                'label' => 'Tribune',
                'price_cents' => 2500, // 25 €
                'max_per_order' => 10,
            ]
        );

        TicketType::updateOrCreate(
            ['slug' => 'enfant'],
            [
                'name' => 'ENFANT',
                'label' => 'Enfant (-12 ans)',
                'price_cents' => 1000, // 10 €
                'max_per_order' => 10,
            ]
        );

        TicketType::updateOrCreate(
            ['slug' => 'vip'],
            [
                'name' => 'VIP',
                'label' => 'Table VIP (x5)',
                'price_cents' => 50000, // 500 €
                'max_per_order' => 4,
            ]
        );
    }
}
