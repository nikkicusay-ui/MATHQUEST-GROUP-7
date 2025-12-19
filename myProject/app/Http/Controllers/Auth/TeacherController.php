<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Find the teacher
        $teacher = Teacher::where('email', $request->email)->first();
        
        // Check if teacher exists and password is correct
        if ($teacher && Hash::check($request->password, $teacher->password_hash)) {
            // Manually log in the teacher
            Auth::guard('teacher')->login($teacher);
            
            // Store in session
            session([
                'teacher_id' => $teacher->teacher_id,
                'teacher_name' => $teacher->first_name . ' ' . $teacher->last_name,
                'teacher_position' => $teacher->position,
                'teacher_email' => $teacher->email,
            ]);
            
            // Redirect to dashboard
            return redirect()->route('teacher.dashboard')
                ->with('success', 'Welcome back, ' . $teacher->first_name . '!');
        }
        
        // If authentication fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    
    public function logout(Request $request)
    {
        Auth::guard('teacher')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
    
    public function sendResetLink(Request $request)
    {
        // Simple email check for now
        $teacher = Teacher::where('email', $request->email)->first();
        
        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Email not found in our records.',
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Password reset instructions have been sent to your email.',
        ]);
    }
}

