<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutgoingLetterRequest;
use App\Models\LetterClassification;
use App\Models\OutgoingLetter;
use App\Models\Unit;
use App\Exports\OutgoingLettersExport;
use App\Services\OutgoingLetterNumberService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class OutgoingLetterController extends Controller
{
    public function index(Request $request): View
    {
        $letters = OutgoingLetter::with(['unit', 'classification'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');
                $query->where(fn ($query) => $query->where('letter_number', 'like', "%{$search}%")
                    ->orWhere('recipient', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%"));
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()->paginate(10)->withQueryString();

        return view('outgoing-letters.index', compact('letters'));
    }

    public function create(): View
    {
        return view('outgoing-letters.create', $this->formData());
    }

    public function store(OutgoingLetterRequest $request, OutgoingLetterNumberService $numberService): RedirectResponse
    {
        $letter = OutgoingLetter::create(array_merge($request->validated(), ['created_by' => $request->user()->id]));
        $numberService->assign($letter);

        return to_route('outgoing-letters.show', $letter)->with('status', 'Surat keluar berhasil disimpan.');
    }

    public function show(OutgoingLetter $outgoingLetter): View
    {
        return view('outgoing-letters.show', compact('outgoingLetter'));
    }

    public function edit(OutgoingLetter $outgoingLetter): View
    {
        return view('outgoing-letters.edit', array_merge(['outgoingLetter' => $outgoingLetter], $this->formData()));
    }

    public function update(OutgoingLetterRequest $request, OutgoingLetter $outgoingLetter): RedirectResponse
    {
        $outgoingLetter->update($request->validated());

        return to_route('outgoing-letters.show', $outgoingLetter)->with('status', 'Surat keluar diperbarui.');
    }

    public function export()
    {
        return Excel::download(new OutgoingLettersExport, 'surat-keluar.xlsx');
    }

    private function formData(): array
    {
        return ['units' => Unit::orderBy('name')->get(), 'classifications' => LetterClassification::orderBy('name')->get()];
    }
}
