<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Ticket #{{ $ticket->id }} - CS Portal</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
        }
        .chat-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            height: 85vh;
        }
        .chat-header {
            background-color: #0056b3;
            color: white;
            padding: 15px 20px;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-back {
            color: white;
            text-decoration: none;
            background-color: rgba(255,255,255,0.2);
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 14px;
        }
        .btn-back:hover {
            background-color: rgba(255,255,255,0.3);
        }
        .chat-box {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #e5ddd5; /* Warna background ala WhatsApp */
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .message {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 8px;
            position: relative;
            font-size: 15px;
            line-height: 1.4;
        }
        .message .time {
            font-size: 11px;
            color: #777;
            text-align: right;
            margin-top: 5px;
            display: block;
        }

        .msg-customer {
            background-color: white;
            align-self: flex-start;
            border-top-left-radius: 0;
        }

        .msg-cs {
            background-color: #dcf8c6;
            align-self: flex-end;
            border-top-right-radius: 0;
        }
        .chat-input-area {
            padding: 15px;
            background: #f0f0f0;
            border-radius: 0 0 8px 8px;
            display: flex;
            gap: 10px;
        }
        .chat-input-area textarea {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            resize: none;
            outline: none;
            font-family: inherit;
        }
        .btn-send {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 0 20px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-send:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="chat-container">
        <div class="chat-header">
            <div>
                <h3 style="margin: 0;">Ticket #{{ $ticket->id }}</h3>
                <small>Subject: {{ $ticket->subject }}</small>
            </div>

            <div style="display: flex; gap: 10px; align-items: center;">
    
                <form action="{{ route('cs.ticket.complete', $ticket->id) }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" 
                            class="btn-send" 
                            style="background-color: #dc3545; padding: 8px 12px; font-size: 14px;" 
                            onclick="return confirm('Do you want to end this session? (Yes/No)');">
                        ✔ Complete
                    </button>
                </form>
                <a href="{{ route('cs.users') }}" class="btn-back">⬅ Back</a>
            </div>
        </div><div class="chat-box">
            @forelse($chatHistory as $chat)
                @if($chat->sender_type == 'CUSTOMER')
                    <div class="message msg-customer">
                        {{ $chat->message }}
                        <span class="time">{{ $chat->created_at->format('H:i') }}</span>
                    </div>
                @else
                    <div class="message msg-cs">
                        {{ $chat->message }}
                        <span class="time">{{ $chat->created_at->format('H:i') }}</span>
                    </div>
                @endif
            @empty
                <div style="text-align: center; color: #666; margin-top: 20px;">
                    Belum ada pesan di tiket ini.
                </div>
            @endforelse
        </div>

        <form action="{{ url('/cs/ticket/' . $ticket->id . '/reply') }}" method="POST" class="chat-input-area">
            @csrf
            <textarea name="pesan" rows="2" placeholder="Type your reply here..." required></textarea>
            <button type="submit" class="btn-send">Send</button>
        </form>
    </div>

</body>
</html>