<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisSurat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jenis_surat';
    protected $fillable = ['name', 'code'];

    public function incomingLetters()
    {
        return $this->hasMany(IncomingLetter::class, 'sifat_id');
    }
}
