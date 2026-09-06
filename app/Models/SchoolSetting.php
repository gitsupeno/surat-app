<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolSetting extends Model
{
    protected $fillable = [
        'government_name',
        'department_name',
        'branch_department_name',
        'school_name',
        'principal_name',
        'principal_nip',
        'address',
        'website',
        'email',
        'province_logo_path',
        'school_logo_path',
    ];
}
