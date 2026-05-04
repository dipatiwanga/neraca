<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Account;

/**
 * AccountController
 * Mengelola alur logika untuk Chart of Accounts (COA)
 */
class AccountController extends Controller
{
    private $accountModel;

    public function __construct()
    {
        // Proteksi Halaman
        \App\Middleware\AuthMiddleware::handle();
        
        $this->accountModel = new Account();
    }

    /**
     * Menampilkan daftar akun
     */
    public function index()
    {
        $accounts = $this->accountModel->getAll();
        
        $this->view('accounts/index', [
            'title' => 'Daftar Akun (COA)',
            'accounts' => $accounts
        ]);
    }

    /**
     * Menampilkan form tambah akun
     */
    public function create()
    {
        // Ambil data untuk dropdown parent_id
        $parents = $this->accountModel->getAll();
        
        $this->view('accounts/create', [
            'title' => 'Tambah Akun Baru',
            'parents' => $parents
        ]);
    }

    /**
     * Menyimpan akun baru ke database
     */
    public function store()
    {
        // Sederhananya kita ambil dari $_POST
        // Idealnya ada validasi di sini
        $data = [
            'code' => $_POST['code'],
            'name' => $_POST['name'],
            'type' => $_POST['type'],
            'parent_id' => !empty($_POST['parent_id']) ? $_POST['parent_id'] : null
        ];

        if ($this->accountModel->create($data)) {
            header('Location: /accounts');
            exit;
        } else {
            die("Gagal menyimpan data.");
        }
    }

    /**
     * Menampilkan form edit akun
     */
    public function edit($id)
    {
        $account = $this->accountModel->findById($id);
        $parents = $this->accountModel->getAll();

        if (!$account) {
            die("Akun tidak ditemukan.");
        }

        $this->view('accounts/edit', [
            'title' => 'Edit Akun: ' . $account->name,
            'account' => $account,
            'parents' => $parents
        ]);
    }

    /**
     * Memperbarui data akun di database
     */
    public function update($id)
    {
        $data = [
            'code' => $_POST['code'],
            'name' => $_POST['name'],
            'type' => $_POST['type'],
            'parent_id' => !empty($_POST['parent_id']) ? $_POST['parent_id'] : null
        ];

        if ($this->accountModel->update($id, $data)) {
            header('Location: /accounts');
            exit;
        } else {
            die("Gagal memperbarui data.");
        }
    }
}
