<x-app-layout><x-slot name="header">
        <div>
            <p class="eyebrow">Administrasi surat</p>
            <h2 class="mt-1 text-2xl font-semibold text-slate-900">Template surat</h2>
            <p class="mt-1 text-sm text-slate-500">Gunakan placeholder seperti @{{nomor_surat}}, @{{tanggal}}, @{{perihal}}, @{{nama_penerima}}, dan @{{isi_surat}}.</p>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-6xl space-y-4 sm:px-6 lg:px-8">@if(session('status'))<div class="rounded-md bg-green-50 p-4 text-sm text-green-700">{{ session('status') }}</div>@endif<div class="soft-panel p-6">
                <h3 class="font-semibold text-slate-900">Tambah template</h3>
                <form method="POST" action="{{ route('outgoing-letter-templates.store') }}" class="mt-4 space-y-3">@csrf<input name="name" placeholder="Nama template" class="form-input block w-full" required><select name="jenis_surat_id" class="form-input block w-full">
                        <option value="">Semua jenis surat</option>@foreach($jenisSurat as $jenis)<option value="{{ $jenis->id }}">{{ $jenis->name }}</option>@endforeach
                    </select><textarea name="content" rows="8" class="form-input block w-full" placeholder="Isi template surat" required></textarea><button class="button-primary">Simpan template</button></form>
            </div>
            <div class="space-y-3">@foreach($templates as $template)<div class="soft-panel p-5">
                    <form method="POST" action="{{ route('outgoing-letter-templates.update', $template) }}" class="space-y-3">@csrf @method('PUT')<div class="grid gap-3 md:grid-cols-2"><input name="name" value="{{ $template->name }}" class="form-input" required><select name="jenis_surat_id" class="form-input">
                                <option value="">Semua jenis surat</option>@foreach($jenisSurat as $jenis)<option value="{{ $jenis->id }}" @selected($template->jenis_surat_id == $jenis->id)>{{ $jenis->name }}</option>@endforeach
                            </select></div><textarea name="content" rows="7" class="form-input block w-full" required>{{ $template->content }}</textarea>
                        <div class="flex justify-end gap-2"><button class="button-primary">Simpan perubahan</button></div>
                    </form>
                    <form method="POST" action="{{ route('outgoing-letter-templates.destroy', $template) }}" onsubmit="return confirm('Hapus template ini?')">@csrf @method('DELETE')<button class="text-sm font-semibold text-red-600">Hapus template</button></form>
                </div>@endforeach</div>{{ $templates->links() }}
        </div>
    </div>
</x-app-layout>