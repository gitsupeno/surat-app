<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutgoingLetter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'serial_no',
        'letter_number',
        'date_letter',
        'jenis_surat_id',
        'sifat',
        'lampiran',
        'recipient',
        'recipient_position',
        'recipient_address',
        'recipient_email',
        'subject',
        'opening',
        'body',
        'closing',
        'classification_id',
        'unit_id',
        'status',
        'created_by',
        'signer_name',
        'signer_nip',
        'signer_position',
        'signature_path',
        'use_letterhead',
        'approved_by',
        'approved_at',
        'verified_by',
        'verified_at',
        'rejection_reason',
        'sent_at',
        'archived_at',
    ];

    protected function casts(): array
    {
        return [
            'date_letter' => 'date',
            'approved_at' => 'datetime',
            'verified_at' => 'datetime',
            'sent_at' => 'datetime',
            'archived_at' => 'datetime',
            'use_letterhead' => 'boolean',
        ];
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }
    public function classification()
    {
        return $this->belongsTo(LetterClassification::class, 'classification_id');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }
}
