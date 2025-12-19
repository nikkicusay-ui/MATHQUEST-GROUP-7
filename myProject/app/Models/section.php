<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Section extends Model
{
    protected $table = 'sections';
    protected $primaryKey = 'section_id';
    
    protected $fillable = [
        'section_name',
        'teacher_id',
        'archived',
    ];
    
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    
    public function students()
    {
        return $this->hasMany(Student::class, 'section_id');
    }
}
