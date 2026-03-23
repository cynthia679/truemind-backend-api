<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CoursesController extends Controller
{
    public function index()
    {
        // List all courses with nested assignments and progress
        return response()->json(Course::with(['assignments', 'progress', 'instructor'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor_id' => 'required|exists:users,id'
        ]);

        $course = Course::create($validated);

        // Return created course with nested relations
        return response()->json($course->load(['assignments', 'progress', 'instructor']), 201);
    }

    public function show($id)
    {
        // Show single course with nested assignments and progress
        return response()->json(Course::with(['assignments', 'progress', 'instructor'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'instructor_id' => 'sometimes|required|exists:users,id'
        ]);

        $course->update($validated);

        // Return updated course with nested relations
        return response()->json($course->load(['assignments', 'progress', 'instructor']));
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json(['message' => 'Course deleted successfully']);
    }
}
