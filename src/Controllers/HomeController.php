<?php

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Bisa memanggil model seperti ini:
        // $akunModel = $this->model('Akun');
        // $dataAkun = $akunModel->getAll();

        $data = [
            'title' => 'Dashboard Sistem Akuntansi',
            'pesan' => 'Selamat datang di Sistem Akuntansi Koperasi'
        ];

        // Memanggil file src/Views/home.php
        $this->view('home', $data);
    }
}
