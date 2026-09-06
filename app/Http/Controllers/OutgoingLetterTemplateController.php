<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\OutgoingLetterTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OutgoingLetterTemplateController extends Controller
{
    public function index(): View
    {
        return view('outgoing-letter-templates.index', [
            'templates' => OutgoingLetterTemplate::with('jenisSurat')->latest()->paginate(10),
            'jenisSurat' => JenisSurat::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255'], 'jenis_surat_id' => ['nullable', 'exists:jenis_surat,id'], 'content' => ['required', 'string'], 'use_letterhead' => ['nullable', 'boolean']]);
        $data['created_by'] = $request->user()->id;
        OutgoingLetterTemplate::create($data);
        return back()->with('status', 'Template surat berhasil ditambahkan.');
    }

    public function update(Request $request, OutgoingLetterTemplate $template): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255'], 'jenis_surat_id' => ['nullable', 'exists:jenis_surat,id'], 'content' => ['required', 'string'], 'use_letterhead' => ['nullable', 'boolean']]);
        $template->update($data);
        return back()->with('status', 'Template surat berhasil diperbarui.');
    }

    public function destroy(OutgoingLetterTemplate $template): RedirectResponse
    {
        $template->delete();
        return back()->with('status', 'Template surat berhasil dihapus.');
    }
}
