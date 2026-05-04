<nav style="background: #444; color: #fff; padding: 10px; text-align: center; margin-bottom: 20px;">
    <a href="/" style="color: #fff; text-decoration: none; margin: 0 15px;">Dashboard</a>
    <a href="/accounts" style="color: #fff; text-decoration: none; margin: 0 15px;">Daftar Akun</a>
    <a href="/journals" style="color: #fff; text-decoration: none; margin: 0 15px;">Jurnal Umum</a>
    <a href="/reports/balance-sheet" style="color: #fff; text-decoration: none; margin: 0 15px;">Laporan Neraca</a>
    
    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <a href="/users" style="color: #ffc107; text-decoration: none; margin: 0 15px; font-weight: bold;">Manajemen User</a>
    <?php endif; ?>
    
    <span style="margin-left: 30px; font-size: 0.9em; color: #ccc;">User: <?= $_SESSION['user_name'] ?? 'Guest' ?></span>
    <a href="/logout" style="background: #d9534f; color: #fff; text-decoration: none; padding: 5px 12px; border-radius: 4px; margin-left: 15px; font-size: 0.9em;">Logout</a>
</nav>
