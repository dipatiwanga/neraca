# Struktur Proyek Sistem Akuntansi Koperasi

Berikut adalah struktur direktori dan file untuk proyek Sistem Akuntansi Koperasi (Neraca) beserta penjelasan fungsi masing-masing komponen.

```text
neraca/
├── core/                           # Inti dari Framework MVC (Core System)
│   ├── Controller.php              # Base controller untuk memuat model dan view
│   ├── Database.php                # Wrapper PDO dengan pola Singleton & Transaksi
│   ├── Router.php                  # Engine routing untuk pemetaan URL ke Controller
│   └── Session.php                 # Wrapper untuk native PHP session
├── public/                         # Document Root yang dapat diakses dari web browser
│   ├── .htaccess                   # Konfigurasi Apache untuk URL Rewriting
│   └── index.php                   # Front Controller, titik masuk tunggal aplikasi
├── src/                            # Kode sumber utama aplikasi (Logika Bisnis & UI)
│   ├── Controllers/                # Kelas Controller untuk menangani request HTTP
│   │   ├── AccountController.php   # Mengelola Bagan Akun (COA)
│   │   ├── AuthController.php      # Mengelola Login dan Logout
│   │   ├── HomeController.php      # Mengelola halaman Dashboard utama
│   │   ├── JournalController.php   # Mengelola pencatatan Jurnal Umum
│   │   ├── ReportController.php    # Mengelola Laporan (Neraca)
│   │   └── UserController.php      # Mengelola pengguna sistem (Manajemen User)
│   ├── Helpers/                    # Fungsi bantuan/utilitas statis
│   │   ├── Accounting.php          # Fungsi validasi keseimbangan jurnal & neraca
│   │   └── Auth.php                # Fungsi hashing & verifikasi password BCRYPT
│   ├── Middleware/                 # Lapisan penengah sebelum mencapai Controller
│   │   └── AuthMiddleware.php      # Penjaga rute, memastikan user telah login
│   ├── Models/                     # Kelas representasi tabel database
│   │   ├── Account.php             # Model untuk tabel 'accounts'
│   │   ├── Akun.php                # Model alternatif/legacy (digantikan oleh Account.php)
│   │   ├── Journal.php             # Model untuk tabel 'journals' (Header Jurnal)
│   │   ├── JournalItem.php         # Model untuk tabel 'journal_items' (Detail Jurnal)
│   │   ├── Ledger.php              # Model agregasi untuk Buku Besar dan Neraca
│   │   └── User.php                # Model untuk tabel 'users'
│   └── Views/                      # Tampilan antarmuka HTML
│       ├── accounts/               # Tampilan modul COA
│       │   ├── create.php
│       │   └── index.php
│       ├── auth/                   # Tampilan modul Autentikasi
│       │   └── login.php
│       ├── journals/               # Tampilan modul Jurnal
│       │   ├── create.php
│       │   └── index.php
│       ├── partials/               # Komponen view yang dapat digunakan ulang
│       │   └── nav.php             # Menu navigasi atas
│       ├── reports/                # Tampilan modul Laporan
│       │   └── balance_sheet.php
│       ├── users/                  # Tampilan modul Manajemen User
│       │   ├── create.php
│       │   └── index.php
│       └── home.php                # Tampilan Dashboard
├── docs/                           # Dokumentasi Proyek
│   ├── BRD.md                      # Business Requirements Document
│   ├── PROJECT_STRUCTURE.md        # File ini
│   └── UR.md                       # User Requirements
├── Dockerfile                      # Spesifikasi image container (PHP 8.2 + Apache)
├── composer.json                   # Konfigurasi dependensi dan autoloader PSR-4
├── docker-compose.yml              # Orkestrasi layanan (Web App & Database MySQL)
└── issue.md                        # Draf spesifikasi awal dan rancangan aplikasi
```

## Penjelasan Lapisan Arsitektur

1. **`core/` (Kerangka Kerja):** Berisi fondasi teknis. Komponen di sini bersifat generik dan tidak terikat pada logika bisnis koperasi. Tujuannya adalah membuat struktur MVC bekerja layaknya framework modern.
2. **`src/Models/` (Data layer):** Berinteraksi langsung dengan database. `Ledger.php` adalah pengecualian menarik karena ia tidak memetakan satu tabel spesifik, melainkan melakukan agregasi (JOIN & GROUP) laporan keuangan.
3. **`src/Controllers/` (Logic Layer):** Bertindak sebagai "mandor". Mengambil input pengguna dari `$_POST`/`$_GET`, memanggil `Model` untuk memproses data, dan memilih `View` yang tepat untuk ditampilkan.
4. **`src/Views/` (Presentation Layer):** Bertanggung jawab hanya untuk menampilkan data. View tidak boleh memanipulasi database secara langsung.
