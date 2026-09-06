<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutgoingLetter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'serial_no', 'letter_number', 'date_letter', 'recipient', 'subject', 'body',
        'classification_id', 'unit_id', 'status', 'created_by', 'approved_by', 'approved_at',
    ];

    protected function casts(): array
    {
        return ['date_letter' => 'date', 'approved_at' => 'datetime'];
    }

    public function classification() { return $this->belongsTo(LetterClassification::class, 'classification_id'); }
    public function unit() { return $this->belongsTo(Unit::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }
}
