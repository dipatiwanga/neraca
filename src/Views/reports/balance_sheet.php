<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="card">
    <div style="text-align: center; margin-bottom: 40px; border-bottom: 3px double var(--border-color); padding-bottom: 20px;">
        <h1 style="margin-bottom: 5px;">Laporan Neraca</h1>
        <div style="color: var(--secondary-color); font-weight: 500;">Per Tanggal: <?= date('d F Y') ?></div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
        
        <!-- AKTIVA (ASSETS) -->
        <div>
            <h3 style="background: #f1f5f9; padding: 10px; border-radius: 6px;">AKTIVA (ASET)</h3>
            <table style="margin-top: 0;">
                <thead>
                    <tr>
                        <th>Akun</th>
                        <th style="text-align: right;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['assets']['items'] as $item): ?>
                    <tr>
                        <td><?= $item->code ?> - <?= $item->name ?></td>
                        <td style="text-align: right;"><?= number_format($item->balance, 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot style="font-weight: bold;">
                    <tr>
                        <td>TOTAL AKTIVA</td>
                        <td style="text-align: right; border-top: 2px solid var(--text-color);"><?= number_format($data['assets']['total'], 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- PASIVA (LIABILITIES & EQUITY) -->
        <div>
            <h3 style="background: #f1f5f9; padding: 10px; border-radius: 6px;">PASIVA (KEWAJIBAN & MODAL)</h3>
            
            <label style="display: block; font-weight: 600; margin: 15px 0 5px 0;">Kewajiban</label>
            <table style="margin-top: 0;">
                <tbody>
                    <?php foreach ($data['liabilities']['items'] as $item): ?>
                    <tr>
                        <td><?= $item->code ?> - <?= $item->name ?></td>
                        <td style="text-align: right;"><?= number_format($item->balance, 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr style="font-weight: 600; font-style: italic;">
                        <td>Subtotal Kewajiban</td>
                        <td style="text-align: right;"><?= number_format($data['liabilities']['total'], 2) ?></td>
                    </tr>
                </tbody>
            </table>

            <label style="display: block; font-weight: 600; margin: 20px 0 5px 0;">Ekuitas (Modal)</label>
            <table style="margin-top: 0;">
                <tbody>
                    <?php foreach ($data['equity']['items'] as $item): ?>
                    <tr>
                        <td><?= $item->code ?> - <?= $item->name ?></td>
                        <td style="text-align: right;"><?= number_format($item->balance, 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr style="font-weight: 600; font-style: italic;">
                        <td>Subtotal Ekuitas</td>
                        <td style="text-align: right;"><?= number_format($data['equity']['total'], 2) ?></td>
                    </tr>
                </tbody>
                <tfoot style="font-weight: bold; font-size: 1.1em; background: #f8fafc;">
                    <tr>
                        <td>TOTAL PASIVA</td>
                        <td style="text-align: right; border-top: 2px solid var(--text-color);"><?= number_format($data['liabilities']['total'] + $data['equity']['total'], 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Validasi Balance -->
    <div style="margin-top: 40px; text-align: center;">
        <?php 
        $totalAktiva = $data['assets']['total'];
        $totalPasiva = $data['liabilities']['total'] + $data['equity']['total'];
        $isBalanced = round($totalAktiva, 2) == round($totalPasiva, 2);
        ?>
        <div class="badge <?= $isBalanced ? 'badge-success' : 'badge-danger' ?>" style="padding: 15px 30px; font-size: 1.2em;">
            Status: <?= $isBalanced ? 'SEIMBANG (BALANCED)' : 'TIDAK SEIMBANG (NOT BALANCED)' ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
