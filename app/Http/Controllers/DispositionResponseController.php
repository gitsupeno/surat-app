<?php

namespace App\Http\Controllers;

use App\Http\Requests\DispositionResponseRequest;
use App\Models\Disposition;
use Illuminate\Http\RedirectResponse;

class DispositionResponseController extends Controller
{
    public function store(DispositionResponseRequest $request, Disposition $disposition): RedirectResponse
    {
        $disposition->responses()->create([
            'responded_by' => $request->user()->id,
            'response' => $request->validated('response'),
        ]);
        $disposition->update(['status' => 'ditanggapi']);

        return to_route('incoming-letters.show', $disposition->incomingLetter)
            ->with('status', 'Tanggapan disposisi berhasil dikirim.');
    }
}
