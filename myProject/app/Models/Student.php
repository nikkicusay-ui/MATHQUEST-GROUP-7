<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
    
    protected $table = 'students';
    protected $primaryKey = 'student_id';
    
    protected $fillable = [
        'lrn',
        'first_name',
        'last_name',
        'passcode',
        'section_id',
    ];
    
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}