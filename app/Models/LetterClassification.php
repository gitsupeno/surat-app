<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LetterClassification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'code', 'description'];

    public function incomingLetters()
    {
        return $this->hasMany(IncomingLetter::class, 'classification_id');
    }
}
