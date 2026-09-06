<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="eyebrow">Pusat arsip</p>
                <h2 class="mt-1 text-2xl font-semibold text-slate-900">Surat keluar</h2>
                <p class="mt-1 text-sm text-slate-500">Kelola, buat, dan tindak lanjuti seluruh surat yang diterbitkan.</p>
            </div>
            <div class="flex flex-wrap gap-2">@can('export data')<a href="{{ route('outgoing-letters.export') }}" class="button-secondary"><span>↓</span> Export Excel</a>@endcan @can('create outgoing_letter')<a href="{{ route('outgoing-letters.create') }}" class="button-primary"><span>＋</span> Tambah surat</a>@endcan</div>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-4 sm:px-6 lg:px-8">@if(session('status'))<div class="rounded-md bg-green-50 p-4 text-sm text-green-700">{{ session('status') }}</div>@endif<form method="GET" class="flex flex-col gap-3 rounded-lg bg-white p-4 shadow-sm sm:flex-row"><input name="search" value="{{ request('search') }}" placeholder="Cari nomor, penerima, atau perihal" class="flex-1 rounded-md border-gray-300 text-sm"><select name="status" class="rounded-md border-gray-300 text-sm">
                    <option value="">Semua status</option>@foreach(['draft','approval','terkirim'] as $status)<option value="{{ $status }}" @selected(request('status')===$status)>{{ ucfirst($status) }}</option>@endforeach
                </select><button class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white">Cari</button></form>
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-6 py-3">Nomor</th>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Penerima</th>
                                <th class="px-6 py-3">Perihal</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">@forelse($letters as $letter)<tr>
                                <td class="px-6 py-4 font-medium">{{ $letter->letter_number }}</td>
                                <td class="px-6 py-4">{{ $letter->date_letter?->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">{{ $letter->recipient }}</td>
                                <td class="px-6 py-4">{{ $letter->subject }}</td>
                                <td class="px-6 py-4">{{ ucfirst($letter->status) }}</td>
                                <td class="px-6 py-4 text-right"><a class="text-indigo-600" href="{{ route('outgoing-letters.show', $letter) }}">Lihat</a></td>
                            </tr>@empty<tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">Belum ada surat keluar.</td>
                            </tr>@endforelse</tbody>
                    </table>
                </div>
                <div class="p-4">{{ $letters->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>