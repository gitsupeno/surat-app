<nav x-data="{ open: false }" class="app-sidebar">
    <div :class="{ 'sidebar-panel-open': open }" class="flex h-full flex-col">
        <div class="flex h-20 items-center border-b border-slate-700/60 px-6">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                @if($schoolSetting?->school_logo_path)
                <img src="{{ Storage::disk('public')->url($schoolSetting->school_logo_path) }}" alt="Logo {{ $schoolSetting->school_name ?: 'sekolah' }}" class="school-logo-mark">
                @else
                <span class="brand-mark bg-teal-500 text-white shadow-none">A</span>
                @endif
                <span><span class="block max-w-40 truncate font-semibold leading-none text-white">ArsipKu</span><span class="mt-1 block text-[10px] font-semibold uppercase tracking-[.18em] text-slate-400">Persuratan</span></span>
            </a>
            <button @click="open = false" class="ms-auto text-slate-400 lg:hidden" aria-label="Tutup menu"><span class="text-2xl">&times;</span></button>
        </div>

        <div class="flex-1 px-4 py-7">
            <p class="sidebar-label">Menu utama</p>
            <div class="mt-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link-active' : '' }}"><span class="sidebar-icon">⌂</span><span>Dashboard</span></a>
                @can('read incoming_letter')
                <a href="{{ route('incoming-letters.index') }}" class="sidebar-link {{ request()->routeIs('incoming-letters.*', 'dispositions.*') ? 'sidebar-link-active' : '' }}"><span class="sidebar-icon">↙</span><span>Surat Masuk</span></a>
                @endcan
                @can('read outgoing_letter')
                <a href="{{ route('outgoing-letters.index') }}" class="sidebar-link {{ request()->routeIs('outgoing-letters.*') ? 'sidebar-link-active' : '' }}"><span class="sidebar-icon">↗</span><span>Surat Keluar</span></a>
                @endcan
            </div>

            <p class="sidebar-label mt-9">Akun</p>
            <div class="mt-3 space-y-1">
                @can('manage master')
                <a href="{{ route('jenis-surat.index') }}" class="sidebar-link {{ request()->routeIs('jenis-surat.*') ? 'sidebar-link-active' : '' }}"><span class="sidebar-icon">▤</span><span>Jenis surat</span></a>
                <a href="{{ route('outgoing-letter-templates.index') }}" class="sidebar-link {{ request()->routeIs('outgoing-letter-templates.*') ? 'sidebar-link-active' : '' }}"><span class="sidebar-icon">▧</span><span>Template surat</span></a>
                <a href="{{ route('outgoing-letter-number-settings.edit') }}" class="sidebar-link {{ request()->routeIs('outgoing-letter-number-settings.*') ? 'sidebar-link-active' : '' }}"><span class="sidebar-icon">#</span><span>Penomoran surat</span></a>
                @endcan
                @can('manage school settings')
                <a href="{{ route('school-settings.edit') }}" class="sidebar-link {{ request()->routeIs('school-settings.*') ? 'sidebar-link-active' : '' }}"><span class="sidebar-icon">⚙</span><span>Pengaturan sekolah</span></a>
                @endcan
                <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'sidebar-link-active' : '' }}"><span class="sidebar-icon">○</span><span>Profil saya</span></a>
            </div>
        </div>

    </div>

    <button @click="open = true" class="sidebar-mobile-trigger" aria-label="Buka menu"><span class="text-xl">☰</span></button>
    <div x-show="open" x-transition.opacity @click="open = false" class="sidebar-overlay" style="display: none"></div>
</nav>