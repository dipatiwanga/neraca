<?php

namespace App\Middleware;

use Core\Session;

/**
 * AuthMiddleware
 * Memastikan pengguna sudah terautentikasi sebelum mengakses halaman tertentu
 */
class AuthMiddleware
{
    /**
     * Menjalankan pengecekan session
     * Jika tidak ada session user_id, maka redirect ke halaman login
     */
    public static function handle()
    {
        // Pastikan session sudah dimulai
        Session::start();

        if (!Session::has('user_id')) {
            header('Location: /login');
            exit;
        }
    }
}
