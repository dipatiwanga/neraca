<?php

namespace App\Helpers;

/**
 * Auth Helper
 * Menyediakan fungsi bantuan untuk keamanan dan autentikasi
 */
class Auth
{
    /**
     * Membuat hash aman untuk password
     * Menggunakan algoritma BCRYPT (Standar industri PHP)
     * 
     * @param string $password Password teks biasa
     * @return string Hash password
     */
    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Memverifikasi apakah password sesuai dengan hash di database
     * 
     * @param string $password Password teks biasa dari input login
     * @param string $hash Hash password dari database
     * @return bool True jika cocok, False jika tidak
     */
    public static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * Mengecek apakah user sudah login (Opsional helper)
     * @return bool
     */
    public static function check()
    {
        return isset($_SESSION['user_id']);
    }
}
