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
        // 1. Pastikan sudah login
        AuthMiddleware::handle();

        // 2. Pastikan role adalah admin
        if ($_SESSION['user_role'] !== 'admin') {
            die("Akses Ditolak: Anda bukan Administrator.");
        }

        $this->userModel = new User();
    }

    /**
     * Menampilkan daftar user
     */
    public function index()
    {
        $sql = "SELECT id, name, email, role, created_at FROM users ORDER BY name ASC";
        $db = \Core\Database::getInstance();
        $users = $db->query($sql)->resultSet();

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
     * Menyimpan user baru
     */
    public function store()
    {
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => Auth::hashPassword($_POST['password']),
            'role' => $_POST['role']
        ];

        // Validasi email unik
        if ($this->userModel->findByEmail($data['email'])) {
            die("Email sudah terdaftar.");
        }

        // Insert ke database (Saya tambahkan field role di model create nantinya)
        $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $db = \Core\Database::getInstance();
        $db->query($sql)
           ->bind(':name', $data['name'])
           ->bind(':email', $data['email'])
           ->bind(':password', $data['password'])
           ->bind(':role', $data['role'])
           ->execute();

        header('Location: /users');
        exit;
    }
}
