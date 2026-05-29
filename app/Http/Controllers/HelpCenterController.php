<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket; 
use Illuminate\Support\Facades\Auth;

class HelpCenterController extends Controller
{
    public function index()
    {

        $tickets = Ticket::where('user_id', Auth::id())->get();
        

        return view('helpcenter.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        return "
            <div style='text-align: center; margin-top: 50px; font-family: sans-serif;'>
                <h2>Terima kasih atas feedback anda.</h2>
                <p>Mohon bersabar, pihak kami akan segera membalas terkait respon anda.</p>
                <br>
                
                <a href='" . route('dashboard.user') . "'>
                    <button style='padding: 10px 20px; cursor: pointer;'>Kembali ke Dashboard</button>
                </a>
            </div>
        ";
    }
        
}

