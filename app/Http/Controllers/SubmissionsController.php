<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;

class SubmissionsController extends Controller
{
    public function index()
    {
        // List all submissions with nested assignment and student
        return response()->json(Submission::with(['assignment', 'student'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'student_id' => 'required|exists:users,id',
            'content' => 'nullable|string',
            'submitted_at' => 'nullable|date',
        ]);

        $submission = Submission::create($validated);

        // Return created submission with nested relations
        return response()->json($submission->load(['assignment', 'student']), 201);
    }

    public function show($id)
    {
        // Show single submission with nested relations
        return response()->json(Submission::with(['assignment', 'student'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);

        $validated = $request->validate([
            'assignment_id' => 'sometimes|required|exists:assignments,id',
            'student_id' => 'sometimes|required|exists:users,id',
            'content' => 'nullable|string',
            'submitted_at' => 'nullable|date',
        ]);

        $submission->update($validated);

        // Return updated submission with nested relations
        return response()->json($submission->load(['assignment', 'student']));
    }

    public function destroy($id)
    {
        $submission = Submission::findOrFail($id);
        $submission->delete();

        return response()->json(['message' => 'Submission deleted successfully']);
    }
}
