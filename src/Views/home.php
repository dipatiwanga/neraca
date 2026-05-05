<?php require_once __DIR__ . '/partials/header.php'; ?>

<main class="card">
    <h1>Dashboard Utama</h1>
    <p><?= $pesan ?></p>

    <div style="margin-top: 30px;">
        <h3>Navigasi Cepat:</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 15px;">
            <a href="/accounts" class="btn btn-primary" style="text-align: center; padding: 25px;">
                <div style="font-size: 1.5em; margin-bottom: 10px;">📊</div>
                Daftar Akun
            </a>
            <a href="/journals/create" class="btn btn-success" style="text-align: center; padding: 25px;">
                <div style="font-size: 1.5em; margin-bottom: 10px;">✍️</div>
                Input Jurnal
            </a>
            <a href="/reports/balance-sheet" class="btn btn-warning" style="text-align: center; padding: 25px;">
                <div style="font-size: 1.5em; margin-bottom: 10px;">📋</div>
                Laporan Neraca
            </a>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
