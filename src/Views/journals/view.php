<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--border-color); padding-bottom: 15px; margin-bottom: 20px;">
        <h1>Rincian Jurnal</h1>
        <a href="/journals" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 30px;">
        <div>
            <label style="color: var(--secondary-color); font-size: 0.8em; text-transform: uppercase;">Tanggal</label>
            <div style="font-size: 1.1em; font-weight: 500;"><?= htmlspecialchars($journal->date) ?></div>
        </div>
        <div>
            <label style="color: var(--secondary-color); font-size: 0.8em; text-transform: uppercase;">Keterangan</label>
            <div style="font-size: 1.1em; font-weight: 500;"><?= htmlspecialchars($journal->description) ?></div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th style="text-align: right;">Debit</th>
                <th style="text-align: right;">Kredit</th>
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
                    <td><strong><?= htmlspecialchars($item->account_code) ?></strong></td>
                    <td><?= htmlspecialchars($item->account_name) ?></td>
                    <td style="text-align: right;"><?= number_format($item->debit, 2) ?></td>
                    <td style="text-align: right;"><?= number_format($item->credit, 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot style="font-weight: bold; background: #f8fafc;">
            <tr>
                <td colspan="2" style="text-align: right;">TOTAL</td>
                <td style="text-align: right; border-top: 2px solid var(--text-color);"><?= number_format($totalDebit, 2) ?></td>
                <td style="text-align: right; border-top: 2px solid var(--text-color);"><?= number_format($totalCredit, 2) ?></td>
            </tr>
        </tfoot>
    </table>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
