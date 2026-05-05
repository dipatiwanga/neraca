<?php

namespace App\Middleware;

use Core\Session;

/**
 * RoleMiddleware
 * Memastikan pengguna memiliki hak akses (role) yang sesuai
 */
class RoleMiddleware
{
    /**
     * Memvalidasi role pengguna
     * 
     * @param string|array $allowedRoles Role yang diizinkan (misal: 'admin' atau ['admin', 'staff'])
     * @return void
     */
    public static function handle($allowedRoles)
    {
        // 1. Pastikan session dimulai
        Session::start();

        // 2. Cek apakah sudah login
        if (!Session::has('user_id')) {
            header('Location: /login');
            exit;
        }

        // 3. Normalisasi input roles ke array agar bisa menerima string tunggal atau banyak role
        $roles = is_array($allowedRoles) ? $allowedRoles : [$allowedRoles];

        // 4. Ambil role user dari session
        $userRole = Session::get('user_role');

        // 5. Verifikasi hak akses
        if (!in_array($userRole, $roles)) {
            // Kirim header HTTP 403 Forbidden
            http_response_code(403);
            
            // Tampilan sederhana Access Denied
            echo "<div style='font-family: sans-serif; text-align: center; padding: 50px;'>";
            echo "<h1 style='color: #d9534f;'>403 - Access Denied</h1>";
            echo "<p>Maaf, akun Anda (" . htmlspecialchars($userRole) . ") tidak memiliki izin untuk mengakses halaman ini.</p>";
            echo "<hr style='max-width: 300px;'>";
            echo "<a href='/' style='color: #007bff; text-decoration: none;'>Kembali ke Dashboard</a>";
            echo "</div>";
            exit;
        }
    }
}
