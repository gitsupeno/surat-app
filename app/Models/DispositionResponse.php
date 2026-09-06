<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispositionResponse extends Model
{
    use HasFactory;

    protected $fillable = ['disposition_id', 'responded_by', 'response'];

    public function disposition() { return $this->belongsTo(Disposition::class); }
    public function responder() { return $this->belongsTo(User::class, 'responded_by'); }
}
