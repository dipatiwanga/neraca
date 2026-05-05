<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Neraca Koperasi</title>
    <link rel="stylesheet" href="/css/main.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            padding: 0;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h1 {
            font-size: 1.8em;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        .login-header p {
            color: var(--secondary-color);
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h1>Login Sistem</h1>
            <p>Masukkan kredensial Anda</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger" style="text-align: center;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST">
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" required placeholder="admin@koperasi.com" autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 1em; margin-top: 10px;">
                Masuk ke Aplikasi
            </button>
        </form>

        <div style="margin-top: 30px; text-align: center; color: var(--secondary-color); font-size: 0.8em;">
            &copy; <?= date('Y') ?> Neraca Koperasi v1.0
        </div>
    </div>
</body>
</html>
