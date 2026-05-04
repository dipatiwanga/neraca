<?php

namespace App\Models;

use Core\Database;

/**
 * JournalItem Model
 */
class JournalItem
{
    private $db;
    private $table = 'journal_items';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Menyimpan satu baris item jurnal
     * @param array $data ['journal_id', 'account_id', 'debit', 'credit']
     * @return bool
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (journal_id, account_id, debit, credit) 
                VALUES (:journal_id, :account_id, :debit, :credit)";
        
        return $this->db->query($sql)
                        ->bind(':journal_id', $data['journal_id'])
                        ->bind(':account_id', $data['account_id'])
                        ->bind(':debit', $data['debit'])
                        ->bind(':credit', $data['credit'])
                        ->execute();
    }

    /**
     * Mengambil item berdasarkan journal_id
     */
    public function getByJournalId($journalId)
    {
        $sql = "SELECT ji.*, a.name as account_name, a.code as account_code 
                FROM {$this->table} ji 
                JOIN accounts a ON ji.account_id = a.id 
                WHERE ji.journal_id = :journal_id";
        
        return $this->db->query($sql)
                        ->bind(':journal_id', $journalId)
                        ->resultSet();
    }
}
