<x-app-layout><x-slot name="header">
        <div>
            <p class="eyebrow">Pusat arsip</p>
            <h2 class="mt-1 text-2xl font-semibold text-slate-900">Edit surat keluar</h2>
            <p class="mt-1 text-sm text-slate-500">Perbarui data surat agar arsip tetap akurat.</p>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('outgoing-letters.update', $outgoingLetter) }}" class="rounded-lg bg-white p-6 shadow-sm">@method('PUT') @include('outgoing-letters.form', ['submitLabel' => 'Perbarui'])</form>
        </div>
    </div>
</x-app-layout>