<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teacher extends Authenticatable
{
    use Notifiable; 

 
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
        'remember_token', 
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
