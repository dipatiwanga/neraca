<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="card">
    <h1>Input Jurnal Umum</h1>
    
    <form action="/journals/store" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
            <div class="form-group">
                <label for="date">Tanggal Transaksi</label>
                <input type="date" id="date" name="date" required value="<?= date('Y-m-d') ?>">
            </div>
            <div class="form-group">
                <label for="description">Keterangan / Deskripsi</label>
                <input type="text" id="description" name="description" required placeholder="Contoh: Pembayaran Biaya Listrik">
            </div>
        </div>

        <h3 style="margin-top: 20px;">Rincian Akun</h3>
        <table id="journal-items">
            <thead>
                <tr>
                    <th>Pilih Akun</th>
                    <th style="width: 200px;">Debit</th>
                    <th style="width: 200px;">Kredit</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < 2; $i++): ?>
                <tr>
                    <td>
                        <select name="account_id[]" required>
                            <option value="">-- Pilih Akun --</option>
                            <?php foreach ($accounts as $acc): ?>
                                <option value="<?= $acc->id ?>"><?= $acc->code ?> - <?= $acc->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="number" name="debit[]" step="0.01" value="0"></td>
                    <td><input type="number" name="credit[]" step="0.01" value="0"></td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-success" style="flex: 1;">Simpan Transaksi</button>
            <a href="/journals" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
