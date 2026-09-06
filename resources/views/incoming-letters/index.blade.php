<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="eyebrow">Pusat arsip</p>
                <h2 class="mt-1 text-2xl font-semibold text-slate-900">Surat masuk</h2>
                <p class="mt-1 text-sm text-slate-500">Kelola, cari, dan tindak lanjuti seluruh surat yang diterima.</p>
            </div>
            <div class="flex flex-wrap gap-2">@can('export data')<a href="{{ route('incoming-letters.export') }}" class="button-secondary"><span>↓</span> Export Excel</a>@endcan @can('create incoming_letter')<a href="{{ route('incoming-letters.create') }}" class="button-primary"><span>＋</span> Tambah surat</a>@endcan</div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-4 sm:px-6 lg:px-8">
            @if (session('status'))
            <div class="rounded-md bg-green-50 p-4 text-sm text-green-700">{{ session('status') }}</div>
            @endif
            <form method="GET" class="filter-card">
                <div class="filter-search"><span>⌕</span><input name="search" value="{{ request('search') }}" placeholder="Cari nomor, pengirim, atau perihal"></div><select name="status" class="form-input sm:w-48">
                    <option value="">Semua status</option>
                    @foreach (['baru', 'didisposisikan', 'selesai'] as $status)
                    <option value="{{ $status }}" @selected(request('status')===$status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select><button class="button-primary justify-center">Terapkan filter</button>@if(request()->hasAny(['search', 'status']))<a href="{{ route('incoming-letters.index') }}" class="button-secondary justify-center">Reset</a>@endif
            </form>
            <div class="table-shell">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="table-head">
                            <tr>
                                <th>Surat</th>
                                <th>Tanggal diterima</th>
                                <th>Pengirim</th>
                                <th>Tujuan</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($letters as $letter)
                            <tr class="table-row">
                                <td><a href="{{ route('incoming-letters.show', $letter) }}" class="font-semibold text-slate-900 hover:text-teal-700">{{ $letter->mail_number ?: 'Nomor belum diisi' }}</a><span class="mt-1 block max-w-xs truncate text-xs text-slate-500">{{ $letter->subject }}</span></td>
                                <td class="whitespace-nowrap text-slate-600">{{ $letter->date_received?->format('d M Y') ?: '-' }}</td>
                                <td><span class="block max-w-[12rem] truncate font-medium text-slate-700">{{ $letter->sender ?: '-' }}</span></td>
                                <td class="text-slate-600">{{ $letter->unit?->name ?: '-' }}</td>
                                <td><span class="status-pill status-{{ $letter->status }}">{{ ucfirst($letter->status) }}</span></td>
                                <td>
                                    <div class="flex justify-end gap-2"><a class="table-action" href="{{ route('incoming-letters.show', $letter) }}" title="Lihat detail">↗</a>@can('update incoming_letter')<a class="table-action" href="{{ route('incoming-letters.edit', $letter) }}" title="Edit surat">✎</a>@endcan @can('delete incoming_letter')<form method="POST" action="{{ route('incoming-letters.destroy', $letter) }}" onsubmit="return confirm('Hapus surat ini?')">@csrf @method('DELETE')<button class="table-action table-action-danger" title="Hapus surat">×</button></form>@endcan</div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">Belum ada surat masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pagination-bar">
                    <p>Menampilkan <strong>{{ $letters->firstItem() ?: 0 }}</strong>–<strong>{{ $letters->lastItem() ?: 0 }}</strong> dari <strong>{{ $letters->total() }}</strong> surat</p>
                    <div>{{ $letters->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>