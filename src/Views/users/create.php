<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn-save { padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer; border-radius: 3px; }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../partials/nav.php'; ?>

    <h1>Tambah Pengguna Baru</h1>

    <form action="/users/store" method="POST" style="max-width: 400px;">
        <div class="form-group">
            <label>Nama Lengkap:</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <label>Role:</label>
            <select name="role" required>
                <option value="staff">Staff (Operator)</option>
                <option value="admin">Administrator (Semua Akses)</option>
            </select>
        </div>
        <button type="submit" class="btn-save">Simpan User</button>
        <a href="/users" style="margin-left: 10px;">Batal</a>
    </form>
</body>
</html>
