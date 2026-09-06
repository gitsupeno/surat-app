<?php

namespace App\Http\Controllers;

use App\Exports\OutgoingLettersExport;
use App\Http\Requests\OutgoingLetterRequest;
use App\Models\AuditLog;
use App\Models\JenisSurat;
use App\Models\LetterClassification;
use App\Models\OutgoingLetter;
use App\Models\SchoolSetting;
use App\Models\Unit;
use App\Services\OutgoingLetterNumberService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class OutgoingLetterController extends Controller
{
    public function index(Request $request): View
    {
        $letters = OutgoingLetter::with(['unit', 'classification', 'jenisSurat'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');
                $query->where(function ($query) use ($search) {
                    $query->where('letter_number', 'like', "%{$search}%")
                        ->orWhere('recipient', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('jenis_surat_id'), fn($query) => $query->where('jenis_surat_id', $request->integer('jenis_surat_id')))
            ->when($request->filled('year'), fn($query) => $query->whereYear('date_letter', $request->integer('year')))
            ->when($request->filled('date_from'), fn($query) => $query->whereDate('date_letter', '>=', $request->date('date_from')))
            ->when($request->filled('date_to'), fn($query) => $query->whereDate('date_letter', '<=', $request->date('date_to')))
            ->when($request->string('sort') === 'number', fn($query) => $query->orderBy('serial_no', $request->string('direction') === 'asc' ? 'asc' : 'desc'), fn($query) => $query->latest('date_letter'))
            ->paginate(10)->withQueryString();

        return view('outgoing-letters.index', [
            'letters' => $letters,
            'jenisSurat' => JenisSurat::orderBy('name')->get(),
            'years' => range(now()->year, now()->year - 5),
            'statuses' => $this->statuses(),
        ]);
    }

    public function create(): View
    {
        return view('outgoing-letters.create', $this->formData());
    }

    public function store(OutgoingLetterRequest $request, OutgoingLetterNumberService $numberService): RedirectResponse
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['status'] = 'menunggu_verifikasi';
        $data['serial_no'] = 0;
        $data['use_letterhead'] = $request->boolean('use_letterhead');
        $data['body'] = $this->sanitizeBody($data['body']);
        $letter = OutgoingLetter::create($data);
        $numberService->assign($letter);
        $this->audit($letter, 'dibuat', [], $letter->toArray());

        return to_route('outgoing-letters.show', $letter)->with('status', 'Surat keluar berhasil dibuat dan menunggu verifikasi.');
    }

    public function show(OutgoingLetter $outgoingLetter): View
    {
        $outgoingLetter->load(['unit', 'classification', 'jenisSurat', 'creator', 'approver', 'verifier', 'auditLogs.user']);
        return view('outgoing-letters.show', compact('outgoingLetter'));
    }

    public function edit(OutgoingLetter $outgoingLetter): View
    {
        abort_unless(in_array($outgoingLetter->status, ['draft', 'ditolak'], true), 403, 'Surat hanya dapat diedit saat draft atau ditolak.');
        return view('outgoing-letters.edit', array_merge(['outgoingLetter' => $outgoingLetter], $this->formData()));
    }

    public function update(OutgoingLetterRequest $request, OutgoingLetter $outgoingLetter, OutgoingLetterNumberService $numberService): RedirectResponse
    {
        abort_unless(in_array($outgoingLetter->status, ['draft', 'ditolak'], true), 403, 'Surat tidak dapat diperbarui pada tahap ini.');
        $old = $outgoingLetter->toArray();
        $data = $request->validated();
        $data['status'] = 'menunggu_verifikasi';
        $data['use_letterhead'] = $request->boolean('use_letterhead');
        $data['body'] = $this->sanitizeBody($data['body']);
        $outgoingLetter->update($data);
        $numberService->assign($outgoingLetter);
        $this->audit($outgoingLetter, 'diubah', $old, $outgoingLetter->fresh()->toArray());

        return to_route('outgoing-letters.show', $outgoingLetter)->with('status', 'Surat diperbarui dan dikirim kembali untuk verifikasi.');
    }

    public function destroy(OutgoingLetter $outgoingLetter): RedirectResponse
    {
        abort_unless(in_array($outgoingLetter->status, ['draft', 'ditolak'], true), 403, 'Hanya draft atau surat ditolak yang dapat dihapus.');
        $this->audit($outgoingLetter, 'dihapus', $outgoingLetter->toArray(), []);
        $outgoingLetter->delete();
        return to_route('outgoing-letters.index')->with('status', 'Surat berhasil dihapus.');
    }

    public function duplicate(OutgoingLetter $outgoingLetter): RedirectResponse
    {
        $copy = $outgoingLetter->replicate(['letter_number', 'serial_no', 'approved_by', 'approved_at', 'verified_by', 'verified_at', 'sent_at', 'archived_at']);
        $copy->created_by = request()->user()->id;
        $copy->serial_no = 0;
        $copy->status = 'draft';
        $copy->save();
        $this->audit($copy, 'diduplikasi', [], $copy->toArray());
        return to_route('outgoing-letters.edit', $copy)->with('status', 'Salinan surat dibuat sebagai draft.');
    }

    public function archive(OutgoingLetter $outgoingLetter): RedirectResponse
    {
        abort_unless($outgoingLetter->status === 'sudah_dikirim', 403, 'Surat harus sudah dikirim sebelum diarsipkan.');
        $outgoingLetter->update(['status' => 'diarsipkan', 'archived_at' => now()]);
        $this->audit($outgoingLetter, 'diarsipkan', [], ['status' => 'diarsipkan']);
        return back()->with('status', 'Surat berhasil diarsipkan.');
    }

    public function preview(OutgoingLetter $outgoingLetter): View
    {
        return view('outgoing-letters.pdf', ['letter' => $outgoingLetter->load(['jenisSurat', 'unit']), 'school' => SchoolSetting::first(), 'preview' => true]);
    }

    public function pdf(OutgoingLetter $outgoingLetter)
    {
        $pdf = Pdf::loadView('outgoing-letters.pdf', ['letter' => $outgoingLetter->load(['jenisSurat', 'unit']), 'school' => SchoolSetting::first(), 'preview' => false])->setPaper('a4');
        return $pdf->download('Surat_Keluar_' . preg_replace('/[^A-Za-z0-9_-]/', '_', $outgoingLetter->letter_number) . '.pdf');
    }

    public function verify(OutgoingLetter $outgoingLetter): RedirectResponse
    {
        abort_unless($outgoingLetter->status === 'menunggu_verifikasi', 422, 'Surat tidak sedang menunggu verifikasi.');
        $outgoingLetter->update(['status' => 'disetujui', 'verified_by' => request()->user()->id, 'verified_at' => now()]);
        $this->audit($outgoingLetter, 'diverifikasi', [], ['status' => 'disetujui']);
        return back()->with('status', 'Surat berhasil diverifikasi dan disetujui.');
    }

    public function reject(Request $request, OutgoingLetter $outgoingLetter): RedirectResponse
    {
        $request->validate(['rejection_reason' => ['required', 'string', 'max:1000']]);
        abort_unless($outgoingLetter->status === 'menunggu_verifikasi', 422, 'Surat tidak sedang menunggu verifikasi.');
        $reason = $request->string('rejection_reason')->toString();
        $outgoingLetter->update(['status' => 'ditolak', 'rejection_reason' => $reason]);
        $this->audit($outgoingLetter, 'ditolak', [], ['status' => 'ditolak', 'rejection_reason' => $reason]);
        return back()->with('status', 'Surat ditolak dan dapat diperbaiki oleh pembuat.');
    }

    public function markSent(OutgoingLetter $outgoingLetter): RedirectResponse
    {
        abort_unless($outgoingLetter->status === 'disetujui', 422, 'Surat harus disetujui sebelum dikirim.');
        $outgoingLetter->update(['status' => 'sudah_dikirim', 'sent_at' => now()]);
        $this->audit($outgoingLetter, 'dikirim', [], ['status' => 'sudah_dikirim']);
        return back()->with('status', 'Surat ditandai sudah dikirim.');
    }

    public function export()
    {
        return Excel::download(new OutgoingLettersExport, 'surat-keluar.xlsx');
    }

    private function formData(): array
    {
        return ['units' => Unit::orderBy('name')->get(), 'classifications' => LetterClassification::orderBy('name')->get(), 'jenisSurat' => JenisSurat::orderBy('name')->get(), 'school' => SchoolSetting::first()];
    }

    private function statuses(): array
    {
        return ['draft' => 'Draft', 'menunggu_verifikasi' => 'Menunggu Verifikasi', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak', 'sudah_ditandatangani' => 'Sudah Ditandatangani', 'sudah_dikirim' => 'Sudah Dikirim', 'diarsipkan' => 'Diarsipkan'];
    }

    private function audit(OutgoingLetter $letter, string $action, array $old, array $new): void
    {
        AuditLog::create(['user_id' => request()->user()?->id, 'auditable_type' => $letter::class, 'auditable_id' => $letter->id, 'action' => $action, 'old_values' => $old, 'new_values' => $new]);
    }

    private function sanitizeBody(string $body): string
    {
        return strip_tags($body, '<p><br><strong><b><em><i><u><ol><ul><li><table><thead><tbody><tr><th><td>');
    }
}
