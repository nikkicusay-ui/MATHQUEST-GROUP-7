<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentArchive extends Model
{
    protected $table = 'student_archives';
    protected $primaryKey = 'archive_id';
    
    protected $fillable = [
        'student_id',
        'section_id',
        'first_name',
        'middle_name',
        'last_name',
        'lrn',
        'school_year',
        'passcode',
        'archived_at',
    ];
    
    protected $casts = [
        'archived_at' => 'datetime',
    ];
    
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}