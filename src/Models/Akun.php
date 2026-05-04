<?php

namespace App\Models;

use Core\Database;

class Akun
{
    private $db;

    public function __construct()
    {
        // Menggunakan Singleton pattern
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        return $this->db->query("SELECT * FROM akun")->resultSet();
    }

    public function getById($id)
    {
        return $this->db->query("SELECT * FROM akun WHERE id = :id")
                        ->bind(':id', $id)
                        ->single();
    }

    public function tambah($data)
    {
        return $this->db->query("INSERT INTO akun (kode, nama, tipe) VALUES (:kode, :nama, :tipe)")
                        ->bind(':kode', $data['kode'])
                        ->bind(':nama', $data['nama'])
                        ->bind(':tipe', $data['tipe'])
                        ->execute();
    }
}
