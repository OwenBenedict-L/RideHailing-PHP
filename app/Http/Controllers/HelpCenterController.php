<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket; 
use Illuminate\Support\Facades\Auth;
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
        
        HelpCenter::create([
            'user_id' => Auth::id(),
            'jenis_keluhan' => $request->jenis_keluhan, 
            'isi_keluhan' => $request->isi_keluhan,
            'status' => 'pending'
        ]);

        return "
            <div style='text-align: center; margin-top: 50px; font-family: sans-serif;'>
                <h2>Thank you for your feedback.</h2>
                <p>Please be patient, our team will respond to your feedback ASAP.</p>
                <br>
                
                <a href='" . route('dashboard.user') . "'>
                    <button style='padding: 10px 20px; cursor: pointer;'>Return to Dashboard</button>
                </a>
            </div>
        ";
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

        return view('helpcenter.chat', compact('tiket'));
    }

    public function sendReply(Request $request, $id)
    {
        $pesanBaru = $request->pesan;
        return "
            <div style='font-family: sans-serif; padding: 20px;'>
                <h3 style='color: green;'>Pesan Berhasil Terkirim!</h3>
                <p>Tiket ID: <strong>$id</strong></p>
                <p>Isi Pesan: <em>$pesanBaru</em></p>
                <br>
                <a href='" . route('helpcenter.history') . "' style='text-decoration: none;'>
                    <button type='button' style='padding: 5px 15px; cursor: pointer;'>Kembali ke History</button>
                </a>
            </div>";
    }
}

