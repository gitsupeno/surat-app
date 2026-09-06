<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="eyebrow">Pusat arsip</p>
                <h2 class="mt-1 text-2xl font-semibold text-slate-900">Detail surat keluar</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $outgoingLetter->letter_number }}</p>
            </div><a href="{{ route('outgoing-letters.index') }}" class="button-secondary">← Kembali</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-5xl space-y-4 sm:px-6 lg:px-8">@if(session('status'))<div class="rounded-md bg-green-50 p-4 text-sm text-green-700">{{ session('status') }}</div>@endif @if($outgoingLetter->rejection_reason)<div class="rounded-md bg-red-50 p-4 text-sm text-red-700"><strong>Alasan penolakan:</strong> {{ $outgoingLetter->rejection_reason }}</div>@endif
            <div class="soft-panel p-6">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div><span class="status-pill status-{{ $outgoingLetter->status }}">{{ str_replace('_', ' ', ucfirst($outgoingLetter->status)) }}</span>
                        <h3 class="mt-3 text-xl font-semibold text-slate-900">{{ $outgoingLetter->subject }}</h3>
                        <p class="mt-1 text-sm text-slate-500">{{ $outgoingLetter->recipient }} · {{ $outgoingLetter->date_letter?->format('d/m/Y') }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">@can('print outgoing_letter')<a href="{{ route('outgoing-letters.preview', $outgoingLetter) }}" class="button-secondary">Preview</a><a href="{{ route('outgoing-letters.pdf', $outgoingLetter) }}" class="button-primary">Download PDF</a>@endcan @can('create outgoing_letter')<form method="POST" action="{{ route('outgoing-letters.duplicate', $outgoingLetter) }}">@csrf<button class="button-secondary">Duplikat</button></form>@endcan @can('update outgoing_letter')@if(in_array($outgoingLetter->status, ['draft','ditolak']))<a href="{{ route('outgoing-letters.edit', $outgoingLetter) }}" class="button-secondary">Edit</a>@endif @endcan</div>
                </div>
                <dl class="mt-6 grid gap-5 border-t border-slate-100 pt-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm text-gray-500">Nomor surat</dt>
                        <dd class="mt-1 font-medium">{{ $outgoingLetter->letter_number }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Jenis surat</dt>
                        <dd class="mt-1 font-medium">{{ $outgoingLetter->jenisSurat?->name ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Sifat</dt>
                        <dd class="mt-1 font-medium">{{ ucfirst($outgoingLetter->sifat) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Lampiran</dt>
                        <dd class="mt-1 font-medium">{{ $outgoingLetter->lampiran ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Jabatan penerima</dt>
                        <dd class="mt-1 font-medium">{{ $outgoingLetter->recipient_position ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Email tujuan</dt>
                        <dd class="mt-1 font-medium">{{ $outgoingLetter->recipient_email ?: '-' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm text-gray-500">Alamat tujuan</dt>
                        <dd class="mt-1 whitespace-pre-line">{{ $outgoingLetter->recipient_address ?: '-' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm text-gray-500">Isi surat</dt>
                        <dd class="mt-1 whitespace-pre-line">{{ $outgoingLetter->body }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Penandatangan</dt>
                        <dd class="mt-1 font-medium">{{ $outgoingLetter->signer_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">NIP/NUPTK</dt>
                        <dd class="mt-1 font-medium">{{ $outgoingLetter->signer_nip ?: '-' }}</dd>
                    </div>
                </dl>
            </div>
            <div class="soft-panel flex flex-wrap gap-2 p-6">@can('verify outgoing_letter')@if($outgoingLetter->status === 'menunggu_verifikasi')<form method="POST" action="{{ route('outgoing-letters.verify', $outgoingLetter) }}">@csrf @method('PATCH')<button class="button-primary">Setujui / Verifikasi</button></form>
                <form method="POST" action="{{ route('outgoing-letters.reject', $outgoingLetter) }}" class="flex gap-2"><input name="rejection_reason" required placeholder="Alasan penolakan" class="form-input"><button class="button-secondary">Tolak</button></form>@endif @endcan @can('send outgoing_letter')@if($outgoingLetter->status === 'disetujui')<form method="POST" action="{{ route('outgoing-letters.send', $outgoingLetter) }}">@csrf @method('PATCH')<button class="button-primary">Tandai sudah dikirim</button></form>@endif @endcan @can('archive outgoing_letter')@if($outgoingLetter->status === 'sudah_dikirim')<form method="POST" action="{{ route('outgoing-letters.archive', $outgoingLetter) }}">@csrf @method('PATCH')<button class="button-secondary">Arsipkan</button></form>@endif @endcan
            </div>
            <div class="soft-panel p-6">
                <h3 class="font-semibold text-slate-900">Riwayat perubahan</h3>
                <div class="mt-4 space-y-3">@forelse($outgoingLetter->auditLogs as $log)<div class="border-l-2 border-teal-200 pl-3 text-sm"><strong>{{ ucfirst($log->action) }}</strong><span class="text-slate-500"> oleh {{ $log->user?->name ?: 'Sistem' }} · {{ $log->created_at->format('d/m/Y H:i') }}</span></div>@empty<p class="text-sm text-slate-500">Belum ada riwayat.</p>@endforelse</div>
            </div>
        </div>
    </div>
</x-app-layout>