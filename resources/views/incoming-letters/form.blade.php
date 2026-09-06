@csrf
<div class="letter-form-intro"><span class="letter-form-icon">↙</span>
    <div>
        <p class="eyebrow">Data surat masuk</p>
        <h3 class="mt-1 text-lg font-semibold text-slate-900">Lengkapi informasi surat</h3>
        <p class="mt-1 text-sm text-slate-500">Simpan data secara rapi agar mudah dicari dan didisposisikan.</p>
    </div>
</div>
<div class="form-section">
    <div class="form-section-heading"><span>01</span>
        <div>
            <h4>Informasi utama</h4>
            <p>Identitas dan waktu penerimaan surat.</p>
        </div>
    </div>
    <div class="mt-5 grid gap-5 md:grid-cols-2">
        <div><x-input-label for="mail_number" value="Nomor surat" class="form-label" /><x-text-input id="mail_number" name="mail_number" value="{{ old('mail_number', $incomingLetter->mail_number ?? '') }}" placeholder="Contoh: 005/SM/IX/2026" class="form-input mt-2 block w-full" /><x-input-error :messages="$errors->get('mail_number')" class="mt-2" /></div>
        <div><x-input-label for="sender" value="Pengirim" class="form-label" /><x-text-input id="sender" name="sender" value="{{ old('sender', $incomingLetter->sender ?? '') }}" placeholder="Nama instansi atau pengirim" class="form-input mt-2 block w-full" /><x-input-error :messages="$errors->get('sender')" class="mt-2" /></div>
        <div><x-input-label for="date_letter" value="Tanggal surat" class="form-label" /><x-text-input id="date_letter" type="date" name="date_letter" value="{{ old('date_letter', isset($incomingLetter) && $incomingLetter->date_letter ? $incomingLetter->date_letter->format('Y-m-d') : '') }}" class="form-input mt-2 block w-full" /><x-input-error :messages="$errors->get('date_letter')" class="mt-2" /></div>
        <div><x-input-label for="date_received" value="Tanggal diterima" class="form-label" /><x-text-input id="date_received" type="date" name="date_received" value="{{ old('date_received', isset($incomingLetter) && $incomingLetter->date_received ? $incomingLetter->date_received->format('Y-m-d') : '') }}" class="form-input mt-2 block w-full" /><x-input-error :messages="$errors->get('date_received')" class="mt-2" /></div>
        <div class="md:col-span-2"><x-input-label for="subject" value="Perihal surat *" class="form-label" /><x-text-input id="subject" name="subject" value="{{ old('subject', $incomingLetter->subject ?? '') }}" placeholder="Tuliskan perihal surat dengan jelas" class="form-input mt-2 block w-full" required /><x-input-error :messages="$errors->get('subject')" class="mt-2" /></div>
    </div>
</div>
<div class="form-section">
    <div class="form-section-heading"><span>02</span>
        <div>
            <h4>Klasifikasi dan tujuan</h4>
            <p>Atur sifat surat dan unit yang menerima.</p>
        </div>
    </div>
    <div class="mt-5 grid gap-5 md:grid-cols-2">
        <div><x-input-label for="sifat_id" value="Sifat surat" class="form-label" /><select id="sifat_id" name="sifat_id" class="form-input mt-2 block w-full">
                <option value="">Pilih sifat surat</option>@foreach($sifats as $sifat)<option value="{{ $sifat->id }}" @selected(old('sifat_id', $incomingLetter->sifat_id ?? '') == $sifat->id)>{{ $sifat->name }}</option>@endforeach
            </select><x-input-error :messages="$errors->get('sifat_id')" class="mt-2" /></div>
        <div><x-input-label for="classification_id" value="Klasifikasi" class="form-label" /><select id="classification_id" name="classification_id" class="form-input mt-2 block w-full">
                <option value="">Pilih klasifikasi</option>@foreach($classifications as $classification)<option value="{{ $classification->id }}" @selected(old('classification_id', $incomingLetter->classification_id ?? '') == $classification->id)>{{ $classification->code }} - {{ $classification->name }}</option>@endforeach
            </select><x-input-error :messages="$errors->get('classification_id')" class="mt-2" /></div>
        <div><x-input-label for="unit_id" value="Unit tujuan" class="form-label" /><select id="unit_id" name="unit_id" class="form-input mt-2 block w-full">
                <option value="">Pilih unit tujuan</option>@foreach($units as $unit)<option value="{{ $unit->id }}" @selected(old('unit_id', $incomingLetter->unit_id ?? '') == $unit->id)>{{ $unit->name }}</option>@endforeach
            </select><x-input-error :messages="$errors->get('unit_id')" class="mt-2" /></div>
        <div><x-input-label for="status" value="Status surat" class="form-label" /><select id="status" name="status" class="form-input mt-2 block w-full">@foreach(['baru', 'didisposisikan', 'selesai'] as $status)<option value="{{ $status }}" @selected(old('status', $incomingLetter->status ?? 'baru') === $status)>{{ ucfirst($status) }}</option>@endforeach</select><x-input-error :messages="$errors->get('status')" class="mt-2" /></div>
    </div>
</div>
<div class="form-section">
    <div class="form-section-heading"><span>03</span>
        <div>
            <h4>Catatan tambahan</h4>
            <p>Tambahkan konteks penting untuk tim.</p>
        </div>
    </div><textarea id="notes" name="notes" rows="4" placeholder="Tulis catatan atau instruksi tambahan..." class="form-input mt-5 block w-full">{{ old('notes', $incomingLetter->notes ?? '') }}</textarea><x-input-error :messages="$errors->get('notes')" class="mt-2" />
</div>
<div class="form-section">
    <div class="form-section-heading"><span>04</span>
        <div>
            <h4>Dokumen surat</h4>
            <p>Unggah salinan surat untuk disimpan bersama datanya.</p>
        </div>
    </div>
    <div class="mt-5">
        <x-input-label for="document" value="Dokumen surat" class="form-label" />
        <input id="document" type="file" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="form-input mt-2 block w-full" />
        <p class="mt-1 text-xs text-slate-500">PDF, DOC, DOCX, JPG, atau PNG. Maksimal 10 MB.</p>
        <x-input-error :messages="$errors->get('document')" class="mt-2" />
        @if (!empty($incomingLetter?->document_path))
        <p class="mt-2 text-sm text-slate-600">Dokumen saat ini: <a href="{{ Storage::disk('public')->url($incomingLetter->document_path) }}" target="_blank" rel="noopener" class="font-semibold text-teal-700 hover:underline">Lihat dokumen</a></p>
        @endif
    </div>
</div>
<div class="mt-7 flex flex-col-reverse justify-end gap-3 border-t border-slate-100 pt-5 sm:flex-row"><a href="{{ route('incoming-letters.index') }}" class="button-secondary text-center">Batal</a><x-primary-button class="button-primary justify-center">{{ $submitLabel }} <span class="ms-2">→</span></x-primary-button></div>