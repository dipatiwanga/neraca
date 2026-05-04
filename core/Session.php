<?php

namespace Core;

/**
 * Session Class
 * Wrapper sederhana untuk mengelola PHP Native Session
 */
class Session
{
    /**
     * Memulai session jika belum dimulai
     */
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Menyimpan data ke session
     * 
     * @param string $key
     * @param mixed $value
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Mengambil data dari session
     * 
     * @param string $key
     * @param mixed $default Nilai default jika key tidak ditemukan
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * Menghapus data spesifik dari session
     * 
     * @param string $key
     */
    public static function forget($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Menghancurkan seluruh session (Logout)
     */
    public static function destroy()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Mengecek apakah key tertentu ada di session
     * 
     * @param string $key
     * @return bool
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }
}
