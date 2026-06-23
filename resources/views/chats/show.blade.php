<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    @vite(['resources/css/chat.css'])
</head>
<body>
    <div class="chat-container">
        
        <div class="chat-header">
            @if(auth('user')->check())
                <a href="{{ route('bookings.index') }}"><button type="button" class="btn-back">⬅ Back</button></a>
            @elseif(auth('driver')->check())
                <a href="{{ route('driver.orders') }}"><button type="button" class="btn-back">⬅ Back</button></a>
            @endif
            <h2>{{ $contact->name }}</h2>
        </div>

        <div class="chat-messages">
            @if($chat->isEmpty())
                <div class="no-messages">No messages yet.</div>
            @else
                @foreach($chat as $message)
                    @if((auth('user')->check() && $message->senderUser_id == auth('user')->id()) || 
                        (auth('driver')->check() && $message->senderDriver_id == auth('driver')->id()))
                        
                        <div class="message-row me">
                            
                            <input type="checkbox" id="edit-toggle-{{ $message->id }}" class="edit-toggle" style="display: none;">
                            
                            <div class="bubble-wrapper">
                                
                                <div class="actions-wrapper">
                                    <label for="edit-toggle-{{ $message->id }}" class="btn-edit-trigger">✏️</label>
                                    
                                    <form action="{{ auth('user')->check() ? route('chat.delete.user', $message->id) : route('chat.delete.driver', $message->id) }}" 
                                          method="POST" 
                                          class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-trigger">🗑️</button>
                                    </form>
                                </div>
                                
                                <div class="bubble me">
                                    <span style="display: block;">{{ $message->message }}</span>

                                    @if(isset($message->is_edited) && $message->is_edited)
                                        <span class="edited-tag">(edited)</span>
                                    @endif
                                </div>

                                <form action="{{ auth('user')->check() ? route('chat.update.user', $message->id) : route('chat.update.driver', $message->id) }}" 
                                      method="POST" 
                                      class="edit-form">
                                    @csrf
                                    <input type="text" name="message" class="input-edit" value="{{ $message->message }}" required>
                                    <button type="submit" class="btn-save">Save</button>
                                    <label for="edit-toggle-{{ $message->id }}" class="btn-cancel" style="display: inline-block; line-height: 1.5;">X</label>
                                </form>

                            </div>
                        </div>

                    @else
                        <div class="message-row them">
                            <div class="bubble-wrapper">
                                <div class="bubble them">
                                    <span style="display: block;">{{ $message->message }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="chat-input-area">
            <form action="{{ auth('user')->check() ? route('chat.send.user', $contact->id) : route('chat.send.driver', $contact->id) }}" method="POST">
                @csrf
                <input type="text" name="message" class="chat-input" placeholder="Type a message..." autocomplete="off" required>
                <button type="submit" class="btn-send">Send</button>
            </form>
        </div>

    </div>
</body>
</html>