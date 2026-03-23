<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    // List all progress records for the logged-in student
    public function index()
    {
        $studentId = Auth::id();
        $progress = Progress::where('student_id', $studentId)->get();

        return response()->json($progress);
    }

    // Show progress for a specific course
    public function showByCourse($courseId)
    {
        $studentId = Auth::id();

        $progress = Progress::where('student_id', $studentId)
                            ->where('course_id', $courseId)
                            ->firstOrFail();

        return response()->json($progress);
    }

    // Update progress for a specific course
    public function updateByCourse(Request $request, $courseId)
    {
        $studentId = Auth::id();

        $progress = Progress::where('student_id', $studentId)
                            ->where('course_id', $courseId)
                            ->firstOrFail();

        $validated = $request->validate([
            'completion_percentage' => 'nullable|numeric|min:0|max:100',
            'score' => 'nullable|numeric|min:0|max:100',
            // add any other progress fields
        ]);

        $progress->update($validated);

        return response()->json($progress);
    }
}
