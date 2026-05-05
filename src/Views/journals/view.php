<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Rincian Jurnal' ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .card { border: 1px solid #ddd; padding: 20px; border-radius: 8px; max-width: 800px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .text-right { text-align: right; }
        .btn { padding: 8px 15px; text-decoration: none; background: #6c757d; color: white; border-radius: 4px; display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../partials/nav.php'; ?>

    <div class="card">
        <h1><?= $title ?></h1>
        <p><strong>Tanggal:</strong> <?= htmlspecialchars($journal->date) ?></p>
        <p><strong>Keterangan:</strong> <?= htmlspecialchars($journal->description) ?></p>

        <table>
            <thead>
                <tr>
                    <th>Kode Akun</th>
                    <th>Nama Akun</th>
                    <th class="text-right">Debit</th>
                    <th class="text-right">Kredit</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalDebit = 0;
                $totalCredit = 0;
                foreach ($items as $item): 
                    $totalDebit += $item->debit;
                    $totalCredit += $item->credit;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item->account_code) ?></td>
                        <td><?= htmlspecialchars($item->account_name) ?></td>
                        <td class="text-right"><?= number_format($item->debit, 2) ?></td>
                        <td class="text-right"><?= number_format($item->credit, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">TOTAL</th>
                    <th class="text-right"><?= number_format($totalDebit, 2) ?></th>
                    <th class="text-right"><?= number_format($totalCredit, 2) ?></th>
                </tr>
            </tfoot>
        </table>

        <a href="/journals" class="btn">Kembali ke Daftar Jurnal</a>
    </div>
</body>
</html>
