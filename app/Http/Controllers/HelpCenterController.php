<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket; 
use Illuminate\Support\Facades\Auth;
use App\Models\TicketMessage;
use App\Models\HelpCenter;
use App\Models\UserNotification;
use App\Models\DriverNotification;

class HelpCenterController extends Controller
{

    public function index()
    {
        $isDriver = Auth::guard('driver')->check();
        $tickets = Ticket::where('user_id', Auth::id())->get();
        if ($isDriver) {
            $tickets = Ticket::where('driver_id', Auth::guard('driver')->id())->get();
        }
        return view('helpcenter.index', compact('tickets'));
    } 

    public function store(Request $request)
    {
        $TotalTicketOpen = Ticket::where('user_id', Auth::id())
                                    ->where('status', 'OPEN')
                                    ->count();

        if ($TotalTicketOpen >= 1) {
            return redirect()->back()
                ->withErrors(['ticket_limit' => 'max 1 tickets at the time'])
                ->withInput(); 
        }

        $request->validate([
            'jenis_keluhan' => 'required|string',
            'isi_keluhan' => 'required|string',
            'jenis_keluhan_lainnya' => 'required_if:jenis_keluhan,lainnya|string|nullable' 
        ]);


        $type = $request->jenis_keluhan;
        

        if ($type === 'lainnya') {
            $type = $request->jenis_keluhan_lainnya;
        }
        
        $NewTicket = Ticket::create([
            'user_id' => Auth::id(),
            'subject' => $type, 
            'status' => 'OPEN'
        ]);

        TicketMessage::create([
            'ticket_id' => $NewTicket->id,
            'sender_type' => 'CUSTOMER',
            'message' => $request->isi_keluhan
        ]);
        
        $jenis = str_replace('_', ' ', $request->jenis_keluhan);
        if ($request->jenis_keluhan === 'lainnya') {
            $jenis = $request->jenis_keluhan_lainnya;
        }

        $jenis = str_replace('_', ' ', $request->jenis_keluhan);
        if ($request->jenis_keluhan === 'lainnya') {
            $jenis = $request->jenis_keluhan_lainnya;
        }

        if (Auth::guard('user')->check()) {
            UserNotification::create([
                'user_id' => Auth::id(),
                'type'    => 'help',
                'title'   => 'Support Ticket Created 🛠️',
                'message' => 'Your ticket regarding "' . $jenis . '" has been received. Our team will review it and get back to you as soon as possible.',
                'is_read' => false
            ]);
        } elseif (Auth::guard('driver')->check()) {
            DriverNotification::create([
                'driver_id' => Auth::guard('driver')->id(),
                'type'    => 'help',
                'title'   => 'Support Ticket Created 🛠️',
                'message' => 'Your ticket regarding "' . $jenis . '" has been received. Our team will review it and get back to you as soon as possible.',
                'is_read' => false
            ]);
        }

        return redirect()->route('helpcenter.feedback')->with('success', 'Ticket created!');
    }

    public function feedbackPage()
    {
        return view('helpcenter.feedback'); 
    }
    
    public function history()
    {
        $keluhan = Ticket::where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')->get();

        return view('helpcenter.history', compact('keluhan'));
    }
    
    public function chat($id)
    {
        $tiket = Ticket::findOrFail($id);

        $riwayatChat = TicketMessage::where('ticket_id', $id)
                                    ->orderBy('created_at', 'asc')
                                    ->get();

        return view('helpcenter.chat', compact('tiket', 'riwayatChat'));
    }

    public function sendReply(Request $request, $id)
    {
        $tiket = Ticket::findOrFail($id);
        TicketMessage::create([
            'ticket_id' => $id,
            'sender_type' => 'CUSTOMER',
            'message' => $request->pesan
        ]);

        return redirect()->back(); 
    }
}