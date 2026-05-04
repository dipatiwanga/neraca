<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Daftar Jurnal' ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn { padding: 5px 10px; text-decoration: none; background: #007bff; color: white; border-radius: 3px; }
        .btn-add { background: #28a745; margin-bottom: 10px; display: inline-block; }
        nav { margin-bottom: 20px; }
        nav a { margin-right: 15px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../partials/nav.php'; ?>

    <h1><?= $title ?? 'Riwayat Jurnal Umum' ?></h1>
    
    <a href="/journals/create" class="btn btn-add">+ Input Jurnal Baru</a>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($journals)): ?>
                <?php foreach ($journals as $j): ?>
                    <tr>
                        <td><?= htmlspecialchars($j->date) ?></td>
                        <td><?= htmlspecialchars($j->description) ?></td>
                        <td>
                            <a href="/journals/view/<?= $j->id ?>" class="btn">Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align: center;">Belum ada transaksi jurnal.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
