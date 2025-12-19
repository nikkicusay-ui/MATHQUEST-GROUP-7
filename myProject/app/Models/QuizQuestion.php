<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $table = 'quiz_questions';
    protected $primaryKey = 'quiz_question_id';
    
    protected $fillable = [
        'quiz_id',
        'question_id',
    ];
    
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
    
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}