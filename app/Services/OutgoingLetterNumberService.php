<?php

namespace App\Services;

use App\Models\OutgoingLetter;
use App\Models\OutgoingLetterNumberSetting;
use Illuminate\Support\Facades\DB;

class OutgoingLetterNumberService
{
    public function assign(OutgoingLetter $letter): OutgoingLetter
    {
        return DB::transaction(function () use ($letter) {
            $date = $letter->date_letter ?: now();
            $setting = OutgoingLetterNumberSetting::query()->lockForUpdate()->firstOrCreate([], [
                'school_code' => 'SEKOLAH',
                'format' => '{nomor}/{kode_sekolah}/{bulan_romawi}/{tahun}',
                'reset_yearly' => true,
                'next_number' => 1,
            ]);
            $serial = OutgoingLetter::whereYear('date_letter', $date->year)->lockForUpdate()->max('serial_no') + 1;
            $romanMonths = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
            $values = [
                '{nomor}' => str_pad((string) $serial, 3, '0', STR_PAD_LEFT),
                '{kode_sekolah}' => $setting->school_code,
                '{kode_jenis}' => $letter->jenisSurat?->code ?: 'SURAT',
                '{bulan_romawi}' => $romanMonths[$date->month],
                '{tahun}' => (string) $date->year,
            ];

            $letter->update([
                'serial_no' => $serial,
                'letter_number' => str_replace(array_keys($values), array_values($values), $setting->format),
            ]);
            $setting->update(['next_number' => $serial + 1]);

            return $letter->refresh();
        });
    }
}
