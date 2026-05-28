<!DOCTYPE html>
<html>
<body>
    <h2>Hasil Estimasi Perjalanan Anda</h2>
    <hr>
    
    <h3>Rute Perjalanan</h3>
    <p><strong>Titik Jemput:</strong> {{ $estimation->origin }}</p>
    <p><strong>Tujuan:</strong> {{ $estimation->destination }}</p>
    
    <hr>

    <h3>Rincian Harga</h3>
    <p><strong>Perkiraan Jarak:</strong> {{ $estimation->distance }} Km</p>
    <p><strong>Total Tarif:</strong> Rp {{ number_format($estimation->fare, 0, ',', '.') }}</p>
    
    <hr>
    <p><i>*Ini adalah template data untuk Booking. Fitur tombol konfirmasi Booking akan kita taruh di halaman ini nantinya.</i></p>

    <a href="{{ route('dashboard.user') }}">
        <button type="button">Kembali ke Dasbor</button>
    </a>

</body>
</html>