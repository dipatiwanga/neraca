# Business Requirements Document (BRD)
**Sistem Informasi Akuntansi Koperasi (Neraca)**

## 1. Ringkasan Eksekutif (Executive Summary)
Sistem Informasi Akuntansi Koperasi adalah aplikasi berbasis web yang dirancang untuk memfasilitasi pencatatan, pengelolaan, dan pelaporan keuangan koperasi. Sistem ini dibangun untuk menggantikan proses pencatatan manual, meminimalkan *human error*, dan memastikan kepatuhan terhadap standar akuntansi keuangan dasar (*Double-Entry Bookkeeping*).

## 2. Tujuan Proyek (Project Objectives)
- Menyediakan platform pencatatan transaksi keuangan yang cepat, aman, dan terpusat.
- Menjamin keseimbangan data akuntansi (Total Debit = Total Kredit) melalui validasi sistem terotomasi.
- Menghasilkan laporan Neraca Keuangan secara *real-time* untuk mendukung pengambilan keputusan pengurus koperasi.
- Menyediakan manajemen akses berjenjang (Role-Based) untuk menjaga kerahasiaan dan integritas data keuangan.

## 3. Ruang Lingkup (Scope)
**In-Scope:**
- Manajemen Pengguna dan Hak Akses (RBAC).
- Pengelolaan Bagan Akun (Chart of Accounts / COA) dengan hierarki (Parent/Sub-akun).
- Pencatatan Jurnal Umum dengan metode *Double-Entry*.
- Pelaporan Buku Besar (General Ledger Summary).
- Pelaporan Neraca (Balance Sheet).

**Out-of-Scope (Fase Selanjutnya):**
- Modul Simpan Pinjam anggota koperasi.
- Laporan Laba Rugi (Income Statement).
- Arus Kas (Cash Flow).
- Pencetakan struk transaksi fisik.

## 4. Aturan Bisnis (Business Rules)
1. **Prinsip Double-Entry:** Setiap transaksi (Jurnal Umum) harus melibatkan setidaknya dua baris akun (satu debit, satu kredit).
2. **Keseimbangan Transaksi:** Sistem tidak mengizinkan penyimpanan Jurnal jika `Total Debit != Total Kredit`.
3. **Saldo Normal:** 
   - Aset (Asset) dan Beban (Expense) bersaldo normal Debit. Penambahan dicatat di Debit.
   - Kewajiban (Liability), Modal (Equity), dan Pendapatan (Revenue) bersaldo normal Kredit. Penambahan dicatat di Kredit.
4. **Keamanan Transaksional:** Penyimpanan Jurnal dan rincian itemnya harus bersifat Atomik (Database Transactions). Jika satu baris item gagal disimpan, seluruh transaksi jurnal tersebut harus dibatalkan (*Rollback*).
5. **Akses Data:** Laporan keuangan dapat dilihat oleh semua staf yang memiliki akun, namun modifikasi *Chart of Accounts* dan pembuatan akses User baru hanya dapat dilakukan oleh peran Administrator.

## 5. Pemangku Kepentingan (Stakeholders)
1. **Ketua/Pengurus Koperasi:** Membutuhkan akses ke laporan Neraca yang akurat dan *real-time* untuk evaluasi kesehatan finansial.
2. **Akuntan / Bendahara (Admin):** Membutuhkan akses penuh untuk mengatur Bagan Akun (COA), mengaudit jurnal, dan mengelola pengguna aplikasi.
3. **Staf Kasir/Operator:** Membutuhkan akses yang mudah dan cepat untuk menginput transaksi jurnal harian.
