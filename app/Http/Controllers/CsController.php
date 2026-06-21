<?php

namespace App\Http\Controllers;

use App\Models\User;

class CsController extends Controller
{
    public function dashboard()
    {
        return view('cs.dashboard');
    }

    public function showAllUsers()
    {
        $users = User::all(); 

        return view('cs.user_list', compact('users'));
    }
}

