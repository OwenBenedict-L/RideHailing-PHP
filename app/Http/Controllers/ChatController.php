<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Models\Bookings;

class ChatController extends Controller
{
    public function storeForUser(Request $request, $driverId)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        Chat::create([
            'senderUser_id'      => auth('user')->id(),
            'receiverDriver_id'  => $driverId,
            'message'            => $request->message
        ]);

        return back();
    }

    public function storeForDriver(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        Chat::create([
            'senderDriver_id' => auth('driver')->id(),
            'receiverUser_id' => $userId,
            'message'         => $request->message
        ]);

        return back();
    }

    public function showConversationForUser($driverId)
    {
        $currentUser = auth('user')->id();
        $contact = Driver::findOrFail($driverId);

        $chat = Chat::where(function ($query) use ($currentUser, $driverId) {
        $query->where('senderUser_id', $currentUser) ->where('receiverDriver_id', $driverId);
    })
    ->orWhere(function ($query) use ($currentUser, $driverId) {
        $query->where('senderDriver_id', $driverId)->where('receiverUser_id', $currentUser);
    })
    ->orderBy('created_at')->get();

        return view( 'chats.show',compact('chat', 'contact'));
    }

    public function showConversationForDriver($userId)
    {
        $currentDriver = auth('driver')->id();
        $contact = User::findOrFail($userId);

        $chat = Chat::where(function ($query) use ($currentDriver, $userId) {
        $query->where('senderDriver_id', $currentDriver) ->where('receiverUser_id', $userId);
    })
    ->orWhere(function ($query) use ($currentDriver, $userId) {
        $query->where('senderUser_id', $userId)->where('receiverDriver_id', $currentDriver);
    })
    ->orderBy('created_at')->get();

        return view( 'chats.show',compact('chat', 'contact'));
    }

    public function updateChatUser(Request $request, $chatId) {
        $request->validate(['message' => 'required|string']);
    
        $chat = Chat::where('id', $chatId)->where('senderUser_id', auth('user')->id()) ->firstOrFail();
    
        $chat->update(['message' => $request->message, 'is_edited' => true]);
        return back();
    }

    public function updateChatDriver(Request $request, $chatId) {
        $request->validate(['message' => 'required|string']);
    
        $chat = Chat::where('id', $chatId)->where('senderDriver_id', auth('driver')->id()) ->firstOrFail();
    
        $chat->update(['message' => $request->message, 'is_edited' => true]);
        return back();
    }
};