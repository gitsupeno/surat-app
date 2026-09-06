<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchoolSettingRequest;
use App\Models\SchoolSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SchoolSettingController extends Controller
{
    public function edit(): View
    {
        return view('school-settings.edit', [
            'setting' => $this->setting(),
        ]);
    }

    public function update(SchoolSettingRequest $request): RedirectResponse
    {
        $setting = $this->setting();
        $data = $request->validated();
        unset($data['province_logo'], $data['school_logo']);

        foreach (['province_logo', 'school_logo'] as $logo) {
            if ($request->hasFile($logo)) {
                $pathColumn = $logo . '_path';

                if ($setting->{$pathColumn}) {
                    Storage::disk('public')->delete($setting->{$pathColumn});
                }

                $data[$pathColumn] = $request->file($logo)->store('school-settings', 'public');
            }
        }

        $setting->update($data);

        return to_route('school-settings.edit')->with('status', 'Pengaturan sekolah berhasil diperbarui.');
    }

    private function setting(): SchoolSetting
    {
        return SchoolSetting::query()->firstOrCreate(['id' => 1], [
            'government_name' => '',
            'department_name' => '',
            'school_name' => '',
            'principal_name' => '',
            'principal_nip' => '',
            'address' => '',
        ]);
    }
}
