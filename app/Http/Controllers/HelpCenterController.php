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

        $tickets = Ticket::where('user_id', Auth::id())->get();
        

        return view('helpcenter.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        $jenis = $request->jenis_keluhan;
        if ($jenis === 'lainnya') {
            $jenis = $request->jenis_keluhan_lainnya;
        }
        
        $tiketBaru = HelpCenter::create([
            'user_id' => Auth::id(),
            'subject' => $jenis,
            'status' => 'OPEN'
        ]);

        \App\Models\TicketMessage::create([
            'ticket_id' => $tiketBaru->id,
            'sender_type' => 'CUSTOMER',
            'message' => $request->isi_keluhan
        ]);
        return redirect()->route('helpcenter.history');
    }

    public function history()
    {
        $keluhan = HelpCenter::where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')->get();

        return view('helpcenter.history', compact('keluhan'));
    }
    

    public function chat($id)
    {
        $tiket = HelpCenter::findOrFail($id);

        $riwayatChat = TicketMessage::where('ticket_id', $id)
                                    ->orderBy('created_at', 'asc')
                                    ->get();

        return view('helpcenter.chat', compact('tiket', 'riwayatChat'));
    }

    public function sendReply(Request $request, $id)
    {
        $tiket = HelpCenter::findOrFail($id);
        TicketMessage::create([
            'ticket_id' => $id,
            'sender_type' => 'CUSTOMER',
            'message' => $request->pesan
        ]);

        return redirect()->back(); 
    }

}

