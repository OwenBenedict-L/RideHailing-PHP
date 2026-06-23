<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint History</title>
    @vite(['resources/css/helpcenter-history.css'])
</head>
<body>

    <div class="card">
        <h2>My Complaint History</h2>
        <hr>

        <table class="history-table">
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
                            <span class="status-incomplete">Incomplete</span>
                        @else
                            <span class="status-complete">Complete</span>
                        @endif
                    </td>
                        
                    <td>
                        @if(Auth::guard('driver')->check())
                            <a href="{{ route('driver.helpcenter.chat', $item->id) }}" class="reply-link">Message</a>
                        @else
                            <a href="{{ route('helpcenter.chat', $item->id) }}" class="reply-link">Message</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="button-container">
            @if(Auth::guard('driver')->check())
                <button type="button" class="btn-secondary" onclick="window.location.href='{{ route('driver.helpcenter.index') }}'">Back</button>
            @else
                <button type="button" class="btn-secondary" onclick="window.location.href='{{ route('helpcenter.index') }}'">Back</button>
            @endif
        </div>
    </div>

</body>
</html>