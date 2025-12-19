<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Please enter your email address.',
            'password.required' => 'Please enter your password.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Find teacher by email
        $teacher = Teacher::where('email', $request->email)->first();

        // Check if teacher exists and password is correct
        if ($teacher && Hash::check($request->password, $teacher->password_hash)) {
            // Log in the teacher
            Auth::guard('teacher')->login($teacher, $request->has('remember_me'));
            
            // Store teacher info in session
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

        // Authentication failed
        return redirect()->back()
            ->with('error', 'Invalid email or password.')
            ->withInput();
    }

    public function sendResetLink(Request $request)
    {
        // Validate email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:teachers,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Email not found in our records.',
            ]);
        }

        // In a real app, you would send a password reset email here
        // For now, we'll just return a success message
        
        return response()->json([
            'success' => true,
            'message' => 'Password reset instructions have been sent to your email.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('teacher')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}