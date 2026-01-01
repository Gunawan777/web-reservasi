# Product Requirements Document (PRD)

## Aplikasi Jasa Reparasi

---

## 1. Informasi Umum Produk

### 1.1 Nama Produk

**RepairGo** _(nama sementara)_

### 1.2 Deskripsi Singkat

RepairGo adalah aplikasi berbasis **web (mobile-friendly)** yang menyediakan layanan **pemesanan jasa reparasi** secara online. Aplikasi ini menghubungkan **pelanggan** dan **teknisi** secara langsung dengan sistem pembayaran aman (escrow) serta penentuan harga yang terkontrol untuk menghindari ketimpangan harga.

### 1.3 Tujuan Produk

-   Mempermudah pelanggan memesan jasa reparasi
-   Memberikan kepastian harga dan keamanan pembayaran
-   Membantu teknisi mendapatkan order secara adil
-   Menyediakan sistem manajemen pesanan berbasis web

---

## 2. Latar Belakang Masalah

### Permasalahan

-   Pelanggan kesulitan menemukan teknisi terpercaya
-   Harga jasa reparasi berbeda jauh antar teknisi
-   Pembayaran tidak memiliki jaminan keamanan
-   Proses pemesanan masih manual

### Solusi

RepairGo menyediakan:

-   Booking jasa reparasi online
-   Sistem pembayaran tertahan (escrow)
-   Penentuan harga berbasis sistem
-   Tracking status perbaikan

---

## 3. Target Pengguna (User Persona)

### 3.1 Pelanggan

-   Masyarakat umum
-   Usia 18–50 tahun
-   Membutuhkan jasa reparasi cepat, transparan, dan aman

### 3.2 Teknisi

-   Teknisi elektronik, kendaraan, dan peralatan rumah tangga
-   Usaha kecil hingga menengah
-   Membutuhkan sistem pengelolaan pesanan dan pembayaran

---

## 4. Ruang Lingkup Produk (Scope)

### 4.1 Platform

-   Aplikasi web responsif
-   Dapat diakses melalui browser desktop dan mobile

### 4.2 Jenis Layanan

-   Reparasi elektronik
-   Reparasi kendaraan
-   Reparasi peralatan rumah tangga

---

## 5. Fitur Utama

### 5.1 Fitur untuk Pelanggan

-   Registrasi & Login (dengan pilihan role Pelanggan/Teknisi)
-   Lihat Kategori Jasa Reparasi
-   Lihat Daftar Teknisi
-   Lihat Detail Teknisi
-   Pesan Jasa Reparasi (memilih layanan, memasukkan deskripsi, memilih tanggal)
-   Estimasi Harga Otomatis (berdasarkan layanan yang dipilih)
-   Konfirmasi Pembayaran (manual/dummy payment)
-   Konfirmasi Penyelesaian Layanan
-   Riwayat Pemesanan (menampilkan semua pesanan dengan status dan pembayaran)
-   Berikan Rating & Ulasan ke Teknisi setelah layanan selesai dan dibayar

### 5.2 Fitur untuk Teknisi

-   Registrasi & Login teknisi
-   Kelola profil & layanan (saat ini hanya ditampilkan, belum ada UI pengelolaan)
-   Terima / Tolak Pesanan (untuk pesanan yang berstatus 'pending')
-   Update Status Pengerjaan (dari 'accepted' ke 'in_progress', dan 'in_progress' ke 'completed')
-   Ajukan Revisi Harga (untuk pesanan yang 'accepted' atau 'in_progress')
-   Riwayat Pekerjaan (menampilkan pesanan yang 'completed', 'cancelled', 'rejected')
-   Saldo & riwayat pencairan (masih akan dikembangkan lebih lanjut)

---

## 6. Sistem Pembayaran (Escrow)

### 6.1 Konsep Pembayaran

-   Pelanggan membayar di awal melalui aplikasi (simulasi manual)
-   Dana ditahan oleh sistem (diwakili oleh `payment_status`)
-   Dana diteruskan ke teknisi setelah layanan selesai dan dikonfirmasi pelanggan (belum diimplementasikan sepenuhnya, hanya konfirmasi status)

### 6.3 Status Pembayaran

-   Pending (belum dibayar oleh pelanggan)
-   Paid (sudah dibayar oleh pelanggan, dana ditahan)
-   Refunded (belum diimplementasikan)

---

## 7. Sistem Penentuan Harga (Anti-Ketimpangan)

### 7.1 Harga Dasar

Harga dasar ditentukan oleh sistem dan berlaku sama untuk semua teknisi.

Contoh:

-   Servis HP ringan → Rp50.000
-   Servis Laptop → Rp150.000

### 7.2 Rentang Harga

Teknisi hanya dapat menyesuaikan harga dalam batas tertentu. (Belum diimplementasikan)

Contoh:

-   Harga dasar: Rp100.000
-   Minimum: Rp90.000 (-10%)
-   Maksimum: Rp120.000 (+20%)

### 7.3 Faktor Penyesuaian

-   Jenis kerusakan
-   Estimasi waktu pengerjaan
-   Biaya komponen
-   Jarak lokasi (opsional)

Rumus:
Total Harga = Harga Dasar

-   Biaya Kerusakan
-   Biaya Komponen
-   Biaya Jarak

yaml
Salin kode

### 7.4 Revisi Harga

-   Teknisi mengajukan revisi harga (`revised_price`)
-   Pelanggan wajib menyetujui sebelum pengerjaan dilanjutkan (mekanisme persetujuan belum diimplementasikan, saat ini hanya pengajuan)

---

## 8. Alur Pengguna

### Alur Pelanggan

1. Login / Daftar
2. Pilih layanan
3. Lihat estimasi harga
4. Bayar di aplikasi (simulasi)
5. Teknisi mengerjakan
6. Konfirmasi selesai
7. Beri ulasan

### Alur Teknisi

1. Login
2. Terima / Tolak pesanan (status 'pending')
3. Ajukan revisi harga (opsional)
4. Update status ('accepted' ke 'in_progress', 'in_progress' ke 'completed')
5. Menunggu konfirmasi pembayaran dan penyelesaian dari pelanggan
6. Dana masuk ke saldo (belum diimplementasikan)

---

## 9. Kebutuhan Fungsional

| Kode  | Deskripsi                                                    | Status                                      |
| ----- | ------------------------------------------------------------ | ------------------------------------------- |
| FR-01 | Login & registrasi (dengan pemilihan role)                   | Implemented                                 |
| FR-02 | Pemesanan jasa (memilih teknisi, layanan, detail booking)    | Implemented                                 |
| FR-03 | Estimasi harga otomatis (berdasarkan layanan)                | Implemented (client-side JS)                |
| FR-04 | Pembayaran escrow (simulasi pembayaran & konfirmasi selesai) | Implemented (dummy payment & status update) |
| FR-05 | Update status (oleh teknisi)                                 | Implemented                                 |
| FR-06 | Rating & ulasan (oleh pelanggan setelah selesai dan bayar)   | Implemented                                 |
| FR-07 | Riwayat transaksi (pelanggan dan teknisi)                    | Implemented (di dashboard masing-masing)    |
| FR-08 | Pengelolaan saldo & pencairan teknisi                        | Not Implemented                             |
| FR-09 | Pengajuan revisi harga (oleh teknisi)                        | Implemented (pengajuan saja)                |

---

## 10. Kebutuhan Non-Fungsional

-   Aplikasi responsif
-   Keamanan data & transaksi
-   Transparansi harga
-   Performa stabil
-   Skalabilitas sistem

---

## 11. Teknologi yang Digunakan

### Backend

-   Laravel Framework

### Frontend

-   Blade Template
-   HTML, CSS, JavaScript
-   Bootstrap / Tailwind CSS

### Database

-   MySQL

### Server & Tools

-   XAMPP
-   Apache Web Server
-   phpMyAdmin

---

## 12. Pengembangan Selanjutnya

-   Chat real-time
-   Integrasi Google Maps
-   Notifikasi real-time
-   Sistem langganan teknisi

---

## 13. Kesimpulan

RepairGo merupakan aplikasi jasa reparasi berbasis web dengan sistem pembayaran aman dan penentuan harga terkontrol untuk menciptakan ekosistem yang adil antara pelanggan dan teknisi.
