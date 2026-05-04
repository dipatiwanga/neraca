<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Tambah Akun' ?></title>
    <style>
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn-save { padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer; border-radius: 3px; }
        .btn-back { color: #666; text-decoration: none; margin-left: 10px; }
    </style>
</head>
<body>
    <h1><?= $title ?? 'Tambah Akun Baru' ?></h1>

    <form action="/accounts/store" method="POST">
        <div class="form-group">
            <label for="code">Kode Akun:</label>
            <input type="text" name="code" id="code" required placeholder="Contoh: 1101">
        </div>

        <div class="form-group">
            <label for="name">Nama Akun:</label>
            <input type="text" name="name" id="name" required placeholder="Contoh: Kas Kecil">
        </div>

        <div class="form-group">
            <label for="type">Tipe Akun:</label>
            <select name="type" id="type" required>
                <option value="asset">Asset (Aktiva)</option>
                <option value="liability">Liability (Kewajiban)</option>
                <option value="equity">Equity (Modal)</option>
                <option value="revenue">Revenue (Pendapatan)</option>
                <option value="expense">Expense (Beban)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="parent_id">Parent Akun (Opsional):</label>
            <select name="parent_id" id="parent_id">
                <option value="">-- Tidak Ada --</option>
                <?php foreach ($parents as $p): ?>
                    <option value="<?= $p->id ?>"><?= $p->code ?> - <?= $p->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn-save">Simpan Akun</button>
        <a href="/accounts" class="btn-back">Batal</a>
    </form>
</body>
</html>
