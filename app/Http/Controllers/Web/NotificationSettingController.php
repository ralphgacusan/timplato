<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotificationSetting;
use App\Models\User; // ✅ Add this line
use App\Models\Notification; // ✅ Also needed for sending notifications

class NotificationSettingController extends Controller
{
    // Show all notification settings + manual send form
    public function index()
    {
        $settings = NotificationSetting::all();
        $users = User::select('id', 'first_name', 'last_name', 'email')->get();

        return view('admin.notification-settings', compact('settings', 'users'));
    }

    // Toggle automated notification setting
    public function toggle(Request $request, NotificationSetting $setting)
    {
        $setting->update(['enabled' => !$setting->enabled]);

        return redirect()->back()->with('success', "{$setting->label} setting updated.");
    }

    // Send manual notification
    public function sendManual(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'send_to_all' => 'nullable|boolean',
        ]);

        if ($request->send_to_all) {
            $users = User::all();
            foreach ($users as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => $request->title,
                    'message' => $request->message,
                ]);
            }
        } else {
            Notification::create([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'message' => $request->message,
            ]);
        }

        return redirect()->back()->with('success', 'Notification sent successfully.');
    }
}
