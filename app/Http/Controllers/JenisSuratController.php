<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JenisSuratController extends Controller
{
    public function index(): View
    {
        return view('jenis-surat.index', ['jenisSurat' => JenisSurat::orderBy('name')->paginate(15)]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255'], 'code' => ['nullable', 'string', 'max:20', 'unique:jenis_surat,code']]);
        JenisSurat::create($data);
        return back()->with('status', 'Jenis surat berhasil ditambahkan.');
    }

    public function update(Request $request, JenisSurat $jenisSurat): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255'], 'code' => ['nullable', 'string', 'max:20', 'unique:jenis_surat,code,' . $jenisSurat->id]]);
        $jenisSurat->update($data);
        return back()->with('status', 'Jenis surat berhasil diperbarui.');
    }

    public function destroy(JenisSurat $jenisSurat): RedirectResponse
    {
        abort_unless($jenisSurat->outgoingLetters()->doesntExist() && $jenisSurat->incomingLetters()->doesntExist(), 422, 'Jenis surat yang sudah digunakan tidak dapat dihapus.');
        $jenisSurat->delete();
        return back()->with('status', 'Jenis surat berhasil dihapus.');
    }
}
