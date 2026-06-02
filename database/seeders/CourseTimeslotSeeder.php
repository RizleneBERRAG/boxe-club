<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Timeslot;
use Illuminate\Database\Seeder;

class CourseTimeslotSeeder extends Seeder
{
    public function run(): void
    {
        // Quelques cours fixes
        $courses = [
            ['title'=>'Boxe anglaise - Débutants','level'=>'débutant','description'=>'Initiation technique & cardio'],
            ['title'=>'Boxe anglaise - Intermédiaires','level'=>'intermédiaire','description'=>'Perfectionnement & sparring contrôlé'],
            ['title'=>'Préparation physique','level'=>null,'description'=>'Renfo, fractionné, mobilité'],
        ];

        foreach ($courses as $c) {
            $course = Course::updateOrCreate(
                ['title'=>$c['title']],
                ['level'=>$c['level'],'description'=>$c['description'],'is_active'=>true]
            );

            // Créneaux types (lundi/mercredi/vendredi)
            $slots = [
                ['weekday'=>1,'start'=>'19:30','end'=>'20:45','location'=>'Ring Principal'],
                ['weekday'=>3,'start'=>'19:30','end'=>'20:45','location'=>'Salle A'],
                ['weekday'=>5,'start'=>'18:00','end'=>'19:15','location'=>'Salle B'],
            ];

            foreach ($slots as $s) {
                Timeslot::firstOrCreate(
                    ['course_id'=>$course->id,'weekday'=>$s['weekday'],'start'=>$s['start']],
                    ['end'=>$s['end'],'location'=>$s['location']]
                );
            }
        }
    }
}

