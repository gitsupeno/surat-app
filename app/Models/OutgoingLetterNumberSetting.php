<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingLetterNumberSetting extends Model
{
    protected $fillable = ['school_code', 'format', 'reset_yearly', 'next_number'];

    protected function casts(): array
    {
        return ['reset_yearly' => 'boolean'];
    }
}
