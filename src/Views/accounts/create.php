<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h1>Tambah Akun Baru</h1>
    
    <form action="/accounts/store" method="POST">
        <div class="form-group">
            <label for="code">Kode Akun</label>
            <input type="text" id="code" name="code" required placeholder="Contoh: 1101">
        </div>

        <div class="form-group">
            <label for="name">Nama Akun</label>
            <input type="text" id="name" name="name" required placeholder="Contoh: Kas Utama">
        </div>

        <div class="form-group">
            <label for="type">Tipe Akun</label>
            <select id="type" name="type" required>
                <option value="asset">Aset</option>
                <option value="liability">Liabilitas (Kewajiban)</option>
                <option value="equity">Ekuitas (Modal)</option>
                <option value="income">Pendapatan</option>
                <option value="expense">Beban/Biaya</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn btn-success" style="flex: 1;">Simpan Akun</button>
            <a href="/accounts" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
