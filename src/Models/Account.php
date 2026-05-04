<?php

namespace App\Models;

use Core\Database;

/**
 * Account Model
 * Mengelola data pada tabel 'accounts' (Bagan Akun / Chart of Accounts)
 */
class Account
{
    private $db;
    private $table = 'accounts';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Mengambil semua data akun
     * @return array Array of objects
     */
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY code ASC";
        return $this->db->query($sql)->resultSet();
    }

    /**
     * Mencari akun berdasarkan ID
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
     * Membuat akun baru
     * @param array $data ['code', 'name', 'type', 'parent_id']
     * @return bool
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (code, name, type, parent_id) 
                VALUES (:code, :name, :type, :parent_id)";
        
        return $this->db->query($sql)
                        ->bind(':code', $data['code'])
                        ->bind(':name', $data['name'])
                        ->bind(':type', $data['type'])
                        ->bind(':parent_id', $data['parent_id'] ?? null)
                        ->execute();
    }

    /**
     * Memperbarui data akun
     * @param int $id
     * @param array $data ['code', 'name', 'type', 'parent_id']
     * @return bool
     */
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} 
                SET code = :code, 
                    name = :name, 
                    type = :type, 
                    parent_id = :parent_id 
                WHERE id = :id";
        
        return $this->db->query($sql)
                        ->bind(':id', $id)
                        ->bind(':code', $data['code'])
                        ->bind(':name', $data['name'])
                        ->bind(':type', $data['type'])
                        ->bind(':parent_id', $data['parent_id'] ?? null)
                        ->execute();
    }

    /**
     * Menghapus akun (Opsional, ditambahkan untuk kelengkapan)
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
}
