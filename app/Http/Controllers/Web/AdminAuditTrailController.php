<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\User; 
use Illuminate\Http\Request;

class AdminAuditTrailController extends Controller
{
    public function index(Request $request)
    {
        $admins = User::where('role', 'admin')->get(); // get only admins

        $logs = AdminLog::with('admin')
            ->when($request->action, fn($q) => $q->where('action', $request->action))
            ->when($request->admin_id, fn($q) => $q->where('admin_id', $request->admin_id)) // filter by selected admin
            ->when($request->search, fn($q) =>
                $q->whereHas('admin', fn($q2) =>
                    $q2->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%')
                )
            )
            ->orderBy('created_at', $request->sort === 'oldest' ? 'asc' : 'desc')
            ->paginate(10);

        return view('admin.audit-trail', compact('logs', 'admins'));
    }
}
