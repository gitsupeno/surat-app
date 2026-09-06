<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutgoingLetterTemplate extends Model
{
    use SoftDeletes;

    protected $fillable = ['jenis_surat_id', 'name', 'content', 'use_letterhead', 'created_by'];

    protected function casts(): array
    {
        return ['use_letterhead' => 'boolean'];
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
