namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $primaryKey = 'question_id';

    protected $fillable = [
        'teacher_id',
        'question_text',
        'difficulty',
        'points'
    ];

    // Uncomment if no timestamps exist
    // public $timestamps = false;

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
    }

    public function quizzes()
    {
        return $this->belongsToMany(
            Quiz::class,
            'quiz_questions',
            'question_id',
            'quiz_id'
        );
    }

    public function quizLogs()
    {
        return $this->hasMany(QuizLog::class, 'question_id', 'question_id');
    }
}
