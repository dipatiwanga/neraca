<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; margin-bottom: 30px; }
        th, td { border: 1px solid #ddd; padding: 10px; }
        th { background: #f4f4f4; text-align: left; }
        .total-row { font-weight: bold; background: #eee; }
        .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; }
        .alert-success { color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6; }
        .alert-warning { color: #8a6d3b; background-color: #fcf8e3; border-color: #faebcc; }
        nav { margin-bottom: 20px; }
        nav a { margin-right: 15px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../partials/nav.php'; ?>

    <h1><?= $title ?></h1>

    <?php if ($validation['status']): ?>
        <div class="alert alert-success"><?= $validation['message'] ?></div>
    <?php else: ?>
        <div class="alert alert-warning"><?= $validation['message'] ?></div>
    <?php endif; ?>

    <h3>AKTIVA (ASSETS)</h3>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Akun</th>
                <th style="text-align: right;">Saldo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['assets']['items'] as $item): ?>
                <tr>
                    <td><?= $item->code ?></td>
                    <td><?= $item->name ?></td>
                    <td style="text-align: right;"><?= number_format($item->balance, 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="2">TOTAL AKTIVA</td>
                <td style="text-align: right;"><?= number_format($data['assets']['total'], 2) ?></td>
            </tr>
        </tbody>
    </table>

    <h3>KEWAJIBAN & MODAL</h3>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Akun</th>
                <th style="text-align: right;">Saldo</th>
            </tr>
        </thead>
        <tbody>
            <tr><th colspan="3">Kewajiban (Liabilities)</th></tr>
            <?php foreach ($data['liabilities']['items'] as $item): ?>
                <tr>
                    <td><?= $item->code ?></td>
                    <td><?= $item->name ?></td>
                    <td style="text-align: right;"><?= number_format($item->balance, 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="2">Total Kewajiban</td>
                <td style="text-align: right;"><?= number_format($data['liabilities']['total'], 2) ?></td>
            </tr>

            <tr><th colspan="3">Modal (Equity)</th></tr>
            <?php foreach ($data['equity']['items'] as $item): ?>
                <tr>
                    <td><?= $item->code ?></td>
                    <td><?= $item->name ?></td>
                    <td style="text-align: right;"><?= number_format($item->balance, 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="2">Total Modal</td>
                <td style="text-align: right;"><?= number_format($data['equity']['total'], 2) ?></td>
            </tr>

            <tr class="total-row" style="background: #333; color: #fff;">
                <td colspan="2">TOTAL KEWAJIBAN + MODAL</td>
                <td style="text-align: right;"><?= number_format($data['liabilities']['total'] + $data['equity']['total'], 2) ?></td>
            </tr>
        </tbody>
    </table>

    <p><button onclick="window.print()">Cetak Laporan</button></p>
</body>
</html>
