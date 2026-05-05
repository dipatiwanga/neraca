<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Manajemen User' ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; line-height: 1.6; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 0.9em; }
        .btn-add { background: #28a745; color: white; padding: 10px 15px; display: inline-block; margin-bottom: 15px; }
        .btn-edit { background: #ffc107; color: #333; }
        .btn-delete { background: #dc3545; color: white; }
        .badge { padding: 3px 8px; border-radius: 10px; font-size: 0.8em; font-weight: bold; }
        .badge-admin { background: #e3f2fd; color: #0d47a1; }
        .badge-staff { background: #f1f8e9; color: #33691e; }
        .alert { padding: 10px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 15px; border-radius: 4px; }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../partials/nav.php'; ?>

    <h1>Daftar Pengguna Sistem</h1>

    <?php if (isset($_GET['status'])): ?>
        <div class="alert">
            <?php 
                if($_GET['status'] == 'created') echo "User berhasil ditambahkan!";
                if($_GET['status'] == 'updated') echo "Data user berhasil diperbarui!";
                if($_GET['status'] == 'deleted') echo "User berhasil dihapus!";
            ?>
        </div>
    <?php endif; ?>

    <a href="/users/create" class="btn btn-add">+ Tambah User Baru</a>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user->name) ?></td>
                    <td><?= htmlspecialchars($user->email) ?></td>
                    <td>
                        <span class="badge <?= $user->role === 'admin' ? 'badge-admin' : 'badge-staff' ?>">
                            <?= strtoupper($user->role) ?>
                        </span>
                    </td>
                    <td>
                        <a href="/users/edit/<?= $user->id ?>" class="btn btn-edit">Edit</a>
                        <a href="/users/delete/<?= $user->id ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
