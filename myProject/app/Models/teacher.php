<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Authenticatable
{
    use HasFactory;

    protected $table = 'teachers';
    protected $primaryKey = 'teacher_id';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'position',
        'email',
        'password_hash',
    ];

    protected $hidden = [
        'password_hash',
    ];

    // This is important: We are using 'password_hash' as the password field.
    // But Laravel by default expects 'password'. So we need to tell Laravel to use 'password_hash'.
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
