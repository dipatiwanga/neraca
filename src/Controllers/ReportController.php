<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Ledger;
use App\Helpers\Accounting;

/**
 * ReportController
 */
class ReportController extends Controller
{
    private $ledgerModel;

    public function __construct()
    {
        $this->ledgerModel = new Ledger();
    }

    /**
     * Menampilkan Laporan Neraca
     */
    public function balanceSheet()
    {
        $data = $this->ledgerModel->getBalanceSheet();
        $validation = Accounting::validateBalanceSheet($data);

        $this->view('reports/balance_sheet', [
            'title' => 'Laporan Neraca',
            'data' => $data,
            'validation' => $validation
        ]);
    }
}
