<?php

namespace App\Models;

use Core\Database;

/**
 * Ledger Model
 * Mengelola data Buku Besar dan Laporan Keuangan
 */
class Ledger
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Mengambil data Buku Besar (Saldo per Akun)
     * Menghitung total debit, total credit, dan saldo akhir.
     * 
     * @return array Array of objects
     */
    public function getLedger()
    {
        $sql = "SELECT 
                    a.id, 
                    a.code, 
                    a.name, 
                    a.type,
                    COALESCE(SUM(ji.debit), 0) as total_debit, 
                    COALESCE(SUM(ji.credit), 0) as total_credit,
                    (COALESCE(SUM(ji.debit), 0) - COALESCE(SUM(ji.credit), 0)) as balance
                FROM accounts a
                LEFT JOIN journal_items ji ON a.id = ji.account_id
                GROUP BY a.id, a.code, a.name, a.type
                ORDER BY a.code ASC";
        
        return $this->db->query($sql)->resultSet();
    }

    /**
     * Mengambil detail transaksi per akun (Buku Besar Detail)
     * @param int $accountId
     * @return array
     */
    /**
     * Mengambil data Laporan Neraca (Balance Sheet)
     * Mengelompokkan akun berdasarkan tipe (Asset, Liability, Equity)
     * 
     * @return array
     */
    public function getBalanceSheet()
    {
        $ledger = $this->getLedger();
        
        $balanceSheet = [
            'assets' => ['items' => [], 'total' => 0],
            'liabilities' => ['items' => [], 'total' => 0],
            'equity' => ['items' => [], 'total' => 0],
        ];

        foreach ($ledger as $row) {
            switch ($row->type) {
                case 'asset':
                    $balanceSheet['assets']['items'][] = $row;
                    $balanceSheet['assets']['total'] += $row->balance;
                    break;
                case 'liability':
                    // Saldo normal Liability adalah Kredit (Credit - Debit)
                    $actualBalance = $row->total_credit - $row->total_debit;
                    $row->balance = $actualBalance;
                    $balanceSheet['liabilities']['items'][] = $row;
                    $balanceSheet['liabilities']['total'] += $actualBalance;
                    break;
                case 'equity':
                    // Saldo normal Equity adalah Kredit (Credit - Debit)
                    $actualBalance = $row->total_credit - $row->total_debit;
                    $row->balance = $actualBalance;
                    $balanceSheet['equity']['items'][] = $row;
                    $balanceSheet['equity']['total'] += $actualBalance;
                    break;
            }
        }

        return $balanceSheet;
    }
}
