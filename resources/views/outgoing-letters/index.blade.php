<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="eyebrow">Pusat arsip</p>
                <h2 class="mt-1 text-2xl font-semibold text-slate-900">Surat keluar</h2>
                <p class="mt-1 text-sm text-slate-500">Kelola, verifikasi, cetak, kirim, dan arsipkan surat resmi sekolah.</p>
            </div>
            <div class="flex flex-wrap gap-2">@can('export data')<a href="{{ route('outgoing-letters.export') }}" class="button-secondary">↓ Export</a>@endcan @can('create outgoing_letter')<a href="{{ route('outgoing-letters.create') }}" class="button-primary">＋ Tambah surat</a>@endcan</div>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-4 sm:px-6 lg:px-8">@if(session('status'))<div class="rounded-md bg-green-50 p-4 text-sm text-green-700">{{ session('status') }}</div>@endif
            <form method="GET" class="filter-card">
                <div class="filter-search"><span>⌕</span><input name="search" value="{{ request('search') }}" placeholder="Cari nomor, tujuan, atau perihal"></div><select name="year" class="form-input sm:w-32">
                    <option value="">Semua tahun</option>@foreach($years as $year)<option value="{{ $year }}" @selected(request('year')==$year)>{{ $year }}</option>@endforeach
                </select><select name="jenis_surat_id" class="form-input sm:w-48">
                    <option value="">Semua jenis</option>@foreach($jenisSurat as $jenis)<option value="{{ $jenis->id }}" @selected(request('jenis_surat_id')==$jenis->id)>{{ $jenis->name }}</option>@endforeach
                </select><select name="status" class="form-input sm:w-48">
                    <option value="">Semua status</option>@foreach($statuses as $value => $label)<option value="{{ $value }}" @selected(request('status')===$value)>{{ $label }}</option>@endforeach
                </select><button class="button-primary justify-center">Terapkan</button>@if(request()->hasAny(['search','year','jenis_surat_id','status']))<a href="{{ route('outgoing-letters.index') }}" class="button-secondary justify-center">Reset</a>@endif
            </form>
            <div class="table-shell">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="table-head">
                            <tr>
                                <th>No</th>
                                <th>Nomor surat</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Tujuan</th>
                                <th>Perihal</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>@forelse($letters as $letter)<tr class="table-row">
                                <td>{{ $letters->firstItem() + $loop->index }}</td>
                                <td><a href="{{ route('outgoing-letters.show', $letter) }}" class="font-semibold text-slate-900 hover:text-teal-700">{{ $letter->letter_number ?: 'Nomor belum dibuat' }}</a></td>
                                <td>{{ $letter->date_letter?->format('d/m/Y') ?: '-' }}</td>
                                <td>{{ $letter->jenisSurat?->name ?: '-' }}</td>
                                <td>{{ $letter->recipient }}</td>
                                <td class="max-w-xs truncate">{{ $letter->subject }}</td>
                                <td><span class="status-pill status-{{ $letter->status }}">{{ $statuses[$letter->status] ?? ucfirst($letter->status) }}</span></td>
                                <td>
                                    <div class="flex justify-end gap-2"><a class="table-action" href="{{ route('outgoing-letters.show', $letter) }}" title="Lihat detail">↗</a>@can('print outgoing_letter')<a class="table-action" href="{{ route('outgoing-letters.preview', $letter) }}" title="Preview surat">⌕</a>@endcan @can('delete outgoing_letter')@if(in_array($letter->status, ['draft','ditolak']))<form method="POST" action="{{ route('outgoing-letters.destroy', $letter) }}" onsubmit="return confirm('Hapus surat ini?')">@csrf @method('DELETE')<button class="table-action table-action-danger" title="Hapus surat">×</button></form>@endif @endcan</div>
                                </td>
                            </tr>@empty<tr>
                                <td colspan="8" class="px-6 py-10 text-center text-gray-500">Belum ada surat keluar.</td>
                            </tr>@endforelse</tbody>
                    </table>
                </div>
                <div class="pagination-bar">{{ $letters->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>