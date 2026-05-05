<?php

namespace App\Models;

use Core\Database;

/**
 * Journal Model
 */
class Journal
{
    private $db;
    private $table = 'journals';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Membuat Jurnal beserta rincian itemnya (Transaction)
     * @param array $journalData ['date', 'description']
     * @param array $itemsData Array of ['account_id', 'debit', 'credit']
     * @return bool
     * @throws \Exception
     */
    public function createWithItems($journalData, $itemsData)
    {
        // 1. Validasi Balance (Debit == Credit)
        $totalDebit = 0;
        $totalCredit = 0;
        foreach ($itemsData as $item) {
            $totalDebit += $item['debit'];
            $totalCredit += $item['credit'];
        }

        if ($totalDebit !== $totalCredit) {
            throw new \Exception("Jurnal tidak seimbang! Total Debit ({$totalDebit}) != Total Credit ({$totalCredit}).");
        }

        try {
            // 2. Mulai Transaksi
            $this->db->beginTransaction();

            // 3. Insert Header Jurnal
            $sqlJournal = "INSERT INTO {$this->table} (date, description) VALUES (:date, :description)";
            $this->db->query($sqlJournal)
                     ->bind(':date', $journalData['date'])
                     ->bind(':description', $journalData['description'])
                     ->execute();

            $journalId = $this->db->lastInsertId();

            // 4. Insert Item Jurnal
            $journalItem = new JournalItem();
            foreach ($itemsData as $item) {
                $item['journal_id'] = $journalId;
                if (!$journalItem->create($item)) {
                    throw new \Exception("Gagal menyimpan rincian jurnal.");
                }
            }

            // 5. Commit Jika Semua Sukses
            $this->db->commit();
            return true;

        } catch (\Exception $e) {
            // Rollback Jika Ada Error
            $this->db->rollBack();
            error_log("Gagal membuat jurnal: " . $e->getMessage());
            throw $e;
        }
    }

    public function getAll()
    {
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY date DESC")->resultSet();
    }

    public function getById($id)
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE id = :id")
                        ->bind(':id', $id)
                        ->single();
    }
}
