<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quizzes';
    protected $primaryKey = 'quiz_id';
    
    protected $fillable = [
        'title',
        'description',
        'teacher_id',
        'section_id',
        'is_published',
    ];
    
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}