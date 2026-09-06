<?php

namespace App\Exports;

use App\Models\OutgoingLetter;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OutgoingLettersExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return OutgoingLetter::with(['classification', 'unit'])->latest('date_letter');
    }

    public function headings(): array
    {
        return ['Nomor Surat', 'Tanggal', 'Penerima', 'Perihal', 'Klasifikasi', 'Unit', 'Status'];
    }

    public function map($letter): array
    {
        return [$letter->letter_number, $letter->date_letter?->format('Y-m-d'), $letter->recipient, $letter->subject, $letter->classification?->name, $letter->unit?->name, $letter->status];
    }
}
