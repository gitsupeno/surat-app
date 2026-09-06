<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'code', 'description'];

    public function incomingLetters()
    {
        return $this->hasMany(IncomingLetter::class);
    }

    public function outgoingLetters()
    {
        return $this->hasMany(OutgoingLetter::class);
    }
}
