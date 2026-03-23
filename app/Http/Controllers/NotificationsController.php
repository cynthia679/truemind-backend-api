<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationsController extends Controller
{
    public function index()
    {
        // List all notifications with nested user
        return response()->json(Notification::with('user')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string|max:50',
            'message' => 'required|string',
            'read' => 'sometimes|boolean'
        ]);

        $notification = Notification::create($validated);

        // Return notification with nested user
        return response()->json($notification->load('user'), 201);
    }

    public function show($id)
    {
        // Show single notification with nested user
        return response()->json(Notification::with('user')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'type' => 'sometimes|required|string|max:50',
            'message' => 'sometimes|required|string',
            'read' => 'sometimes|boolean'
        ]);

        $notification->update($validated);

        // Return updated notification with nested user
        return response()->json($notification->load('user'));
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json(['message' => 'Notification deleted successfully']);
    }
}
