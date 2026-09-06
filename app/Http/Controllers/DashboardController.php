<?php

namespace App\Http\Controllers;

use App\Models\Disposition;
use App\Models\IncomingLetter;
use App\Models\OutgoingLetter;
use App\Models\SchoolSetting;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $month = Carbon::now();

        return view('dashboard', [
            'schoolSetting' => SchoolSetting::query()->first(),
            'incomingTotal' => IncomingLetter::count(),
            'incomingPending' => IncomingLetter::whereIn('status', ['baru', 'didisposisikan'])->count(),
            'outgoingTotal' => OutgoingLetter::count(),
            'outgoingApproval' => OutgoingLetter::where('status', 'approval')->count(),
            'dispositionPending' => Disposition::where('status', 'ditugaskan')->count(),
            'monthlyIncoming' => IncomingLetter::whereMonth('date_received', $month->month)->whereYear('date_received', $month->year)->count(),
            'monthlyOutgoing' => OutgoingLetter::whereMonth('date_letter', $month->month)->whereYear('date_letter', $month->year)->count(),
            'recentIncoming' => IncomingLetter::latest()->take(5)->get(),
            'recentOutgoing' => OutgoingLetter::latest()->take(5)->get(),
        ]);
    }
}
