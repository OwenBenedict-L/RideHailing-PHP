<html>
<body>
    <h1>Promos List</h1>

    @if(session('success'))
        <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="10" cellspacing="0">
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
                    <td colspan="6" style="text-align: center;">No promos available.</td>
                </tr>
            @else
                @foreach($promos as $promo)
                    <tr>
                        <td><strong>{{ $promo->code }}</strong></td>
                        <td>{{ $promo->discount_percentage }}%</td>
                        <td>
                            @if($promo->max_discount)
                                Rp {{ number_format($promo->max_discount, 0, ',', '.') }}
                            @else
                                No Limit
                            @endif
                        </td>
                        <td>{{ $promo->expiry_date->format('d M Y') }}</td>
                        
                        @if(Auth::user()->email === 'developer@gmail.com')
                            <td>
                                @if($promo->is_active && $promo->expiry_date >= now())
                                    <span style="color: green;">Active</span>
                                @else
                                    <span style="color: red;">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ url('/promos/' . $promo->id) }}" style="margin: 0;">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" style="background-color: red; color: white;">DELETE</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <br>
    <a href="{{ route('dashboard.user') }}">
        <button type="button">BACK TO DASHBOARD</button>
    </a>
</body>
</html>