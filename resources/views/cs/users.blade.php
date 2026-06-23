<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - CS Portal</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .btn-back {
            text-decoration: none;
            background-color: #6c757d;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
        }
        h2 {
            color: #333;
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        table th {
            background-color: #0056b3;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .btn-complaint {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 13px;
            transition: 0.3s;
        }
        .btn-complaint.active {
            background-color: #28a745; 
            color: white;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .btn-complaint.active:hover {
            background-color: #218838; 
        }
        .btn-complaint.inactive {
            background-color: #e0e0e0; 
            color: #9e9e9e;
            cursor: not-allowed; 
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>User & Driver Management</h1>
            <a href="{{ url('/cs/dashboard') }}" class="btn-back">⬅ Back to Dashboard</a>
        </div>

        <h2>List Users (Customer)</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Complaint</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('d M Y, H:i') }}</td>

                    <td style="text-align: center;">
                        @php
                            $tiketAktif = \App\Models\Ticket::where('user_id', $user->id)
                                                            ->where('status', 'OPEN')
                                                            ->latest() 
                                                            ->first();
                        @endphp
                        @if($tiketAktif)
                            <a href="{{ route('cs.chat', $tiketAktif->id) }}" class="btn-complaint active">Active</a>
                        @else
                            <button class="btn-complaint inactive" disabled>Inactive</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Belum ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <h2>List Drivers</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Complaint</th>
                </tr>
            </thead>
            <tbody>
                @forelse($drivers as $index => $driver)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $driver->name }}</td>
                    <td>{{ $driver->email }}</td>
                    <td>{{ $driver->created_at->format('d M Y, H:i') }}</td>
                    <td style="text-align: center;">
                        @php
                            $tiketAktifDriver = \App\Models\Ticket::where('driver_id', $driver->id)
                                                                  ->where('status', 'OPEN')
                                                                  ->latest() 
                                                                  ->first();
                        @endphp
                        @if($tiketAktifDriver)
                            <a href="{{ route('cs.chat', $tiketAktifDriver->id) }}" class="btn-complaint active">Active</a>
                        @else
                            <button class="btn-complaint inactive" disabled>Inactive</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No Driver.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>