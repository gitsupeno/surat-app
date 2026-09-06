<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Detail Surat Masuk</h2><a href="{{ route('incoming-letters.index') }}" class="text-sm text-indigo-600">Kembali</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-4xl space-y-4 sm:px-6 lg:px-8">@if(session('status'))<div class="rounded-md bg-green-50 p-4 text-sm text-green-700">{{ session('status') }}</div>@endif<div class="rounded-lg bg-white p-6 shadow-sm">
                <dl class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm text-gray-500">Nomor surat</dt>
                        <dd class="mt-1 font-medium">{{ $incomingLetter->mail_number ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Tanggal diterima</dt>
                        <dd class="mt-1 font-medium">{{ $incomingLetter->date_received?->format('d/m/Y') ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Pengirim</dt>
                        <dd class="mt-1 font-medium">{{ $incomingLetter->sender ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Status</dt>
                        <dd class="mt-1 font-medium">{{ ucfirst($incomingLetter->status) }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm text-gray-500">Perihal</dt>
                        <dd class="mt-1 font-medium">{{ $incomingLetter->subject }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Sifat</dt>
                        <dd class="mt-1 font-medium">{{ $incomingLetter->sifat?->name ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Klasifikasi</dt>
                        <dd class="mt-1 font-medium">{{ $incomingLetter->classification?->name ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Unit</dt>
                        <dd class="mt-1 font-medium">{{ $incomingLetter->unit?->name ?: '-' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm text-gray-500">Catatan</dt>
                        <dd class="mt-1 whitespace-pre-line">{{ $incomingLetter->notes ?: '-' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm text-gray-500">Dokumen surat</dt>
                        <dd class="mt-1">@if($incomingLetter->document_path)<a href="{{ asset('storage/' . $incomingLetter->document_path) }}" target="_blank" rel="noopener" class="font-semibold text-indigo-600 hover:underline">Lihat dokumen</a>@else<span>-</span>@endif</dd>
                    </div>
                </dl>
            </div>
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">Riwayat Disposisi</h3>@can('disposition.create')<a href="{{ route('dispositions.create', $incomingLetter) }}" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white">Buat Disposisi</a>@endcan
                </div>@forelse($incomingLetter->dispositions as $disposition)<div class="mt-4 rounded-md border p-4">
                    <div class="flex justify-between">
                        <p class="font-medium">{{ $disposition->assignee->name }}</p><a class="text-sm text-indigo-600" href="{{ route('dispositions.show', $disposition) }}">Detail</a>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">{{ $disposition->instruction }}</p>
                    <p class="mt-2 text-xs text-gray-500">Status: {{ ucfirst($disposition->status) }}</p>
                </div>@empty<p class="mt-4 text-sm text-gray-500">Belum ada disposisi.</p>@endforelse
            </div>
        </div>
    </div>
</x-app-layout>