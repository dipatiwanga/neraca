<?php

namespace Core;

use PDO;
use PDOException;

/**
 * Database Class - Singleton Pattern
 * Mengelola koneksi ke MariaDB/MySQL menggunakan PDO
 */
class Database
{
    private static $instance = null;
    private $dbh;
    private $stmt;

    /**
     * Private constructor untuk mencegah instansiasi langsung
     */
    private function __construct()
    {
        // Mengambil konfigurasi dari Environment Variables
        $host = getenv('DB_HOST') ?: 'localhost';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '';
        $dbname = getenv('DB_NAME') ?: 'db_koperasi';

        $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
        
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->dbh = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            // Error handling sederhana
            error_log("Database Connection Error: " . $e->getMessage());
            die("Maaf, terjadi masalah pada koneksi database.");
        }
    }

    /**
     * Mendapatkan instance tunggal dari Database
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Menyiapkan statement SQL
     */
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
        return $this;
    }

    /**
     * Bind parameter ke statement
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
        return $this;
    }

    /**
     * Menjalankan statement
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * Mendapatkan hasil dalam bentuk array of objects
     */
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    /**
     * Mendapatkan satu baris hasil
     */
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch();
    }

    /**
     * Mendapatkan jumlah baris yang terpengaruh
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    /**
     * Mendapatkan ID terakhir yang dimasukkan
     */
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    /**
     * Memulai transaksi database
     */
    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    /**
     * Commit transaksi
     */
    public function commit()
    {
        return $this->dbh->commit();
    }

    /**
     * Rollback transaksi
     */
    public function rollBack()
    {
        return $this->dbh->rollBack();
    }

    /**
     * Mencegah cloning instance
     */
    private function __clone() {}

    /**
     * Mencegah unserialize instance
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}
