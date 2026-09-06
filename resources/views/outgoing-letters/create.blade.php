<x-app-layout><x-slot name="header">
        <div>
            <p class="eyebrow">Pusat arsip</p>
            <h2 class="mt-1 text-2xl font-semibold text-slate-900">Tambah surat keluar</h2>
            <p class="mt-1 text-sm text-slate-500">Buat surat keluar dan siapkan untuk proses approval.</p>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('outgoing-letters.store') }}" class="rounded-lg bg-white p-6 shadow-sm">@include('outgoing-letters.form', ['submitLabel' => 'Simpan'])</form>
        </div>
    </div>
</x-app-layout>