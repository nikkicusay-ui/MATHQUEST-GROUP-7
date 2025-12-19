namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Section;
use App\Models\Student;
use App\Models\LearningMaterial;
use App\Models\Quiz;
use App\Models\StudentQuiz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::guard('teacher')->user();

        // Sections
        $sections = $teacher->sections()
            ->where('archived', 0)
            ->get();

        $section_ids = $sections->pluck('section_id')->toArray();

        // Students count
        $students_count = Student::whereIn('section_id', $section_ids)->count();

        // Learning materials count
        $materials_count = LearningMaterial::where('teacher_id', $teacher->teacher_id)->count();

        // Quizzes count
        $quizzes_count = Quiz::where('teacher_id', $teacher->teacher_id)->count();

        // Overall class average score
        $class_average_score = "0.00";

        if (!empty($section_ids)) {
            $avg_score = StudentQuiz::selectRaw('AVG((sq.score / qq.total_points) * 100) as avg_score')
                ->from('student_quizzes as sq')
                ->join('students as st', 'sq.student_id', '=', 'st.student_id')
                ->join('quiz_attempts as qa', function ($join) {
                    $join->on('sq.student_id', '=', 'qa.student_id')
                         ->on('sq.quiz_id', '=', 'qa.quiz_id');
                })
                ->join(DB::raw('
                    (SELECT qq.quiz_id, SUM(q.points) as total_points
                     FROM quiz_questions qq
                     JOIN questions q ON qq.question_id = q.question_id
                     GROUP BY qq.quiz_id) as qq
                '), 'qq.quiz_id', '=', 'sq.quiz_id')
                ->whereIn('st.section_id', $section_ids)
                ->whereNotNull('sq.score')
                ->where('qa.is_completed', 1)
                ->value('avg_score');

            $class_average_score = $avg_score
                ? number_format($avg_score, 2)
                : "0.00";
        }

        // Recent activities (placeholder)
        $recent_activities = $this->getRecentActivities($teacher);

        return view('teacher.dashboard', compact(
            'teacher',
            'sections',
            'students_count',
            'materials_count',
            'quizzes_count',
            'class_average_score',
            'recent_activities'
        ));
    }

    private function getRecentActivities(Teacher $teacher)
    {
        // TODO: replace with real activity logs
        return [
            [
                'icon' => 'fa-book',
                'title' => 'Uploaded a new learning material',
                'desc' => 'Math Module 3',
                'time' => '2 hours ago'
            ],
            [
                'icon' => 'fa-clipboard-list',
                'title' => 'Created a new quiz',
                'desc' => 'Quiz #5 - Fractions',
                'time' => '1 day ago'
            ],
        ];
    }
}
