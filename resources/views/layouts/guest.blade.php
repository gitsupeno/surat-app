<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ArsipKu') }} · Masuk</title>

    <link rel="preconnect" href="https://fonts.bunny.net">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="auth-shell flex min-h-screen items-center justify-center p-4 sm:p-8">
        <div class="auth-frame grid w-full max-w-5xl overflow-hidden lg:min-h-0 lg:grid-cols-[.95fr_1.05fr]">
            <main class="auth-form-area flex items-center justify-center px-6 py-10 sm:px-12 lg:px-14">
                <div class="w-full max-w-md">
                    <div class="mb-10">
                        <a href="/" class="inline-flex items-center gap-3">
                            <span class="brand-mark">A</span>
                            <span><span class="block font-semibold leading-none text-slate-900">ArsipKu</span><span class="mt-1 block text-[10px] font-semibold uppercase tracking-[.16em] text-slate-400">Sistem Persuratan</span></span>
                        </a>
                    </div>
                    {{ $slot }}
                    <p class="mt-10 text-xs text-slate-400">© {{ now()->year }} ArsipKu · Internal workspace</p>
                </div>
            </main>

            <section class="auth-intro relative hidden overflow-hidden p-8 text-white lg:flex lg:flex-col lg:justify-between xl:p-10">
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-[.2em] text-teal-100">Ruang kerja digital</p>
                        <span class="auth-status"><span></span> Sistem aktif</span>
                    </div>
                </div>
                <div class="auth-visual relative z-10">
                    <div class="auth-document auth-document-back"></div>
                    <div class="auth-document auth-document-front p-5">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                            <span class="h-2 w-20 rounded-full bg-teal-600"></span>
                            <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400">ArsipKu / 2026</span>
                        </div>
                        <div class="mt-6 grid grid-cols-[1.2fr_.8fr] gap-4">
                            <div><span class="block h-2 w-28 rounded-full bg-slate-800"></span><span class="mt-3 block h-2 w-36 rounded-full bg-slate-200"></span><span class="mt-2 block h-2 w-24 rounded-full bg-slate-200"></span></div>
                            <div class="rounded-lg bg-teal-50 p-3"><span class="block text-[9px] font-bold uppercase text-teal-700">Status</span><span class="mt-2 block text-lg font-bold text-teal-800">Aktif</span></div>
                        </div>
                        <div class="mt-8 space-y-2"><span class="block h-2 w-full rounded-full bg-slate-100"></span><span class="block h-2 w-5/6 rounded-full bg-slate-100"></span><span class="block h-2 w-3/4 rounded-full bg-slate-100"></span></div>
                    </div>
                    <div class="auth-float-card auth-float-card-top"><span class="auth-float-dot bg-amber-400"></span><span><strong>12</strong> surat menunggu</span></div>
                    <div class="auth-float-card auth-float-card-bottom"><span class="auth-float-dot bg-emerald-400"></span><span>Data tersimpan aman</span></div>
                </div>
                <div class="relative z-10">
                    <p class="text-3xl font-semibold leading-tight tracking-tight">Surat tertata,<br><span class="text-teal-300">kerja lebih bermakna.</span></p>
                    <p class="mt-4 max-w-sm text-sm leading-6 text-slate-300">Kelola surat masuk, disposisi, dan surat keluar dalam satu alur kerja yang mudah ditelusuri.</p>
                </div>
            </section>
        </div>
    </div>
</body>

</html>