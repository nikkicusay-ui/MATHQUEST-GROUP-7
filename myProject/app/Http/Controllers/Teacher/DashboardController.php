<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Section;
use App\Models\Student;
use App\Models\LearningMaterial;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated teacher
        $teacher = Auth::guard('teacher')->user();
        
        if (!$teacher) {
            return redirect()->route('teacher.login');
        }

        // Get teacher details
        $teacher_name = $teacher->first_name . ' ' . $teacher->last_name;
        $sidebar_initials = strtoupper(substr($teacher->first_name, 0, 1) . substr($teacher->last_name, 0, 1));
        
        // Get sections created by this teacher
        $sections = Section::where('teacher_id', $teacher->teacher_id)
                          ->where('archived', 0)
                          ->get();
        
        // Count total students in all sections
        $students_count = Student::whereIn('section_id', $sections->pluck('section_id'))->count();
        
        // Count learning materials
        $materials_count = LearningMaterial::where('teacher_id', $teacher->teacher_id)->count();
        
        // Count quizzes
        $quizzes_count = Quiz::where('teacher_id', $teacher->teacher_id)->count();
        
        // Calculate class average score
        $class_average_score = 0.00;
        
        if ($sections->isNotEmpty()) {
            $section_ids = $sections->pluck('section_id');
            
            $average_score = DB::table('student_quizzes as sq')
                ->join('students as st', 'sq.student_id', '=', 'st.student_id')
                ->join('quiz_attempts as qa', function($join) {
                    $join->on('sq.student_id', '=', 'qa.student_id')
                         ->on('sq.quiz_id', '=', 'qa.quiz_id');
                })
                ->whereIn('st.section_id', $section_ids)
                ->whereNotNull('sq.score')
                ->where('qa.is_completed', 1)
                ->select(DB::raw('AVG((sq.score / (SELECT SUM(points) FROM questions q JOIN quiz_questions qq ON q.question_id = qq.question_id WHERE qq.quiz_id = sq.quiz_id)) * 100) as avg_score'))
                ->first();
            
            if ($average_score && $average_score->avg_score !== null) {
                $class_average_score = number_format((float)$average_score->avg_score, 2);
            }
        }
        
        // Get recent activities (we'll create a helper for this)
        $recent_activities = $this->getRecentActivities($teacher->teacher_id);
        
        return view('teacher.dashboard', compact(
            'teacher',
            'teacher_name',
            'sidebar_initials',
            'sections',
            'students_count',
            'materials_count',
            'quizzes_count',
            'class_average_score',
            'recent_activities'
        ));
    }
    
    private function getRecentActivities($teacher_id)
    {
        // This is a simplified version. In a real app, you'd query actual activities
        return [
            [
                'icon' => 'fa-user-plus',
                'title' => 'New Student Added',
                'desc' => 'Added a new student to Grade 3 - Section A',
                'time' => '2 hours ago'
            ],
            [
                'icon' => 'fa-clipboard-check',
                'title' => 'Quiz Created',
                'desc' => 'Created a new quiz: Basic Addition',
                'time' => '1 day ago'
            ],
            [
                'icon' => 'fa-book',
                'title' => 'Material Uploaded',
                'desc' => 'Uploaded a new learning material: Multiplication',
                'time' => '2 days ago'
            ],
            [
                'icon' => 'fa-chart-line',
                'title' => 'Report Generated',
                'desc' => 'Generated quarterly progress report',
                'time' => '3 days ago'
            ],
        ];
    }
}