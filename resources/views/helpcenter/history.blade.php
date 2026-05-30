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
        th:nth-child(1) { width: 25%; }
        th:nth-child(2) { width: 55%; } 
        th:nth-child(3) { width: 20%; }
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