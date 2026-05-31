<!DOCTYPE html>
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
                $jenis_inggris = $kamus[$tiket->jenis_keluhan] ?? $tiket->jenis_keluhan;
            @endphp

            <p><strong>Topic:</strong> {{ $jenis_inggris }}</p>
            <p><strong>Original Complaint:</strong> <br> "{{ $tiket->isi_keluhan }}"</p>
        </div>

        <form action="{{ route('helpcenter.reply', $tiket->id) }}" method="POST">
            @csrf
            <label for="pesan"><strong>Send a message to CS:</strong></label><br>
            <textarea name="pesan" id="pesan" class="chat-box" placeholder="Type your message here..." required></textarea>
            
            <button type="submit" style="padding: 5px 15px; background-color: #007bff; color: white; border: none; cursor: pointer; border-radius: 4px;">Send Message</button>
        </form>
    </div>

    <br>
    <a href="{{ route('helpcenter.history') }}" style="text-decoration: none;">
        <button type="button" style="padding: 5px 15px; cursor: pointer;">Back to History</button>
    </a>

</body>
</html>