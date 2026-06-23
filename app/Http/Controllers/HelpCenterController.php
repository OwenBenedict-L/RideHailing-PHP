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
        
        if ($isDriver) {
            $tickets = Ticket::where('driver_id', Auth::guard('driver')->id())->get();
        } else {
            $tickets = Ticket::where('user_id', Auth::id())->get();
        }
        
        return view('helpcenter.index', compact('tickets'));
    } 

    public function store(Request $request)
    {
        $isDriver = Auth::guard('driver')->check();

        if ($isDriver) {
            $TotalTicketOpen = Ticket::where('driver_id', Auth::guard('driver')->id())
                                    ->where('status', 'OPEN')
                                    ->count();
        } else {
            $TotalTicketOpen = Ticket::where('user_id', Auth::id())
                                    ->where('status', 'OPEN')
                                    ->count();
        }                          

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

        $ticketData = [
            'subject' => $type, 
            'status' => 'OPEN'
        ];

        if ($isDriver) {
            $ticketData['driver_id'] = Auth::guard('driver')->id();
        } else {
            $ticketData['user_id'] = Auth::id(); 
        }

        $NewTicket = Ticket::create($ticketData);

        TicketMessage::create([
            'ticket_id' => $NewTicket->id,
            'sender_type' => 'CUSTOMER',
            'message' => $request->isi_keluhan
        ]);
        
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
        if ($isDriver) {
            return redirect()->route('driver.helpcenter.feedback')->with('success', 'Ticket created!');
        } else {
            return redirect()->route('helpcenter.feedback')->with('success', 'Ticket created!');
        }
    }

    public function feedbackPage()
    {
        return view('helpcenter.feedback'); 
    }
    
    public function history()
    {
        $isDriver = Auth::guard('driver')->check();

        if ($isDriver) {
            $keluhan = Ticket::where('driver_id', Auth::guard('driver')->id())
                             ->orderBy('created_at', 'desc')->get();
        } else {
            $keluhan = Ticket::where('user_id', Auth::id())
                             ->orderBy('created_at', 'desc')->get();
        }

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

        $prizes = ['Promo Diskon 10%', 'Cashback Rp 5.000', 'Voucher Gratis Ongkir', 'Zonk'];
        $gachaResult = $prizes[array_rand($prizes)];
        
        if ($gachaResult !== 'Zonk') {
            session()->flash('gacha_prize', 'Selamat! Dari interaksi ini kamu mendapatkan: ' . $gachaResult);
        }

        return redirect()->back(); 
    }
}