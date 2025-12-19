<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Section;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\AcademicSetting;
use App\Models\QuizQuestion;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizzesController extends Controller
{
    public function index()
    {
        // Get the authenticated teacher
        $teacher = Auth::guard('teacher')->user();
        
        if (!$teacher) {
            return redirect()->route('login');
        }

        // Get teacher details
        $teacher_name = $teacher->first_name . ' ' . $teacher->last_name;
        $sidebar_initials = strtoupper(
            substr($teacher->first_name, 0, 1) . substr($teacher->last_name, 0, 1)
        );

        // Get academic settings
        $settings = AcademicSetting::latest()->first();
        $current_quarter = $settings->current_quarter ?? '1st';
        $current_week = $settings->current_week ?? 1;

        // Get sections created by this teacher
        $sections = Section::where('teacher_id', $teacher->teacher_id)
                          ->where('archived', 0)
                          ->orderBy('school_year', 'DESC')
                          ->orderBy('section_name')
                          ->get();

        // Get quizzes with related data
        $quizzes = Quiz::where('teacher_id', $teacher->teacher_id)
                      ->with(['sections', 'quizQuestions.question', 'studentQuizzes'])
                      ->orderBy('date_created', 'DESC')
                      ->get()
                      ->map(function($quiz) {
                          // Add calculated fields
                          $quiz->question_count = $quiz->quizQuestions->count();
                          $quiz->total_points = $quiz->quizQuestions->sum(function($qq) {
                              return $qq->question->points ?? 0;
                          });
                          
                          $quiz->students_taken = $quiz->studentQuizzes->count();
                          $quiz->average_score = $quiz->studentQuizzes->avg('score') ?? 0;
                          
                          $quiz->sections_count = $quiz->sections->count();
                          $quiz->assigned_sections = $quiz->sections->pluck('section_name')->implode(', ');
                          
                          return $quiz;
                      });

        // Get total questions count
        $total_questions = QuizQuestion::count();

        // Get question statistics by difficulty
        $question_stats = $this->getQuestionStatistics();

        return view('teacher.quizzes', compact(
            'teacher',
            'teacher_name',
            'sidebar_initials',
            'settings',
            'current_quarter',
            'current_week',
            'sections',
            'quizzes',
            'total_questions',
            'question_stats'
        ));
    }

    public function destroy($id)
    {
        $teacher = Auth::guard('teacher')->user();
        
        $quiz = Quiz::where('quiz_id', $id)
                   ->where('teacher_id', $teacher->teacher_id)
                   ->first();
        
        if (!$quiz) {
            return redirect()->route('teacher.quizzes')
                ->with('error', 'Quiz not found or unauthorized');
        }

        try {
            $quiz->delete();
            return redirect()->route('teacher.quizzes')
                ->with('success', 'Quiz deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('teacher.quizzes')
                ->with('error', 'Error deleting quiz');
        }
    }

    private function getQuestionStatistics()
    {
        $difficulties = ['Easy', 'Medium', 'Hard'];
        $stats = [];
        
        foreach ($difficulties as $difficulty) {
            // Count total questions by difficulty
            $total = QuizQuestion::where('difficulty', $difficulty)->count();
            
            // Get usage statistics (simplified - in real app you'd join tables)
            $used = QuizQuestion::whereHas('question', function($query) use ($difficulty) {
                $query->where('difficulty', $difficulty);
            })->count();
            
            $stats[$difficulty] = [
                'total' => $total,
                'used' => $used,
                'correct' => 0, // Placeholder - you'd calculate from quiz logs
            ];
        }
        
        return $stats;
    }
}