<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    // Specify the table name
    protected $table = 'teachers';

  
    protected $primaryKey = 'teacher_id';

    protected $fillable = [
        'first_name',
        'middle_name',   
        'last_name',
        'position',     
        'email',
        'password_hash'
    ];

    // Fields hidden when converting to arrays or JSON
    protected $hidden = [
        'password_hash'
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
