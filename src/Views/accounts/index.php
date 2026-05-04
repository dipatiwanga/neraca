<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Daftar Akun' ?></title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn { padding: 5px 10px; text-decoration: none; background: #007bff; color: white; border-radius: 3px; }
        .btn-add { background: #28a745; margin-bottom: 10px; display: inline-block; }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../partials/nav.php'; ?>
    <h1><?= $title ?? 'Chart of Accounts (COA)' ?></h1>
    
    <a href="/accounts/create" class="btn btn-add">+ Tambah Akun Baru</a>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Akun</th>
                <th>Tipe</th>
                <th>Parent ID</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($accounts)): ?>
                <?php foreach ($accounts as $acc): ?>
                    <tr>
                        <td><?= htmlspecialchars($acc->code) ?></td>
                        <td><?= htmlspecialchars($acc->name) ?></td>
                        <td><?= ucfirst(htmlspecialchars($acc->type)) ?></td>
                        <td><?= $acc->parent_id ?: '-' ?></td>
                        <td>
                            <a href="/accounts/edit/<?= $acc->id ?>" class="btn">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada data akun.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p><a href="/"> kembali ke Home</a></p>
</body>
</html>
