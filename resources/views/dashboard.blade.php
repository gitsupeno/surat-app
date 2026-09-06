<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="eyebrow">{{ $schoolSetting?->school_name ?: 'Ringkasan operasional' }}</p>
            <h2 class="mt-1 text-2xl font-semibold text-slate-900">Dashboard</h2>
            <p class="mt-1 text-sm text-slate-500">Pantau arus surat dan pekerjaan yang masih berjalan.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                <div class="stat-card stat-card-blue">
                    <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M4 6.5A2.5 2.5 0 0 1 6.5 4H20v15H6.5A2.5 2.5 0 0 1 4 16.5v-10Z" />
                            <path d="M4 7h13M8 11h8M8 14h5" />
                        </svg></div>
                    <p class="stat-label">Surat masuk</p>
                    <p class="stat-value">{{ $incomingTotal }}</p><span class="stat-caption">Total diterima</span>
                </div>
                <div class="stat-card stat-card-amber">
                    <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="12" r="8.5" />
                            <path d="M12 7v5l3 2" />
                        </svg></div>
                    <p class="stat-label">Belum selesai</p>
                    <p class="stat-value">{{ $incomingPending }}</p><span class="stat-caption">Perlu perhatian</span>
                </div>
                <div class="stat-card stat-card-emerald">
                    <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M20 7 10 17l-5-5" />
                            <path d="M20 12v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h9" />
                        </svg></div>
                    <p class="stat-label">Surat keluar</p>
                    <p class="stat-value">{{ $outgoingTotal }}</p><span class="stat-caption">Total dibuat</span>
                </div>
                <div class="stat-card stat-card-rose">
                    <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M12 3 4.5 6v5.5c0 4.4 3.1 7.8 7.5 9.5 4.4-1.7 7.5-5.1 7.5-9.5V6L12 3Z" />
                            <path d="M12 8v4M12 15h.01" />
                        </svg></div>
                    <p class="stat-label">Menunggu approval</p>
                    <p class="stat-value">{{ $outgoingApproval }}</p><span class="stat-caption">Perlu ditinjau</span>
                </div>
                <div class="stat-card stat-card-violet">
                    <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M5 5h14v10H5zM8 19h8M12 15v4" />
                            <path d="M8 9h8M8 12h5" />
                        </svg></div>
                    <p class="stat-label">Disposisi aktif</p>
                    <p class="stat-value">{{ $dispositionPending }}</p><span class="stat-caption">Sedang berjalan</span>
                </div>
            </div>
            <div class="grid gap-6 lg:grid-cols-2">
                <div class="soft-panel p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="eyebrow">Traffic</p>
                            <h3 class="mt-1 font-semibold text-slate-900">Aktivitas bulan ini</h3>
                        </div><span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">{{ now()->translatedFormat('F Y') }}</span>
                    </div>
                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div class="rounded-lg border border-blue-100 bg-blue-50/60 p-4">
                            <p class="text-sm text-slate-500">Surat masuk</p>
                            <p class="mt-2 font-mono text-3xl font-semibold text-blue-700">{{ $monthlyIncoming }}</p>
                        </div>
                        <div class="rounded-lg border border-teal-100 bg-teal-50/60 p-4">
                            <p class="text-sm text-slate-500">Surat keluar</p>
                            <p class="mt-2 font-mono text-3xl font-semibold text-teal-700">{{ $monthlyOutgoing }}</p>
                        </div>
                    </div>
                </div>
                <div class="soft-panel p-6">
                    <p class="eyebrow">Mulai bekerja</p>
                    <h3 class="mt-1 font-semibold text-slate-900">Akses cepat</h3>
                    <div class="mt-6 grid gap-3 sm:grid-cols-2"><a href="{{ route('incoming-letters.index') }}" class="group rounded-lg border border-slate-200 p-4 transition hover:-translate-y-0.5 hover:border-teal-300 hover:bg-teal-50"><span class="text-xs font-bold text-teal-600">01</span><span class="mt-2 block font-semibold text-slate-800">Surat Masuk</span><span class="mt-1 block text-xs text-slate-500">Kelola dan disposisikan</span></a><a href="{{ route('outgoing-letters.index') }}" class="group rounded-lg border border-slate-200 p-4 transition hover:-translate-y-0.5 hover:border-teal-300 hover:bg-teal-50"><span class="text-xs font-bold text-teal-600">02</span><span class="mt-2 block font-semibold text-slate-800">Surat Keluar</span><span class="mt-1 block text-xs text-slate-500">Draft dan approval</span></a></div>
                </div>
            </div>
            <div class="grid gap-6 lg:grid-cols-2">
                <div class="soft-panel p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-slate-900">Surat masuk terbaru</h3><a href="{{ route('incoming-letters.index') }}" class="text-xs font-bold text-teal-700">Lihat semua</a>
                    </div>
                    <div class="mt-4 divide-y divide-slate-100">@forelse($recentIncoming as $letter)<a href="{{ route('incoming-letters.show', $letter) }}" class="block py-3 transition hover:ps-1">
                            <p class="font-medium text-slate-800">{{ $letter->subject }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $letter->sender ?: 'Pengirim tidak diisi' }} <span class="mx-1 text-slate-300">/</span> {{ $letter->status }}</p>
                        </a>@empty<p class="py-3 text-sm text-slate-500">Belum ada data.</p>@endforelse</div>
                </div>
                <div class="soft-panel p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-slate-900">Surat keluar terbaru</h3><a href="{{ route('outgoing-letters.index') }}" class="text-xs font-bold text-teal-700">Lihat semua</a>
                    </div>
                    <div class="mt-4 divide-y divide-slate-100">@forelse($recentOutgoing as $letter)<a href="{{ route('outgoing-letters.show', $letter) }}" class="block py-3 transition hover:ps-1">
                            <p class="font-medium text-slate-800">{{ $letter->subject }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $letter->letter_number }} <span class="mx-1 text-slate-300">/</span> {{ $letter->status }}</p>
                        </a>@empty<p class="py-3 text-sm text-slate-500">Belum ada data.</p>@endforelse</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>