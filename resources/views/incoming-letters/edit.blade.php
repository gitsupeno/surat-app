<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="eyebrow">Pusat surat masuk</p>
            <h2 class="mt-1 text-2xl font-semibold text-slate-900">Edit surat masuk</h2>
            <p class="mt-1 text-sm text-slate-500">Perbarui data agar arsip tetap akurat.</p>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('incoming-letters.update', $incomingLetter) }}" enctype="multipart/form-data" class="letter-form-card">@method('PUT') @include('incoming-letters.form', ['submitLabel' => 'Simpan perubahan'])</form>
        </div>
    </div>
</x-app-layout>