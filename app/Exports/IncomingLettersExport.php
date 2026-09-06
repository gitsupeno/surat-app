<?php

namespace App\Exports;

use App\Models\IncomingLetter;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IncomingLettersExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return IncomingLetter::with(['classification', 'unit'])->latest('date_received');
    }

    public function headings(): array
    {
        return ['Nomor Surat', 'Tanggal Surat', 'Tanggal Diterima', 'Pengirim', 'Perihal', 'Klasifikasi', 'Unit', 'Status'];
    }

    public function map($letter): array
    {
        return [$letter->mail_number, $letter->date_letter?->format('Y-m-d'), $letter->date_received?->format('Y-m-d'), $letter->sender, $letter->subject, $letter->classification?->name, $letter->unit?->name, $letter->status];
    }
}
