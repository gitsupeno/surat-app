<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IncomingLetterController;
use App\Http\Controllers\DispositionController;
use App\Http\Controllers\DispositionResponseController;
use App\Http\Controllers\OutgoingLetterController;
use App\Http\Controllers\OutgoingLetterApprovalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolSettingController;
use App\Http\Controllers\JenisSuratController;
use App\Http\Controllers\OutgoingLetterTemplateController;
use App\Http\Controllers\OutgoingLetterNumberSettingController;
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
    Route::get('outgoing-letters/{outgoingLetter}/preview', [OutgoingLetterController::class, 'preview'])->middleware('permission:read outgoing_letter')->name('outgoing-letters.preview');
    Route::get('outgoing-letters/{outgoingLetter}/pdf', [OutgoingLetterController::class, 'pdf'])->middleware('permission:print outgoing_letter')->name('outgoing-letters.pdf');
    Route::post('outgoing-letters/{outgoingLetter}/duplicate', [OutgoingLetterController::class, 'duplicate'])->middleware('permission:create outgoing_letter')->name('outgoing-letters.duplicate');
    Route::patch('outgoing-letters/{outgoingLetter}/verify', [OutgoingLetterController::class, 'verify'])->middleware('permission:verify outgoing_letter')->name('outgoing-letters.verify');
    Route::patch('outgoing-letters/{outgoingLetter}/reject', [OutgoingLetterController::class, 'reject'])->middleware('permission:verify outgoing_letter')->name('outgoing-letters.reject');
    Route::patch('outgoing-letters/{outgoingLetter}/send', [OutgoingLetterController::class, 'markSent'])->middleware('permission:send outgoing_letter')->name('outgoing-letters.send');
    Route::patch('outgoing-letters/{outgoingLetter}/archive', [OutgoingLetterController::class, 'archive'])->middleware('permission:archive outgoing_letter')->name('outgoing-letters.archive');
    Route::get('outgoing-letters/{outgoingLetter}', [OutgoingLetterController::class, 'show'])->middleware('permission:read outgoing_letter')->name('outgoing-letters.show');
    Route::get('outgoing-letters/{outgoingLetter}/edit', [OutgoingLetterController::class, 'edit'])->middleware('permission:update outgoing_letter')->name('outgoing-letters.edit');
    Route::put('outgoing-letters/{outgoingLetter}', [OutgoingLetterController::class, 'update'])->middleware('permission:update outgoing_letter')->name('outgoing-letters.update');
    Route::delete('outgoing-letters/{outgoingLetter}', [OutgoingLetterController::class, 'destroy'])->middleware('permission:delete outgoing_letter')->name('outgoing-letters.destroy');
    Route::patch('outgoing-letters/{outgoingLetter}/approve', [OutgoingLetterController::class, 'verify'])->middleware('permission:approve outgoing_letter')->name('outgoing-letters.approve');
    Route::get('outgoing-letters-export', [OutgoingLetterController::class, 'export'])
        ->middleware('permission:export data')->name('outgoing-letters.export');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/school-settings', [SchoolSettingController::class, 'edit'])
        ->middleware('permission:manage school settings')->name('school-settings.edit');
    Route::put('/school-settings', [SchoolSettingController::class, 'update'])
        ->middleware('permission:manage school settings')->name('school-settings.update');
    Route::get('/jenis-surat', [JenisSuratController::class, 'index'])->middleware('permission:manage master')->name('jenis-surat.index');
    Route::post('/jenis-surat', [JenisSuratController::class, 'store'])->middleware('permission:manage master')->name('jenis-surat.store');
    Route::put('/jenis-surat/{jenisSurat}', [JenisSuratController::class, 'update'])->middleware('permission:manage master')->name('jenis-surat.update');
    Route::delete('/jenis-surat/{jenisSurat}', [JenisSuratController::class, 'destroy'])->middleware('permission:manage master')->name('jenis-surat.destroy');
    Route::get('/outgoing-letter-templates', [OutgoingLetterTemplateController::class, 'index'])->middleware('permission:manage master')->name('outgoing-letter-templates.index');
    Route::post('/outgoing-letter-templates', [OutgoingLetterTemplateController::class, 'store'])->middleware('permission:manage master')->name('outgoing-letter-templates.store');
    Route::put('/outgoing-letter-templates/{template}', [OutgoingLetterTemplateController::class, 'update'])->middleware('permission:manage master')->name('outgoing-letter-templates.update');
    Route::delete('/outgoing-letter-templates/{template}', [OutgoingLetterTemplateController::class, 'destroy'])->middleware('permission:manage master')->name('outgoing-letter-templates.destroy');
    Route::get('/outgoing-letter-number-settings', [OutgoingLetterNumberSettingController::class, 'edit'])->middleware('permission:manage master')->name('outgoing-letter-number-settings.edit');
    Route::put('/outgoing-letter-number-settings', [OutgoingLetterNumberSettingController::class, 'update'])->middleware('permission:manage master')->name('outgoing-letter-number-settings.update');
});

require __DIR__ . '/auth.php';
