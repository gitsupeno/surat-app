<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="eyebrow">Data master</p>
            <h2 class="mt-1 text-2xl font-semibold text-slate-900">Jenis surat</h2>
            <p class="mt-1 text-sm text-slate-500">Kelola pilihan jenis surat untuk modul surat keluar.</p>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-4xl space-y-4 sm:px-6 lg:px-8">@if(session('status'))<div class="rounded-md bg-green-50 p-4 text-sm text-green-700">{{ session('status') }}</div>@endif<div class="soft-panel p-6">
                <h3 class="font-semibold text-slate-900">Tambah jenis surat</h3>
                <form method="POST" action="{{ route('jenis-surat.store') }}" class="mt-4 grid gap-3 sm:grid-cols-[1fr_2fr_auto]">@csrf<input name="code" placeholder="Kode, contoh UND" class="form-input" required><input name="name" placeholder="Nama jenis surat" class="form-input" required><button class="button-primary">Tambah</button></form>
            </div>
            <div class="table-shell">
                <table class="min-w-full">
                    <thead class="table-head">
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>@foreach($jenisSurat as $jenis)<tr class="table-row">
                            <td>{{ $jenis->code ?: '-' }}</td>
                            <td>{{ $jenis->name }}</td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <form method="POST" action="{{ route('jenis-surat.update', $jenis) }}" class="flex gap-2">@csrf @method('PUT')<input name="code" value="{{ $jenis->code }}" class="form-input w-24"><input name="name" value="{{ $jenis->name }}" class="form-input"><button class="table-action" title="Simpan perubahan">✓</button></form>
                                    <form method="POST" action="{{ route('jenis-surat.destroy', $jenis) }}" onsubmit="return confirm('Hapus jenis surat ini?')">@csrf @method('DELETE')<button class="table-action table-action-danger" title="Hapus">×</button></form>
                                </div>
                            </td>
                        </tr>@endforeach</tbody>
                </table>
                <div class="pagination-bar">{{ $jenisSurat->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>