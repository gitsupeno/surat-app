<?php

namespace App\Http\Controllers;

use App\Models\OutgoingLetterNumberSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OutgoingLetterNumberSettingController extends Controller
{
    public function edit(): View
    {
        return view('outgoing-letter-number-settings.edit', ['setting' => OutgoingLetterNumberSetting::query()->firstOrCreate([], ['school_code' => 'SEKOLAH', 'format' => '{nomor}/{kode_sekolah}/{bulan_romawi}/{tahun}', 'reset_yearly' => true, 'next_number' => 1])]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate(['school_code' => ['required', 'string', 'max:50'], 'format' => ['required', 'string', 'max:255'], 'reset_yearly' => ['nullable', 'boolean'], 'next_number' => ['required', 'integer', 'min:1']]);
        OutgoingLetterNumberSetting::query()->firstOrCreate(['id' => 1])->update($data);
        return back()->with('status', 'Format nomor surat berhasil diperbarui.');
    }
}
