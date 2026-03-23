<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;

class ProgressController extends Controller
{
    public function index()
    {
        // List all progress with nested course and student
        return response()->json(Progress::with(['course', 'student'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'student_id' => 'required|exists:users,id',
            'completion_percentage' => 'required|numeric|min:0|max:100'
        ]);

        $progress = Progress::create($validated);

        // Return progress with nested relations
        return response()->json($progress->load(['course', 'student']), 201);
    }

    public function show($id)
    {
        // Show single progress with nested course and student
        return response()->json(Progress::with(['course', 'student'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $progress = Progress::findOrFail($id);

        $validated = $request->validate([
            'course_id' => 'sometimes|required|exists:courses,id',
            'student_id' => 'sometimes|required|exists:users,id',
            'completion_percentage' => 'sometimes|required|numeric|min:0|max:100'
        ]);

        $progress->update($validated);

        // Return updated progress with nested relations
        return response()->json($progress->load(['course', 'student']));
    }

    public function destroy($id)
    {
        $progress = Progress::findOrFail($id);
        $progress->delete();

        return response()->json(['message' => 'Progress deleted successfully']);
    }
}
