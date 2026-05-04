# User Requirements (UR)
**Sistem Informasi Akuntansi Koperasi (Neraca)**

Dokumen ini menjabarkan persyaratan pengguna dari perspektif interaksi dengan sistem, berfokus pada apa yang pengguna dapat dan tidak dapat lakukan.

## 1. Peran Pengguna (User Roles)
Terdapat dua peran utama dalam sistem:
1. **Administrator (Admin):** Memiliki akses penuh ke seluruh modul sistem, termasuk manajemen pengguna. Biasanya dipegang oleh Bendahara Utama atau IT Support.
2. **Staff (Operator):** Memiliki akses untuk operasional harian seperti mencatat transaksi dan melihat laporan keuangan, namun dibatasi dari fitur administratif.

## 2. Kebutuhan Fungsional (Functional Requirements)

### 2.1. Modul Autentikasi
- **UR-AUTH-01 (Login):** Pengguna (Admin/Staff) harus dapat masuk ke sistem menggunakan kombinasi *Email* dan *Password*.
- **UR-AUTH-02 (Logout):** Pengguna harus dapat keluar dari sistem dengan aman, menghancurkan sesi aktif mereka.
- **UR-AUTH-03 (Session Protection):** Pengguna yang belum login tidak dapat mengakses halaman apapun selain halaman login. Jika mencoba mengakses secara paksa via URL, sistem akan mengarahkan (redirect) ke form login.

### 2.2. Modul Bagan Akun (Chart of Accounts / COA)
- **UR-COA-01 (Lihat Daftar):** Pengguna dapat melihat daftar seluruh akun akuntansi yang terdaftar beserta kode, nama, dan tipe akun.
- **UR-COA-02 (Tambah Akun):** Pengguna dapat menambahkan akun baru dengan mengisi field Kode, Nama, Tipe (Asset, Liability, Equity, Revenue, Expense), dan menunjuk Parent Akun (Opsional).

### 2.3. Modul Jurnal Umum
- **UR-JRN-01 (Lihat Daftar):** Pengguna dapat melihat riwayat transaksi jurnal umum yang diurutkan berdasarkan tanggal.
- **UR-JRN-02 (Input Transaksi):** Pengguna dapat mencatat jurnal baru. Form harus mendukung:
  - Input Tanggal dan Keterangan.
  - Pemilihan minimal dua baris akun (dari *dropdown* COA).
  - Pengisian nominal Debit dan Kredit untuk masing-masing baris.
- **UR-JRN-03 (Validasi Input):** Sistem harus menolak *submission* dan memunculkan peringatan jika total nominal Debit tidak sama dengan total nominal Kredit.

### 2.4. Modul Laporan (Neraca)
- **UR-REP-01 (Lihat Neraca):** Pengguna dapat melihat Laporan Neraca (Balance Sheet).
- **UR-REP-02 (Format Laporan):** Laporan harus menampilkan akun yang dikelompokkan secara otomatis menjadi Aktiva (Assets) dan Kewajiban & Modal (Liabilities & Equity).
- **UR-REP-03 (Verifikasi Keseimbangan):** Halaman laporan harus menampilkan *alert* hijau jika Neraca seimbang (Aset = Kewajiban + Modal), dan *alert* kuning/merah jika tidak seimbang.

### 2.5. Modul Manajemen User (Hanya Admin)
- **UR-USR-01 (Restriksi):** Modul ini tidak boleh terlihat di menu navigasi jika yang login adalah akun Staff.
- **UR-USR-02 (Lihat Pengguna):** Admin dapat melihat daftar akun yang bisa masuk ke aplikasi.
- **UR-USR-03 (Buat Pengguna):** Admin dapat membuat akun baru dengan menentukan Nama, Email, Password, dan menetapkan *Role* (Admin atau Staff).

## 3. Kebutuhan Non-Fungsional (Non-Functional Requirements)

- **NFR-01 (Keamanan Password):** Sistem tidak boleh menampilkan atau menyimpan password dalam teks biasa. Password harus di-hash (misal menggunakan BCRYPT) sebelum disimpan ke database.
- **NFR-02 (Performa):** Waktu muat (load time) untuk perhitungan Neraca tidak boleh lebih dari 3 detik untuk dataset berukuran sedang (kurang dari 10.000 jurnal). Hal ini dicapai dengan menggunakan satu *query database* teroptimasi (`COALESCE` dan `SUM`).
- **NFR-03 (UI/UX Minimalis):** Antarmuka pengguna harus bersih, responsif, dan fungsional tanpa animasi atau skrip eksternal yang memberatkan (Plain HTML/CSS).
- **NFR-04 (Dependabilitas):** Aplikasi harus tetap bisa di-build dan dijalankan dengan perintah `docker-compose up` secara instan tanpa perlu instalasi PHP/MySQL lokal di komputer klien.
