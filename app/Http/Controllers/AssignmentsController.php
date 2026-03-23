<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;

class AssignmentsController extends Controller
{
    public function index()
    {
        // List all assignments with nested course and submissions
        return response()->json(Assignment::with(['course', 'submissions'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'due_date' => 'required|date',
        ]);

        $assignment = Assignment::create($validated);

        // Return created assignment with nested relations
        return response()->json($assignment->load(['course', 'submissions']), 201);
    }

    public function show($id)
    {
        // Show single assignment with nested relations
        return response()->json(Assignment::with(['course', 'submissions'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'instructions' => 'nullable|string',
            'course_id' => 'sometimes|required|exists:courses,id',
            'due_date' => 'sometimes|required|date',
        ]);

        $assignment->update($validated);

        // Return updated assignment with nested relations
        return response()->json($assignment->load(['course', 'submissions']));
    }

    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();

        return response()->json(['message' => 'Assignment deleted successfully']);
    }
}
