<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Input Jurnal' ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 8px; box-sizing: border-box; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        .btn-save { padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer; border-radius: 3px; margin-top: 20px; }
        .btn-add-row { background: #17a2b8; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 0.8em; }
    </style>
</head>
<body>
    <h1>Input Jurnal Baru</h1>

    <form action="/journals/store" method="POST">
        <div class="form-group">
            <label>Tanggal:</label>
            <input type="date" name="date" required value="<?= date('Y-m-d') ?>">
        </div>

        <div class="form-group">
            <label>Keterangan:</label>
            <textarea name="description" required placeholder="Misal: Pembayaran Listrik Meio"></textarea>
        </div>

        <h3>Rincian Transaksi</h3>
        <table id="journal-table">
            <thead>
                <tr>
                    <th width="40%">Akun</th>
                    <th width="30%">Debit</th>
                    <th width="30%">Credit</th>
                </tr>
            </thead>
            <tbody>
                <!-- Baris 1 -->
                <tr>
                    <td>
                        <select name="account_id[]" required>
                            <option value="">-- Pilih Akun --</option>
                            <?php foreach ($accounts as $a): ?>
                                <option value="<?= $a->id ?>"><?= $a->code ?> - <?= $a->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="number" name="debit[]" step="0.01" value="0"></td>
                    <td><input type="number" name="credit[]" step="0.01" value="0"></td>
                </tr>
                <!-- Baris 2 -->
                <tr>
                    <td>
                        <select name="account_id[]" required>
                            <option value="">-- Pilih Akun --</option>
                            <?php foreach ($accounts as $a): ?>
                                <option value="<?= $a->id ?>"><?= $a->code ?> - <?= $a->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="number" name="debit[]" step="0.01" value="0"></td>
                    <td><input type="number" name="credit[]" step="0.01" value="0"></td>
                </tr>
            </tbody>
        </table>
        
        <p><small>* Pastikan Total Debit = Total Credit</small></p>

        <button type="submit" class="btn-save">Simpan Jurnal</button>
        <a href="/journals" style="margin-left: 10px;">Batal</a>
    </form>
</body>
</html>
