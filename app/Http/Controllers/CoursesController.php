<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CoursesController extends Controller
{
    // List all courses with assignments, progress, and instructor
    public function index()
    {
        return response()->json(
            Course::with(['assignments', 'progress', 'instructor'])->get()
        );
    }

    // Store a new course (instructor is the authenticated user)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Automatically assign the logged-in user as instructor
        $validated['instructor_id'] = Auth::id();

        $course = Course::create($validated);

        return response()->json($course->load(['assignments', 'progress', 'instructor']), 201);
    }

    // Show a single course with nested relations
    public function show(Course $course)
    {
        return response()->json($course->load(['assignments', 'progress', 'instructor']));
    }

    // Update a course (only the instructor can update)
    public function update(Request $request, Course $course)
    {
        // Optional: check if the authenticated user is the instructor
        if ($course->instructor_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course->update($validated);

        return response()->json($course->load(['assignments', 'progress', 'instructor']));
    }

    // Delete a course (only the instructor can delete)
    public function destroy(Course $course)
    {
        if ($course->instructor_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $course->delete();

        return response()->json(['message' => 'Course deleted successfully']);
    }
}
