<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f4f4f4; }
        .btn { padding: 5px 12px; text-decoration: none; border-radius: 4px; font-size: 0.9em; }
        .btn-add { background: #28a745; color: #fff; display: inline-block; margin-bottom: 15px; }
        .badge { padding: 3px 8px; border-radius: 10px; font-size: 0.8em; color: #fff; }
        .badge-admin { background: #dc3545; }
        .badge-staff { background: #6c757d; }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../partials/nav.php'; ?>

    <h1>Daftar Pengguna Sistem</h1>
    <a href="/users/create" class="btn btn-add">+ Tambah User Baru</a>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Tgl Dibuat</th>
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
                    <td><?= $user->created_at ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
