# Diagram Sistem Akuntansi Koperasi

Dokumen ini memuat diagram arsitektur dan relasi database untuk mempermudah pemahaman alur kerja aplikasi. Diagram direpresentasikan menggunakan sintaks **Mermaid**.

## 1. Entity Relationship Diagram (ERD)
Diagram ini menunjukkan struktur tabel di dalam database MySQL beserta relasi antar tabelnya.

```mermaid
erDiagram
    USERS {
        int id PK
        varchar name
        varchar email UK "Unique"
        varchar password "BCRYPT Hash"
        enum role "admin, staff"
        timestamp created_at
    }
    ACCOUNTS {
        int id PK
        varchar code UK "Contoh: 1101"
        varchar name "Contoh: Kas Utama"
        enum type "asset, liability, equity, revenue, expense"
        int parent_id FK "Self-referencing untuk sub-akun"
    }
    JOURNALS {
        int id PK
        date date
        text description "Keterangan transaksi"
    }
    JOURNAL_ITEMS {
        int id PK
        int journal_id FK
        int account_id FK
        decimal debit
        decimal credit
    }

    JOURNALS ||--|{ JOURNAL_ITEMS : "memiliki rincian"
    ACCOUNTS ||--o{ JOURNAL_ITEMS : "dicatat pada"
    ACCOUNTS ||--o{ ACCOUNTS : "memiliki parent (opsional)"
```

**Penjelasan Relasi Database:**
- Satu transaksi **Jurnal** (`journals`) harus memiliki satu atau lebih rincian **Item Jurnal** (`journal_items`).
- Setiap **Item Jurnal** (`journal_items`) wajib merujuk pada satu **Bagan Akun** (`accounts`) tertentu.
- Tabel **Accounts** memiliki relasi *self-referencing* (`parent_id`) untuk mendukung hierarki akun bertingkat.

---

## 2. Diagram Alur MVC (Model-View-Controller)
Diagram ini menjelaskan perjalanan sebuah *HTTP Request* dari pengguna hingga menghasilkan halaman web (*HTTP Response*).

```mermaid
sequenceDiagram
    participant Browser as Pengguna (Browser)
    participant Index as public/index.php
    participant Router as core/Router.php
    participant Middleware as AuthMiddleware
    participant Controller as Controller
    participant Model as Model (DB)
    participant View as View (HTML)

    Browser->>Index: HTTP Request (Misal: GET /journals)
    Index->>Router: dispatch(URL)
    Router->>Controller: Instansiasi (Misal: JournalController)
    Controller->>Middleware: handle() (Cek Session)
    
    alt Belum Login
        Middleware-->>Browser: Redirect ke /login
    else Sudah Login
        Controller->>Model: Minta Data (Misal: ambil semua jurnal)
        Model-->>Controller: Return Result Set (Array/Object)
        Controller->>View: render('views/...', data)
        View-->>Browser: HTTP Response (Halaman HTML)
    end
```

**Penjelasan Alur MVC:**
1. Semua permintaan (Request) masuk ke `public/index.php` sebagai *Front Controller*.
2. `Router` akan membedah URL dan mencari `Controller` mana yang bertugas.
3. Sebelum memproses logika, Controller akan memanggil `AuthMiddleware` untuk memastikan user berhak mengakses.
4. Jika aman, Controller akan meminta data dari `Model` (berinteraksi dengan Singleton Database).
5. Data yang didapat dari Model akan dikirim ke `View` untuk dirangkai menjadi HTML, lalu dikirim balik ke Pengguna.
