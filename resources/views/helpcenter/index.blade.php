<!DOCTYPE html>
<html>
<body>
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

    <a href="{{ route('dashboard.user') }}" style="text-decoration: none;">
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
</body>
</html>

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
