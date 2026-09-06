<?php

namespace App\Http\Controllers;

use App\Models\OutgoingLetter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class OutgoingLetterApprovalController extends Controller
{
    public function approve(OutgoingLetter $outgoingLetter): RedirectResponse
    {
        abort_unless($outgoingLetter->status === 'approval', 422, 'Surat belum berada pada tahap approval.');

        $outgoingLetter->update([
            'status' => 'terkirim',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return to_route('outgoing-letters.show', $outgoingLetter)->with('status', 'Surat keluar telah disetujui dan ditandai terkirim.');
    }
}
