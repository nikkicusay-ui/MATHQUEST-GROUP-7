<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicSetting extends Model
{
    protected $table = 'academic_settings';
    protected $primaryKey = 'setting_id';
    
    protected $fillable = [
        'current_quarter',
        'current_week',
    ];
}