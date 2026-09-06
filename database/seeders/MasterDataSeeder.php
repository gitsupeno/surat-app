<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Models\LetterClassification;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        Unit::updateOrCreate(['code' => 'TU'], [
            'name' => 'Tata Usaha',
            'description' => 'Unit tata usaha',
        ]);

        foreach ([
            ['code' => 'UM', 'name' => 'Umum'],
            ['code' => 'KP', 'name' => 'Kepegawaian'],
            ['code' => 'KU', 'name' => 'Keuangan'],
        ] as $classification) {
            LetterClassification::updateOrCreate(
                ['code' => $classification['code']],
                ['name' => $classification['name']],
            );
        }

        foreach ([
            ['code' => 'B', 'name' => 'Biasa'],
            ['code' => 'P', 'name' => 'Penting'],
            ['code' => 'R', 'name' => 'Rahasia'],
        ] as $sifat) {
            JenisSurat::updateOrCreate(
                ['code' => $sifat['code']],
                ['name' => $sifat['name']],
            );
        }
    }
}
