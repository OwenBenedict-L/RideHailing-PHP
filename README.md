# Proyek Backend Ride-Hailing (Laravel MVC Platform)

Sistem Ride-Hailing ini dirancang sebagai platform layanan transportasi online berbasis arsitektur MVC (Model-View-Controller) menggunakan framework Laravel (PHP). Proyek ini bertujuan untuk mengintegrasikan seluruh siklus layanan transportasi digital ke dalam satu alur ekosistem yang saling berkaitan secara real-time.

Alur kerja sistem dimulai dari manajemen identitas dan hak akses melalui User Authentication & Management serta Driver Management. Setiap akun yang terverifikasi secara otomatis terikat dengan Wallet System untuk menangani transaksi non-tunai, baik berupa pengisian saldo (top-up) maupun pembayaran biaya perjalanan.

Pada fase operasional, pengguna dapat melakukan simulasi rute melalui Ride Estimation untuk mendapatkan kalkulasi jarak dan tarif dasar secara dinamis. Nilai tarif ini kemudian dapat dikombinasikan dengan kode potongan harga pada modul Fitur Promo & Diskon (Voucher Management) sebelum pengguna memproses pesanan melalui Booking System. 

Selama pesanan aktif, koordinasi koordinat dan komunikasi diperkuat lewat fitur In-App Chat. Ketika perjalanan selesai, sistem mengeksekusi saldo wallet secara otomatis, mengirimkan ringkasan melalui Notification Management, dan membuka akses halaman Review & Rating bagi pengguna untuk memberikan umpan balik, serta menyediakan layanan Help Center untuk penanganan kendala pasca-perjalanan.

## Struktur Arsitektur Fitur (MVC Laravel)

### 1. Authentication & User Management
1. Model: `User.php` (Mengelola data kredensial, enkripsi password, hak akses peran, serta relasi ke tabel internal sistem).
2. View: 
    * `login/landing.blade.php` (Halaman utama/selamat datang untuk memilih masuk sebagai user, driver, atau customer service).
    * `login/loginUser.blade.php` (Halaman masuk khusus untuk komponen pengguna/penumpang).
    * `login/loginCs.blade.php` (Halaman masuk khusus untuk komponen Customer Service).
    * `login/registerUser.blade.php` (Halaman pendaftaran akun penumpang/user baru).
    * `login/dashboardUser.blade.php` (Halaman panel kendali utama setelah penumpang berhasil masuk).
3. Controller: `AuthController.php`
4. Route:
    * `GET /` ➔ Memeriksa session aktif pada tiap guard; jika tidak ada, menampilkan halaman login.landing.
    * `GET /login-user` ➔ Menampilkan form halaman masuk khusus user (Guest).
    * `POST /login-user` ➔ Memproses validasi kredensial masuk akun user.
    * `GET /register-user` ➔ Menampilkan form pembuatan akun user baru (Guest).
    * `POST /register-user` ➔ Mendaftarkan entitas user baru ke database.
    * `GET /login-cs` ➔ Menampilkan form halaman masuk khusus customer service (Guest).
    * `POST /login-cs` ➔ Memproses validasi kredensial masuk akun customer service.
    * `GET /register-cs` ➔ Menampilkan form pembuatan akun customer service baru (Guest).
    * `POST /register-cs` ➔ Mendaftarkan entitas customer service baru ke database.
    * `GET /dashboard-user` ➔ Mengakses halaman utama panel kendali user (Menerapkan middleware auth:user).
    * `POST /logout-user` ➔ Menghapus session aktif dan mengeluarkan akun user dari sistem.

### 2. Authentication & Driver Management
1. Model: `Driver.php` (Berisi data-data seperti nama, email, password yang bersifat kredensial, menyimpan enkripsi dari password, hak akses peran, serta relasi ke tabel internal sistem, serta data-data tambahan untuk driver seperti nomor SIM, jenis kendaraaan (Motor/Mobil), dan nomor plat kendaraan).
2. View: 
    * `login/landing.blade.php` (Halaman utama/selamat datang untuk memilih masuk sebagai user, driver, atau customer service).
    * `login/loginDriver.blade.php` (Halaman masuk khusus untuk komponen pengemudi/driver).
    * `login/registerDriver.blade.php` (Halaman pendaftaran berkas dan akun pengemudi/driver baru).
    * `login/dashboardDriver.blade.php` (Halaman panel kendali utama setelah pengemudi/driver berhasil masuk).
3. Controller: `AuthController.php`
4. Route:
    * `GET /` ➔ Memeriksa session aktif pada tiap guard; jika tidak ada, menampilkan halaman login.landing.
    * `GET /login-driver` ➔ Menampilkan form halaman masuk khusus driver (Guest).
    * `POST /login-driver` ➔ Memproses validasi kredensial masuk akun driver.
    * `GET /register-driver` ➔ Menampilkan form pembuatan akun driver baru (Guest).
    * `POST /register-driver` ➔ Mendaftarkan entitas driver baru ke database.
    * `GET /dashboard-driver` ➔ Mengakses halaman utama panel kendali driver (Menerapkan middleware auth:driver).
    * `POST /logout-driver` ➔ Menghapus session aktif dan mengeluarkan akun driver dari sistem.

### 3. Wallet System
1. Model: `Wallet.php`, `WalletTransaction.php`, `DriverWallet.php`, `DriverWalletTransaction.php` (Mencatat saldo wallet, top up, dan riwayat transaksi pada wallet untuk user dan driver).
2. View: `wallet/index.blade.php` (Informasi jumlah saldo, riwayat transaksi keuangan, dan form top-up).
    * `wallet/balance.blade.php` (Halaman yang berisi informasi saldo dan tombol untuk top up dan cek histori).
    * `wallet/history.blade.php` (Halaman yang berisi daftar histori transaksi dari wallet user).
    * `wallet/topup.blade.php` (Halaman yang berisi form untuk melakukan top up pada wallet user).
    * `wallet/driver-balance.blade.php` (Halaman yang berisi informasi saldo dan tombol untuk transfer ke bank dan cek histori).
    * `wallet/driver-history.blade.php` (Halaman yang berisi daftar histori transaksi dari wallet driver).
    * `wallet/driver-withdraw.blade.php` (Halaman yang berisi form untuk melakukan transfer ke bank).
3. Controller: `WalletController.php`, `DriverWalletController.php`
4. Route:
    * `GET /wallet` ➔ Menampilkan saldo user.
    * `GET /wallet/topup` ➔ Menampilkan form untuk mengisi jumlah saldo yang ingin dilakukan top up.
    * `POST /wallet/topup` ➔ Memproses top up saldo pada wallet user.
    * `GET /wallet/history` ➔ Menampilkan riwayat transaksi pada wallet user.
    * `GET driver/wallet` ➔ Menampilkan saldo driver.
    * `GET driver/wallet/withdraw` ➔ Menampilkan form untuk mengisi jumlah saldo, nama bank, dan nomor rekening yang ingin dilakukan transfer ke bank.
    * `POST driver/wallet/withdraw` ➔ Memproses transfer ke bank pada wallet driver.
    * `GET driver/wallet/history` ➔ Menampilkan riwayat transaksi pada wallet driver.

### 4. Ride Estimation
1. Model: `Estimation.php` ➔ Menyimpan data kalkulasi sementara yang mencakup lokasi asal, tujuan, jarak tempuh, estimasi waktu, tarif, dan surge multiplier dengan status default ACTIVE.
2. View:
    * `estimations/show.blade.php` ➔ Halaman detail yang menampilkan informasi jarak rute dan daftar pilihan tipe kendaraan beserta kalkulasi tarif akhir yang dinamis.
3. Controller: `EstimationController.php.`
4. Route:
    * `GET /estimations/create` ➔ Mengecek riwayat sesi estimasi dan menampilkan form pengisian titik penjemputan serta tujuan.
    * `POST /estimations` ➔ Memproses perhitungan jarak, estimasi waktu tempuh, dan membuat atau memperbarui data estimasi ke database.
    * `GET /estimations/detail` ➔ Menampilkan halaman pemilihan tipe kendaraan (seperti Car atau Motor) beserta tarif yang telah dikalkulasikan dengan surge multiplier.
    * `POST /estimations/select` ➔ Memproses tipe kendaraan yang dipilih pengguna, memperbarui tarif final pada data estimasi, dan mengarahkan pengguna ke halaman checkout pemesanan.*


### 5. Fitur Promo & Diskon (Voucher Management)
1. Model: `Promo.php` (Memuat skema aturan kode voucher, besaran nilai persentase diskon, kuota batas pemakaian, serta validitas tanggal kedaluwarsa).
2. View: Berintegrasi langsung di dalam form pembuatan pesanan (`bookings/create.blade.php`) dan Menampilkan daftar seluruh kode promo aktif yang tersedia di sistem (`promos/index.blade.php`)
3. Controller: `PromoController.php`
4. Route:
    * `GET /promos` ➔ Menampilkan daftar katalog voucher promo aktif.
    * `GET /promos/create` ➔ Membuka form pembuatan data promo baru ke sistem.
    * `POST /promos` ➔ Menyimpan data aturan skema promo baru ke dalam database.
    * `POST /promos/validate` ➔ Memproses validasi string kode promo terhadap tarif dasar pesanan secara real-time.
    * `DELETE /promos/{id}` ➔ Menghapus atau menonaktifkan kode promo tertentu dari database berdasarkan ID.

### 6. Booking System
1. Model: `Booking.php` (Mengelola status perjalanan: `pending`, `confirmed`, `on_way`, `completed`, `cancelled`).
2. View: 
    * `bookings/index.blade.php` (Terdapat booking history yang memuat seluruh riwayat data pemesanan secara real time).
    * `bookings/create.blade.php` (Halaman untuk input lokasi penjemputan dan tujuan perjalanan).
    * `bookings/checkout.blade.php` (Halaman konfirmasi checkout pesanan & validasi kecukupan saldo).
3. Controller: `BookingController.php`
4. Route:
    * `GET /bookings` ➔ Menampilkan daftar riwayat pemesanan pengguna.
    * `GET /bookings/create` ➔ Menampilkan form untuk mengisi rute perjalanan.
    * `POST /bookings/confirm` ➔ Memproses data awal atau estimasi sebelum dilempar ke checkout.
    * `GET /bookings/checkout` ➔ Menampilkan halaman konfirmasi pembayaran dan cek saldo wallet.
    * `POST /bookings` ➔ Menyimpan data pesanan resmi ke database setelah user menekan tombol Book Now.
    * `DELETE /bookings/{booking}` ➔ Membatalkan pesanan perjalanan aktif berjalan (menghapus/mengubah status menjadi cancelled).

### 7. User Notification
1. Model: `Notification.php` (Mengelola penyimpanan data pesan notifikasi untuk user).
2. View: 
    * `notifications/index.blade.php` (Halaman pusat kotak masuk yang menampilkan seluruh daftar pesan notifikasi masuk secara real-time).
    * `notifications/show.blade.php` (Halaman untuk melihat detail isi pesan dari salah satu notifikasi spesifik).
3. Controller: `UserNotificationController.php`
4. Route:
    * `GET /notifications` ➔ Menampilkan daftar seluruh pesan notifikasi milik akun.
    * `GET /notifications/{id}` ➔ Membuka dan menampilkan detail isi dari satu notifikasi spesifik berdasarkan ID.
    * `POST /notifications/mark-all-read` ➔ Mengubah status seluruh notifikasi yang ada menjadi sudah dibaca sekaligus.
    * `PUT /notifications/{id}` ➔ Memperbarui status keterbacaan atau data tertentu pada satu notifikasi spesifik.
    * `DELETE /notifications/{id}` ➔ Menghapus satu pesan notifikasi tertentu dari daftar kotak masuk.
    * `DELETE /notifications/delete-all` ➔ Membersihkan dan menghapus seluruh riwayat notifikasi secara permanen dari akun.

### 8. Driver Notification
1. Model: `Notification.php` (Mengelola penyimpanan data pesan notifikasi untuk driver).
2. View: 
    * `driver-notifications/index.blade.php` (Halaman pusat kotak masuk yang menampilkan seluruh daftar pesan notifikasi masuk secara real-time).
    * `driver-notifications/show.blade.php` (Halaman untuk melihat detail isi pesan dari salah satu notifikasi spesifik).
3. Controller: `DriverNotificationController.php`
4. Route:
    * `GET /driver-notifications` ➔ Menampilkan daftar seluruh pesan notifikasi milik akun pengemudi.
    * `GET /driver-notifications/{driverNotification}` ➔ Membuka dan menampilkan detail isi dari satu notifikasi pengemudi spesifik.
    * `POST /driver-notifications/mark-all-read` ➔ Mengubah status seluruh notifikasi pengemudi menjadi sudah dibaca sekaligus.
    * `PUT /driver-notifications/{driverNotification}` ➔ Memperbarui status keterbacaan atau data pada satu notifikasi pengemudi.
    * `DELETE /driver-notifications/{driverNotification}` ➔ Menghapus satu pesan notifikasi tertentu dari kotak masuk pengemudi.
    * `DELETE /driver-notifications/delete-all` ➔ Membersihkan seluruh riwayat notifikasi secara permanen dari akun pengemudi.

### 9. In-App Chat
1. Model: `Chat.php` (Berisi data-data yang akan dimasukkan ke dalam database seperti sender (senderUser_id untuk user dan senderDriver_id untuk driver), receiver (receiverUser_id untuk user dan receiverDriver_id untuk driver), booking_id, dan message (pesan)).
2. View: `chat/show.blade.php` (Interface dari chat antara driver dan user).
3. Controller: `ChatController.php`
4. Route:
    - Auth(User)
    * `GET /chat/user/{driver_id}` ➔ Membuka halaman view chat bagi user dengan user sebagai receiver dan mengambil id dari driver untuk dihubungkan dalam chat.
    * `POST /chat/user/{driver_id}` ➔ Memungkinkan user untuk mengetik dan mengirimkan pesan kepada driver.
    * `PATCH /chat/user/{driver_id}/edit/{chat_id}` ➔ Memberikan user cara untuk mengubah isi pesan yang sudah dikirimkan sebelumnya.
    * `DELETE /chat/user/{driver_id}/delete/{chat_id}` ➔ Memberikan user cara untuk menghapus isi pesan yang sudah dikirimkan sebelumnya.
    - Auth(Driver)
    * `GET /chat/driver/{user_id}` ➔ Membuka halaman view chat bagi driver dengan user sebagai receiver dan mengambil id dari user untuk dihubungkan dalam chat.
    * `POST /chat/driver/{user_id}` ➔ Memungkinkan driver untuk mengetik dan mengirimkan pesan kepada user.
    * `PATCH /chat/driver/{user_id}/edit/{chat_id}` ➔ Memberikan driver cara untuk mengubah isi pesan yang sudah dikirimkan sebelumnya.
    * `DELETE /chat/driver/{user_id}/delete/{chat_id}` ➔ Memberikan driver cara untuk menghapus isi pesan yang sudah dikirimkan sebelumnya.

### 10. Review & Rating
1. Model: `Review.php` (Menyimpan nilai integer tingkatan rating bintang 1-5 dan deskripsi review).
2. View: 
    * `reviews/create.blade.php` (Form pengisian rating dan review setelah perjalanan berstatus selesai).
    * `reviews/edit.blade.php` (Form untuk memperbarui ulasan review dan rating sebelumnya).
3. Controller: `ReviewController.php`
4. Route:**
    * `GET /bookings/{booking}/review` ➔ Menampilkan form untuk mengisi rating dan review.
    * `POST /bookings/{booking}/review` ➔ Memproses pengiriman rating dan review.
    * `GET /bookings/{booking}/review/edit` ➔ Menampilkan form untuk memperbarui rating dan review sebelumnya.
    * `PUT /bookings/{booking}/review` ➔ Memproses pengiriman rating dan review yang sudah diperbarui.

### 11. Help Center
1. Model:
    * `Ticket.php` ➔ Menyimpan data utama tiket komplain termasuk relasi ke user atau driver, subjek masalah, dan status OPEN atau RESOLVED. 
    * `TicketMessage.php` ➔ Menyimpan riwayat obrolan/chat antara pengguna dan Customer Service di dalam suatu tiket.  
2. View:
    * `helpcenter/index.blade.php` ➔ Halaman utama untuk membuat tiket baru, mencakup dropdown jenis keluhan dan form input detail masalah.  
    * `helpcenter/history.blade.php` ➔ Halaman tabel riwayat tiket yang menampilkan status keluhan, subjek, dan tombol akses ke halaman chat.  
    * `helpcenter/chat.blade.php` ➔ Antarmuka real-time chat antara pengguna dan CS, menampilkan gelembung pesan dan informasi tiket awal.  
    * `helpcenter/feedback.blade.php` ➔ Halaman success/feedback setelah pengguna berhasil mengirim tiket baru.  
3. Controller: `HelpCenterController.php ` 
4. Route:
    * `GET /helpcenter` ➔ Menampilkan form pembuatan tiket keluhan.  
    * `POST /helpcenter` ➔ Memvalidasi keluhan, membatasi maksimal 1 tiket OPEN per pengguna, membuat data tiket, dan mengirimkan notifikasi sistem.  
    * `GET /helpcenter/history` ➔ Mengambil seluruh data tiket milik pengguna yang sedang login dan menampilkannya di tabel riwayat.  
    * `GET /helpcenter/chat/{id}` ➔ Menampilkan riwayat percakapan secara chronological berdasarkan ID tiket.  
    * `POST /helpcenter/chat/{id}` ➔ Menyimpan balasan pesan dari pengguna ke tabel TicketMessage. Fitur ini juga dilengkapi dengan sistem gacha prizes secara acak.  
    * `GET /helpcenter/feedback` ➔ Mengarahkan pengguna ke halaman konfirmasi setelah tiket berhasil dibuat.  

### 12. Customer Service
1. Model:(Menggunakan model `User`, `Driver`, `Ticket`, dan `TicketMessage` yang sudah ada untuk proses relasi data).  
2. View:
    * `cs/dashboard.blade.php` ➔ Halaman utama dashboard CS yang menampilkan navigasi menu manajemen portal.  
    * `cs/users.blade.php` ➔ Halaman tabel manajemen yang memuat daftar seluruh akun pengguna dan pengemudi. Terdapat indikator tombol keluhan aktif (Active/Inactive) yang akan mengarahkan CS ke ruang obrolan tiket terbuka.  
    * `cs/chat.blade.php` ➔ Antarmuka ruang obrolan khusus admin CS. Terdapat fitur untuk membaca histori chat dari customer, membalas pesan, serta tombol peringatan konfirmasi Complete untuk menutup sesi tiket.  
3. Controller: `CsController.php`  
4. Route:   
    * `GET /cs/dashboard` ➔ Menampilkan halaman utama portal CS.  
    * `GET /cs/users` ➔ Mengambil data riwayat pengguna (User & Driver) beserta pengecekan tiket berstatus OPEN untuk ditampilkan di dalam tabel.  
    * `GET /cs/ticket/{id}/chat` ➔ Membuka sesi obrolan (chat history) antara pelanggan dan CS. (Otomatis redirect keluar jika tiket sudah berstatus RESOLVED).  
    * `POST /cs/ticket/{id}/reply` ➔ Menyimpan balasan pesan dari pihak CS ke dalam database dengan sender_type 'CS'.  
    * `POST /cs/ticket/{id}/complete` ➔ Memperbarui status tiket dari OPEN menjadi RESOLVED, yang akan mematikan akses chat dari sisi pengguna.