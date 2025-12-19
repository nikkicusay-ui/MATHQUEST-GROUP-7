<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    // Specify the table name
    protected $table = 'teachers';

    // Specify the primary key
    protected $primaryKey = 'teacher_id';

    // Fields that can be mass-assigned (used in signup and updates)
    protected $fillable = [
        'first_name',
        'middle_name',   // from the second version
        'last_name',
        'position',      // from the second version
        'email',
        'password_hash'  // used for login
    ];

    // Fields hidden when converting to arrays or JSON
    protected $hidden = [
        'password_hash'
    ];

    // Tell Laravel which field to use for authentication
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
