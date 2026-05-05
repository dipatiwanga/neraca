<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Helpers\Auth;
use App\Middleware\AuthMiddleware;

/**
 * UserController
 * Mengelola data pengguna (Hanya untuk Admin)
 */
class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        // 1. Proteksi Middleware (Pastikan sudah login)
        AuthMiddleware::handle();

        // 2. Role Constraint (Hanya Admin yang boleh mengelola user)
        if ($_SESSION['user_role'] !== 'admin') {
            die("Akses Ditolak: Anda tidak memiliki izin untuk mengakses halaman ini.");
        }

        $this->userModel = new User();
    }

    /**
     * Menampilkan daftar user
     */
    public function index()
    {
        $users = $this->userModel->getAll();

        $this->view('users/index', [
            'title' => 'Manajemen User',
            'users' => $users
        ]);
    }

    /**
     * Menampilkan form tambah user
     */
    public function create()
    {
        $this->view('users/create', [
            'title' => 'Tambah User Baru'
        ]);
    }

    /**
     * Menyimpan user baru ke database
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /users');
            exit;
        }

        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => Auth::hashPassword($_POST['password']),
            'role' => $_POST['role']
        ];

        // Validasi email unik
        if ($this->userModel->findByEmail($data['email'])) {
            die("Error: Email sudah terdaftar dalam sistem.");
        }

        if ($this->userModel->create($data)) {
            header('Location: /users?status=created');
            exit;
        } else {
            die("Gagal menyimpan data user.");
        }
    }

    /**
     * Menampilkan form edit user
     */
    public function edit($id)
    {
        $user = $this->userModel->findById($id);
        
        if (!$user) {
            die("Error: User tidak ditemukan.");
        }

        $this->view('users/edit', [
            'title' => 'Edit User',
            'user' => $user
        ]);
    }

    /**
     * Memperbarui data user
     */
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /users');
            exit;
        }

        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'role' => $_POST['role']
        ];

        // Update password hanya jika diisi (logic di Model akan menangani seleksi field)
        if (!empty($_POST['password'])) {
            $data['password'] = Auth::hashPassword($_POST['password']);
        }

        if ($this->userModel->update($id, $data)) {
            header('Location: /users?status=updated');
            exit;
        } else {
            die("Gagal memperbarui data user.");
        }
    }

    /**
     * Menghapus user
     */
    public function delete($id)
    {
        // Keamanan: Cegah admin menghapus dirinya sendiri
        if ($id == $_SESSION['user_id']) {
            die("Error: Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.");
        }

        if ($this->userModel->delete($id)) {
            header('Location: /users?status=deleted');
            exit;
        } else {
            die("Gagal menghapus user.");
        }
    }
}
