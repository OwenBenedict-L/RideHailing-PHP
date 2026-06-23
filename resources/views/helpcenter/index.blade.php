<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Ticket - HelpCenter</title>
    @vite(['resources/css/helpcenter.css'])
</head>
<body>

<div class="content-wrapper">
    @if ($errors->has('ticket_limit'))
    <div class="custom-alert-danger">
        <span class="alert-icon">⚠️</span>
        <span class="alert-message">{{ $errors->first('ticket_limit') }}</span>
    </div>
    @endif

    <h2>Create Ticket</h2>
    <hr style="border: 0; border-top: 1px solid #E2E8F0; margin-bottom: 20px;">

    @if(Auth::guard('driver')->check())
        <form action="{{ route('driver.helpcenter.store') }}" method="POST">
    @else
        <form action="{{ route('helpcenter.store') }}" method="POST">
    @endif
    @csrf 

    <label for="jenis"><strong>Type of Complaint:</strong></label>
    <select name="jenis_keluhan" id="jenis" onchange="tampilkanKotakLainnya()" required>
        <option value="" disabled selected>-- Select Type of Complaint --</option>
        <option value="lapor_pengemudi">Report driver</option>
        <option value="barang_tertinggal">Report a lost item</option>
        <option value="bug_aplikasi">Report a bug or error in the application</option>
        <option value="batalkan_perjalanan">Cancel Trip</option>
        <option value="masalah_pembayaran">Payment / Balance Issues</option>
        <option value="lainnya">Others</option>
    </select>

    <div id="id_lainnya" style="display: none;">
        <label for="input_lainnya"><strong>Other complaints:</strong></label>
        <input type="text" name="jenis_keluhan_lainnya" id="input_lainnya" minlength="5" maxlength="25">
    </div>

    <label for="keluhan"><strong>Fill in the complaints:</strong></label>
    <textarea name="isi_keluhan" id="keluhan" rows="5" minlength="10" maxlength="100" placeholder="Describe your issue..." required></textarea>

    <div style="display: flex; gap: 10px;">
        @if(Auth::guard('driver')->check())
            <a href="{{ route('dashboard.driver') }}" style="text-decoration: none;">
                <button type="button" class="btn btn-outline" style="border: 1px solid #CBD5E0; color: #4A5568;">Back</button>
            </a>
        @elseif(Auth::guard('user')->check())
            <a href="{{ route('dashboard.user') }}" style="text-decoration: none;">
                <button type="button" class="btn btn-outline" style="border: 1px solid #CBD5E0; color: #4A5568;">Back</button>
            </a>
        @endif
        
        <button type="submit" class="btn btn-solid">Send Ticket</button>
    </div>
    </form>

    <br>
    <hr style="margin: 20px 0;"> 

    <div>
        @if(Auth::guard('driver')->check())
            <a href="{{ route('driver.helpcenter.history') }}" style="text-decoration: none;">
        @else
            <a href="{{ route('helpcenter.history') }}" style="text-decoration: none;">
        @endif
            <button type="button" class="btn btn-outline" style="background-color: #718096; color: white;">View History</button>
        </a>
    </div>
</div>

    <script>
        function tampilkanKotakLainnya() {
            var pilihan = document.getElementById("jenis");
            var wadahLainnya = document.getElementById("id_lainnya");
            var inputLainnya = document.getElementById("input_lainnya");

            if (pilihan.value === "lainnya") {
                wadahLainnya.style.display = "block"; 
                inputLainnya.required = true;         
            } else {
                wadahLainnya.style.display = "none";  
                inputLainnya.required = false;       
                inputLainnya.value = "";              
            }
        }
    </script>
</body>
</html>