<?php

namespace App\Helpers;

/**
 * Menu Helper
 * Mengelola daftar menu dinamis berdasarkan role pengguna
 */
class Menu
{
    /**
     * Mendapatkan daftar menu berdasarkan role
     * 
     * @param string $role Role user ('admin' atau 'staff')
     * @return array
     */
    public static function getMenuByRole($role)
    {
        // Menu dasar yang bisa diakses oleh semua role (admin & staff)
        $menus = [
            [
                'title' => 'Dashboard',
                'url' => '/',
                'active' => '/'
            ],
            [
                'title' => 'Daftar Akun',
                'url' => '/accounts',
                'active' => '/accounts'
            ],
            [
                'title' => 'Jurnal Umum',
                'url' => '/journals',
                'active' => '/journals'
            ],
            [
                'title' => 'Laporan Neraca',
                'url' => '/reports/balance-sheet',
                'active' => '/reports/balance-sheet'
            ]
        ];

        // Menu khusus Admin
        if ($role === 'admin') {
            // Kita sisipkan menu Manajemen User untuk admin
            $menus[] = [
                'title' => 'Manajemen User',
                'url' => '/users',
                'active' => '/users',
                'highlight' => true
            ];
        }

        return $menus;
    }
}
