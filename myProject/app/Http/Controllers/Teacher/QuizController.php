<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Section;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();

        $sections = $teacher->sections()->where('archived', 0)->orderBy('school_year', 'desc')->get();

        $quizzes = $teacher->quizzes()
            ->with(['sections', 'questions', 'studentQuizzes'])
            ->orderBy('date_created', 'desc')
            ->get();

        $total_questions = Question::count();

        $question_stats = Question::selectRaw("
                difficulty,
                COUNT(*) as total,
                (SELECT COUNT(DISTINCT qq.quiz_id) FROM quiz_questions qq WHERE qq.question_id = questions.question_id) as used,
                (SELECT COALESCE(SUM(ql.is_correct),0) FROM quiz_logs ql WHERE ql.question_id = questions.question_id) as correct
            ")
            ->groupBy('difficulty')
            ->get()
            ->groupBy('difficulty');

        $settings = \DB::table('academic_settings')->orderByDesc('setting_id')->first();
        $current_quarter = $settings->current_quarter ?? '1st';
        $current_week = $settings->current_week ?? 1;

        return view('teacher.quizzes.index', compact('teacher', 'sections', 'quizzes', 'question_stats', 'total_questions', 'current_quarter', 'current_week'));
    }

    public function destroy($id)
    {
        $teacher = Auth::user();
        $quiz = Quiz::where('quiz_id', $id)->where('teacher_id', $teacher->teacher_id)->firstOrFail();
        $quiz->delete();

        return redirect()->route('teacher.quizzes.index')->with('success', 'Quiz deleted successfully');
    }
}
