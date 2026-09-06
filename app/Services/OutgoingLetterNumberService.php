<?php

namespace App\Services;

use App\Models\OutgoingLetter;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;

class OutgoingLetterNumberService
{
    public function assign(OutgoingLetter $letter): OutgoingLetter
    {
        return DB::transaction(function () use ($letter) {
            $year = ($letter->date_letter ?: now())->year;
            $serial = OutgoingLetter::where('unit_id', $letter->unit_id)
                ->whereYear('date_letter', $year)
                ->lockForUpdate()
                ->max('serial_no') + 1;
            $unit = Unit::findOrFail($letter->unit_id);
            $classification = $letter->classification?->code ?: 'UMUM';
            $month = ($letter->date_letter ?: now())->month;
            $romanMonths = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

            $letter->update([
                'serial_no' => $serial,
                'letter_number' => sprintf('%d/%s/%s/%s/%s/%d', $serial, $classification, $unit->code ?: 'UNIT', $romanMonths[$month], $year),
            ]);

            return $letter->refresh();
        });
    }
}
