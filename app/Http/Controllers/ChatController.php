<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Models\Driver;
use App\Models\UserNotification;
use App\Models\DriverNotification;
use Illuminate\Http\Request;
use App\Models\Booking;

class ChatController extends Controller
{
    public function storeForUser(Request $request, $driverId)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $currentUser = auth('user')->id();

        $activeBooking = Booking::where('user_id', $currentUser)
            ->where('driver_id', $driverId)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->latest()
            ->first();

        Chat::create([
            'booking_id'         => $activeBooking ? $activeBooking->id : null,
            'senderUser_id'      => auth('user')->id(),
            'receiverDriver_id'  => $driverId,
            'message'            => $request->message
        ]);

        $userName = auth('user')->user()->name ?? 'Passenger';

        DriverNotification::create([
            'driver_id' => $driverId,
            'type'      => 'chat',
            'title'     => 'New Message from Passenger 💬',
            'message'   => $userName . ' said: "' . \Illuminate\Support\Str::limit($request->message, 40) . '"',
            'is_read'   => false
        ]);

        return back();
    }

    public function storeForDriver(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $currentDriver = auth('driver')->id();

        $activeBooking = Booking::where('driver_id', $currentDriver)
            ->where('user_id', $userId)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->latest()
            ->first();

        Chat::create([
            'booking_id'      => $activeBooking ? $activeBooking->id : null,
            'senderDriver_id' => auth('driver')->id(),
            'receiverUser_id' => $userId,
            'message'         => $request->message
        ]);

        $driverName = auth('driver')->user()->name ?? 'Driver';
        
        UserNotification::create([
            'user_id' => $userId,
            'type'    => 'chat',
            'title'   => 'New Message from Driver 💬',
            'message' => $driverName . ' said: "' . \Illuminate\Support\Str::limit($request->message, 40) . '"',
            'is_read' => false
        ]);

        return back();
    }

    public function showConversationForUser($driverId)
    {
        $currentUser = auth('user')->id();
        $contact = Driver::findOrFail($driverId);

        $activeBooking = Booking::where('user_id', $currentUser)
            ->where('driver_id', $driverId)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->latest()
            ->first();

        if (!$activeBooking) {
            $chat = collect();
            return view('chats.show', compact('chat', 'contact'));
        }

        $chat = Chat::where('booking_id', $activeBooking->id)
            ->orderBy('created_at')
            ->get();

        return view('chats.show', compact('chat', 'contact'));
    }

    public function showConversationForDriver($userId)
    {
        $currentDriver = auth('driver')->id();
        $contact = User::findOrFail($userId);

        $activeBooking = Booking::where('driver_id', $currentDriver)
            ->where('user_id', $userId)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->latest()
            ->first();

        if (!$activeBooking) {
            $chat = collect();
            return view('chats.show', compact('chat', 'contact'));
        }

        $chat = Chat::where('booking_id', $activeBooking->id)
            ->orderBy('created_at')
            ->get();

        return view('chats.show', compact('chat', 'contact'));
    }

    public function updateChatUser(Request $request, $driverId, $chatId) 
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);
    
        $chat = Chat::where('id', $chatId)
            ->where('senderUser_id', auth('user')->id())
            ->where('receiverDriver_id', $driverId) 
            ->firstOrFail();
    
        $chat->update([
            'message' => $request->message, 
            'is_edited' => true
        ]);

        return back()->with('success', 'Message updated.');
    }

    public function updateChatDriver(Request $request, $userId, $chatId) 
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $chat = Chat::where('id', $chatId)
            ->where('senderDriver_id', auth('driver')->id())
            ->where('receiverUser_id', $userId)
            ->firstOrFail();
    
        $chat->update([
            'message' => $request->message, 
            'is_edited' => true
        ]);

        return back()->with('success', 'Message updated.');
    }

    public function deleteChatUser($driverId, $chatId) 
    {
        $chat = Chat::where('id', $chatId)
            ->where('senderUser_id', auth('user')->id())
            ->where('receiverDriver_id', $driverId)
            ->firstOrFail();
            
        $chat->delete();
        return back()->with('success', 'Message deleted.');
    }

    public function deleteChatDriver($userId, $chatId) 
    {
        $chat = Chat::where('id', $chatId)
            ->where('senderDriver_id', auth('driver')->id())
            ->where('receiverUser_id', $userId)
            ->firstOrFail();
            
        $chat->delete();
        return back()->with('success', 'Message deleted.');
    }
};