<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promos List</title>
    @vite(['resources/css/promos.css'])
</head>
<body>

    <div class="promo-container">
        <h1>Promos List</h1>

        @if(session('success'))
            <div class="alert-success">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        <table class="promo-table">
            <thead>
                <tr>
                    <th>Promo Code</th>
                    <th>Discount</th>
                    <th>Max Discount</th>
                    <th>Valid Until</th>
                    @if(Auth::user()->email === 'developer@gmail.com')
                        <th>Status</th>
                        <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if($promos->isEmpty())
                    <tr>
                        <td colspan="{{ Auth::user()->email === 'developer@gmail.com' ? 6 : 4 }}" class="empty-state">
                            No promos available.
                        </td>
                    </tr>
                @else
                    @foreach($promos as $promo)
                        <tr>
                            <td><span class="promo-code">{{ $promo->code }}</span></td>
                            <td>{{ $promo->discount_percentage }}%</td>
                            <td>
                                @if($promo->max_discount)
                                    Rp {{ number_format($promo->max_discount, 0, ',', '.') }}
                                @else
                                    <span class="no-limit">No Limit</span>
                                @endif
                            </td>
                            <td>{{ $promo->expiry_date->format('d M Y') }}</td>
                            
                            @if(Auth::user()->email === 'developer@gmail.com')
                                <td>
                                    @if($promo->is_active && $promo->expiry_date >= now())
                                        <span class="status-badge active">Active</span>
                                    @else
                                        <span class="status-badge inactive">Inactive</span>
                                    @endif
                                        <td>
                                            <form method="POST" action="{{ url('/promos/' . $promo->id) }}" class="form-delete">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" 
                                                        class="btn-delete" 
                                                        onclick="return confirm('Are you sure you want to delete this promo? This action cannot be undone.');">
                                                    DELETE
                                                </button>
                                            </form>
                                        </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <a href="{{ route('dashboard.user') }}" class="btn-back">
            BACK TO DASHBOARD
        </a>
    </div>

</body>
</html>