<?php

namespace App\Helpers;

/**
 * Accounting Helper
 */
class Accounting
{
    /**
     * Memvalidasi apakah total debit dan total credit seimbang (balance)
     * 
     * @param array $items Array of arrays [['debit' => 100, 'credit' => 0], ...]
     * @return bool
     * @throws \Exception
     */
    public static function validateJournal(array $items)
    {
        $totalDebit = 0;
        $totalCredit = 0;

        foreach ($items as $item) {
            $totalDebit += (float) ($item['debit'] ?? 0);
            $totalCredit += (float) ($item['credit'] ?? 0);
        }

        // Menggunakan round untuk menghindari masalah floating point precision
        if (round($totalDebit, 2) !== round($totalCredit, 2)) {
            throw new \Exception(
                sprintf(
                    "Jurnal tidak seimbang (Unbalanced)! Total Debit: %s, Total Credit: %s",
                    number_format($totalDebit, 2),
                    number_format($totalCredit, 2)
                )
            );
        }

        return true;
    }

    /**
     * Memvalidasi persamaan dasar akuntansi pada Neraca
     * Persamaan: Assets = Liabilities + Equity
     * 
     * @param array $data Output dari Ledger::getBalanceSheet()
     * @return array ['status' => bool, 'message' => string]
     */
    public static function validateBalanceSheet(array $data)
    {
        $totalAssets = (float) $data['assets']['total'];
        $totalLiabilities = (float) $data['liabilities']['total'];
        $totalEquity = (float) $data['equity']['total'];

        $rightSide = $totalLiabilities + $totalEquity;

        // Toleransi selisih karena floating point
        $isBalanced = round($totalAssets, 2) === round($rightSide, 2);

        if (!$isBalanced) {
            return [
                'status' => false,
                'message' => sprintf(
                    "PERINGATAN: Neraca tidak seimbang! Total Aset (%s) != Total Kewajiban + Modal (%s). Selisih: %s",
                    number_format($totalAssets, 2),
                    number_format($rightSide, 2),
                    number_format($totalAssets - $rightSide, 2)
                )
            ];
        }

        return [
            'status' => true,
            'message' => "Neraca Seimbang (Balanced)."
        ];
    }
}
