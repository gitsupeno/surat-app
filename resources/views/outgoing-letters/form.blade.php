@csrf
<div class="letter-form-intro"><span class="letter-form-icon">↗</span>
    <div>
        <p class="eyebrow">Pusat surat keluar</p>
        <h3 class="mt-1 text-lg font-semibold text-slate-900">Lengkapi surat resmi</h3>
        <p class="mt-1 text-sm text-slate-500">Surat baru akan masuk ke tahap menunggu verifikasi.</p>
    </div>
</div>
<div class="form-section">
    <div class="form-section-heading"><span>01</span>
        <div>
            <h4>Identitas surat</h4>
            <p>Nomor surat dibuat otomatis setelah disimpan.</p>
        </div>
    </div>
    <div class="mt-5 grid gap-5 md:grid-cols-2">
        <div><x-input-label for="date_letter" value="Tanggal surat" class="form-label" /><x-text-input id="date_letter" type="date" name="date_letter" value="{{ old('date_letter', isset($outgoingLetter) ? $outgoingLetter->date_letter?->format('Y-m-d') : now()->format('Y-m-d')) }}" class="form-input mt-2 block w-full" required /><x-input-error :messages="$errors->get('date_letter')" class="mt-2" /></div>
        <div><x-input-label for="jenis_surat_id" value="Jenis surat" class="form-label" /><select id="jenis_surat_id" name="jenis_surat_id" class="form-input mt-2 block w-full" required>
                <option value="">Pilih jenis surat</option>@foreach($jenisSurat as $jenis)<option value="{{ $jenis->id }}" @selected(old('jenis_surat_id', $outgoingLetter->jenis_surat_id ?? '') == $jenis->id)>{{ $jenis->code ? $jenis->code . ' - ' : '' }}{{ $jenis->name }}</option>@endforeach
            </select><x-input-error :messages="$errors->get('jenis_surat_id')" class="mt-2" /></div>
        <div><x-input-label for="sifat" value="Sifat surat" class="form-label" /><select id="sifat" name="sifat" class="form-input mt-2 block w-full" required>@foreach(['biasa' => 'Biasa', 'penting' => 'Penting', 'segera' => 'Segera', 'rahasia' => 'Rahasia'] as $value => $label)<option value="{{ $value }}" @selected(old('sifat', $outgoingLetter->sifat ?? 'biasa') === $value)>{{ $label }}</option>@endforeach</select><x-input-error :messages="$errors->get('sifat')" class="mt-2" /></div>
        <div><x-input-label for="lampiran" value="Lampiran" class="form-label" /><x-text-input id="lampiran" name="lampiran" value="{{ old('lampiran', $outgoingLetter->lampiran ?? '') }}" placeholder="Contoh: 1 berkas" class="form-input mt-2 block w-full" /><x-input-error :messages="$errors->get('lampiran')" class="mt-2" /></div>
        <div class="md:col-span-2"><x-input-label for="subject" value="Perihal" class="form-label" /><x-text-input id="subject" name="subject" value="{{ old('subject', $outgoingLetter->subject ?? '') }}" class="form-input mt-2 block w-full" required /><x-input-error :messages="$errors->get('subject')" class="mt-2" /></div>
    </div>
</div>
<div class="form-section">
    <div class="form-section-heading"><span>02</span>
        <div>
            <h4>Tujuan surat</h4>
            <p>Informasi penerima atau instansi tujuan.</p>
        </div>
    </div>
    <div class="mt-5 grid gap-5 md:grid-cols-2">
        <div><x-input-label for="recipient" value="Nama penerima/instansi" class="form-label" /><x-text-input id="recipient" name="recipient" value="{{ old('recipient', $outgoingLetter->recipient ?? '') }}" class="form-input mt-2 block w-full" required /><x-input-error :messages="$errors->get('recipient')" class="mt-2" /></div>
        <div><x-input-label for="recipient_position" value="Jabatan penerima" class="form-label" /><x-text-input id="recipient_position" name="recipient_position" value="{{ old('recipient_position', $outgoingLetter->recipient_position ?? '') }}" class="form-input mt-2 block w-full" /><x-input-error :messages="$errors->get('recipient_position')" class="mt-2" /></div>
        <div><x-input-label for="recipient_email" value="Email tujuan" class="form-label" /><x-text-input id="recipient_email" type="email" name="recipient_email" value="{{ old('recipient_email', $outgoingLetter->recipient_email ?? '') }}" class="form-input mt-2 block w-full" /><x-input-error :messages="$errors->get('recipient_email')" class="mt-2" /></div>
        <div><x-input-label for="unit_id" value="Unit pengelola" class="form-label" /><select id="unit_id" name="unit_id" class="form-input mt-2 block w-full" required>
                <option value="">Pilih unit</option>@foreach($units as $unit)<option value="{{ $unit->id }}" @selected(old('unit_id', $outgoingLetter->unit_id ?? '') == $unit->id)>{{ $unit->name }}</option>@endforeach
            </select><x-input-error :messages="$errors->get('unit_id')" class="mt-2" /></div>
        <div class="md:col-span-2"><x-input-label for="recipient_address" value="Alamat tujuan" class="form-label" /><textarea id="recipient_address" name="recipient_address" rows="2" class="form-input mt-2 block w-full">{{ old('recipient_address', $outgoingLetter->recipient_address ?? '') }}</textarea><x-input-error :messages="$errors->get('recipient_address')" class="mt-2" /></div>
    </div>
</div>
<div class="form-section">
    <div class="form-section-heading"><span>03</span>
        <div>
            <h4>Isi surat</h4>
            <p>Gunakan HTML sederhana untuk format teks, tabel, numbering, dan bullet dari Microsoft Word.</p>
        </div>
    </div>
    <div class="mt-5 space-y-5">
        <div><x-input-label for="opening" value="Salam pembuka" class="form-label" /><textarea id="opening" name="opening" rows="2" class="form-input mt-2 block w-full">{{ old('opening', $outgoingLetter->opening ?? 'Dengan hormat,') }}</textarea><x-input-error :messages="$errors->get('opening')" class="mt-2" /></div>
        <div><x-input-label for="body_editor" value="Isi surat" class="form-label" />
            <div class="mt-2 flex flex-wrap gap-1 rounded-t-md border border-b-0 border-slate-200 bg-slate-50 p-2"><button type="button" class="table-action" data-editor-command="bold" title="Tebal"><strong>B</strong></button><button type="button" class="table-action" data-editor-command="italic" title="Miring"><em>I</em></button><button type="button" class="table-action" data-editor-command="underline" title="Garis bawah"><u>U</u></button><button type="button" class="table-action" data-editor-command="insertUnorderedList" title="Bullet">•</button><button type="button" class="table-action" data-editor-command="insertOrderedList" title="Penomoran">1.</button><button type="button" class="table-action" data-editor-command="justifyLeft" title="Rata kiri">≡</button><button type="button" class="table-action" data-editor-command="justifyCenter" title="Rata tengah">≡</button><button type="button" class="table-action" data-editor-command="justifyRight" title="Rata kanan">≡</button></div>
            <div id="body_editor" contenteditable="true" class="form-input min-h-48 rounded-t-none p-3" data-editor-target="body">{!! old('body', $outgoingLetter->body ?? '') !!}</div><textarea id="body" name="body" class="hidden" required></textarea><x-input-error :messages="$errors->get('body')" class="mt-2" />
        </div>
        <div><x-input-label for="closing" value="Salam penutup" class="form-label" /><textarea id="closing" name="closing" rows="3" class="form-input mt-2 block w-full">{{ old('closing', $outgoingLetter->closing ?? 'Demikian surat ini kami sampaikan. Atas perhatian dan kerja samanya kami ucapkan terima kasih.') }}</textarea><x-input-error :messages="$errors->get('closing')" class="mt-2" /></div>
    </div>
</div>
<div class="form-section">
    <div class="form-section-heading"><span>04</span>
        <div>
            <h4>Penandatangan dan kop</h4>
            <p>Data penandatangan dapat mengikuti identitas kepala sekolah.</p>
        </div>
    </div>
    <div class="mt-5 grid gap-5 md:grid-cols-2">
        <div><x-input-label for="signer_name" value="Nama penandatangan" class="form-label" /><x-text-input id="signer_name" name="signer_name" value="{{ old('signer_name', $outgoingLetter->signer_name ?? ($school?->principal_name ?? '')) }}" class="form-input mt-2 block w-full" required /><x-input-error :messages="$errors->get('signer_name')" class="mt-2" /></div>
        <div><x-input-label for="signer_nip" value="NIP/NUPTK" class="form-label" /><x-text-input id="signer_nip" name="signer_nip" value="{{ old('signer_nip', $outgoingLetter->signer_nip ?? ($school?->principal_nip ?? '')) }}" class="form-input mt-2 block w-full" /><x-input-error :messages="$errors->get('signer_nip')" class="mt-2" /></div>
        <div><x-input-label for="signer_position" value="Jabatan penandatangan" class="form-label" /><x-text-input id="signer_position" name="signer_position" value="{{ old('signer_position', $outgoingLetter->signer_position ?? 'Kepala Sekolah') }}" class="form-input mt-2 block w-full" required /><x-input-error :messages="$errors->get('signer_position')" class="mt-2" /></div>
        <div class="flex items-center gap-3 pt-6"><input id="use_letterhead" type="checkbox" name="use_letterhead" value="1" @checked(old('use_letterhead', $outgoingLetter->use_letterhead ?? true)) class="rounded border-slate-300 text-teal-600 focus:ring-teal-500"><x-input-label for="use_letterhead" value="Gunakan kop surat" class="form-label" /></div>
    </div>
</div>
<div class="mt-7 flex flex-col-reverse justify-end gap-3 border-t border-slate-100 pt-5 sm:flex-row"><a href="{{ route('outgoing-letters.index') }}" class="button-secondary text-center">Batal</a><x-primary-button class="button-primary justify-center">{{ $submitLabel }} <span class="ms-2">→</span></x-primary-button></div>
<script>
    document.querySelectorAll('[data-editor-command]').forEach((button) => button.addEventListener('click', () => {
        document.execCommand(button.dataset.editorCommand, false);
        document.querySelector('#body').value = document.querySelector('#body_editor').innerHTML;
        document.querySelector('#body_editor').focus();
    }));
    document.querySelector('#body_editor').closest('form').addEventListener('submit', () => {
        document.querySelector('#body').value = document.querySelector('#body_editor').innerHTML;
    });
</script>