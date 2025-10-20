<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Timeslot;

class TeamBafountaScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // Lieux (avec adresse + transport)
        $BREL = "Gymnase Jacques Brel — 7 avenue d'Oschatz (T4/C12 arrêt Lycée Jacques Brel)";
        $GUIMIER = "Gymnase Jean Guimier — Avenue Jules Guesde (métro/bus arrêt Parilly)";

        // 1 = Lundi ... 7 = Dimanche
        // On définit les cours (créés/MAJ par titre)
        $courses = [
            'Amateurs (Compétiteurs)'        => ['level' => 'avancé', 'desc' => 'Groupe compétiteurs'],
            'Éducatif'                       => ['level' => 'débutant', 'desc' => 'Jeunes éducatifs'],
            'Aéro Boxe'                      => ['level' => null, 'desc' => 'Cardio/Technique sans opposition'],
            'Amateurs & Loisirs'             => ['level' => 'intermédiaire', 'desc' => 'Loisirs / amateurs'],
            'Baby Boxe'                      => ['level' => 'débutant', 'desc' => 'Initiation 4–7 ans'],
            'Musculation Amateurs'           => ['level' => null, 'desc' => 'Préparation physique (amateurs)'],
            'Entraînement Boxe (Loisir/Amateur/Aéro)' => ['level' => null, 'desc' => 'Séance commune technique/physique'],
            'Éducatif & Baby (Samedi)'       => ['level' => 'débutant', 'desc' => 'Séance encadrée par Filip Bafounta'],
        ];

        // Upsert des cours
        $courseIds = [];
        foreach ($courses as $title => $meta) {
            $c = Course::updateOrCreate(
                ['title' => $title],
                ['description' => $meta['desc'] ?? null, 'level' => $meta['level'] ?? null, 'is_active' => true]
            );
            $courseIds[$title] = $c->id;
        }

        // On nettoie les créneaux existants pour repartir propre
        Timeslot::query()->delete();

        // Planning exact fourni
        $schedule = [
            // LUNDI — Jacques Brel
            ['Amateurs (Compétiteurs)', 1, '20:15', '22:00', $BREL],

            // MARDI — Jacques Brel
            ['Éducatif',                2, '18:00', '19:15', $BREL],
            ['Aéro Boxe',               2, '19:15', '20:30', $BREL],
            ['Amateurs & Loisirs',      2, '20:30', '22:00', $BREL],

            // MERCREDI — Baby à Brel, Muscu à Guimier
            ['Baby Boxe',               3, '17:00', '18:00', $BREL],
            ['Musculation Amateurs',    3, '19:15', '21:00', $GUIMIER],

            // JEUDI — comme mardi — Jacques Brel
            ['Éducatif',                4, '18:00', '19:15', $BREL],
            ['Aéro Boxe',               4, '19:15', '20:30', $BREL],
            ['Amateurs & Loisirs',      4, '20:30', '22:00', $BREL],

            // VENDREDI — pas d’entraînement (rien à créer)

            // SAMEDI — Jean Guimier
            ['Musculation Amateurs',                   6, '08:45', '10:00', $GUIMIER], // avec Aimé Bafounta
            ['Entraînement Boxe (Loisir/Amateur/Aéro)',6, '10:00', '12:00', $GUIMIER], // avec Aimé Bafounta
            ['Éducatif & Baby (Samedi)',               6, '10:00', '12:00', $GUIMIER], // avec Filip Bafounta

            // DIMANCHE — rien
        ];

        foreach ($schedule as [$title, $weekday, $start, $end, $location]) {
            Timeslot::create([
                'course_id' => $courseIds[$title],
                'weekday'   => $weekday,     // 1 = lundi ... 7 = dimanche
                'start'     => $start,
                'end'       => $end,
                'location'  => $location,
            ]);
        }
    }
}
