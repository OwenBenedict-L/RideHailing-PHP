<?php

namespace App\Http\Controllers;

use App\Models\DriverNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = DriverNotification::where('driver_id', Auth::guard('driver')->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('driver_notifications.index', compact('notifications'));
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
    public function show(DriverNotification $driverNotification)
    {
        if ($driverNotification->driver_id !== Auth::guard('driver')->id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$driverNotification->is_read) {
            $driverNotification->update(['is_read' => true]);

            $driverNotification->refresh();
            
        }

        return view('driver_notifications.show', compact('driverNotification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DriverNotification $driverNotification)
    {
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DriverNotification $driverNotification)
    {
        if ($driverNotification->driver_id !== Auth::guard('driver')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'is_read' => 'required|boolean',
        ]);

        $driverNotification->update($request->only('is_read'));

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DriverNotification $driverNotification)
    {
        if ($driverNotification->driver_id !== Auth::guard('driver')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $driverNotification->delete();

        return redirect()->route('driver-notifications.index')->with('success', 'Notification deleted successfully.');
    }

    public function markAllRead()
    {
        DriverNotification::where('driver_id', Auth::guard('driver')->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function deleteAll()
    {
        DriverNotification::where('driver_id', Auth::guard('driver')->id())->delete();

        return redirect()->back()->with('success', 'All notifications deleted successfully.');
    }
}
