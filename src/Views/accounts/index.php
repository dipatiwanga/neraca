<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1><?= $title ?? 'Chart of Accounts (COA)' ?></h1>
        <a href="/accounts/create" class="btn btn-success">+ Tambah Akun Baru</a>
    </div>

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
                        <td><strong><?= htmlspecialchars($acc->code) ?></strong></td>
                        <td><?= htmlspecialchars($acc->name) ?></td>
                        <td>
                            <span class="badge badge-primary"><?= ucfirst(htmlspecialchars($acc->type)) ?></span>
                        </td>
                        <td><?= $acc->parent_id ?: '-' ?></td>
                        <td>
                            <a href="/accounts/edit/<?= $acc->id ?>" class="btn btn-sm btn-primary">Edit</a>
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
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
