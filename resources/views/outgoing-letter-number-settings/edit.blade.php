<x-app-layout><x-slot name="header">
        <div>
            <p class="eyebrow">Administrasi surat</p>
            <h2 class="mt-1 text-2xl font-semibold text-slate-900">Penomoran surat keluar</h2>
            <p class="mt-1 text-sm text-slate-500">Atur format nomor otomatis untuk surat keluar.</p>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">@if(session('status'))<div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">{{ session('status') }}</div>@endif<form method="POST" action="{{ route('outgoing-letter-number-settings.update') }}" class="letter-form-card">@csrf @method('PUT')<div class="grid gap-5 md:grid-cols-2">
                    <div><x-input-label for="school_code" value="Kode sekolah" class="form-label" /><x-text-input id="school_code" name="school_code" value="{{ old('school_code', $setting->school_code) }}" class="form-input mt-2 block w-full" required /><x-input-error :messages="$errors->get('school_code')" class="mt-2" /></div>
                    <div><x-input-label for="next_number" value="Nomor berikutnya" class="form-label" /><x-text-input id="next_number" type="number" min="1" name="next_number" value="{{ old('next_number', $setting->next_number) }}" class="form-input mt-2 block w-full" required /><x-input-error :messages="$errors->get('next_number')" class="mt-2" /></div>
                    <div class="md:col-span-2"><x-input-label for="format" value="Format nomor" class="form-label" /><x-text-input id="format" name="format" value="{{ old('format', $setting->format) }}" class="form-input mt-2 block w-full" required />
                        <p class="mt-2 text-xs text-slate-500">Placeholder: {nomor}, {kode_sekolah}, {kode_jenis}, {bulan_romawi}, {tahun}</p><x-input-error :messages="$errors->get('format')" class="mt-2" />
                    </div><label class="flex items-center gap-2 text-sm font-semibold text-slate-600"><input type="checkbox" name="reset_yearly" value="1" @checked(old('reset_yearly', $setting->reset_yearly))> Reset nomor setiap tahun</label>
                </div>
                <div class="mt-6 flex justify-end"><button class="button-primary">Simpan pengaturan</button></div>
            </form>
        </div>
    </div>
</x-app-layout>