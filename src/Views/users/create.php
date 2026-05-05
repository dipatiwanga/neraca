<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="card" style="max-width: 500px; margin: 0 auto;">
    <h1>Tambah User Baru</h1>
    
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
            <label for="password">Password Default</label>
            <input type="password" id="password" name="password" required placeholder="Minimal 6 karakter">
        </div>

        <div class="form-group">
            <label for="role">Hak Akses (Role)</label>
            <select id="role" name="role" required>
                <option value="staff">Staff (Operator)</option>
                <option value="admin">Administrator (Akses Penuh)</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-success" style="flex: 1;">Simpan User</button>
            <a href="/users" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
