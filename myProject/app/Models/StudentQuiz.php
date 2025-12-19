<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentQuiz extends Model
{
    protected $table = 'student_quizzes';
    protected $primaryKey = 'student_quiz_id';
    
    protected $fillable = [
        'quiz_id',
        'student_id',
        'score',
        'completed_at',
    ];
    
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
    
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}