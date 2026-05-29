<!DOCTYPE html>
<html>
<body>
    <h2>Create Ticket</h2>
    <hr>

    <form action="/helpcenter" method="POST">
    @csrf 

    <label for="jenis">Jenis Keluhan:</label><br>
    <select name="jenis_keluhan" id="jenis" onchange="tampilkanKotakLainnya()" required>
        <option value="" disabled selected>-- Pilih Jenis Keluhan --</option>
        <option value="lapor_pengemudi">Lapor pengemudi</option>
        <option value="barang_tertinggal">Lapor barang tertinggal</option>
        <option value="bug_aplikasi">Lapor Bug atau error pada aplikasi</option>
        <option value="batalkan_perjalanan">Batalkan Perjalanan</option>
        <option value="masalah_pembayaran">Masalah Pembayaran / Saldo</option>
        <option value="lainnya">Lainnya</option>
    </select>
    <br><br>

    <div id="wadah_lainnya" style="display: none;">
        <label for="input_lainnya">keluhan lainnya</label><br>
        <input type="text" name="jenis_keluhan_lainnya" id="input_lainnya" minlength="5" maxlength="25">
        <br><br>
    </div>
    
    <label for="keluhan">Isi Keluhan:</label><br>
    <textarea name="isi_keluhan" id="keluhan" rows="5" minlength="10" maxlength="100" required></textarea>
    <br><br>

    <a href="{{ route('dashboard.user') }}">
        <button type="button">Back</button>
    </a>
    <br>
        <button type="submit">Kirim Keluhan</button>
    </form>
    <p></p>
</body>
</html>

<script>
    function tampilkanKotakLainnya() {
        var pilihan = document.getElementById("jenis");
        var wadahLainnya = document.getElementById("wadah_lainnya");
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