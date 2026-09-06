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

        foreach (
            [
                ['code' => 'UM', 'name' => 'Umum'],
                ['code' => 'KP', 'name' => 'Kepegawaian'],
                ['code' => 'KU', 'name' => 'Keuangan'],
            ] as $classification
        ) {
            LetterClassification::updateOrCreate(
                ['code' => $classification['code']],
                ['name' => $classification['name']],
            );
        }

        foreach (
            [
                ['code' => 'B', 'name' => 'Biasa'],
                ['code' => 'P', 'name' => 'Penting'],
                ['code' => 'R', 'name' => 'Rahasia'],
                ['code' => 'S', 'name' => 'Segera'],
            ] as $sifat
        ) {
            JenisSurat::updateOrCreate(
                ['code' => $sifat['code']],
                ['name' => $sifat['name']],
            );
        }

        foreach (
            [
                ['code' => 'UND', 'name' => 'Surat Undangan'],
                ['code' => 'PEM', 'name' => 'Surat Pemberitahuan'],
                ['code' => 'TGS', 'name' => 'Surat Tugas'],
                ['code' => 'MOH', 'name' => 'Surat Permohonan'],
                ['code' => 'PGT', 'name' => 'Surat Pengantar'],
                ['code' => 'KET', 'name' => 'Surat Keterangan'],
                ['code' => 'REK', 'name' => 'Surat Rekomendasi'],
                ['code' => 'NYT', 'name' => 'Surat Pernyataan'],
                ['code' => 'EDR', 'name' => 'Surat Edaran'],
                ['code' => 'BAL', 'name' => 'Surat Balasan'],
                ['code' => 'ORT', 'name' => 'Surat Pemanggilan Orang Tua/Wali'],
                ['code' => 'BNT', 'name' => 'Surat Permohonan Bantuan'],
                ['code' => 'KSM', 'name' => 'Surat Permohonan Kerja Sama'],
                ['code' => 'LNY', 'name' => 'Surat lainnya'],
            ] as $jenis
        ) {
            JenisSurat::updateOrCreate(['code' => $jenis['code']], ['name' => $jenis['name']]);
        }
    }
}
