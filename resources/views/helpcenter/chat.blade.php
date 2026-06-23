<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat CS</title>
    @vite(['resources/css/helpcenter-chat.css'])
</head>
<body>
    <div class="card">
        
        <h2>Customer Service Chat</h2>
        <hr>

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
                        <div class="chat-message chat-customer">
                            <div class="chat-bubble">{{ $chat->message }}</div>
                        </div>
                    @else
                        <div class="chat-message chat-cs">
                            <div class="chat-bubble">{{ $chat->message }}</div>
                        </div>
                    @endif
                @endforeach
            @else
                <p class="empty-chat">Belum ada pesan balasan. Silakan ketik pesan Anda di bawah.</p>
            @endif
        </div>

        @if($tiket->status === 'RESOLVED')
            <div class="alert-closed">
                <strong>Chat Closed</strong><br>
                This issue has been closed by Customer Service. You can't send messages anymore. Sorry if this disturbs your comfort.
            </div>
            
            <div class="button-container-single">
                @if(Auth::guard('driver')->check())
                    <button type="button" class="btn-secondary" onclick="window.location.href='{{ route('driver.helpcenter.history') }}'">Back to History</button>
                @else
                    <button type="button" class="btn-secondary" onclick="window.location.href='{{ route('helpcenter.history') }}'">Back to History</button>
                @endif
            </div>
            
        @else
            @if(Auth::guard('driver')->check())
                <form action="{{ route('driver.helpcenter.sendReply', $tiket->id) }}" method="POST">
            @else
                <form action="{{ route('helpcenter.sendReply', $tiket->id) }}" method="POST">
            @endif
            @csrf
            
                <label for="pesan">Send a message to CS:</label>
                <textarea name="pesan" id="pesan" rows="4" placeholder="Type your message here..." required></textarea>
                
                <div class="button-container">
                    @if(Auth::guard('driver')->check())
                        <button type="button" class="btn-secondary" onclick="window.location.href='{{ route('driver.helpcenter.history') }}'">Back to History</button>
                    @else
                        <button type="button" class="btn-secondary" onclick="window.location.href='{{ route('helpcenter.history') }}'">Back to History</button>
                    @endif
                    
                    <button type="submit" class="btn-primary">Send Message</button>
                </div>
            </form>
        @endif

    </div>

</body>
</html>