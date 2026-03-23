<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;

class SubmissionsController extends Controller
{
    // List all submissions for a specific assignment
    public function index(Assignment $assignment)
    {
        return response()->json(
            $assignment->submissions()->with('student')->get()
        );
    }

    // Store a submission under a specific assignment (student only)
    public function store(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $validated['student_id'] = Auth::id();

        $submission = $assignment->submissions()->create($validated);

        return response()->json($submission->load('student'), 201);
    }

    // Show a specific submission for a specific assignment
    public function show(Assignment $assignment, Submission $submission)
    {
        if ($submission->assignment_id !== $assignment->id) {
            return response()->json(['message' => 'Submission not found in this assignment'], 404);
        }

        return response()->json($submission->load('student', 'assignment'));
    }

    // Update a submission (student only) for a specific assignment
    public function update(Request $request, Assignment $assignment, Submission $submission)
    {
        if ($submission->assignment_id !== $assignment->id) {
            return response()->json(['message' => 'Submission not found in this assignment'], 404);
        }

        if ($submission->student_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $submission->update($validated);

        return response()->json($submission->load('student'));
    }

    // Delete a submission (student only) for a specific assignment
    public function destroy(Assignment $assignment, Submission $submission)
    {
        if ($submission->assignment_id !== $assignment->id) {
            return response()->json(['message' => 'Submission not found in this assignment'], 404);
        }

        if ($submission->student_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $submission->delete();

        return response()->json(['message' => 'Submission deleted successfully']);
    }
}
