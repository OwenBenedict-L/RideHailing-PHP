<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - CS Portal</title>
    @vite(['resources/css/cs.css'])
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