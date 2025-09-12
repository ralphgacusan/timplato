<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SupportTicket;

class SupportTicketController extends Controller
{
    /**
     * Show the support tickets view
     */
    public function index()
    {
        $tickets = Auth::check()
            ? SupportTicket::where('user_id', Auth::id())->latest()->get()
            : [];

        return view('customer.customer-support', compact('tickets'));
    }

    /**
     * Store a new support ticket
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'open',
        ]);

        return redirect()->back()->with('success', 'Support ticket submitted successfully!');
    }
}
