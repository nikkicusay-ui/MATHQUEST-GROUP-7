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

    protected $rememberTokenName = 'remember_token';

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

    protected $rememberTokenName = 'remember_token';

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
