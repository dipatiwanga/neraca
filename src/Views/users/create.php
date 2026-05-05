<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Tambah User' ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; line-height: 1.6; }
        .card { max-width: 500px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background: #28a745; color: white; border: none; padding: 12px 20px; border-radius: 4px; cursor: pointer; width: 100%; font-size: 1em; }
        .btn-submit:hover { background: #218838; }
        .back-link { display: block; text-align: center; margin-top: 15px; text-decoration: none; color: #666; }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../partials/nav.php'; ?>

    <div class="card">
        <h2>Tambah Pengguna Baru</h2>
        <form action="/users/store" method="POST">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" required placeholder="Contoh: Budi Santoso">
            </div>
            
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" required placeholder="email@contoh.com">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Minimal 6 karakter">
            </div>

            <div class="form-group">
                <label for="role">Hak Akses (Role)</label>
                <select id="role" name="role" required>
                    <option value="staff">Staff (Operator)</option>
                    <option value="admin">Administrator (Full Access)</option>
                </select>
            </div>

            <button type="submit" class="btn-submit">Simpan Pengguna</button>
            <a href="/users" class="back-link">Kembali ke Daftar</a>
        </form>
    </div>
</body>
</html>
