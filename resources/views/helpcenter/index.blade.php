<html>
<body>
    @if ($errors->has('ticket_limit'))
    <div class="custom-alert-danger">
        <span class="alert-icon">⚠️</span>
        <span class="alert-message">{{ $errors->first('ticket_limit') }}</span>
    </div>
@endif

<style>
.custom-alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    padding: 12px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-family: sans-serif;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    animation: shake 0.4s ease-in-out; /* Efek getar saat muncul */
}

.alert-icon {
    margin-right: 10px;
    font-size: 1.2rem;
}

.alert-message {
    font-weight: bold;
}

/* Animasi tambahan agar alert lebih terlihat "memaksa" (force) */
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}
</style>

    <h2>Create Ticket</h2>
    <hr>

    <form action="/helpcenter" method="POST">
    @csrf 

    <label for="jenis">Type of Complaint:</label><br>
    <select name="jenis_keluhan" id="jenis" onchange="tampilkanKotakLainnya()" required>
        <option value="" disabled selected>-- Select Type of Complaint --</option>
        <option value="lapor_pengemudi">Report driver</option>
        <option value="barang_tertinggal">Report a lost item</option>
        <option value="bug_aplikasi">Report a bug or error in the application</option>
        <option value="batalkan_perjalanan">Cancel Trip</option>
        <option value="masalah_pembayaran">Payment / Balance Issues</option>
        <option value="lainnya">Others</option>
    </select>
    <br><br>

    <div id="id_lainnya" style="display: none;">
        <label for="input_lainnya">Other complaints:</label><br>
        <input type="text" name="jenis_keluhan_lainnya" id="input_lainnya" minlength="5" maxlength="25">
        <br><br>
    </div>

    <label for="keluhan">Fill in the complaints:</label><br>
    <textarea name="isi_keluhan" id="keluhan" rows="5" minlength="10" maxlength="100" required></textarea>
    <br><br>

    <a href="{{route('dashboard.user')}}" style="text-decoration: none;">
        <button type="button" style = "margin-right: 15px;">Back</button>
    </a>
    <button type="submit">Send</button>
    <br><br><br>
    <div style="text-align: left;">
        <a href="{{ route('helpcenter.history') }}">
            <button type="button" style="cursor: pointer;">History</button>
        </a>
    </div>
    <hr style="margin-bottom: 15px;"> 

    </form>
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


