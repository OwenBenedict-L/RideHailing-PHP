<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = UserNotification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $notification = UserNotification::findOrFail($id);

        if ($notification->user_id !== Auth::guard('user')->id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$notification->is_read) {
            $notification->update(['is_read' => true]);
        }

        $userNotification = $notification;
        return view('notifications.show', compact('userNotification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $notification = UserNotification::findOrFail($id);

        if ($notification->user_id !== Auth::guard('user')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'is_read' => 'required|boolean',
        ]);

        $notification->update($request->only('is_read'));

        return redirect()->route('notifications.index')->with('success', 'Notification marked as read.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $notification = UserNotification::findOrFail($id);

        if ($notification->user_id !== Auth::guard('user')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $notification->delete();

        return redirect()->route('notifications.index')->with('success', 'Notification deleted from your inbox.');
    }
}
