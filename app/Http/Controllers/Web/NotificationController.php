<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    
    public function showNotifications()
{
    // Get all notifications for the logged-in user, newest first
    $notifications = Notification::where('user_id', Auth::id())
                                 ->orderBy('created_at', 'desc')
                                 ->get();

    return view('customer.user-profile', compact('notifications'));
}
}
