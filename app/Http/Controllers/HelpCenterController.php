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
}