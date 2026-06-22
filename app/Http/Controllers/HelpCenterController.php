<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket; 
use Illuminate\Support\Facades\Auth;
use App\Models\TicketMessage;
use App\Models\HelpCenter;

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

        $tpye = $request->jenis_keluhan;
        if ($type === 'others') {
            $type = $request->jenis_keluhan_lainnya;
        }
        
        $NewTicket = Ticket::create([
            'user_id' => Auth::id(),
            'subject' => $jenis,
            'status' => 'OPEN'
        ]);

        TicketMessage::create([
            'ticket_id' => $tiketBaru->id,
            'sender_type' => 'CUSTOMER',
            'message' => $request->isi_keluhan
        ]);
        return redirect()->route('helpcenter.feedback');
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

