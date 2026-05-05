<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="card" style="max-width: 500px; margin: 0 auto;">
    <h1>Edit Pengguna</h1>
    
    <form action="/users/update/<?= $user->id ?>" method="POST">
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user->name) ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Alamat Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->email) ?>" required>
        </div>

        <div class="form-group">
            <label for="role">Hak Akses (Role)</label>
            <select id="role" name="role" required>
                <option value="staff" <?= $user->role === 'staff' ? 'selected' : '' ?>>Staff (Operator)</option>
                <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>Administrator (Akses Penuh)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="password">Password Baru</label>
            <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin ganti">
            <p style="font-size: 0.8em; color: var(--secondary-color); margin-top: 5px;">*Hanya diisi jika ingin melakukan reset password user ini.</p>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">Simpan Perubahan</button>
            <a href="/users" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
