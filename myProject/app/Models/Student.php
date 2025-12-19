<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Authenticatable
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'student_id';

    protected $fillable = [
        'lrn',
        'first_name',
        'last_name',
        'passcode',
    ];

    protected $hidden = [
        'passcode',
    ];

    public function getAuthPassword()
    {
        return $this->passcode;
    }
}