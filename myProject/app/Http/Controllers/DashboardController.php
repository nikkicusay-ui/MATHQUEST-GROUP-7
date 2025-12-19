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
        
        // Calculate class average score - SIMPLIFIED VERSION FOR NOW
        $class_average_score = 0.00;
        
        if ($sections->isNotEmpty()) {
            // For now, we'll use a simple placeholder calculation
            // In a real app, you would have actual quiz scores
            $class_average_score = number_format(75.5, 2); // Placeholder value
        }
        
        // Get recent activities
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
        // Simplified recent activities
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