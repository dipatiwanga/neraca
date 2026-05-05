<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Manajemen Pengguna</h1>
        <a href="/users/create" class="btn btn-success">+ Tambah User Baru</a>
    </div>

    <?php if (isset($_GET['status'])): ?>
        <div class="alert alert-success">
            <?php 
                if($_GET['status'] == 'created') echo "User berhasil ditambahkan!";
                if($_GET['status'] == 'updated') echo "Data user berhasil diperbarui!";
                if($_GET['status'] == 'deleted') echo "User berhasil dihapus!";
            ?>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Nama Lengkap</th>
                <th>Alamat Email</th>
                <th>Role / Akses</th>
                <th>Tanggal Terdaftar</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($user->name) ?></strong></td>
                    <td><?= htmlspecialchars($user->email) ?></td>
                    <td>
                        <span class="badge <?= $user->role === 'admin' ? 'badge-primary' : 'badge-success' ?>">
                            <?= strtoupper($user->role) ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y', strtotime($user->created_at)) ?></td>
                    <td style="text-align: center;">
                        <a href="/users/edit/<?= $user->id ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="/users/delete/<?= $user->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
