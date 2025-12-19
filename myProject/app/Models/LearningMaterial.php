<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningMaterial extends Model
{
    protected $table = 'learning_materials';
    protected $primaryKey = 'material_id';
    
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_type',
        'teacher_id',
        'section_id',
    ];
    
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}