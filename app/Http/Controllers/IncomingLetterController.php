<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomingLetterRequest;
use App\Models\IncomingLetter;
use App\Models\JenisSurat;
use App\Models\LetterClassification;
use App\Models\Unit;
use App\Exports\IncomingLettersExport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class IncomingLetterController extends Controller
{
    public function index(Request $request): View
    {
        $letters = IncomingLetter::with(['classification', 'unit', 'sifat'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');
                $query->where(function ($query) use ($search) {
                    $query->where('mail_number', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhere('sender', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn($query) => $query->where('status', $request->string('status')))
            ->latest('date_received')
            ->paginate(10)
            ->withQueryString();

        return view('incoming-letters.index', compact('letters'));
    }

    public function create(): View
    {
        return view('incoming-letters.create', $this->formData());
    }

    public function store(IncomingLetterRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['document']);

        if ($request->hasFile('document')) {
            $data['document_path'] = $request->file('document')->store('incoming-letters', 'public');
        }

        $request->user()->incomingLetters()->create($data);

        return to_route('incoming-letters.index')->with('status', 'Surat masuk berhasil ditambahkan.');
    }

    public function show(IncomingLetter $incomingLetter): View
    {
        $incomingLetter->load(['dispositions.assignee', 'dispositions.responses.responder']);

        return view('incoming-letters.show', compact('incomingLetter'));
    }

    public function edit(IncomingLetter $incomingLetter): View
    {
        return view('incoming-letters.edit', array_merge(['incomingLetter' => $incomingLetter], $this->formData()));
    }

    public function update(IncomingLetterRequest $request, IncomingLetter $incomingLetter): RedirectResponse
    {
        $data = $request->validated();
        unset($data['document']);

        if ($request->hasFile('document')) {
            if ($incomingLetter->document_path) {
                Storage::disk('public')->delete($incomingLetter->document_path);
            }

            $data['document_path'] = $request->file('document')->store('incoming-letters', 'public');
        }

        $incomingLetter->update($data);

        return to_route('incoming-letters.index')->with('status', 'Surat masuk berhasil diperbarui.');
    }

    public function destroy(IncomingLetter $incomingLetter): RedirectResponse
    {
        if ($incomingLetter->document_path) {
            Storage::disk('public')->delete($incomingLetter->document_path);
        }

        $incomingLetter->delete();

        return to_route('incoming-letters.index')->with('status', 'Surat masuk berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new IncomingLettersExport, 'surat-masuk.xlsx');
    }

    private function formData(): array
    {
        return [
            'units' => Unit::orderBy('name')->get(),
            'classifications' => LetterClassification::orderBy('name')->get(),
            'sifats' => JenisSurat::orderBy('name')->get(),
        ];
    }
}
