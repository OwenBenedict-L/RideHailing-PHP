<!DOCTYPE html>
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

        /* this is for width */
        th:nth-child(1) { width: 15%; } /* Type of Complaint */
        th:nth-child(2) { width: 40%; } /* Complaints (tetap paling lebar) */
        th:nth-child(3) { width: 15%; } /* Date */
        th:nth-child(4) { width: 15%; } /* Status */
        th:nth-child(5) { width: 15%} /* Reply */
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
                $jenis_inggris = $kamus[$item->jenis_keluhan] ?? $item->jenis_keluhan;
            @endphp

            <tr>
                <td>{{ $jenis_inggris }}</td>
                <td>{{ $item->isi_keluhan }}</td>
                <td>{{ $item->created_at->format('d M Y, H:i') }}</td>

                <td>
                    @if($item->status == 'pending')
                        <span style="color: #d9534f; font-weight: bold;">Incomplete</span>
                    @else
                        <span style="color: #5cb85c; font-weight: bold;">Complete</span>
                    @endif
                </td>
                    
                <td>
                    <a href="{{ route('helpcenter.chat', $item->id) }}" style="color: #007bff; text-decoration: underline; font-weight: bold;">Message</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>
    
    <a href="{{ route('helpcenter.index') }}" style="text-decoration: none;">
        <button type="button" style="padding: 5px 15px; cursor: pointer;">Back</button>
    </a>
</body>
</html>