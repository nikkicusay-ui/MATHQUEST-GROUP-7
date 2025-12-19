namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\LearningMaterial;
use App\Models\AcademicSetting;

class ModuleController extends Controller
{
    public function index()
    {
        $teacher = Auth::guard('teacher')->user();

        $settings = AcademicSetting::latest()->first() ?? new AcademicSetting([
            'current_quarter' => '1st',
            'current_week' => 1
        ]);

        $current_material = LearningMaterial::where('teacher_id', $teacher->teacher_id)
            ->where('quarter', $settings->current_quarter)
            ->where('week', $settings->current_week)
            ->latest()
            ->first();

        $materials = LearningMaterial::where('teacher_id', $teacher->teacher_id)
            ->orderByRaw("FIELD(quarter, '1st','2nd','3rd','4th') DESC")
            ->orderByDesc('week')
            ->orderByDesc('created_at')
            ->get();

        return view('teacher.modules', compact(
            'teacher',
            'settings',
            'current_material',
            'materials'
        ));
    }

    public function updateSettings(Request $request)
    {
        $teacher = Auth::guard('teacher')->user();

        $request->validate([
            'current_quarter' => 'required|in:1st,2nd,3rd,4th',
            'current_week' => 'required|integer|min:1|max:52',
        ]);

        AcademicSetting::updateOrCreate(
            [],
            [
                'current_quarter' => $request->current_quarter,
                'current_week' => $request->current_week,
                'updated_by' => $teacher->teacher_id,
            ]
        );

        return back()->with('success', 'Current quarter/week updated successfully!');
    }

    public function upload(Request $request)
    {
        $teacher = Auth::guard('teacher')->user();

        $request->validate([
            'title' => 'required|max:255',
            'quarter' => 'required|in:1st,2nd,3rd,4th',
            'week' => 'required|integer|min:1|max:52',
            'type' => 'required|in:Module,Presentation,Video,Image,Website/Link',
            'file' => 'nullable|file',
            'url' => 'nullable|url'
        ]);

        $file_path = null;
        $url = null;

        if ($request->type === 'Website/Link') {
            $url = $request->url;
        } elseif ($request->hasFile('file')) {
            $file_path = '/storage/' . $request->file('file')->store('learning_materials', 'public');
        }

        LearningMaterial::create([
            'teacher_id' => $teacher->teacher_id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'quarter' => $request->quarter,
            'week' => $request->week,
            'file_path' => $file_path,
            'url' => $url
        ]);

        return back()->with('success', 'Material uploaded successfully!');
    }

    public function edit(Request $request, LearningMaterial $material)
    {
        $teacher = Auth::guard('teacher')->user();

        abort_if($material->teacher_id !== $teacher->teacher_id, 403);

        $request->validate([
            'title' => 'required|max:255',
            'quarter' => 'required|in:1st,2nd,3rd,4th',
            'week' => 'required|integer|min:1|max:52',
            'type' => 'required|in:Module,Presentation,Video,Image,Website/Link',
            'file' => 'nullable|file',
            'url' => 'nullable|url'
        ]);

        $file_path = $material->file_path;
        $url = $material->url;

        if ($request->type === 'Website/Link') {
            $url = $request->url;
            $this->deleteFile($file_path);
            $file_path = null;
        } elseif ($request->hasFile('file')) {
            $this->deleteFile($file_path);
            $file_path = '/storage/' . $request->file('file')->store('learning_materials', 'public');
            $url = null;
        }

        $material->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'quarter' => $request->quarter,
            'week' => $request->week,
            'file_path' => $file_path,
            'url' => $url
        ]);

        return back()->with('success', 'Material updated successfully!');
    }

    public function delete(LearningMaterial $material)
    {
        $teacher = Auth::guard('teacher')->user();

        abort_if($material->teacher_id !== $teacher->teacher_id, 403);

        $this->deleteFile($material->file_path);

        $material->delete();

        return back()->with('success', 'Material deleted successfully!');
    }

    private function deleteFile($path)
    {
        if ($path && Storage::disk('public')->exists(str_replace('/storage/', '', $path))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $path));
        }
    }
}
