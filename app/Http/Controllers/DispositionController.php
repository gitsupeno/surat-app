<?php

namespace App\Http\Controllers;

use App\Http\Requests\DispositionRequest;
use App\Models\Disposition;
use App\Models\IncomingLetter;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DispositionController extends Controller
{
    public function create(IncomingLetter $incomingLetter): View
    {
        return view('dispositions.create', [
            'incomingLetter' => $incomingLetter,
            'staff' => User::role('Staff')->orderBy('name')->get(),
        ]);
    }

    public function store(DispositionRequest $request, IncomingLetter $incomingLetter): RedirectResponse
    {
        $incomingLetter->dispositions()->create(array_merge($request->validated(), [
            'created_by' => $request->user()->id,
        ]));
        $incomingLetter->update(['status' => 'didisposisikan']);

        return to_route('incoming-letters.show', $incomingLetter)->with('status', 'Disposisi berhasil dibuat.');
    }

    public function show(Disposition $disposition): View
    {
        return view('dispositions.show', compact('disposition'));
    }
}
