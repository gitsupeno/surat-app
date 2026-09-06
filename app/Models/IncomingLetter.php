<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomingLetter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'mail_number',
        'date_letter',
        'date_received',
        'sender',
        'subject',
        'sifat_id',
        'classification_id',
        'unit_id',
        'status',
        'notes',
        'created_by',
        'document_path',
    ];

    protected function casts(): array
    {
        return [
            'date_letter' => 'date',
            'date_received' => 'date',
        ];
    }

    public function classification()
    {
        return $this->belongsTo(LetterClassification::class, 'classification_id');
    }

    public function sifat()
    {
        return $this->belongsTo(JenisSurat::class, 'sifat_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function dispositions()
    {
        return $this->hasMany(Disposition::class);
    }
}
