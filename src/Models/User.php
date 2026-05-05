<?php

namespace App\Models;

use Core\Database;

/**
 * User Model
 * Mengelola data pengguna untuk sistem autentikasi dan manajemen user
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
     * Mengambil semua data user
     * @return array
     */
    public function getAll()
    {
        $sql = "SELECT id, name, email, role, created_at FROM {$this->table} ORDER BY name ASC";
        return $this->db->query($sql)->resultSet();
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

    /**
     * Membuat user baru
     * @param array $data ['name', 'email', 'password', 'role']
     * @return bool
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (name, email, password, role) 
                VALUES (:name, :email, :password, :role)";
        
        return $this->db->query($sql)
                        ->bind(':name', $data['name'])
                        ->bind(':email', $data['email'])
                        ->bind(':password', $data['password'])
                        ->bind(':role', $data['role'] ?? 'staff')
                        ->execute();
    }

    /**
     * Memperbarui data user
     * @param int $id
     * @param array $data ['name', 'email', 'role', 'password' (optional)]
     * @return bool
     */
    public function update($id, $data)
    {
        $updateFields = "name = :name, email = :email, role = :role";
        
        // Hanya update password jika field password diisi
        if (!empty($data['password'])) {
            $updateFields .= ", password = :password";
        }

        $sql = "UPDATE {$this->table} SET {$updateFields} WHERE id = :id";
        
        $this->db->query($sql)
                 ->bind(':name', $data['name'])
                 ->bind(':email', $data['email'])
                 ->bind(':role', $data['role'])
                 ->bind(':id', $id);

        if (!empty($data['password'])) {
            $this->db->bind(':password', $data['password']);
        }

        return $this->db->execute();
    }

    /**
     * Menghapus user
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        return $this->db->query($sql)
                        ->bind(':id', $id)
                        ->execute();
    }

    /**
     * Memperbarui password user secara spesifik
     * @param int $id
     * @param string $hashedPassword
     * @return bool
     */
    public function updatePassword($id, $hashedPassword)
    {
        $sql = "UPDATE {$this->table} SET password = :password WHERE id = :id";
        return $this->db->query($sql)
                        ->bind(':password', $hashedPassword)
                        ->bind(':id', $id)
                        ->execute();
    }
}
