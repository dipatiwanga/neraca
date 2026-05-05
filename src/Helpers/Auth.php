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
     * Mengecek apakah user adalah Admin
     * @return bool
     */
    public static function isAdmin()
    {
        return \Core\Session::get('user_role') === 'admin';
    }

    /**
     * Mengecek apakah user memiliki izin akses ke modul tertentu
     * 
     * @param string $module Nama modul (misal: 'users', 'journals')
     * @return bool
     */
    public static function canAccess($module)
    {
        $userRole = \Core\Session::get('user_role');

        // Admin memiliki akses ke semua modul
        if ($userRole === 'admin') {
            return true;
        }

        // Daftar modul yang dibatasi untuk Staff
        $restrictedForStaff = ['users'];

        return !in_array($module, $restrictedForStaff);
    }
}
