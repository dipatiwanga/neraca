<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; margin: 0; padding: 0; }
        header { background: #333; color: #fff; padding: 1rem; text-align: center; }
        nav { background: #444; color: #fff; padding: 0.5rem; text-align: center; }
        nav a { color: #fff; text-decoration: none; margin: 0 1rem; }
        nav a:hover { text-decoration: underline; }
        main { padding: 2rem; max-width: 800px; margin: auto; }
        .card { border: 1px solid #ddd; padding: 1rem; margin-bottom: 1rem; border-radius: 5px; }
    </style>
</head>
<body>
    <header>
        <h1><?= $title ?></h1>
    </header>
    <?php require_once __DIR__ . '/partials/nav.php'; ?>
    <main>
        <h2>Selamat Datang</h2>
        <p><?= $pesan ?></p>

        <div class="card">
            <h3>Menu Utama:</h3>
            <ul>
                <li><a href="/accounts">Kelola Daftar Akun</a> - Tambah dan atur kode akun.</li>
                <li><a href="/journals/create">Input Transaksi</a> - Catat jurnal debit/kredit.</li>
                <li><a href="/reports/balance-sheet">Lihat Neraca</a> - Pantau posisi keuangan.</li>
            </ul>
        </div>
    </main>
</body>
</html>
