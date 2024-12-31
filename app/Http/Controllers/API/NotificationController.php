<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;

use Illuminate\Http\Request;



class NotificationController extends Controller
{
    public function index($id)
    {
        $tenDaysAgo = now()->subDays(10);

        // Fetch notifications from the last 10 days
        $notifications = Notification::where('user_id', $id)
            ->where('created_at', '>=', $tenDaysAgo) // Filter notifications from the last 10 days
            ->with(['affectation.client']) // Eager load affectation and its related client
            ->orderBy('created_at', 'desc')
            ->paginate(10); // 10 items per page

        return response()->json($notifications);
    }

    public function markAsRead(Request $request)
    {
        $notification = Notification::findOrFail($request->notification_id);

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
