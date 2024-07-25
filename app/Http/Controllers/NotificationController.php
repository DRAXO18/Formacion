<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function fetchNotifications()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->take(5) // Limita a las últimas 5 notificaciones, ajusta según necesites
            ->get();

        return response()->json(['notifications' => $notifications]);
    }
}