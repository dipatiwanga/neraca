<?php

namespace App\Controllers;

use Core\Controller;
use Core\Session;
use App\Models\User;
use App\Helpers\Auth;
use App\Middleware\AuthMiddleware;

/**
 * ProfileController
 * Mengelola informasi profil user dan keamanan akun
 */
class ProfileController extends Controller
{
    private $userModel;

    public function __construct()
    {
        // Pastikan hanya user yang sudah login yang bisa akses
        AuthMiddleware::handle();
        $this->userModel = new User();
    }

    /**
     * Menampilkan form ganti password
     */
    public function showChangePassword()
    {
        $this->view('profile/change_password', [
            'title' => 'Ganti Password'
        ]);
    }

    /**
     * Memproses permintaan ganti password
     */
    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /profile/change-password');
            exit;
        }

        $userId = Session::get('user_id');
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        // 1. Validasi Input Dasar
        if (empty($oldPassword) || empty($newPassword)) {
            die("Error: Semua field wajib diisi.");
        }

        if ($newPassword !== $confirmPassword) {
            die("Error: Konfirmasi password baru tidak cocok.");
        }

        // 2. Ambil data user dari database
        $user = $this->userModel->findById($userId);
        if (!$user) {
            die("Error: User tidak ditemukan.");
        }

        // 3. Verifikasi Password Lama (Security Step)
        if (!Auth::verifyPassword($oldPassword, $user->password)) {
            die("Error: Password lama yang Anda masukkan salah.");
        }

        // 4. Hash Password Baru
        $hashedPassword = Auth::hashPassword($newPassword);

        // 5. Update ke Database
        if ($this->userModel->updatePassword($userId, $hashedPassword)) {
            // Sukses
            header('Location: /profile/change-password?status=success');
            exit;
        } else {
            die("Error: Gagal memperbarui password. Silakan coba lagi.");
        }
    }
}
