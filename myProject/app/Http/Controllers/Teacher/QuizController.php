namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Section;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index()
    {
        $teacher = Auth::guard('teacher')->user();

        $sections = $teacher->sections()
            ->where('archived', 0)
            ->orderByDesc('school_year')
            ->get();

        $quizzes = $teacher->quizzes()
            ->with(['sections', 'questions', 'studentQuizzes'])
            ->orderByDesc('created_at')
            ->get();

        $total_questions = Question::where('teacher_id', $teacher->teacher_id)->count();

        $question_stats = Question::selectRaw("
                difficulty,
                COUNT(*) as total,
                COUNT(DISTINCT qq.quiz_id) as used,
                COALESCE(SUM(ql.is_correct),0) as correct
            ")
            ->leftJoin('quiz_questions as qq', 'qq.question_id', '=', 'questions.question_id')
            ->leftJoin('quiz_logs as ql', 'ql.question_id', '=', 'questions.question_id')
            ->where('questions.teacher_id', $teacher->teacher_id)
            ->groupBy('difficulty')
            ->get()
            ->groupBy('difficulty');

        $settings = DB::table('academic_settings')->latest('setting_id')->first();

        return view('teacher.quizzes.index', [
            'teacher' => $teacher,
            'sections' => $sections,
            'quizzes' => $quizzes,
            'question_stats' => $question_stats,
            'total_questions' => $total_questions,
            'current_quarter' => $settings->current_quarter ?? '1st',
            'current_week' => $settings->current_week ?? 1,
        ]);
    }

    public function destroy($id)
    {
        $teacher = Auth::guard('teacher')->user();

        $quiz = Quiz::where('quiz_id', $id)
            ->where('teacher_id', $teacher->teacher_id)
            ->firstOrFail();

        $quiz->delete();

        return redirect()
            ->route('teacher.quizzes.index')
            ->with('success', 'Quiz deleted successfully');
    }
}
