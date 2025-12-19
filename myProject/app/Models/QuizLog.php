<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\QuizLog;

class QuizLog extends Model
{
    protected $table = 'quiz_logs';
    protected $primaryKey = 'log_id';
    
    protected $fillable = [
        'student_id',
        'quiz_id',
        'question_id',
        'selected_answer',
        'is_correct',
        'answered_at'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'answered_at' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}