<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quizzes';
    protected $primaryKey = 'quiz_id';
    protected $fillable = [
        'teacher_id', 'quarter', 'week', 'quiz_type', 'score', 'date_created'
    ];
    public $timestamps = false;

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'quiz_sections', 'quiz_id', 'section_id');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quiz_questions', 'quiz_id', 'question_id');
    }

    public function studentQuizzes()
    {
        return $this->hasMany(StudentQuiz::class, 'quiz_id', 'quiz_id');
    }
}
