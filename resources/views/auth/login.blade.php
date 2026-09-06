<x-guest-layout>
    <div class="mb-8">
        <p class="eyebrow">Selamat datang kembali</p>
        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">Masuk ke ruang kerja</h2>
        <p class="mt-3 text-sm leading-6 text-slate-500">Lanjutkan pekerjaan administrasi persuratan Anda.</p>
    </div>

    <x-auth-session-status class="mb-5 rounded-lg border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="space-y-2">
            <x-input-label for="email" value="Alamat email" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="email" class="block w-full rounded-lg border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-teal-600 focus:ring-teal-600" type="email" name="email" :value="old('email')" placeholder="nama@instansi.go.id" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="pt-1 text-xs" />
        </div>

        <div class="mt-5 space-y-2">
            <div class="flex items-center justify-between">
                <x-input-label for="password" value="Kata sandi" class="text-sm font-semibold text-slate-700" />
                @if (Route::has('password.request'))
                <a class="text-xs font-semibold text-teal-700 transition hover:text-teal-900" href="{{ route('password.request') }}">Lupa kata sandi?</a>
                @endif
            </div>
            <x-text-input id="password" class="block w-full rounded-lg border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-teal-600 focus:ring-teal-600" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="pt-1 text-xs" />
        </div>

        <div class="mt-5 flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-500">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-teal-700 shadow-sm focus:ring-teal-600" name="remember">
                <span>Ingat saya</span>
            </label>
            <x-primary-button class="rounded-lg bg-teal-700 px-5 py-3 text-sm font-semibold normal-case tracking-normal shadow-lg shadow-teal-700/20 transition hover:bg-teal-800 focus:bg-teal-800 focus:ring-teal-600">
                Masuk ke aplikasi <span class="ms-2 text-base">→</span>
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>