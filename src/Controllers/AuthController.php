<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Helpers\Auth;

/**
 * AuthController
 * Menangani proses Login, Logout, dan Registrasi
 */
class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Menampilkan halaman login
     */
    public function showLogin()
    {
        // Jika sudah login, redirect ke dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        $this->view('auth/login', [
            'title' => 'Login Sistem Akuntansi'
        ]);
    }

    /**
     * Memproses form login
     */
    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // 1. Cari user berdasarkan email
        $user = $this->userModel->findByEmail($email);

        // 2. Verifikasi user dan password
        if ($user && Auth::verifyPassword($password, $user->password)) {
            // 3. Jika valid, simpan ke session
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_role'] = $user->role;

            header('Location: /');
            exit;
        } else {
            // 4. Jika gagal, tampilkan error kembali ke view login
            $this->view('auth/login', [
                'title' => 'Login Sistem Akuntansi',
                'error' => 'Email atau Password salah!'
            ]);
        }
    }

    /**
     * Memproses logout
     */
    public function logout()
    {
        \Core\Session::destroy();
        header('Location: /login');
        exit;
    }
}
