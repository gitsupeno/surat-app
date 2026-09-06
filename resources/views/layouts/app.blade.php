<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ArsipKu') }} · Sistem Persuratan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="app-shell h-screen overflow-hidden lg:flex">
        @include('layouts.navigation')

        <div class="flex min-h-0 min-w-0 flex-1 flex-col lg:ms-64">
            @isset($header)
            <header class="page-heading sticky top-0 z-30 flex-none">
                <div class="page-heading-inner mx-auto flex max-w-7xl items-center justify-between gap-6 px-4 py-4 sm:px-6 lg:px-8">
                    <div class="min-w-0 flex-1">{{ $header }}</div>
                    <div class="header-user shrink-0">
                        <span class="header-user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        <span class="hidden min-w-0 sm:block"><span class="block max-w-40 truncate text-sm font-semibold">{{ Auth::user()->name }}</span><span class="block max-w-40 truncate text-xs">{{ Auth::user()->email }}</span></span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="header-logout" title="Keluar dari aplikasi" aria-label="Keluar dari aplikasi">↪</button>
                        </form>
                    </div>
                </div>
            </header>
            @endisset
            <main class="min-h-0 flex-1 overflow-y-auto">{{ $slot }}</main>
        </div>
    </div>
</body>

</html>