<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentQuiz extends Models
{
    protected $table = 'student_quizzes';
    protected $primaryKey = 'student_quiz_id';
    protected $fillable = ['quiz_id', 'student_id', 'score'];
}
