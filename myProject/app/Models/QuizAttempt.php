<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $table = 'quiz_attempts';
    protected $primaryKey = 'attempt_id';
    
    protected $fillable = [
        'student_id',
        'quiz_id',
        'is_completed',
        'score',
        'timestamp'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'score' => 'integer',
        'timestamp' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}