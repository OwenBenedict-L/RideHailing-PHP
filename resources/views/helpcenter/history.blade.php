<html>
<head>
    <title>Complaint History</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: sans-serif;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 10px;
            text-align: left;
            word-wrap: break-word; 
            overflow-wrap: break-word; 
            word-break: break-word;
        }
        th {
            background-color: #f2f2f2;
        }
        th:nth-child(1) { width: 15%; } 
        th:nth-child(2) { width: 40%; } 
        th:nth-child(3) { width: 15%; } 
        th:nth-child(4) { width: 15%; } 
        th:nth-child(5) { width: 15%} 
    </style>
</head>
<body>
    <h2>My Complaint History</h2>
    <hr>

    <table>
        <thead>
            <tr>
                <th>Type of Complaint</th>
                <th>Complaints</th>
                <th>Date</th>
                <th>Status</th>
                <th>Reply</th>
            </tr>
        </thead>
        <tbody>
            @foreach($keluhan as $item)
            
            @php
                $kamus = [
                    'lapor_pengemudi' => 'Report driver',
                    'barang_tertinggal' => 'Report a lost item',
                    'bug_aplikasi' => 'Report a bug or error in the application',
                    'batalkan_perjalanan' => 'Cancel Trip',
                    'masalah_pembayaran' => 'Payment / Balance Issues',
                    'lainnya' => 'Others'
                ];
                
                $jenis_inggris = $kamus[$item->subject] ?? $item->subject;
                
                $pesanPertama = \App\Models\TicketMessage::where('ticket_id', $item->id)->first();
                $isi_keluhan = $pesanPertama ? $pesanPertama->message : 'Tidak ada teks';
            @endphp

            <tr>
                <td>{{ $jenis_inggris }}</td>
                <td>{{ $isi_keluhan }}</td>
                <td>{{ $item->created_at->format('d M Y, H:i') }}</td>

                <td>
                    @if($item->status == 'OPEN')
                        <span style="color: #d9534f; font-weight: bold;">Incomplete</span>
                    @else
                        <span style="color: #5cb85c; font-weight: bold;">Complete</span>
                    @endif
                </td>
                    
                <td>
                    @if(Auth::guard('driver')->check())
                        <a href="{{ route('driver.helpcenter.chat', $item->id) }}" style="color: #007bff; text-decoration: underline; font-weight: bold;">Message</a>
                    @else
                        <a href="{{ route('helpcenter.chat', $item->id) }}" style="color: #007bff; text-decoration: underline; font-weight: bold;">Message</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>
    
    <div style="text-align: left;">
        @if(Auth::guard('driver')->check())
            <a href="{{ route('driver.helpcenter.index') }}">
        @else
            <a href="{{ route('helpcenter.index') }}">
        @endif
            <button type="button" style="cursor: pointer; padding: 5px 15px;">Back</button>
        </a>
    </div>
</body>
</html>