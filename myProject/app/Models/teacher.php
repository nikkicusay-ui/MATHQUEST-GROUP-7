namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    protected $table = 'teachers';
    protected $primaryKey = 'teacher_id';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'position',
        'profile_image',
        'email',
        'password_hash'
    ];

    protected $hidden = ['password_hash'];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'teacher_id', 'teacher_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'teacher_id', 'teacher_id');
    }
}
