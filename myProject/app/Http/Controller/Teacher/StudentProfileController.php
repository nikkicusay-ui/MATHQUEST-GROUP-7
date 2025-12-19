namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;

class TeacherAuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('auth.teacher-login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $teacher = Teacher::where('email', $request->email)->first();

        if (!$teacher || !Hash::check($request->password, $teacher->password_hash)) {
            return back()
                ->withErrors(['email' => 'Invalid email or password.'])
                ->withInput($request->only('email'));
        }

        Auth::guard('teacher')->login($teacher, $request->boolean('remember'));

        return redirect()
            ->route('teacher.dashboard')
            ->with('success', "Welcome {$teacher->first_name} {$teacher->last_name}!");
    }

    // Show signup form
    public function showSignup()
    {
        return view('auth.teacher-register');
    }

    // Handle signup
    public function signup(Request $request)
    {
        $request->validate([
            'firstname'  => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname'   => 'required|string|max:255',
            'position'   => 'required|string|max:255',
            'email'      => 'required|email|unique:teachers,email',
            'password'   => 'required|min:6|confirmed',
            'terms'      => 'accepted',
        ]);

        $teacher = Teacher::create([
            'first_name'    => $request->firstname,
            'middle_name'   => $request->middlename,
            'last_name'     => $request->lastname,
            'position'      => $request->position,
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password),
        ]);

        Auth::guard('teacher')->login($teacher);

        return redirect()
            ->route('teacher.dashboard')
            ->with('success', "Welcome {$teacher->first_name} {$teacher->last_name}, your account has been created!");
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::guard('teacher')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('teacher.login');
    }
}
