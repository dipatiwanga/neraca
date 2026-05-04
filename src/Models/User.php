<?php

namespace App\Models;

use Core\Database;

/**
 * User Model
 * Mengelola data pengguna untuk sistem autentikasi
 */
class User
{
    private $db;
    private $table = 'users';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Mencari user berdasarkan email
     * @param string $email
     * @return object|bool
     */
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        return $this->db->query($sql)
                        ->bind(':email', $email)
                        ->single();
    }

    /**
     * Membuat user baru
     * @param array $data ['name', 'email', 'password']
     * @return bool
     */
    public function create($data)
    {
        // Pastikan password sudah di-hash sebelum masuk ke sini jika mengikuti pattern controller-driven
        // Namun sebagai pengamanan tambahan, kita bisa pastikan di sini.
        $sql = "INSERT INTO {$this->table} (name, email, password) VALUES (:name, :email, :password)";
        
        return $this->db->query($sql)
                        ->bind(':name', $data['name'])
                        ->bind(':email', $data['email'])
                        ->bind(':password', $data['password'])
                        ->execute();
    }

    /**
     * Mencari user berdasarkan ID
     * @param int $id
     * @return object|bool
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        return $this->db->query($sql)
                        ->bind(':id', $id)
                        ->single();
    }
}
