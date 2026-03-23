<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    // List all notifications for the authenticated user
    public function index()
    {
        return response()->json(
            Notification::where('user_id', Auth::id())->get()
        );
    }

    // Show a single notification (only if it belongs to the user)
    public function show(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($notification);
    }

    // Update a notification (e.g., mark as read)
    public function update(Request $request, Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'read' => 'required|boolean',
        ]);

        $notification->update($validated);

        return response()->json($notification);
    }
}
