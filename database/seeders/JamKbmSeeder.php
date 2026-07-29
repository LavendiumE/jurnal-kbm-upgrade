<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JamKbm;

class JamKbmSeeder extends Seeder
{
    public function run(): void
    {
        $hari = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat'
        ];

        foreach ($hari as $h) {

            for ($i = 1; $i <= 10; $i++) {

                JamKbm::create([

                    'hari' => $h,

                    'jam_ke' => $i,

                    'jam_mulai' => '07:00',

                    'jam_selesai' => '07:45',

                ]);

            }

        }
    }
}