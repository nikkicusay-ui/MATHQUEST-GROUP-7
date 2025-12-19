<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'student_id';
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'lrn',
        'section_id',
        'passcode',
        'current_level',
        'current_points',
        'theta',
        'learner_category',
        'assigned_set',
        'archived',
    ];

    protected $casts = [
        'current_points' => 'integer',
        'current_level' => 'integer',
        'theta' => 'float',
        'archived' => 'boolean',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function studentQuizzes()
    {
        return $this->hasMany(StudentQuiz::class, 'student_id');
    }

    public function badges()
    {
        return $this->hasMany(StudentBadge::class, 'student_id');
    }
}