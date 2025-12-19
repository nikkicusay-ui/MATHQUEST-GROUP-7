<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $primaryKey = 'question_id';
    
    protected $fillable = [
        'teacher_id',
        'question_text',
        'difficulty',
        'question_type',
        'points',
        
    ];
    
    public function quizQuestions()
    {
        return $this->hasMany(QuizQuestion::class, 'question_id');
    }
}

