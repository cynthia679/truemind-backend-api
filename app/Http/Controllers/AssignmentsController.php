<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Course;

class AssignmentsController extends Controller
{
    // List all assignments for a specific course
    public function index(Course $course)
    {
        return response()->json(
            $course->assignments()->with('submissions')->get()
        );
    }

    // Store a new assignment under a specific course
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        $assignment = $course->assignments()->create($validated);

        return response()->json($assignment->load('submissions'), 201);
    }

    // Show a single assignment under a course
    public function show(Course $course, Assignment $assignment)
    {
        if ($assignment->course_id !== $course->id) {
            return response()->json(['message' => 'Assignment not found in this course'], 404);
        }

        return response()->json($assignment->load('submissions'));
    }

    // Update an assignment under a course
    public function update(Request $request, Course $course, Assignment $assignment)
    {
        if ($assignment->course_id !== $course->id) {
            return response()->json(['message' => 'Assignment not found in this course'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'instructions' => 'nullable|string',
            'due_date' => 'sometimes|required|date',
        ]);

        $assignment->update($validated);

        return response()->json($assignment->load('submissions'));
    }

    // Delete an assignment under a course
    public function destroy(Course $course, Assignment $assignment)
    {
        if ($assignment->course_id !== $course->id) {
            return response()->json(['message' => 'Assignment not found in this course'], 404);
        }

        $assignment->delete();

        return response()->json(['message' => 'Assignment deleted successfully']);
    }
}
