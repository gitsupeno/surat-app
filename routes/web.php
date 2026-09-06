<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IncomingLetterController;
use App\Http\Controllers\DispositionController;
use App\Http\Controllers\DispositionResponseController;
use App\Http\Controllers\OutgoingLetterController;
use App\Http\Controllers\OutgoingLetterApprovalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolSettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified', 'permission:view dashboard'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('incoming-letters', [IncomingLetterController::class, 'index'])
        ->middleware('permission:read incoming_letter')->name('incoming-letters.index');
    Route::get('incoming-letters/create', [IncomingLetterController::class, 'create'])
        ->middleware('permission:create incoming_letter')->name('incoming-letters.create');
    Route::post('incoming-letters', [IncomingLetterController::class, 'store'])
        ->middleware('permission:create incoming_letter')->name('incoming-letters.store');
    Route::get('incoming-letters/{incomingLetter}', [IncomingLetterController::class, 'show'])
        ->middleware('permission:read incoming_letter')->name('incoming-letters.show');
    Route::get('incoming-letters/{incomingLetter}/edit', [IncomingLetterController::class, 'edit'])
        ->middleware('permission:update incoming_letter')->name('incoming-letters.edit');
    Route::put('incoming-letters/{incomingLetter}', [IncomingLetterController::class, 'update'])
        ->middleware('permission:update incoming_letter')->name('incoming-letters.update');
    Route::delete('incoming-letters/{incomingLetter}', [IncomingLetterController::class, 'destroy'])
        ->middleware('permission:delete incoming_letter')->name('incoming-letters.destroy');
    Route::get('incoming-letters/{incomingLetter}/dispositions/create', [DispositionController::class, 'create'])
        ->middleware('permission:disposition.create')->name('dispositions.create');
    Route::post('incoming-letters/{incomingLetter}/dispositions', [DispositionController::class, 'store'])
        ->middleware('permission:disposition.create')->name('dispositions.store');
    Route::get('dispositions/{disposition}', [DispositionController::class, 'show'])
        ->middleware('permission:read incoming_letter')->name('dispositions.show');
    Route::post('dispositions/{disposition}/responses', [DispositionResponseController::class, 'store'])
        ->middleware('permission:disposition.respond')->name('dispositions.responses.store');
    Route::get('incoming-letters-export', [IncomingLetterController::class, 'export'])
        ->middleware('permission:export data')->name('incoming-letters.export');
    Route::get('outgoing-letters', [OutgoingLetterController::class, 'index'])->middleware('permission:read outgoing_letter')->name('outgoing-letters.index');
    Route::get('outgoing-letters/create', [OutgoingLetterController::class, 'create'])->middleware('permission:create outgoing_letter')->name('outgoing-letters.create');
    Route::post('outgoing-letters', [OutgoingLetterController::class, 'store'])->middleware('permission:create outgoing_letter')->name('outgoing-letters.store');
    Route::get('outgoing-letters/{outgoingLetter}', [OutgoingLetterController::class, 'show'])->middleware('permission:read outgoing_letter')->name('outgoing-letters.show');
    Route::get('outgoing-letters/{outgoingLetter}/edit', [OutgoingLetterController::class, 'edit'])->middleware('permission:create outgoing_letter')->name('outgoing-letters.edit');
    Route::put('outgoing-letters/{outgoingLetter}', [OutgoingLetterController::class, 'update'])->middleware('permission:create outgoing_letter')->name('outgoing-letters.update');
    Route::patch('outgoing-letters/{outgoingLetter}/approve', [OutgoingLetterApprovalController::class, 'approve'])->middleware('permission:approve outgoing_letter')->name('outgoing-letters.approve');
    Route::get('outgoing-letters-export', [OutgoingLetterController::class, 'export'])
        ->middleware('permission:export data')->name('outgoing-letters.export');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/school-settings', [SchoolSettingController::class, 'edit'])
        ->middleware('permission:manage school settings')->name('school-settings.edit');
    Route::put('/school-settings', [SchoolSettingController::class, 'update'])
        ->middleware('permission:manage school settings')->name('school-settings.update');
});

require __DIR__ . '/auth.php';
