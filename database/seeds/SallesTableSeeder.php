<?php

namespace Database\Seeders;

use App\Salle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SallesTableSeeder extends Seeder
{
    public function run()
    {
        // Amphis

        $amphis = [
            [
                'label' => 'Grand Amphi',
                'type' => 'Cours',
                'capacity' => 80,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Amphi 1',
                'type' => 'Cours',
                'capacity' => 80,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Amphi 2',
                'type' => 'Cours',
                'capacity' => 80,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        Salle::insert($amphis);

        // TD classes 

        for($i = 1; $i <= 12;$i++){
            DB::table('salles')->insert([
                'label' => 'B'.$i,
                'type' => 'TD',
                'capacity' => 30,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // TP classes
        for($i = 2; $i <= 5;$i++){
            DB::table('salles')->insert([
                'label' => 'A'.$i,
                'type' => 'TP',
                'capacity' => 20,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
