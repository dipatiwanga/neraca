<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1><?= $title ?? 'Riwayat Jurnal Umum' ?></h1>
        <a href="/journals/create" class="btn btn-success">+ Input Jurnal Baru</a>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success">Transaksi berhasil disimpan!</div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th style="width: 150px;">Tanggal</th>
                <th>Keterangan</th>
                <th style="width: 150px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($journals)): ?>
                <?php foreach ($journals as $j): ?>
                    <tr>
                        <td><?= htmlspecialchars($j->date) ?></td>
                        <td><?= htmlspecialchars($j->description) ?></td>
                        <td style="text-align: center;">
                            <a href="/journals/view/<?= $j->id ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
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
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
