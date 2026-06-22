<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Driver;

class CsController extends Controller
{
    public function dashboard()
    {
        return view('cs.dashboard');
    }

    public function users()
    {
        $users = User::all();
        $drivers = Driver::all();

        return view('cs.users', compact('users', 'drivers'));
    }
    public function chat($id)
    {
        $ticket = \App\Models\Ticket::findOrFail($id);

        if ($ticket->status === 'RESOLVED') {
            return redirect()->route('cs.users'); 
        }

        $chatHistory = \App\Models\TicketMessage::where('ticket_id', $id)
                                                ->orderBy('created_at', 'asc')
                                                ->get();

        return view('cs.chat', compact('ticket', 'chatHistory'));
    }

    public function complete($id)
    {
        $ticket = \App\Models\Ticket::findOrFail($id);

        $ticket->status = 'RESOLVED'; 
        $ticket->save();

        return redirect()->route('cs.users');
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'pesan' => 'required|string',
        ]);

        \App\Models\TicketMessage::create([
            'ticket_id'   => $id,
            'sender_type' => 'CS', 
            'message'     => $request->pesan,
        ]);
        return redirect()->back();
    }
}

