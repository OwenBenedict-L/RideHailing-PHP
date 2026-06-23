<html>
<head>
    <title>Chat CS</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .chat-container {
            border: 1px solid #ccc;
            padding: 20px;
            max-width: 600px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .ticket-info {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .chat-box {
            width: 100%;
            height: 100px;
            margin-bottom: 10px;
            padding: 10px;
            box-sizing: border-box;
        }
        .chat-history {
            height: 300px; 
            overflow-y: scroll; 
            border: 1px solid #ccc; 
            padding: 15px; 
            margin-bottom: 20px; 
            background-color: white; 
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <h2>Customer Service Chat</h2>
    <hr>

    <div class="chat-container">
        
        <div class="ticket-info">
            @php
                $kamus = [
                    'lapor_pengemudi' => 'Report driver',
                    'barang_tertinggal' => 'Report a lost item',
                    'bug_aplikasi' => 'Report a bug or error in the application',
                    'batalkan_perjalanan' => 'Cancel Trip',
                    'masalah_pembayaran' => 'Payment / Balance Issues',
                    'lainnya' => 'Others'
                ];
                $jenis_inggris = $kamus[$tiket->subject] ?? $tiket->subject;

                $pesanPertama = \App\Models\TicketMessage::where('ticket_id', $tiket->id)->first();
                $isi_keluhan = $pesanPertama ? $pesanPertama->message : 'Tidak ada teks';
            @endphp

            <p><strong>Topic:</strong> {{ $jenis_inggris }}</p>
            <p><strong>Original Complaint:</strong> <br> "{{ $isi_keluhan }}"</p>
        </div>

        <div class="chat-history">
            
            @if(isset($riwayatChat) && $riwayatChat->count() > 0)
                @foreach($riwayatChat as $chat)
                    @if($chat->sender_type == 'CUSTOMER')
                        <div style="text-align: right; margin-bottom: 15px;">
                            <span style="background-color: #cce5ff; padding: 10px 15px; border-radius: 15px 15px 0px 15px; display: inline-block; max-width: 70%; text-align: left;">
                                {{ $chat->message }}
                            </span>
                        </div>
                    @else
                        <div style="text-align: left; margin-bottom: 15px;">
                            <span style="background-color: #f1f0f0; padding: 10px 15px; border-radius: 15px 15px 15px 0px; display: inline-block; max-width: 70%;">
                                {{ $chat->message }}
                            </span>
                        </div>
                    @endif
                @endforeach
            @else
                <p style="text-align: center; color: #888; font-style: italic;">Belum ada pesan balasan. Silakan ketik pesan Anda di bawah.</p>
            @endif
        </div>
        @if($tiket->status === 'RESOLVED')
            <div style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; text-align: center;">
                <strong>Chat Closed</strong><br>
                This issue has been closed by Customer Service. You can't send messages anymore. Sorry if this disturbs your comfort.
            </div>
        @else
        <form action="{{ route('helpcenter.reply', $tiket->id) }}" method="POST">
            @csrf
            <label for="pesan"><strong>Send a message to CS:</strong></label><br>
            <textarea name="pesan" id="pesan" class="chat-box" placeholder="Type your message here..." required></textarea>
            
            <button type="submit" style="padding: 5px 15px; background-color: #007bff; color: white; border: none; cursor: pointer; border-radius: 4px;">Send Message</button>
        </form>
    @endif </div> <br>

    <div style="text-align: left; margin-top: 20px;">
        @if(Auth::guard('driver')->check())
            <a href="{{ route('driver.helpcenter.history') }}">
        @else
            <a href="{{ route('helpcenter.history') }}">
        @endif
            <button type="button" style="padding: 5px 15px; cursor: pointer;">Back to History</button>
        </a>
    </div>

</body>
</html>