<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicSetting extends Model
{
    protected $primaryKey = 'setting_id';
    protected $fillable = [
        'current_quarter',
        'current_week',
        'school_year'
    ];

    protected $casts = [
        'current_week' => 'integer'
    ];
}