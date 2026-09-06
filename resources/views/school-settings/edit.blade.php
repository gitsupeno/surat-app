<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="eyebrow">Administrasi aplikasi</p>
            <h2 class="mt-1 text-2xl font-semibold text-slate-900">Pengaturan sekolah</h2>
            <p class="mt-1 text-sm text-slate-500">Kelola identitas sekolah yang digunakan dalam administrasi persuratan.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @if(session('status'))
            <div class="mb-5 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-700">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('school-settings.update') }}" enctype="multipart/form-data" class="letter-form-card">
                @csrf
                @method('PUT')

                <div class="letter-form-intro"><span class="letter-form-icon">⚙</span>
                    <div>
                        <p class="eyebrow">Identitas sekolah</p>
                        <h3 class="mt-1 text-lg font-semibold text-slate-900">Lengkapi informasi resmi</h3>
                        <p class="mt-1 text-sm text-slate-500">Informasi ini dapat digunakan pada dokumen dan tampilan aplikasi.</p>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-heading"><span>01</span>
                        <div>
                            <h4>Instansi dan sekolah</h4>
                            <p>Masukkan nama lembaga sesuai identitas resmi.</p>
                        </div>
                    </div>
                    <div class="mt-5 grid gap-5 md:grid-cols-2">
                        <div><x-input-label for="government_name" value="Nama pemerintah" class="form-label" /><x-text-input id="government_name" name="government_name" value="{{ old('government_name', $setting->government_name) }}" class="form-input mt-2 block w-full" required /><x-input-error :messages="$errors->get('government_name')" class="mt-2" /></div>
                        <div><x-input-label for="department_name" value="Dinas" class="form-label" /><x-text-input id="department_name" name="department_name" value="{{ old('department_name', $setting->department_name) }}" class="form-input mt-2 block w-full" required /><x-input-error :messages="$errors->get('department_name')" class="mt-2" /></div>
                        <div><x-input-label for="branch_department_name" value="Cabang dinas" class="form-label" /><x-text-input id="branch_department_name" name="branch_department_name" value="{{ old('branch_department_name', $setting->branch_department_name) }}" class="form-input mt-2 block w-full" /><x-input-error :messages="$errors->get('branch_department_name')" class="mt-2" /></div>
                        <div><x-input-label for="school_name" value="Nama sekolah" class="form-label" /><x-text-input id="school_name" name="school_name" value="{{ old('school_name', $setting->school_name) }}" class="form-input mt-2 block w-full" required /><x-input-error :messages="$errors->get('school_name')" class="mt-2" /></div>
                        <div><x-input-label for="principal_name" value="Kepala sekolah" class="form-label" /><x-text-input id="principal_name" name="principal_name" value="{{ old('principal_name', $setting->principal_name) }}" class="form-input mt-2 block w-full" required /><x-input-error :messages="$errors->get('principal_name')" class="mt-2" /></div>
                        <div><x-input-label for="principal_nip" value="NIP kepala sekolah" class="form-label" /><x-text-input id="principal_nip" name="principal_nip" value="{{ old('principal_nip', $setting->principal_nip) }}" class="form-input mt-2 block w-full" required /><x-input-error :messages="$errors->get('principal_nip')" class="mt-2" /></div>
                        <div class="md:col-span-2"><x-input-label for="address" value="Alamat" class="form-label" /><textarea id="address" name="address" rows="3" class="form-input mt-2 block w-full" required>{{ old('address', $setting->address) }}</textarea><x-input-error :messages="$errors->get('address')" class="mt-2" /></div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-heading"><span>02</span>
                        <div>
                            <h4>Kontak sekolah</h4>
                            <p>Tambahkan kanal resmi yang dapat dihubungi.</p>
                        </div>
                    </div>
                    <div class="mt-5 grid gap-5 md:grid-cols-2">
                        <div><x-input-label for="website" value="Website" class="form-label" /><x-text-input id="website" type="url" name="website" value="{{ old('website', $setting->website) }}" placeholder="https://sekolah.example" class="form-input mt-2 block w-full" /><x-input-error :messages="$errors->get('website')" class="mt-2" /></div>
                        <div><x-input-label for="email" value="Email" class="form-label" /><x-text-input id="email" type="email" name="email" value="{{ old('email', $setting->email) }}" class="form-input mt-2 block w-full" /><x-input-error :messages="$errors->get('email')" class="mt-2" /></div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-heading"><span>03</span>
                        <div>
                            <h4>Logo identitas</h4>
                            <p>Gunakan format PNG, JPG, atau SVG dengan ukuran maksimal 5 MB.</p>
                        </div>
                    </div>
                    <div class="mt-5 grid gap-5 md:grid-cols-2">
                        <div><x-input-label for="province_logo" value="Logo provinsi" class="form-label" /><input id="province_logo" type="file" name="province_logo" accept=".jpg,.jpeg,.png,.svg" class="form-input mt-2 block w-full" /><x-input-error :messages="$errors->get('province_logo')" class="mt-2" />@if($setting->province_logo_path)<a href="{{ Storage::disk('public')->url($setting->province_logo_path) }}" target="_blank" rel="noopener" class="mt-2 inline-block text-sm font-semibold text-teal-700 hover:underline">Lihat logo provinsi</a>@endif</div>
                        <div><x-input-label for="school_logo" value="Logo sekolah" class="form-label" /><input id="school_logo" type="file" name="school_logo" accept=".jpg,.jpeg,.png,.svg" class="form-input mt-2 block w-full" /><x-input-error :messages="$errors->get('school_logo')" class="mt-2" />@if($setting->school_logo_path)<a href="{{ Storage::disk('public')->url($setting->school_logo_path) }}" target="_blank" rel="noopener" class="mt-2 inline-block text-sm font-semibold text-teal-700 hover:underline">Lihat logo sekolah</a>@endif</div>
                    </div>
                </div>

                <div class="mt-7 flex justify-end border-t border-slate-100 pt-5"><x-primary-button class="button-primary justify-center">Simpan pengaturan <span class="ms-2">→</span></x-primary-button></div>
            </form>
        </div>
    </div>
</x-app-layout>