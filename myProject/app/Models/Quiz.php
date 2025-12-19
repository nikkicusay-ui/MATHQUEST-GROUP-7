<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quizzes';
    protected $primaryKey = 'quiz_id';
    
    protected $fillable = [
        'quarter',
        'week',
        'quiz_type',
        'score',
        'date_created',
        'teacher_id',
        'section_id',
        'is_published'
    ];
    
    protected $dates = ['date_created'];
    
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'quiz_sections', 'quiz_id', 'section_id');
    }
    
    public function quizQuestions()
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_id');
    }
    
    public function studentQuizzes()
    {
        return $this->hasMany(Quiz::class, 'quiz_id');
    }
}