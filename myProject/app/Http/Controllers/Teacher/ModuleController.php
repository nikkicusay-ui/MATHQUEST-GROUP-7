<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Teacher;
use App\Models\LearningMaterial;
use App\Models\AcademicSetting;

class ModuleController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();

        $settings = AcademicSetting::latest()->first();
        if (!$settings) {
            $settings = new AcademicSetting([
                'current_quarter' => '1st',
                'current_week' => 1
            ]);
        }

        $current_material = LearningMaterial::where('teacher_id', $teacher->id)
            ->where('quarter', $settings->current_quarter)
            ->where('week', $settings->current_week)
            ->latest()
            ->first();

        $materials = LearningMaterial::where('teacher_id', $teacher->id)
            ->orderByRaw("FIELD(quarter, '1st','2nd','3rd','4th') DESC")
            ->orderBy('week', 'DESC')
            ->orderBy('created_at', 'DESC')
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
        $teacher = Auth::user();

        $request->validate([
            'current_quarter' => 'required|string|in:1st,2nd,3rd,4th',
            'current_week' => 'required|integer|min:1|max:52',
        ]);

        $settings = AcademicSetting::latest()->first();

        if ($settings) {
            $settings->update([
                'current_quarter' => $request->current_quarter,
                'current_week' => $request->current_week,
                'updated_by' => $teacher->id,
            ]);
        } else {
            AcademicSetting::create([
                'current_quarter' => $request->current_quarter,
                'current_week' => $request->current_week,
                'updated_by' => $teacher->id,
            ]);
        }

        return redirect()->back()->with('success', 'Current quarter/week updated successfully!');
    }

    public function upload(Request $request)
    {
        $teacher = Auth::user();

        $request->validate([
            'title' => 'required|string|max:255',
            'quarter' => 'required|string|in:1st,2nd,3rd,4th',
            'week' => 'required|integer|min:1|max:52',
            'type' => 'required|string|in:Module,Presentation,Video,Image,Website/Link',
            'file' => 'nullable|file',
            'url' => 'nullable|url'
        ]);

        $file_path = null;
        $url = null;

        if ($request->type === 'Website/Link') {
            $url = $request->url;
        } else {
            if ($request->hasFile('file')) {
                $file_path = $request->file('file')->store('learning_materials', 'public');
            }
        }

        LearningMaterial::create([
            'teacher_id' => $teacher->id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'quarter' => $request->quarter,
            'week' => $request->week,
            'file_path' => $file_path ? '/storage/' . $file_path : null,
            'url' => $url
        ]);

        return redirect()->back()->with('success', 'Material uploaded successfully!');
    }

    public function edit(Request $request, LearningMaterial $material)
    {
        $teacher = Auth::user();

        if ($material->teacher_id !== $teacher->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'quarter' => 'required|string|in:1st,2nd,3rd,4th',
            'week' => 'required|integer|min:1|max:52',
            'type' => 'required|string|in:Module,Presentation,Video,Image,Website/Link',
            'file' => 'nullable|file',
            'url' => 'nullable|url'
        ]);

        $file_path = $material->file_path;
        $url = $material->url;

        if ($request->type === 'Website/Link') {
            $url = $request->url;
            if ($file_path && Storage::disk('public')->exists(str_replace('/storage/', '', $file_path))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $file_path));
            }
            $file_path = null;
        } elseif ($request->hasFile('file')) {
            if ($file_path && Storage::disk('public')->exists(str_replace('/storage/', '', $file_path))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $file_path));
            }
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

        return redirect()->back()->with('success', 'Material updated successfully!');
    }

    public function delete(LearningMaterial $material)
    {
        $teacher = Auth::user();

        if ($material->teacher_id !== $teacher->id) {
            abort(403);
        }

        if ($material->file_path && Storage::disk('public')->exists(str_replace('/storage/', '', $material->file_path))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $material->file_path));
        }

        $material->delete();

        return redirect()->back()->with('success', 'Material deleted successfully!');
    }
}
