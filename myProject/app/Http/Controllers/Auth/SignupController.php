<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignupController extends Controller
{
    public function showSignupForm()
    {
        return view('auth.signup');
    }

    public function signup(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:50',
            'middlename' => 'nullable|string|max:50',
            'lastname' => 'required|string|max:50',
            'position' => 'required|string|max:50',
            'email' => 'required|email|unique:teachers,email|max:100',
            'password' => 'required|min:8|confirmed',
            'terms' => 'required|accepted',
        ], [
            'email.unique' => 'Email already registered.',
            'terms.accepted' => 'You must agree to the terms and conditions.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create teacher
        $teacher = Teacher::create([
            'first_name' => $request->firstname,
            'middle_name' => $request->middlename,
            'last_name' => $request->lastname,
            'position' => $request->position,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
        ]);

        // Flash success message with teacher name
        $successMessage = "Congratulations {$request->firstname} {$request->lastname}! Your account has been created successfully.";

        return view('auth.signup', [
            'success' => $successMessage,
            'teacher' => $teacher,
        ]);
    }
}