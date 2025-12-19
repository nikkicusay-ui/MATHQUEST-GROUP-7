<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;

class Section extends Model
{
    protected $table = 'sections';
    protected $primaryKey = 'section_id';
    protected $fillable = ['section_name', 'teacher_id', 'school_year', 'archived'];

    public function quizzes()
    {
        return $this->belongsToMany;( Quiz::class, 'section_id', 'quiz_id');

    }

}