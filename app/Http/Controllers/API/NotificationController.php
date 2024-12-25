<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;

use Illuminate\Http\Request;



class NotificationController extends Controller
{
    public function index($id)
    {
        $notifications = Notification::where('user_id', $id)
            ->with('affectation')
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
